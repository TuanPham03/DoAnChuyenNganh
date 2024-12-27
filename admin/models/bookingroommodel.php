<?php
    // function getallbooingrooms(){
    //     $conn=connectdb();
    //     $sql="SELECT 
    //             b.seri_num,
    //             br.id AS booking_room_id,
    //             br.check_in_date, 
    //             br.check_out_date, 
    //             br.early_checkout, 
    //             COALESCE(rn.room_number, r.room_number) AS room_number, 
    //             COALESCE(rn.id, r.id) AS room_id,
    //             bg.guest_name, 
    //             bg.guest_phone, 
    //             bg.guest_id_number
    //         FROM booking_rooms br
    //         LEFT JOIN rooms r ON r.id = br.room_id
    //         LEFT JOIN booking_guests bg ON bg.booking_rooms_id = br.id
    //         LEFT JOIN bookings b ON b.id = br.booking_id 
    //         LEFT JOIN room_changes rc ON rc.booking_rooms_id = br.id
    //         LEFT JOIN rooms rn ON rn.id = rc.new_room_id 
    //         WHERE b.status = 'checkin' AND (r.status = 'booked' OR rn.status = 'booked')";
    //     $stmt =$conn-> prepare($sql);
    //     $stmt->execute();
    //     $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $kq;
    // }

    function getAllBookingRooms($page, $limit) {
        $conn = connectdb(); // Kết nối cơ sở dữ liệu

        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $limit;

        // Truy vấn lấy danh sách booking rooms với phân trang
        $sql = "SELECT 
                b.seri_num,
                br.id AS booking_room_id,
                br.check_in_date, 
                br.check_out_date, 
                br.early_checkout, 
                COALESCE(rn.room_number, r.room_number) AS room_number, 
                COALESCE(rn.id, r.id) AS room_id,
                bg.guest_name, 
                bg.guest_phone, 
                bg.guest_id_number
                FROM booking_rooms br
                LEFT JOIN rooms r ON r.id = br.room_id
                LEFT JOIN booking_guests bg ON bg.booking_rooms_id = br.id
                LEFT JOIN bookings b ON b.id = br.booking_id 
                LEFT JOIN room_changes rc ON rc.booking_rooms_id = br.id
                LEFT JOIN rooms rn ON rn.id = rc.new_room_id 
                WHERE b.status = 'checkin' AND (r.status = 'booked' OR rn.status = 'booked')
                LIMIT :offset, :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy tất cả các kết quả của trang hiện tại
        $bookingRooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Truy vấn lấy tổng số bản ghi để tính tổng số trang
        $totalQuery = "SELECT COUNT(*) as total
                    FROM booking_rooms br
                    LEFT JOIN bookings b ON b.id = br.booking_id 
                    LEFT JOIN rooms r ON r.id = br.room_id
                    LEFT JOIN room_changes rc ON rc.booking_rooms_id = br.id
                    LEFT JOIN rooms rn ON rn.id = rc.new_room_id
                    WHERE b.status = 'checkin' AND (r.status = 'booked' OR rn.status = 'booked')";

        $totalResult = $conn->query($totalQuery);
        $totalRow = $totalResult->fetch(PDO::FETCH_ASSOC);
        $totalRecords = $totalRow['total'];
        $totalPages = ceil($totalRecords / $limit); // Tính tổng số trang

        // Trả về kết quả cùng với tổng số trang
        return [
            'bookingRooms' => $bookingRooms,
            'total_pages' => $totalPages
        ];
    }

    
    function getBookingRoombyid($id,$bkrid){
        $conn=connectdb();
        $sql="SELECT br.*,r.room_number from booking_rooms br LEFT JOIN rooms r ON br.room_id=r.id where br.room_id=:id and br.id=:bkr ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':bkr', $bkrid, PDO::PARAM_INT);

        $stmt->execute();
        $bkrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $bkrooms;
    }
    function searchBookingRoom($search){
        $conn=connectdb();
        $sql = "SELECT 
                br.id AS booking_room_id,
                br.check_in_date, 
                br.check_out_date, 
                br.early_checkout, 
                COALESCE(rn.room_number, r.room_number) AS room_number,  
                COALESCE(rn.id, r.id) AS room_id,
                bg.guest_name, 
                bg.guest_phone, 
                bg.guest_id_number,
                b.seri_num
            FROM booking_rooms br
            LEFT JOIN rooms r ON r.id = br.room_id 
            LEFT JOIN booking_guests bg ON bg.booking_rooms_id = br.id
            LEFT JOIN bookings b ON b.id = br.booking_id 
            LEFT JOIN room_changes rc ON rc.booking_rooms_id = br.id
            LEFT JOIN rooms rn ON rn.id = rc.new_room_id  
            WHERE b.status = 'checkin' 
            AND (
                r.room_number LIKE :search
                or rn.room_number LIKE :search
                OR bg.guest_name LIKE :search  
                OR bg.guest_phone LIKE :search  
                OR bg.guest_id_number LIKE :search  
            )";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['search' => '%' . $search . '%']);
        $bkrooms = $stmt->fetchAll();
        return $bkrooms;
    }
    function checkEarlyCheckout($id) {
        $conn = connectdb();
        $sql = "SELECT 
                    br.id, 
                    br.check_out_date, 
                    br.room_id,
                    rc.id AS newid, 
                    rc.new_room_id,
                    rc.check_out_date AS new_checkout
                FROM 
                    booking_rooms br
                LEFT JOIN 
                    room_changes rc 
                ON 
                    rc.booking_rooms_id = br.id
                WHERE 
                    br.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $currentDate = date('Y-m-d');

        if (is_null($result['newid'])) { 
            if ($currentDate < $result['check_out_date']) {
                $sql = "UPDATE booking_rooms SET early_checkout = :currentDate WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':currentDate', $currentDate);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $sql = "UPDATE rooms SET status = 'available' WHERE id = :room_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':room_id', $result['room_id'], PDO::PARAM_INT);
                $stmt->execute();
                
            }
        } else {
            if ($currentDate < $result['new_checkout']) {
                $sql = "UPDATE booking_rooms SET early_checkout = :currentDate WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':currentDate', $currentDate);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                

                $sql = "UPDATE rooms SET status = 'available' WHERE id = :room_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':room_id', $result['new_room_id'], PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        
    }
    


?>