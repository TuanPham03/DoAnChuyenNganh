<?php
    
    // function getAllUser(){
    //     $conn=connectdb();
    //     $sql = "SELECT * FROM users";
    //     $stmt =$conn-> prepare($sql);
    //     $stmt->execute();
    //     $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $kq;

    // }

    function getAllUsers($page, $limit) {
        $conn = connectdb(); // Kết nối cơ sở dữ liệu

        // Tính toán offset cho phân trang
        $offset = ($page - 1) * $limit;

        // Truy vấn lấy danh sách người dùng với phân trang
        $sql = "SELECT * FROM users ORDER BY id ASC LIMIT :offset, :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy tất cả các kết quả của trang hiện tại
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Truy vấn lấy tổng số bản ghi để tính tổng số trang
        $totalQuery = "SELECT COUNT(*) as total FROM users";
        $totalResult = $conn->query($totalQuery);
        $totalRow = $totalResult->fetch(PDO::FETCH_ASSOC);
        $totalRecords = $totalRow['total'];
        $totalPages = ceil($totalRecords / $limit); // Tính tổng số trang

        // Trả về kết quả cùng với tổng số trang
        return [
            'users' => $users,
            'total_pages' => $totalPages
        ];
    }



    function deleteUser($id) {
        try {
            $conn = connectdb();
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    
    function addUser($fullname, $username,$password, $email, $phone, $role){
        $conn = connectdb();
        $sql="INSERT into users(fullname,username,password,email,numphone,role ) values('$fullname', '$username','$password', '$email', '$phone', '$role')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    // function createUser()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_smt_addUser'])) {
    //         $fullname=$_POST['fullname_inp'];
    //         $username=$_POST['username_inp'];
    //         $password=$_POST['pw_inp'];
    //         $email=$_POST['email_inp'];
    //         $phone=$_POST['phone_inp'];
    //         $role=$_POST['role_select'];
    //         addUser($fullname, $username,$password, $email, $phone, $role);
    //         echo '<script>
    //             window.location.href = "index.php?act=user";
    //           </script>';
            
    //     }
    // }
    function updateUser($id,$fullname, $username,$password, $email, $phone, $role){
        $conn = connectdb();
        $sql="UPDATE users set fullname='$fullname',username='$username',password='$password',email='$email',numphone='$phone',role='$role' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function getUserbyId($id){
        $conn=connectdb();
        $sql = "SELECT * FROM users where id=".$id;
        $stmt =$conn-> prepare($sql);
        $stmt->execute();
        $kq=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $kq;

    }
    function checkOldUser($user){
        $conn=connectdb();
        $sql="SELECT * from users where username='$user' ";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if($count > 0)
            return true;
        else 
            return false;
    }
    function checkuser($email, $pass) {
        $conn = connectdb();
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $conn->prepare($sql);
        // Sử dụng bindParam hoặc bindValue để gán giá trị cho các tham số
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $pass, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    function updateUserbyuser($id,$fullname, $email, $phone){
        $conn = connectdb();
        $sql="UPDATE users set fullname='$fullname',email='$email',numphone='$phone' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function updateUserpasswordbyuser($id,$fullname, $email, $phone,$pass){
        $conn = connectdb();
        $sql="UPDATE users set fullname='$fullname',password='$pass',email='$email',numphone='$phone' where id=".$id;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
    function searchUser($search) {
        $conn = connectdb();
        $sql = "SELECT  * FROM users WHERE 
                fullname LIKE :search OR username LIKE :search OR email LIKE :search ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;

    }

?>
