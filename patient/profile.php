<?php
// File: WebsiteBooking/patient/profile.php

// Dòng này phải được gọi đầu tiên để bảo vệ trang và bắt đầu session
require '../includes/check_patient_auth.php';

// Nhúng header chung của trang public
// Lưu ý: đường dẫn là '../includes/' vì file profile.php nằm trong thư mục /patient
require '../includes/header_public.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Trang cá nhân</h1>
            <p class="lead">Chào mừng bạn quay trở lại, <?php echo htmlspecialchars($_SESSION['user_name']); ?>.</p>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <h4>Chức năng</h4>
            <div class="list-group">
                <a href="../booking.php" class="list-group-item list-group-item-action">
                    Đặt lịch hẹn mới
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Xem lịch sử cuộc hẹn (sẽ phát triển sau)
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    Cập nhật thông tin cá nhân (sẽ phát triển sau)
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông tin liên hệ</h5>
                    <p class="card-text">Nếu cần hỗ trợ, vui lòng gọi hotline: <strong>1900.xxxx</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Nhúng footer chung
require '../includes/footer_public.php'; 
?>