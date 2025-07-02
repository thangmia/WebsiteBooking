<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/WebsiteBooking/');
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'patient') {
 
    $_SESSION['error_message'] = "Vui lòng đăng nhập để thực hiện chức năng này.";
    header("Location: " . BASE_URL . "patient/login.php");
    exit();
}
?>