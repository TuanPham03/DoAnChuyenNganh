<?php
    function calculateDay($checkin, $checkout) {
        if ($checkout) {
            $checkinDate = new DateTime($checkin);
            $checkoutDate = new DateTime($checkout);
            $interval = $checkinDate->diff($checkoutDate);
            $day=$interval->days;
            if($day==0){
                return 1;
            }else{
                return $day;
            }
        }
        
    }
?>