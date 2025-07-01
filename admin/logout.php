<?php
// File: WebsiteBooking/admin/logout.php

session_start();

// Hủy tất cả các biến session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập
header("location: login.php");
exit;
?>