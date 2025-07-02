<?php 
// File: WebsiteBooking/index.php

// Nhúng header
require 'includes/header_public.php';
// Nhúng file kết nối db để lấy dữ liệu động
require 'includes/db.php';

// Lấy danh sách dịch vụ để hiển thị
$services_result = $conn->query("SELECT name, description, price FROM services LIMIT 6");
?>

<title>Trang chủ - Phòng khám Nha Khoa Hạnh Phúc</title>

<div class="jumbotron jumbotron-fluid text-center bg-primary text-white">
    <div class="container">
        <h1 class="display-4">Chào mừng đến với Nha Khoa Hạnh Phúc</h1>
        <p class="lead">Nơi mang lại nụ cười rạng rỡ và sức khỏe răng miệng toàn diện cho bạn.</p>
        <a class="btn btn-light btn-lg" href="booking.php" role="button">Đặt lịch hẹn ngay</a>
    </div>
</div>

<div class="container">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Xóa thông báo sau khi hiển thị
            ?>
        </div>
    <?php endif; ?>
    <section id="services" class="my-5">
        <h2 class="text-center mb-4">Dịch vụ của chúng tôi</h2>
        <div class="row">
            <?php if ($services_result && $services_result->num_rows > 0): ?>
                <?php while($service = $services_result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                                <p class="card-text"><strong>Giá: <?php echo number_format($service['price']); ?> VND</strong></p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Chưa có dịch vụ nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </section>

    </div>

<?php 
// Đóng kết nối và nhúng footer
$conn->close();
require 'includes/footer_public.php'; 
?>