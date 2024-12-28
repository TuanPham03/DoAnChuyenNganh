<?php
    function getAllBooking($page , $limit ) {
        $conn = connectdb();
        
        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $limit;
        
        // Truy vấn lấy danh sách booking với phân trang
        $sql = "SELECT * FROM bookings ORDER BY booking_date DESC LIMIT :offset, :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        // Lấy tất cả các kết quả
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Truy vấn lấy tổng số bản ghi để tính tổng số trang
        $total_query = "SELECT COUNT(*) as total FROM bookings";
        $total_result = $conn->query($total_query);
        $total_row = $total_result->fetch(PDO::FETCH_ASSOC);
        $total_records = $total_row['total'];
        $total_pages = ceil($total_records / $limit); // Tính tổng số trang
        
        // Trả về kết quả cùng với tổng số trang
        return [
            'bookings' => $bookings,
            'total_pages' => $total_pages
        ];
    }


    
    // function getAllBooking(){
    //     $conn=connectdb();
    //     $sql = "SELECT * from bookings order by booking_date DESC";
    //     $stmt =$conn-> prepare($sql);
    //     $stmt->execute();
    //     $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $kq;
    // }



    
    // function getAllBookingbyiduser($id){
    //     $conn=connectdb();
    //     $sql = "SELECT b.*,COUNT(br.room_id) as slphong FROM bookings b LEFT JOIN booking_rooms br on b.id=br.booking_id WHERE br.user_id=:id GROUP BY b.id order by b.booking_date DESC;";
    //     $stmt =$conn-> prepare($sql);
    //     $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    //     $stmt->execute();
    //     $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $kq;
    // }

    function getAllBookingbyiduser($id, $page, $limit) {
        $conn = connectdb();
        
        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $limit;

        // Truy vấn lấy danh sách booking của người dùng với phân trang
        $sql = "SELECT b.*, COUNT(br.room_id) as slphong 
                FROM bookings b 
                LEFT JOIN booking_rooms br ON b.id = br.booking_id 
                WHERE br.user_id = :id 
                GROUP BY b.id 
                ORDER BY b.booking_date DESC 
                LIMIT :offset, :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy danh sách booking
        $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Truy vấn lấy tổng số bản ghi của người dùng
        $total_query = "SELECT COUNT(DISTINCT b.id) as total 
                        FROM bookings b 
                        LEFT JOIN booking_rooms br ON b.id = br.booking_id 
                        WHERE br.user_id = :id";
        $total_stmt = $conn->prepare($total_query);
        $total_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $total_stmt->execute();
        $total_row = $total_stmt->fetch(PDO::FETCH_ASSOC);
        $total_records = $total_row['total'];
        $total_pages = ceil($total_records / $limit); // Tính tổng số trang

        // Trả về kết quả cùng với tổng số trang
        return [
            'bookings' => $bookings,
            'total_pages' => $total_pages
        ];
    }

    
    function getDetailBooking($id){
        $conn=connectdb();
        $sql="SELECT rc.id as rcid,rc.new_room_id,rc.change_date,br.*,r.id as id_room,r.room_number,r.status,rt.type_name,bg.guest_name,bg.guest_phone,bg.guest_email,bg.guest_id_number
        FROM booking_rooms br 
        left join rooms r on br.room_id=r.id
        left join room_types rt on r.room_type_id=rt.id
        left join booking_guests bg on br.id=bg.booking_rooms_id
        left join room_changes rc on rc.booking_rooms_id=br.id
        where br.booking_id=:id;
        ";
        $stmt =$conn-> prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }
    function getReservationById($id){
        $conn=connectdb();
        $sql = "SELECT s.service_name FROM reservations res left join services s on res.service_id=s.id where booking_rooms_id =".$id;
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }
    function getUserByBookingRoom($id){
        $conn=connectdb();
        $sql = "SELECT b.seri_num,b.booking_date,u.* FROM bookings b left join booking_rooms br on b.id=br.booking_id left join users u on u.id=br.user_id where b.id =".$id;
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }
    function getBookingById($id){
        $conn=connectdb();
        $sql = "SELECT * FROM bookings where id=".$id;
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }
    function confirmBooking($id){
        $conn = connectdb();
        $sql="UPDATE bookings set status='confirmed' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function cancelBooking($id){
        $conn = connectdb();
        $sql="UPDATE bookings set status='cancelled' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return true;
    }
    function checkinBooking($id){
        $conn = connectdb();
        $sql="UPDATE bookings set status='checkin' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function checkoutBooking($id){
        $conn = connectdb();
        $sql="UPDATE bookings set status='checkout' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function getAllPending(){
        $conn = connectdb();
        $sql = "SELECT * FROM bookings WHERE status = 'pending' order by booking_date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }
    
    function updateGuest($id,$name,$phone,$email,$idguest){
        $conn = connectdb();
        $sql="UPDATE booking_guests set guest_name=:name,guest_phone=:phone,guest_email=:email,guest_id_number=:idguest where booking_rooms_id =:idbookingroom";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':idguest', $idguest);
        $stmt->bindParam(':idbookingroom', $id);
        $stmt->execute();
    }
    function getGuestbyBookingid($id){
        $conn = connectdb();
        $sql="SELECT * FROM booking_guests WHERE booking_rooms_id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;
    }

    function searchBooking($search){
        $conn = connectdb();
        $sql = "SELECT * 
                FROM bookings 
                WHERE seri_num LIKE :search
                ORDER BY booking_date DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['search' => '%' . $search . '%']);
        $kq = $stmt->fetchAll();
        if (empty($kq)) {
            $error = "Không tìm thấy kết quả cho mã seri: $search.";
        } else {
            $error = '';
        }
        return ['kq' => $kq, 'error' => $error];
    }








function randomSeri(){
    $prefix = 'CT';
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('ymd');
    $time=date('his');
    $bookingCode = $prefix . '-' . $date . '-' . $time;
    return $bookingCode;
}
function createBooking($amount,$people) {
    $conn=connectdb();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d H:i:s');
    $seri=randomSeri();
    $sql="INSERT into bookings(seri_num,people,status,amount,booking_date) values('$seri','$people','pending','$amount','$date')";
    $stmt =$conn-> prepare($sql);
    $stmt->execute();
    $bookingid=$conn->lastInsertId();
    return $bookingid;
}
function addBooking($bookingid,$roomid,$userid,$checkin,$checkout,$gname,$gphone,$gemail,$serviceid,$amountBR){
   $conn=connectdb();
    if(!empty($roomid)){
        $sql = "INSERT into booking_rooms(booking_id,room_id,user_id,amount,check_in_date,check_out_date,early_checkout) 
                values('$bookingid','$roomid','$userid','$amountBR','$checkin','$checkout',null)";
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $bookingroomid=$conn->lastInsertId();
        $sql = "INSERT into booking_guests(booking_rooms_id, guest_name, guest_phone, guest_email,guest_id_number) 
                values('$bookingroomid', '$gname', '$gphone', '$gemail',null)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    if(!empty($serviceid)){
        foreach($serviceid as $serviceid){
        $sql = "INSERT into reservations(booking_rooms_id,service_id) 
                values('$bookingroomid','$serviceid')";
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        }
    }
}
?>