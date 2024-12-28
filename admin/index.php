<?php
require_once "../config/connect.php";
require_once "../admin/models/bookingmodel.php";
include "dashboard.php";

 if (isset($_GET['act'])) {
        switch($_GET['act']){
                //Home
                case 'home':
                        require_once "../admin/models/bookingmodel.php";
                        $kq=getAllPending();
                        require_once "home.php";
                        break;
                case 'confirmBookingHome':
                        require_once "../admin/models/bookingmodel.php";
                        if (isset($_GET['id'])) {
                               $id=$_GET['id'];
                               confirmBooking($id);
                        }
                        $kq=getAllPending();
                        require_once "home.php";
                        break;
                //Booking
                case 'booking':
                        require_once "../admin/models/bookingmodel.php";
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                                $total_pages='';
                                $page='';
                                $searchPart1 = $_POST['inp_search1'] ?? '';
                                $searchPart2 = $_POST['inp_search2'] ?? '';
                                if ($searchPart1!=""||$searchPart2!="") {
                                        $searchTerm = "CT-" . $searchPart1 . "-" . $searchPart2;
                                        $kq=searchBooking($searchTerm);
                                        $booking=$kq['kq']??'';
                                        $err=$kq['error']??'';
                                }else{
                                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                                        $limit = 10;
                                        $result = getAllBooking($page, $limit);
                                        $booking = $result['bookings'];
                                        $total_pages = $result['total_pages'];
                                }
                                
                        }else{$page = isset($_GET['page']) ? $_GET['page'] : 1; 
                                $limit = 10;
                                $result = getAllBooking($page, $limit);
                                $booking = $result['bookings'];
                                $total_pages = $result['total_pages'];
                        // $booking=getAllBooking();
                        }
                        require_once "booking.php";
                        break;
                case 'confirmBooking':
                        require_once "../admin/models/bookingmodel.php";
                        if (isset($_GET['id'])) {
                               $id=$_GET['id'];
                               confirmBooking($id);
                               header("Location: index.php?act=booking");
                        }
                        // $kq=getAllBooking();
                        require_once "booking.php";
                        break;
                case 'cancelBooking':
                        require_once "../admin/models/bookingmodel.php";
                        if (isset($_GET['id'])) {
                               $id=$_GET['id'];
                               cancelBooking($id);
                               header("Location: index.php?act=booking");
                        }
                        // $kq=getAllBooking();
                        require_once "booking.php";
                        break;
                case 'checkinBooking':
                        require_once "../admin/models/bookingmodel.php";
                        if (isset($_GET['id'])) {
                               $id=$_GET['id'];
                               checkinBooking($id);
                               header("Location: index.php?act=booking");
                        }
                        // $kq=getAllBooking();
                        require_once "booking.php";
                        break;
                case 'checkoutBooking':
                        require_once "../admin/models/bookingmodel.php";
                        if (isset($_GET['id'])) {
                               $id=$_GET['id'];
                               checkoutBooking($id);
                               header("Location: index.php?act=booking");
                        }
                        // $kq=getAllBooking();
                        require_once "booking.php";
                        break;
                
                //ROOM
                case 'room':
                        include_once '../admin/models/roomsmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        $page="";
                        $total_pages="";
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                        if (!empty($search)) {
                                $kq=searchRoom($search);
                        }else{
                                // $kq=getAllRoom();
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;  
                                $limit = 10;  
                                $result = getAllRoom($page, $limit);  
                                $kq = $result['rooms'];
                                $total_pages = $result['total_pages'];
                                $roomtype=getAllRoomtypess();   
                        }
                        
                        require_once 'room.php';
                        break;
                case 'addRoom':

                        include_once '../admin/models/roomsmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        $page="";
                        $total_pages="";
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_addRoom'])) {
                                $roomnumber=$_POST['number-room_inp'];
                                $roomtypeid=isset($_POST['type_room']) ? $_POST['type_room'] : '';
                                $status=$_POST['status'];
                                $des=$_POST['description_room'];
                                if(empty($roomtypeid)){
                                        $txt_err = "Vui lòng chọn loại phòng.";  
                                        
                                }elseif(checkOldRoom($roomnumber)){
                                        $txt_err="Tên phòng này đã có";
                                        
                                }else{
                                        addRoom($roomnumber,$roomtypeid,$status,$des);
                                        updateRoomTypeQuantity($roomtypeid);
                                        header('location:index.php?act=room');
                                        exit;
                                }
                                
                        }
                        // $kq=getAllRoom();
                        
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;  
                        $limit = 10;  
                        $result = getAllRoom($page, $limit);  
                        $kq = $result['rooms'];
                        $total_pages = $result['total_pages'];
                        $roomtype=getAllRoomtypess();   
                        require_once 'room.php';
                        break;
                case 'delRoom':
                        include_once '../admin/models/uploadmodel.php';
                        include_once '../admin/models/roomsmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        if(isset($_GET['id'])){
                                $encodedId = $_GET['id'];
                                $id = base64_decode($encodedId);
                                $room1 = getRoombyId($id);
                                $roomTypeId = $room1[0]['room_type_id']??"";
                                $kq=deleteRoom($id);
                                if($kq){
                                        $txt_success = 'Đã xóa phòng thành công';
                                }else{
                                        $txt_errr = 'Xóa phòng thất bại';
                                }
                                updateRoomTypeQuantity($roomTypeId);
                                 
                        }
                        // $kq=getAllRoom();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;  
                        $limit = 10;  
                        $result = getAllRoom($page, $limit);  
                        $kq = $result['rooms'];
                        $total_pages = $result['total_pages'];
                        $roomtype=getAllRoomtypess();
                        require_once 'room.php';
                        break;
                case 'updateRoom':
                        include_once '../admin/models/roomsmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $room=getRoombyId($id);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_updateRoom'])) {
                                $id=$_POST['id_inp'];
                                
                                $roomnumber=$_POST['number-room_inp'];
                                $roomtypeid=$_POST['type_room'];
                                $status=$_POST['status'];
                                $des=$_POST['description_room'];
                                
                                updateRoom($id,$roomnumber,$roomtypeid,$status,$des);
                                header('location:index.php?act=room');

                        }
                        // $kq=getAllRoom();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 10; 
                        $result = getAllRoom($page, $limit); 
                        $kq = $result['rooms'];
                        $total_pages = $result['total_pages'];
                        $roomtype=getAllRoomtypess();
                        require_once 'room.php';
                        break;
                //USER        
                case 'user':
                        include_once '../admin/models/usermodel.php';
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $limit = 10; 
                        if (!empty($search)) {     
                                $total_pages="";
                                $kq = searchUser($search); 
                        } else {
                                
                                $result = getAllUsers($page, $limit); 
                                $kq = $result['users'];
                                $total_pages = $result['total_pages'];
                        }
                        require_once 'user.php';
                        break;

                case 'delUser':
                        include_once '../admin/models/usermodel.php';
                        if(isset($_GET['id'])){
                                $encodedId = $_GET['id'];
                                $id = base64_decode($encodedId);
                                $result=deleteUser($id);
                                if($result){
                                        $txt_success='Đã xóa người dùng thành công';
                                }else{
                                        $txt_errr='Không thể xóa người dùng này';
                                }
                        }
                        // $kq=getAllUser();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 10;
                        $result = getAllUsers($page, $limit);
                        $kq = $result['users'];
                        $total_pages = $result['total_pages'];
                        require_once 'user.php';
                        break;
                case 'addUser':
                        include_once '../admin/models/usermodel.php';
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_addUser'])) {
                                $fullname=$_POST['fullname_inp'];
                                $username=$_POST['username_inp'];
                                $password=$_POST['pw_inp'];
                                $email=$_POST['email_inp'];
                                $phone=$_POST['phone_inp'];
                                $role=$_POST['role_select'];
                                if(checkOldUser($username)){
                                        $txt_err="Tên tài khoản này đã có người sử dụng";
                                }else{
                                        addUser($fullname, $username,$password, $email, $phone, $role);
                                }
                        }
                        // $kq=getAllUser();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 10;
                        $result = getAllUsers($page, $limit);
                        $kq = $result['users'];
                        $total_pages = $result['total_pages'];
                        require_once 'user.php';
                        break;
                case 'updateUser':
                        include_once '../admin/models/usermodel.php';
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $user=getUserbyId($id);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_updateUser'])) {
                                $id=$_POST['id_inp'];
                                $fullname=$_POST['fullname_inp'];
                                $username=$_POST['username_inp'];
                                $password=$_POST['pw_inp'];
                                $email=$_POST['email_inp'];
                                $phone=$_POST['phone_inp'];
                                $role=$_POST['role_select'];
                                updateUser($id,$fullname, $username,$password, $email, $phone, $role);
                        }
                        // $kq=getAllUser();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 10;
                        $result = getAllUsers($page, $limit);
                        $kq = $result['users'];
                        $total_pages = $result['total_pages'];
                        require_once 'user.php';
                        break;
                //Roomtypes
                case 'roomtypes':    
                        include_once '../admin/models/uploadmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        $page="";
                        $total_pages="";
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                        if (!empty($search)) {
                                $kq=searchRoomtypes($search);
                        }else{
                                // $kq=getAllRoomtypes();
                                $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                                $limit = 5;
                                $result = getAllRoomTypes($page, $limit);
                                $kq = $result['roomTypes'];
                                $total_pages = $result['total_pages'];
                        }
                        require_once 'roomtypes.php';
                        break;
                case 'delRoomtypes':
                        include_once '../admin/models/uploadmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        if(isset($_GET['id'])){
                                $encodedId = $_GET['id'];
                                $id = base64_decode($encodedId);
                                $k=deleteRoomtypes($id);
                                if($k){
                                        $txt_success="Đã xóa loại phòng thành công";
                                }else{
                                        $txt_error="Xóa loại phòng thất bại";
                                }
                        }
                        // $kq=getAllRoomtypes();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 5;
                        $result = getAllRoomTypes($page, $limit);
                        $kq = $result['roomTypes'];
                        $total_pages = $result['total_pages'];
                        require_once 'roomtypes.php';
                        break;
                case 'addRoomtypes':
                        include_once '../admin/models/uploadmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_addRoomtypes'])) {
                                $typesname=$_POST['nameroomtypes_inp']; 
                                $adult=$_POST['adult_inp'];
                                $child=$_POST['child_inp'];
                                $price=$_POST['price_inp'];
                                $quantity=0;
                                $des=$_POST['description_roomtypes'];
                                $images = [];
                                if(checkOldRoomtypes($typesname)){
                                        $txt_err="Tên loại phòng này đã có";
                                }elseif(!empty($name)&& empty($err)){
                                        $images[] = $name;
                                        addRoomtypes($typesname,$adult,$child,$price,$quantity,$des,$images);
                                        header("location: index.php?act=roomtypes");
                                        exit;
                                }else{
                                        addRoomtypes($typesname,$adult,$child,$price,$quantity,$des,$images);
                                        header("location: index.php?act=roomtypes");
                                        exit;
                                }
                        }
                        // $kq=getAllRoomtypes();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 5;
                        $result = getAllRoomTypes($page, $limit);
                        $kq = $result['roomTypes'];
                        $total_pages = $result['total_pages'];
                        require_once 'roomtypes.php';
                        break;
                case 'updateRoomtypes':
                        include_once '../admin/models/uploadmodel.php';
                        include_once '../admin/models/roomtypesmodel.php';
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $typesroom=getRoomtypesbyId($id);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_updateRoomtypes'])) {
                                $id=$_POST['id_inp'];
                                $typesname=$_POST['nameroomtypes_inp']; 
                                $adult=$_POST['adult_inp'];
                                $child=$_POST['child_inp'];
                                $price=$_POST['price_inp'];
                                $quantity=$_POST['quantity'];
                                $des=$_POST['description_roomtypes'];
                                if (!empty($name)&& empty($err)) {
                                        $images[] = $name;
                                        updateRoomtypes($id,$typesname,$adult,$child,$price,$quantity,$des,$images);
                                        header("location: index.php?act=updateRoomtypes");
                                        exit;
                                }
                                elseif(empty($name)){
                                        updateRoomtypes($id,$typesname,$adult,$child,$price,$quantity,$des);
                                        header("location: index.php?act=updateRoomtypes");
                                        exit;
                                }
                                
                        }
                        // $kq=getAllRoomtypes();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                        $limit = 5;
                        $result = getAllRoomTypes($page, $limit);
                        $kq = $result['roomTypes'];
                        $total_pages = $result['total_pages'];
                        require_once 'roomtypes.php';
                        break;
                //Service
                case 'services':    
                        include_once "../admin/models/servicesmodel.php";
                        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                        if (!empty($search)) {
                                $kq = searchService($search);
                        } else {
                                $kq = getAllServices();
                        }
                        require_once "../admin/services.php";
                        break;

                case 'delServices':
                        include_once "../admin/models/servicesmodel.php";
                        if(isset($_GET['id'])){
                                $encodedId = $_GET['id'];
                                $id = base64_decode($encodedId);
                                $s=deleteServices($id);
                                if ($s) {
                                        $txt_success="Đã xóa dịch vụ thành công";
                                }
                        }
                        $kq=getAllServices();
                        require_once "../admin/services.php";
                        break;
                case 'addServices':
                        include_once "../admin/models/servicesmodel.php";
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_addServices'])) {
                                $name=$_POST['nameservices_inp'];
                                $price=$_POST['servicesprice_inp'];
                                $description=$_POST['description_services'];
                                if(checkOldServices($name)){
                                        $txt_err="Tên dịch vụ này đã có";
                                }else{
                                        addServices( $name,$price,$description);
                                }
                        }
                        $kq=getAllServices();
                        require_once "../admin/services.php";
                        break;
                case 'updateServices':
                        include_once "../admin/models/servicesmodel.php";
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $Services=getServicesbyId($id);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_updateServices'])) {
                                $id=$_POST['id_inp'];
                                $name=$_POST['nameservices_inp'];
                                $price=$_POST['servicesprice_inp'];
                                $description=$_POST['description_services'];
                                updateServices( $id,$name,$price,$description);
                        }
                        $kq=getAllServices();
                        require_once "../admin/services.php";
                        break;
                case 'viewBooking':
                        include_once "../admin/models/bookingmodel.php";
                        include_once "../admin/models/roomsmodel.php";
                        
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $data=getDetailBooking($id);
                                $bookingid=getBookingById($id);
                                $user=getUserByBookingRoom($id);
                                $room=getAllRooms();
                        }
                        require_once "../admin/detailbooking.php";
                        break;
                case 'checkin':
                        include_once "../admin/models/bookingmodel.php";
                        include_once "../admin/models/roomsmodel.php";
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $data=getDetailBooking($id);
                                $bookingid=getBookingById($id);
                                $user=getUserByBookingRoom($id);
                                
                                if(isset($_GET['id'])&&isset($_GET['idroom'])){
                                        $idroom=$_GET['idroom'];
                                        bookedRoom($idroom);     
                                        header("Location: index.php?act=viewBooking&id=$id");
                                        exit();                     
                                }
                        }
                        require_once "../admin/detailbooking.php";
                        break;
                case 'checkout':
                        include_once "../admin/models/bookingmodel.php";
                        include_once "../admin/models/bookingroommodel.php";

                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $data=getDetailBooking($id);
                                $bookingid=getBookingById($id);
                                $user=getUserByBookingRoom($id);
                                if(isset($_GET['id'])&&isset($_GET['idroom'])){
                                        $idroom=$_GET['idroom'];
                                        checkEarlyCheckout($idroom);
                                        header("Location: index.php?act=viewBooking&id=$id");
                                        exit();
                                }
                        }
                        require_once "../admin/detailbooking.php";
                        break;
                case 'updateGuest':
                        include_once "../admin/models/bookingmodel.php";
                        include_once "../admin/models/roomsmodel.php";
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                $data=getDetailBooking($id);
                                $bookingid=getBookingById($id);
                                $user=getUserByBookingRoom($id);
                                $room=getAllRooms();
                        }
                        if(isset($_GET['idbook'])){
                                $idroom=$_GET['idbook'];
                                $guest=getGuestbyBookingid($idroom);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_updateGuest'])) {
                                $idbr=$_POST['id_inp'];
                                $name=$_POST['fullnameguest_inp'];
                                $phone=$_POST['phoneguest_inp'];
                                $email=$_POST['emailguest_inp'];
                                $idguest=$_POST['idguest_inp'];
                                updateGuest($idbr,$name,$phone,$email,$idguest);
                                header("Location: index.php?act=viewBooking&id=$id");
                                exit();
                        }
                          
                        require_once "../admin/detailbooking.php";
                        break;
                case 'bookingRooms':
                        include_once "../admin/models/bookingroommodel.php";
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                                $total_pages='';
                                $page='';
                                $search=$_POST['inp_search'];
                                if($search!=""){
                                $bkrooms=searchBookingRoom($search);
                                }else{
                                // $bkrooms=getallbooingrooms();
                                $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                                $limit = 10;
                                $result = getAllBookingRooms($page, $limit);
                                $bkrooms = $result['bookingRooms'];
                                $total_pages = $result['total_pages'];
                                }
                        }else
                        {
                        // $bkrooms=getallbooingrooms();
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;  
                                $limit = 10;
                                $result = getAllBookingRooms($page, $limit);
                                $bkrooms = $result['bookingRooms'];
                                $total_pages = $result['total_pages'];
                        }
                        require_once "../admin/bookingroom.php";
                        break;
                case 'checkoutroom':
                        include_once "../admin/models/bookingroommodel.php";
                        if(isset($_GET['id'])){
                                $id=$_GET['id'];
                                checkEarlyCheckout($id);
                                header("Location: index.php?act=bookingRooms");
                                exit();
                        }
                        break;
                case 'changeRoom':
                        include_once "../admin/models/bookingroommodel.php";
                        include_once "../admin/models/roomsmodel.php";
                        include_once "../admin/models/changemodel.php";

                        if(isset($_GET['id'])&&isset($_GET['bkr'])){
                                $id=$_GET['id'];
                                $bkr=$_GET['bkr'];
                                $bkroom=getBookingRoombyid($id,$bkr);
                        }
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_changeRoom'])) {
                                $idbkr=$_POST['id_inp'];
                                $idoldroom=$_POST['idroom_inp'];
                                $idnewroom=$_POST['newroom'];
                                $checkin=$_POST['checkin_inp'];
                                $checkout=$_POST['checkout_inp'];
                                $reason=$_POST['reason'];
                                addRoomChange($idbkr,$idoldroom,$idnewroom,$checkin,$checkout,$reason);
                                availibleRoom($idoldroom);
                                bookedRoom($idnewroom);
                                header("Location: index.php?act=bookingRooms");
                        }
                        // $bkrooms=getallbooingrooms();
                        $page = isset($_GET['page']) ? $_GET['page'] : 1; 
                                $limit = 10;
                                $result = getAllBookingRooms($page, $limit);
                                $bkrooms = $result['bookingRooms'];
                                $total_pages = $result['total_pages'];
                        require_once "../admin/bookingroom.php";
                        break;
        }
}
include "footer.php";
?>