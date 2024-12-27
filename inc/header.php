<?php
if (!isset($_GET['act'])) {
            header('location:index.php?act=home');
            exit();
        }  
    $act=$_GET['act'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .h-text {
        font-family: 'Poppins', sans-serif;
    }

    .booking-container {
        background-size: cover;
        background-position: center;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-form {
        width: 1200px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .contact-sidebar {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 10px;
        z-index: 1000;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background-color: #f3f4f6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s, transform 0.3s;
    }

    .contact-icon img {
        width: 70%;
        height: 70%;
    }

    .contact-icon:hover {
        transform: scale(1.1);
        background-color: #e0e7ff;
    }

    .hotel-card {
        height: 100%;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        margin-bottom: 20px;
    }

    .hotel-card:hover {
        transform: scale(1.02);
    }

    .card-img-top {
        object-fit: cover;
        height: 260px;
    }

    .card-title {
        font-weight: bold;
    }

    .rating {
        color: #ffcc00;
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .old-price {
        text-decoration: line-through;
        color: #888;
    }

    .features {
        text-align: center;
        font-size: 0.9rem;
        color: #555;
    }

    .adult-child {
        font-size: 0.9rem;
    }

    .genius {
        background: #f8f9fa;
        padding: 10px;
        border: 1px solid #007bff;
        border-radius: 5px;
    }

    .frame {
        min-height: 100px;
        border: 2px rgba(0, 0, 0, 0.5);
        width: 300px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .filter-section {
        border-right: 1px solid #dee2e6;
        padding-right: 20px;
    }

    .container {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    h2 {
        color: #007bff;
        margin-bottom: 30px;
        text-align: center;
    }

    .room-info {
        background-color: #f1f8ff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .room-info h5 {
        color: #007bff;
    }

    .room-info p {
        font-size: 16px;
        color: #333;
    }

    .room-info ul {
        padding-left: 20px;
    }

    .room-info ul li {
        font-size: 16px;
        color: #555;
    }

    .service-title {
        font-weight: bold;
        color: #007bff;
    }



    .room-details {
        display: flex;
        justify-content: left;
        gap: 20px;
    }

    .room-details .left,
    .room-details .right {
        width: 48%;

    }

    .room-details .right {
        text-align: right;

    }

    .service-title {
        font-weight: bold;
    }

    .detai-txt-check ul {
        list-style-type: disc;
        padding-left: 20px;

    }

    .txt-total-price-detail {
        color: #333;
        font-weight: bold;
        border-top: 2px solid #ccc;
        padding-top: 10px;

    }

    .navbar-nav {
        margin: 0 auto;
    }

    .navbar-collapse {
        display: flex;
        justify-content: center;
    }

    li {
        list-style: none;
    }

    .btnlogin {
        background-color: #3B82F6;
    }

    .btnregister {
        background-color: #22C55E;
    }

    .contact-section {
        background: #fff;
        padding: 0px 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
        background: #007bff;
        color: #fff;
        padding: 30px;
        border-radius: 10px;
    }

    .contact-info i {
        font-size: 30px;
        margin-right: 15px;
    }

    .contact-info h5 {
        margin-bottom: 10px;
    }

    .btn-custom {
        background-color: #007bff;
        color: #fff;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <header>
        <nav
            class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top border-bottom border-2">
            <div class="container-fluid">
                <a class="navbar-brand me-5 fw-bold fs-3 h-text" href="index.php?act=home">CT HOTEL</a>
                <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active me-3" aria-current="page" href="index.php?act=home">Trang
                                chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3" href="index.php?act=contract">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3" href="index.php?act=about">Giới thiệu</a>
                        </li>
                    </ul>
                    <div>
                        <?php if (isset($_SESSION['user_id'])){ ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['name'] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end px-1" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="index.php?act=info">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="index.php?act=history">Lịch sử đặt phòng</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger " href="./admin/logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                        <?php }else{ ?>
                        <a class="btn btn-primary me-2" href="login.php" role="button">Đăng nhập</a>
                        <a class="btn btn-secondary btn-success" href="register.php" role="button">Đăng ký</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>