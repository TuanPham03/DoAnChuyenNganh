<?php 
function addRoomChange($bkr_id,$oldroom_id,$newroom_id,$checkin,$checkout,$reason){
    $conn = connectdb();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d H:i:s');
    $sql="INSERT into room_changes(booking_rooms_id,old_room_id ,new_room_id,check_in_date,check_out_date,change_date,reason) 
        values('$bkr_id', '$oldroom_id','$newroom_id', '$checkin', '$checkout','$date','$reason')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

?>