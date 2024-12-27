<?php 
require_once "./config/connect.php";
require_once "./admin/models/usermodel.php";
$txt_err = "";
$txt_confirm="";
if (isset($_POST['register'])) {
    $fullname = $_POST['fullname_inp'];
    $email = $_POST['email_inp'];
    $username=$_POST['username_inp'];
    $password = $_POST['password'];
    $confirm_password = $_POST['repassword'];
    $role = 'customer';
    $phone = '';
    
    if(checkOldUser($username)) {
        $txt_err="Tên tài khoản này đã có người sử dụng";
    }else{
        if($password==$confirm_password){
            $password=md5($password);
            addUser($fullname, $username,$password, $email, $phone, $role); 
            $txt_confirm="Tạo tài khoản thành công";
        }else{
            $txt_err="Mật khẩu không khớp";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Đăng Ký</title>
    <style>
    .card-container {
        max-width: 400px;
        margin: auto;
        margin-top: 80px;
    }

    .form-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    body {
        background-image: url('images/background.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-container">
            <div class="card-body">
                <h2 class="text-center">Đăng Ký</h2>
                <?php if (!empty($txt_err)): ?>
                <div><?php echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "'.$txt_err.'"
                    });
                    </script>' ?></div>
                <?php elseif (!empty($txt_confirm)): ?>
                <div><?php echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "success",
                        text: "'.$txt_confirm.'"
                    });
                    </script>' ;
                    header('Location: login.php');
                    ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên</label>
                        <input type="text" name="fullname_inp" class="form-control" id="fullname"
                            placeholder="Nhập họ và tên" value="<?php echo $fullname??''?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên tài khoản</label>
                        <input type="text" name="username_inp" class="form-control" id="username"
                            placeholder="Nhập tên tài khoản" value="<?php echo $username??''?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email</label>
                        <input type="email" name="email_inp" class="form-control" id="registerEmail"
                            placeholder="Nhập email" value="<?php echo $email??''?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" id="registerPassword"
                            placeholder="Nhập mật khẩu" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" name="repassword" class="form-control" id="confirmPassword"
                            placeholder="Nhập lại mật khẩu" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Đăng Ký</button>
                </form>
                <p class="mt-3 text-center">Bạn đã có tài khoản? <a href="login.php">Đăng Nhập</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>