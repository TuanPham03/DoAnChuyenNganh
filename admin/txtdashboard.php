<?php
$title='Dashboard';
                                
if (isset($_GET['act'])) {
        switch($_GET['act']){
                case 'room':
                case 'delRoom':
                case 'addRoom':
                case 'updateRoom':
                        $title='Quản lý phòng';
                        $target='#addRoomModal';
                        $text='Thêm phòng';
                        $visible= 'd-block' ;
                        break;
                case 'user':
                case 'delUser':
                case 'addUser':
                case 'updateUser':
                        $title='Quản lý người dùng';
                        break;
                case 'roomtypes':
                case 'delRoomtypes':
                case 'addRoomtypes':
                case 'updateRoomtypes':
                        $title='Quản lý loại phòng';
                        $target='#addRoomtypesModal';
                        $text='Thêm loại phòng';
                        $visible='d-block' ;
                        break;
                case 'services':
                case 'delServices':
                case 'addServices':
                case 'updateServices':
                        $title='Quản lý dịch vụ';
                        $target='#addServicesModal';
                        $text='Thêm dịch vụ';
                        $visible='d-block' ;
                        break;
                
                case 'confirmBooking':
                        $title='Quản lý đặt phòng';
                        $target='#addBookingModal';
                        $text='Đặt phòng';
                        $visible= 'd-block' ;
                        break;
                case 'cancelBooking':
                        $title='Quản lý đặt phòng';
                        $target='#addBookingModal';
                        $text='Đặt phòng';
                        $visible= 'd-block' ;
                        break;
                case 'viewBooking':
                        $title='Chi Tiết Đơn Đặt Phòng';
                        break;
                
        }
}
echo $title;
?>