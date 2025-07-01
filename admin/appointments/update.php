<?php
// File: WebsiteBooking/admin/appointment_edit.php
require 'includes/check_auth.php';
require '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) die("ID không hợp lệ.");
$id = $_GET['id'];

// Xử lý POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu...
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $service_id = $_POST['service_id'];
    $appointment_time = $_POST['appointment_time'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    $sql = "UPDATE appointments SET patient_id = ?, doctor_id = ?, service_id = ?, appointment_time = ?, status = ?, notes = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssi", $patient_id, $doctor_id, $service_id, $appointment_time, $status, $notes, $id);

    if ($stmt->execute()) {
        header("Location: appointments.php?success=Cập nhật lịch hẹn thành công!");
        exit();
    } else {
        $error = "Lỗi khi cập nhật: " . $stmt->error;
    }
}

// Lấy thông tin lịch hẹn hiện tại
$stmt_select = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 1) {
    $appointment = $result->fetch_assoc();
} else {
    die("Không tìm thấy lịch hẹn.");
}
$stmt_select->close();

// Lấy danh sách cho các dropdown
$patients_result = $conn->query("SELECT id, name FROM users WHERE role = 'patient' ORDER BY name");
$doctors_result = $conn->query("SELECT d.id, u.name FROM doctors d JOIN users u ON d.user_id = u.id ORDER BY u.name");
$services_result = $conn->query("SELECT id, name FROM services ORDER BY name");

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Chỉnh sửa Lịch hẹn #<?php echo $id; ?></h1>
    <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

    <form action="update.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="patient_id">Bệnh nhân (*)</label>
            <select class="form-control" id="patient_id" name="patient_id" required>
                <?php while ($row = $patients_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $appointment['patient_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="doctor_id">Bác sĩ (*)</label>
            <select class="form-control" id="doctor_id" name="doctor_id" required>
                 <?php while ($row = $doctors_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $appointment['doctor_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="service_id">Dịch vụ (*)</label>
            <select class="form-control" id="service_id" name="service_id" required>
                <?php while ($row = $services_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $appointment['service_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_time">Thời gian hẹn (*)</label>
            <input type="datetime-local" class="form-control" id="appointment_time" name="appointment_time" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_time'])); ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                <option value="pending" <?php echo ($appointment['status'] == 'pending') ? 'selected' : ''; ?>>Chờ xác nhận</option>
                <option value="confirmed" <?php echo ($appointment['status'] == 'confirmed') ? 'selected' : ''; ?>>Đã xác nhận</option>
                <option value="completed" <?php echo ($appointment['status'] == 'completed') ? 'selected' : ''; ?>>Đã hoàn thành</option>
                <option value="cancelled" <?php echo ($appointment['status'] == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Ghi chú</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"><?php echo htmlspecialchars($appointment['notes']); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
        <a href="appointments.php" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</main>
<?php
$conn->close();
require 'includes/footer.php';
?>