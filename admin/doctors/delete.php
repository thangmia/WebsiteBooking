<?php
// File: WebsiteBooking/admin/doctor_delete.php

require 'includes/check_auth.php';

// Chỉ admin mới có quyền xóa
if (!is_admin()) {
    die("Bạn không có quyền thực hiện hành động này.");
}

require '../includes/db.php';

if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    die("User ID không hợp lệ.");
}
$user_id = $_GET['user_id'];

// Chúng ta sẽ xóa user, và doctor profile sẽ tự động bị xóa nhờ ON DELETE CASCADE
// Lưu ý: Bạn có thể cần xử lý các ràng buộc khác, ví dụ như không cho xóa nếu bác sĩ đang có lịch hẹn 'confirmed' hoặc 'pending'.
// Phần đó có thể được thêm vào sau để tăng tính an toàn cho dữ liệu.

$sql = "DELETE FROM users WHERE id = ? AND role = 'doctor'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: doctors.php?success=Xóa bác sĩ thành công!");
    } else {
        header("Location: doctors.php?error=Không tìm thấy bác sĩ để xóa hoặc người dùng không phải là bác sĩ.");
    }
} else {
    header("Location: doctors.php?error=Lỗi khi xóa bác sĩ: " . $stmt->error);
}

$stmt->close();
$conn->close();
exit();
?>