<?php
    session_start();
    if(isset($_SESSION['name'])&&($_SESSION['name']!="")){
        unset($_SESSION['name']);}
    if(isset($_SESSION['user_id'])&&($_SESSION['user_id']!="")){
        unset($_SESSION['user_id']);}
    if(isset($_SESSION['role'])&&($_SESSION['role']!="")){
        unset($_SESSION['role']);}
    header("location:../login.php");
?>