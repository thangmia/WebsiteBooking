<?php
// File: WebsiteBooking/admin/patient_delete.php

require 'includes/check_auth.php';
require '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID không hợp lệ.");
}
$id = $_GET['id'];

// Chỉ admin mới có quyền xóa
if (!is_admin()) {
    die("Bạn không có quyền thực hiện hành động này.");
}

$sql = "DELETE FROM users WHERE id = ? AND role = 'patient'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: patients.php?success=Xóa bệnh nhân thành công! Các lịch hẹn cũ của họ đã được ẩn danh.");
    } else {
        header("Location: patients.php?error=Không tìm thấy bệnh nhân để xóa.");
    }
} else {
    header("Location: patients.php?error=Lỗi khi xóa bệnh nhân: " . $stmt->error);
}

$stmt->close();
$conn->close();
exit();
?>