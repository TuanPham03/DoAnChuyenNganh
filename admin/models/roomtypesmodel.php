<?php
function getAllRoomtypess(){
    $conn=connectdb();
    $sql = "SELECT rt.*,i.image_url,(rt.quantity - COALESCE(SUM(CASE WHEN r.status = 'booked' THEN 1 ELSE 0 END), 0)) AS available_quantity FROM room_types rt  LEFT JOIN images i ON rt.id = i.room_type_id LEFT JOIN rooms r ON rt.id=r.room_type_id GROUP BY rt.id" ;
    $stmt =$conn-> prepare($sql);
    $stmt->execute();
    $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}

function getAllRoomTypes($page, $limit) {
    $conn = connectdb(); // Kết nối cơ sở dữ liệu

    // Tính toán offset cho phân trang
    $offset = ($page - 1) * $limit;

    // Truy vấn lấy danh sách loại phòng với số lượng còn lại và phân trang
    $sql = "SELECT 
                rt.*, 
                i.image_url, 
                (rt.quantity - COALESCE(SUM(CASE WHEN r.status = 'booked' THEN 1 ELSE 0 END), 0)) AS available_quantity
            FROM room_types rt
            LEFT JOIN images i ON rt.id = i.room_type_id
            LEFT JOIN rooms r ON rt.id = r.room_type_id
            GROUP BY rt.id
            ORDER BY rt.id ASC
            LIMIT :offset, :limit";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    // Lấy tất cả các kết quả của trang hiện tại
    $roomTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Truy vấn lấy tổng số bản ghi để tính tổng số trang
    $totalQuery = "SELECT COUNT(*) as total FROM room_types";
    $totalResult = $conn->query($totalQuery);
    $totalRow = $totalResult->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $totalRow['total'];
    $totalPages = ceil($totalRecords / $limit); // Tính tổng số trang

    // Trả về kết quả cùng với tổng số trang
    return [
        'roomTypes' => $roomTypes,
        'total_pages' => $totalPages
    ];
}



function deleteRoomtypes($id){
    try {
        $conn=connectdb();
        $sql="DELETE  from room_types where id=".$id;
        $conn->exec($sql);
        return true;
    } catch (Exception $ex) {
        return false;
    }
    
}

function addRoomtypes($typesname,$adult,$child,$price,$quantity, $des,$images=[]){
    $conn = connectdb();
    $sql="INSERT into room_types(type_name,adult,child,price,quantity,description)  values('$typesname','$adult','$child','$price','$quantity','$des')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $roomtypesId = $conn->lastInsertId();

    if (!empty($images)) {
        foreach ($images as $imageUrl) {
            $sql = "INSERT INTO images (room_type_id, image_url) VALUES ('$roomtypesId', '$imageUrl')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    }else{
        
            $sql = "INSERT INTO images (room_type_id, image_url) VALUES ('$roomtypesId', null)";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        
    }
}

function updateRoomtypes($id,$typesname,$adult,$child,$price,$quantity , $des,$images=[]){
    $conn = connectdb();
    $sql="UPDATE room_types set type_name='$typesname' ,adult='$adult' ,child='$child' ,price='$price' ,quantity='$quantity' ,description='$des'  where id=".$id;
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if (!empty($images)) {
        foreach ($images as $imageUrl) {
            $sql = "UPDATE  images set image_url='$imageUrl' where room_type_id=".$id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    }
}
    function getRoomtypesbyId($id){
    $conn=connectdb();
    $sql = "SELECT * FROM room_types where id=".$id;
    $stmt =$conn-> prepare($sql);
    $stmt->execute();
    $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;

}
function checkOldRoomtypes($Roomtypes){
        $conn=connectdb();
        $sql="SELECT * from room_types where type_name='$Roomtypes' ";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if($count > 0)
            return true;
        else 
            return false;
    }

   function findRoom($checkin,$checkout,$adult){
        $conn=connectdb();
        $sql = "SELECT rt.*, i.image_url, 
                    (rt.quantity - COUNT(DISTINCT CASE 
                        WHEN booked_rooms.room_id IS NOT NULL THEN r.id 
                    END)) AS available_quantity
                FROM 
                    room_types rt
                LEFT JOIN rooms r ON rt.id = r.room_type_id 
                LEFT JOIN (
                    SELECT 
                        br.room_id 
                    FROM 
                        booking_rooms br 
                    JOIN bookings b ON br.booking_id = b.id 
                    WHERE 
                    (b.status = 'confirmed' OR b.status = 'pending' OR b.status='checkin') 
                    AND br.check_in_date <= '$checkout'
                    AND br.check_out_date >= '$checkin'
                ) booked_rooms ON r.id = booked_rooms.room_id 
                LEFT JOIN images i ON rt.id = i.room_type_id
                WHERE 
                    rt.adult <= $adult
                GROUP BY 
                    rt.id, i.image_url;
                " ;
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    } 
    
    function autoSelectAvailableRooms($checkin,$checkout,$roomTypeSelections)
    {
        $conn = connectdb(); 
        $roomTypeCounts = array_count_values($roomTypeSelections); 
        $selectedRooms = [];
        
        foreach ($roomTypeCounts as $roomTypeId => $count) {
            $sql = "
                SELECT r.*, rt.type_name, rt.price
                FROM rooms r
                LEFT JOIN room_types rt ON r.room_type_id = rt.id
                WHERE r.room_type_id = $roomTypeId
                AND r.id NOT IN (
                    SELECT br.room_id
                    FROM booking_rooms br
                    JOIN bookings b ON br.booking_id = b.id 
                    WHERE (b.status = 'confirmed' OR b.status = 'pending' OR b.status='checkin') 
                    AND br.check_in_date <= '$checkout'
                    AND br.check_out_date >= '$checkin'
                )
                LIMIT $count;
            ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $availableRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($availableRooms as $room) {
                $selectedRooms[] = [
                    'room_id' => $room['id'],
                'type_name' => $room['type_name'],
                'room_number' => $room['room_number'],
                'price' => $room['price']
                ];
            }
            
        }
        return $selectedRooms;
    }
    function checkRoomAvailability($checkin,$checkout,$selectedRooms) {
    $conn = connectdb();
    $roomTypeCounts = array_count_values($selectedRooms); 
    $errors = [];

    foreach ($roomTypeCounts as $roomTypeId => $quantity) {
        $sql = "SELECT rt.id, 
                rt.type_name, 
                COUNT(r.id) AS available_quantity
        FROM room_types rt 
        JOIN rooms r ON rt.id = r.room_type_id 
        WHERE r.id NOT IN 
        ( SELECT br.room_id 
          FROM booking_rooms br 
          JOIN bookings b ON br.booking_id = b.id  
          WHERE (b.status = 'confirmed' OR b.status = 'pending' OR b.status='checkin') 
          AND (br.check_in_date <= '$checkout' 
          AND br.check_out_date >= '$checkin' ) 
        )
        AND rt.id = $roomTypeId
        GROUP BY rt.id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($room) {
            $availableQuantity = (int)$room['available_quantity'];
            if ($quantity > $availableQuantity) {
                $errors[] = "Loại phòng '{$room['type_name']}' không đủ số lượng. Còn lại: {$availableQuantity} phòng.";
            }
        }
    }
        return $errors;
    }
    function isRoomAvailable($roomId, $checkin, $checkout) {
        $conn = connectdb();
        $sql = "SELECT COUNT(*) as count
            FROM booking_rooms br JOIN bookings b ON br.booking_id = b.id
            WHERE (b.status = 'confirmed' OR b.status = 'pending' OR b.status='checkin') AND  room_id = $roomId
            AND 
            check_in_date <= '$checkout' AND check_out_date >= '$checkin'
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] == 0; 
    }

    function searchRoomtypes($search) {
            $conn = connectdb();
            $sql = "SELECT rt.*,i.image_url,(rt.quantity - COALESCE(SUM(CASE WHEN r.status = 'booked' THEN 1 ELSE 0 END), 0)) AS available_quantity FROM room_types rt  LEFT JOIN images i ON rt.id = i.room_type_id LEFT JOIN rooms r ON rt.id=r.room_type_id WHERE 
                    type_name LIKE :search GROUP BY rt.id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            $stmt->execute();
            $rt = $stmt->fetchAll();
            return $rt;

        }
?>