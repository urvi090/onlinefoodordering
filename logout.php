<?php
include('database.php');
include('function.php');

session_start();

unset($_SESSION['IS_LOGIN']);
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_NAME']);
// session_unset();
// session_destroy();

redirect('index.php');

// redirect('login');
//header('location:login.php');
?>