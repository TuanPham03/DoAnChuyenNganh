<?php
    function getAllRooms(){
        $conn=connectdb();
        $sql = "SELECT r.*, rt.type_name FROM rooms r LEFT JOIN room_types rt ON r.room_type_id = rt.id ORDER BY r.room_number ASC";
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }

    
    function getAllRoom($page , $limit ) {
        $conn = connectdb(); // Kết nối cơ sở dữ liệu
        
        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $limit;
        
        // Truy vấn lấy danh sách phòng với phân trang
        $sql = "SELECT r.*, rt.type_name FROM rooms r LEFT JOIN room_types rt ON r.room_type_id = rt.id ORDER BY r.room_number ASC LIMIT :offset, :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        // Lấy tất cả các kết quả
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Truy vấn lấy tổng số bản ghi để tính tổng số trang
        $total_query = "SELECT COUNT(*) as total FROM rooms";
        $total_result = $conn->query($total_query);
        $total_row = $total_result->fetch(PDO::FETCH_ASSOC);
        $total_records = $total_row['total'];
        $total_pages = ceil($total_records / $limit); // Tính tổng số trang
        
        // Trả về kết quả cùng với tổng số trang
        return [
            'rooms' => $rooms,
            'total_pages' => $total_pages
        ];
    }                                                           

    function getAllRoomNotBKR($checkin,$checkout){
        $conn=connectdb();
        $sql = "SELECT * FROM rooms WHERE id NOT IN( SELECT
                        br.room_id 
                    FROM 
                        booking_rooms br 
                    JOIN bookings b ON br.booking_id = b.id 
                    WHERE 
                    (b.status = 'confirmed' OR b.status = 'pending' OR b.status='checkin') 
                    AND br.check_in_date < '$checkout'
                    AND br.check_out_date > '$checkin');";
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }
    function addRoom($roomnumber,$roomtypeid,$status,$des){
        $conn = connectdb();
        $sql="INSERT into rooms(room_number,room_type_id,status,description)  values ('$roomnumber','$roomtypeid','$status','$des') ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function deleteRoom($id) {
    try {
        $conn = connectdb();
        $sql = "DELETE FROM rooms WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

    function availibleRoom($id){
            $conn = connectdb();
            $sql="UPDATE rooms set status='available' where id=".$id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    function bookedRoom($id){
            $conn = connectdb();
            $sql="UPDATE rooms set status='booked' where id=".$id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

    function updateRoom($id,$roomnumber,$roomtypeid,$status, $des){
        $conn = connectdb();

        $sql = "SELECT room_type_id FROM rooms WHERE id = '$id'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $currentRoomTypeId = $stmt->fetchColumn();

        $sql = "UPDATE rooms SET room_number='$roomnumber', room_type_id='$roomtypeid', status='$status', description='$des' WHERE id='$id'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($currentRoomTypeId != $roomtypeid) {
            updateRoomTypeQuantity($currentRoomTypeId);
        }
        updateRoomTypeQuantity($roomtypeid);

    }
    function getRoombyId($id) {
    try {
    
        $conn = connectdb();
        $sql = "SELECT * FROM rooms WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;

    } catch (PDOException $e) {
        return null;
    }
}

    function checkOldRoom($roomnumber){
            $conn=connectdb();
            $sql="SELECT * from rooms where room_number='$roomnumber' ";
            $stmt=$conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if($count > 0)
                return true;
            else 
                return false;
        }

    function updateRoomTypeQuantity($roomTypeId) {
        $conn = connectdb();

        $sql = "SELECT COUNT(*) FROM rooms WHERE room_type_id = '$roomTypeId'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $quantity = $stmt->fetchColumn();

        $sqlUpdate = "UPDATE room_types SET quantity = '$quantity' WHERE id = '$roomTypeId'";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->execute();
    }
    function searchRoom($search) {
        $conn = connectdb();
        $sql = "SELECT  r.*,rt.type_name FROM rooms r LEFT JOIN room_types rt on r.room_type_id=rt.id  WHERE 
                room_number LIKE :search ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        $room = $stmt->fetchAll();
        return $room;

    }
?>