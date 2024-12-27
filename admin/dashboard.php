<?php
    session_start();
    ob_start();
    require_once "../admin/models/bookingmodel.php";
    if($_SESSION['role']!='admin'){
        header('location:../login.php');
        exit;
    }
    else if (!isset($_GET['act'])) {
        header('location:index.php?act=home');
        exit();
    }  
    
    $act=$_GET['act'];
    $visible='d-none';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pagination.js/dist/pagination.css">
    <script src="https://cdn.jsdelivr.net/npm/pagination.js/dist/pagination.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
    tr {
        text-align: center;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #007bff;
        color: white;
    }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="menu border border-end-2 border-black " id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase ">
                <a href="index.php?act=home" class="text-dark text-decoration-none "><i
                        class="fas fa-user-secret me-2"></i>ADMIN</a>
            </div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php?act=booking"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php echo ($act == 'booking') ? 'active' : ''; ?>"><i
                        class="fa-solid fa-download me-2"></i>Đặt phòng
                </a>
                <a href="index.php?act=bookingRooms"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php echo ($act == 'bookingRooms') ? 'active' : ''; ?>"><i
                        class="bi bi-bookmark me-2"></i>Phòng đang đặt
                </a>
                <a href="index.php?act=room"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php echo ($act == 'room') ? 'active' : ''; ?>"><i
                        class="fa-solid fa-th me-2"></i>Phòng</a>
                <a href="index.php?act=roomtypes"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php echo ($act == 'roomtypes') ? 'active' : ''; ?>"><i
                        class="fa-solid fa-swatchbook me-2"></i>Loại phòng </a>
                <a href="index.php?act=services"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php echo ($act == 'services') ? 'active' : ''; ?>"><i
                        class="fa-solid fa-cogs me-2"></i>Dịch vụ</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-print me-2"></i>Hóa đơn</a>
                <a href="index.php?act=user"
                    class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php echo ($act == 'user') ? 'active' : ''; ?>"><i
                        class="fa-solid fa-users me-2"></i>Tài khoản</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fa-solid fa-sliders me-2"></i>Thống kê</a>
                <a href="logout.php"
                    class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Đăng xuất</a>
            </div>

        </div>
        <div class="" id="page-content-wrapper">
            <div class="navbar navbar-expand-lg navbar-light bg-transparent py-4 pb-3 px-4 justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-8">
                        <?php 
                            require_once "txtdashboard.php";
                        ?>
                    </h2>
                </div>
                <button data-bs-target="<?php echo $target??"";?>" type="button"
                    class="btn btn-success <?php echo $visible??""; ?> " data-bs-toggle="modal">
                    <?php echo $text;?>
                </button>
            </div>
            <div class="container-fluid px-4">