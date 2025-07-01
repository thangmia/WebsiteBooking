<?php
// File: WebsiteBooking/admin/includes/check_auth.php

// Bắt đầu session nếu nó chưa được bắt đầu
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa, chuyển hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Kiểm tra vai trò của người dùng
// Chỉ 'admin' và 'doctor' mới được phép ở lại trang quản trị
if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'doctor') {
    // Nếu vai trò không hợp lệ, hủy session và chuyển về trang đăng nhập
    session_destroy();
    header("Location: login.php?error=access_denied");
    exit();
}

/**
 * Hàm tiện ích để kiểm tra xem người dùng hiện tại có phải là admin không.
 * Rất hữu ích cho các chức năng chỉ dành cho admin (ví dụ: xóa dữ liệu).
 *
 * @return boolean True nếu là admin, False nếu không phải.
 */
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>