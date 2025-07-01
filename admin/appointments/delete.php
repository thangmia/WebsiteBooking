<?php
// File: WebsiteBooking/admin/appointment_delete.php

require 'includes/check_auth.php';
require '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID không hợp lệ.");
}
$id = $_GET['id'];

// Chỉ admin mới được xóa
if (!is_admin()) {
    die("Bạn không có quyền thực hiện hành động này.");
}

$sql = "DELETE FROM appointments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: appointments.php?success=Xóa lịch hẹn thành công!");
} else {
    header("Location: appointments.php?error=Lỗi khi xóa: " . $stmt->error);
}

$stmt->close();
$conn->close();
exit();
?>