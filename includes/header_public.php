<?php
<<<<<<< HEAD
define('BASE_URL', '/WebsiteBooking/');
=======
// File: WebsiteBooking/includes/header_public.php
>>>>>>> 2ff454a70b12f990a76cb96ab57b018f94ee2a23

// Bắt đầu session để có thể kiểm tra trạng thái đăng nhập
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
<<<<<<< HEAD
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php"><strong>Nha Khoa Hạnh Phúc</strong></a>
=======
            <a class="navbar-brand" href="index.php"><strong>Nha Khoa Hạnh Phúc</strong></a>
>>>>>>> 2ff454a70b12f990a76cb96ab57b018f94ee2a23
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
<<<<<<< HEAD
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php#services">Dịch vụ</a>
=======
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Dịch vụ</a>
>>>>>>> 2ff454a70b12f990a76cb96ab57b018f94ee2a23
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Đội ngũ Bác sĩ</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'patient'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
<<<<<<< HEAD
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>patient/profile.php">Hồ sơ của tôi</a>
                                <a class="dropdown-item" href="#">Lịch hẹn của tôi</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>patient/logout.php">Đăng xuất</a>
=======
                                <a class="dropdown-item" href="profile.php">Hồ sơ của tôi</a>
                                <a class="dropdown-item" href="#">Lịch hẹn của tôi</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Đăng xuất</a>
>>>>>>> 2ff454a70b12f990a76cb96ab57b018f94ee2a23
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
<<<<<<< HEAD
                            <a class="nav-link" href="<?php echo BASE_URL; ?>patient/register.php">Đăng ký</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="<?php echo BASE_URL; ?>patient/login.php">Đăng nhập</a>
=======
                            <a class="nav-link" href="/patient/register.php">Đăng ký</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="/patient/login.php">Đăng nhập</a>
>>>>>>> 2ff454a70b12f990a76cb96ab57b018f94ee2a23
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>