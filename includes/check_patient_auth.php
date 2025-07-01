<?php
// File: WebsiteBooking/includes/check_patient_auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem user đã đăng nhập chưa và có đúng vai trò 'patient' không
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'patient') {
    // Nếu không, chuyển hướng về trang đăng nhập của patient
    header("Location: login.php");
    exit();
}
?>