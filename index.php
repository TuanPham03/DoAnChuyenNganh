<?php
session_start();
ob_start();
include "./config/connect.php";
require_once "./inc/header.php";
if (isset($_GET['act'])) {
    switch($_GET['act']){
        case "home":
            include_once './admin/models/roomtypesmodel.php';
            if(isset($_SESSION['checkin'])&&($_SESSION['checkin']!="")){
                unset($_SESSION['checkin']);}
            if(isset($_SESSION['checkout'])&&($_SESSION['checkout']!="")){
                unset($_SESSION['checkout']);}
            if(isset($_SESSION['adults'])&&($_SESSION['adults']!="")){
                unset($_SESSION['adults']);}
            if(isset($_SESSION['children'])&&($_SESSION['children']!="")){
                unset($_SESSION['children']);}
            $_SESSION['formData'] = [];
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                $_SESSION['checkin']=$_POST['checkin']??'';
                $_SESSION['checkout']=$_POST['checkout']??'';
                $_SESSION['adults']=$_POST['adults']??'';
                $_SESSION['children']=$_POST['children']??'';
                $_SESSION['checkin1']=$_POST['checkin']??'';
                $_SESSION['checkout1']=$_POST['checkout']??'';
                header('location:index.php?act=room');
            }
            $roomtypes=getAllRoomtypess();
            require_once "./inc/carousel.php";
            break;
        case "room":
            
            include_once './admin/models/roomtypesmodel.php';
            $kq1='';
            if(isset($_SESSION['adults'])&&isset($_SESSION['checkin'])&&isset($_SESSION['checkout'])){
            $kq1=findRoom($_SESSION['checkin'],$_SESSION['checkout'],$_SESSION['adults']);
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                $_SESSION['checkin'] = $_POST['checkin'] ?? '';
                $_SESSION['checkout'] = $_POST['checkout'] ?? '';
                $_SESSION['adults'] = $_POST['adults'] ?? '';
                $_SESSION['children'] = $_POST['children'] ?? '';
                $_SESSION['checkin1'] = $_POST['checkin'] ?? '';
                $_SESSION['checkout1'] = $_POST['checkout'] ?? '';
                $checkin = $_SESSION['checkin'];
                $checkout = $_SESSION['checkout'];
                $adults = $_SESSION['adults'];
                $children = $_SESSION['children'];

                if(isset($_SESSION['adults'])&&isset($_SESSION['checkin'])&&isset($_SESSION['checkout'])){
                        $kq1=findRoom($_SESSION['checkin'],$_SESSION['checkout'],$_SESSION['adults']);
                }
            }
            
            
            require_once "./inc/room.php";
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['bookRoom'])) {

                
                if (!isset($_SESSION['user_id'])) {
                    $_SESSION['flag']=1;
                    echo '<script>
            
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                        confirmButton: "btn btn-success ",
                        cancelButton: "btn btn-danger me-2",
                        },
                        buttonsStyling: false,
                    });

                    swalWithBootstrapButtons
                        .fire({
                        title: "Cảnh báo",
                        text: "Bạn chưa đăng nhập, hãy đăng nhập để đặt phòng",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Đăng nhập",
                        cancelButtonText: "Hủy",
                        reverseButtons: true,
                        })
                        .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "login.php";
                        } 
                        });
                    </script>';
                
                }else if (!empty($errors)) {
                    $errorMessages = implode('<br>', $errors);
                    echo "<script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            background: '#FF3131',
                            color: 'white',
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            title: `{$errorMessages}`
                        });
                    </script>";
                }
                else if ($adults==''||$children=='') {
                    $errorMessages = implode('<br>', $errors);
                    echo "<script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            background: '#FF3131',
                            color: 'white',
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            title: `Vui lòng chọn số lượng người`
                        });
                    </script>";
                }
                else{
                    
                    header("Location: index.php?act=booking");
                    exit();
                }
                
            }
            break;
        case "booking":
            include_once './admin/models/servicesmodel.php';
            include_once './admin/models/roomtypesmodel.php';
            $selectedRooms = $_SESSION['selectedRooms'] ?? [];
            $selected=autoSelectAvailableRooms($_SESSION['checkin1'],$_SESSION['checkout1'],$selectedRooms);
            $services=getAllServices();
            require_once "./inc/booking.php";
            break;
        case "detailbooking":
            require_once "./admin/models/bookingmodel.php";
            require_once "./admin/models/checkdatebookingmodel.php";
            require_once "./admin/models/servicesmodel.php";
            $_SESSION['selectedRooms']=[];
            $Data=$_SESSION['formData']??'';
            $total_people=0;
            $total_people = (isset($_SESSION['adults']) ? $_SESSION['adults'] : 0) + (isset($_SESSION['children']) ? $_SESSION['children'] : 0);
            $total_price=0;
            require_once "./inc/detail.php";
            if( $_SERVER['REQUEST_METHOD'] === 'POST'){
                $totalprice=$_POST['total_amount']??'';
                $bookingid=createBooking($total_price,$total_people);
                foreach($Data as $index => $data){      
                    addBooking($bookingid,$data['room_id'],$_SESSION['user_id'],$data['checkin'],$data['checkout'],$data['fullname'],$data['numphone'],$data['email'],$data['services'],$data['total_room_price']);
                    $_SESSION['formData']=[];
                    
                }
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: 'Đặt phòng thành công!',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'index.php?act=history'; // Chuyển hướng sau khi xác nhận
                        });
                    </script>";
            }
            
            break;
        case "about":
            require_once "./inc/about.php";
            break;
        case "contract":
            require_once "./inc/contract.php";
            break;
        case "info":
            include_once "./admin/models/usermodel.php";
            $uid = $_SESSION['user_id'];
            $user = getUserbyId($uid);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id_inp'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                $status = 'success';
                $message = '';       

                if (isset($_POST['old-password']) && $_POST['old-password'] !== '') {
                    $oldpass = $_POST['old-password'];
                    $newpass = $_POST['new-password'];
                    $repass = $_POST['confirm-password'];
                    $oldpass = md5($oldpass);
                    $newpass = md5($newpass);
                    $repass = md5($repass);
                    if ($oldpass == $user[0]['password']) {
                        if ($newpass == $repass) {
                            updateUserpasswordbyuser($id, $name, $email, $phone, $newpass);
                        } else {
                            $status = 'error';
                            $message = 'password_mismatch';
                        }
                    } else {
                        $status = 'error';
                        $message = 'wrong_old_password';
                    }
                } else {
                    updateUserbyuser($id, $name, $email, $phone);
                }

                // Hiển thị thông báo
                if ($status === 'success') {
                    echo '<script>
                        Swal.fire({
                            title: "Thông báo",
                            text: "Cập nhật thành công",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "index.php?act=info"; // Tải lại trang
                        });
                    </script>';
                } else {
                    if ($message === 'password_mismatch') {
                        echo '<script>
                            Swal.fire({
                                title: "Lỗi",
                                text: "Mật khẩu mới và xác nhận mật khẩu không khớp!",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = "index.php?act=info"; // Tải lại trang
                            });
                        </script>';
                    } elseif ($message === 'wrong_old_password') {
                        echo '<script>
                            Swal.fire({
                                title: "Lỗi",
                                text: "Mật khẩu cũ không đúng!",
                                icon: "error",
                                confirmButtonText: "OK"
                            }).then(() => {
                                window.location.href = "index.php?act=info"; // Tải lại trang
                            });
                        </script>';
                    }
                }
            }
            require_once "./inc/infouser.php";
            break;

        case "history":
            include_once "./admin/models/bookingmodel.php";
            // $history=getAllBookingbyiduser($_SESSION['user_id']);
            $page = isset($_GET['page']) ? $_GET['page'] : 1; 
            $limit = 9;
            $result = getAllBookingbyiduser($_SESSION['user_id'],$page, $limit);
            $history = $result['bookings'];
            $total_pages = $result['total_pages'];
            require_once "./inc/historybooking.php";
            break;
        case "cancelbooking":
            include_once "./admin/models/bookingmodel.php";

            if (isset($_GET['id'])) {
                $id=$_GET['id'];
                $kq=cancelBooking($id);
                if ($kq) {
                    $txt_success="Hủy đặt phòng thành công";
                }
            }
            // $history=getAllBookingbyiduser($_SESSION['user_id']);
            $page = isset($_GET['page']) ? $_GET['page'] : 1; 
            $limit = 9;
            $result = getAllBookingbyiduser($_SESSION['user_id'],$page, $limit);
            $history = $result['bookings'];
            $total_pages = $result['total_pages'];
            require_once "./inc/historybooking.php";
            break;

        case "viewBooking":
            include_once "./admin/models/bookingmodel.php";
            include_once "./admin/models/roomsmodel.php";  
            if(isset($_GET['id'])){
                    $id=$_GET['id'];
                    $data=getDetailBooking($id);
                    $bookingid=getBookingById($id);
                    $user=getUserByBookingRoom($id);
                    $room=getAllRooms();
            }
            require_once "./inc/detailhistory.php";
            break;
    }
}
require_once "./inc/footer.php";
?>