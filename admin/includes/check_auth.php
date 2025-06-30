<?php
// Luôn bắt đầu session ở đầu file
session_start();

// Kiểm tra xem session của người dùng có tồn tại không
// và vai trò của họ có phải là 'admin' hoặc 'doctor' không.
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'doctor')) {
    // Nếu không, đá họ về trang đăng nhập
    // Cần cung cấp đường dẫn đầy đủ từ gốc của web server nếu có thể
    // Ví dụ: /ten_project/admin/login.php
    header('Location: login.php');
    exit(); // Dừng chạy code ngay lập tức
}

// Bổ sung: Phân quyền chi tiết hơn (ví dụ)
// Bạn có thể mở rộng file này để kiểm tra vai trò cụ thể cho từng trang
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>