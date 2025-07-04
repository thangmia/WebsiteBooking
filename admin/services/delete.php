<?php

require '../includes/check_auth.php';

if (!is_admin()) {
    die("Bạn không có quyền thực hiện hành động này.");
}

require '../../includes/db.php';

$id = $_GET['id'];
if (!is_numeric($id)) {
    die("ID không hợp lệ.");
}

$sql_check = "SELECT id FROM appointments WHERE service_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    header("Location: services.php?error=Không thể xóa dịch vụ này vì đang được sử dụng trong một lịch hẹn.");
    exit();
}
$stmt_check->close();

$sql = "DELETE FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: services.php?success=Xóa dịch vụ thành công!");
} else {
    header("Location: services.php?error=Lỗi khi xóa dịch vụ: " . $stmt->error);
}

$stmt->close();
$conn->close();
exit();
?>