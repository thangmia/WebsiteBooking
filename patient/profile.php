<?php
// File: WebsiteBooking/profile.php

// Dòng này phải được gọi đầu tiên để bảo vệ trang
require '../includes/check_patient_auth.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang cá nhân - Phòng khám Nha Khoa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Nha Khoa XYZ</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text">
                        Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                </li>
                <li class="nav-item ml-3">
                    <a class="btn btn-danger" href="logout.php">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Trang cá nhân của bạn</h1>
        <p>Chào mừng bạn đã quay trở lại.</p>
        
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">Đặt lịch hẹn mới</a>
            <a href="#" class="list-group-item list-group-item-action">Xem lịch sử cuộc hẹn</a>
            <a href="#" class="list-group-item list-group-item-action">Cập nhật thông tin</a>
        </div>
    </div>
</body>
</html>