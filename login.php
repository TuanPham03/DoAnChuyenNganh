<?php
session_start();
ob_start();
require_once "./config/connect.php";
require_once "./admin/models/usermodel.php";
$flag=$_SESSION['flag']??0;
if (isset($_POST['login'])) {

    $email = $_POST['email_inp'];
    $pass = $_POST['password'];
    $pass=md5($pass);
    $user=checkuser($email, $pass);
    if ($user) {
        $_SESSION['name'] = $user['fullname'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header ('location:./admin/index.php');
            exit;
        } elseif ($user['role'] == 'customer') {
            if ($flag===1) {
                unset($_SESSION['flag']);
                header ('location:index.php?act=room');
                exit;
            }else{
                header ('location:index.php');
                exit;
            }
        }
    } else {
        $error_message = "Email hoặc mật khẩu không đúng.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Register, Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
    .card-container {
        max-width: 400px;

        margin: auto;

        margin-top: 100px;

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
                <h2 class="text-center">Đăng Nhập</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email_inp" class="form-control" id="email" placeholder="Nhập email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Nhập mật khẩu" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Đăng Nhập</button>
                </form>
                <p class="mt-3 text-center">Bạn chưa có tài khoản? <a href="register.php">Đăng Ký</a></p>
                <p class="text-center"><a href="forgot-password.php">Quên mật khẩu?</a></p>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <?php if (!empty($error_message)){ ?>
        <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "<?php echo $error_message; ?>"
        });
        </script>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>