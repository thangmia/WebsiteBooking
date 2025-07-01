<?php
// WebsiteBooking/includes/db.php

$host = 'localhost';
$dbname = 'db_nhakhoa';
$username = 'root'; // User mặc định của XAMPP
$password = '';     // Password mặc định của XAMPP

// Sử dụng mysqli để nhất quán với file login.php của bạn
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Thiết lập charset để hiển thị tiếng Việt chính xác
$conn->set_charset("utf8mb4");

?>