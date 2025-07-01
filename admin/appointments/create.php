<?php
// File: WebsiteBooking/admin/appointment_create.php

require 'includes/check_auth.php';
require '../includes/db.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $service_id = $_POST['service_id'];
    $appointment_time = $_POST['appointment_time'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    // Validate
    if (empty($patient_id) || empty($doctor_id) || empty($service_id) || empty($appointment_time)) {
        $error = "Vui lòng điền đầy đủ các trường bắt buộc.";
    } else {
        $sql = "INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_time, status, notes) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iissss", $patient_id, $doctor_id, $service_id, $appointment_time, $status, $notes);

        if ($stmt->execute()) {
            header("Location: appointments.php?success=Tạo lịch hẹn thành công!");
            exit();
        } else {
            $error = "Lỗi khi tạo lịch hẹn: " . $stmt->error;
        }
    }
}

// Lấy danh sách để điền vào các dropdown
$patients_result = $conn->query("SELECT id, name FROM users WHERE role = 'patient' ORDER BY name");
$doctors_result = $conn->query("SELECT d.id, u.name FROM doctors d JOIN users u ON d.user_id = u.id ORDER BY u.name");
$services_result = $conn->query("SELECT id, name FROM services ORDER BY name");

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Tạo Lịch hẹn mới</h1>

    <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

    <form action="create.php" method="POST">
        <div class="form-group">
            <label for="patient_id">Bệnh nhân (*)</label>
            <select class="form-control" id="patient_id" name="patient_id" required>
                <option value="">-- Chọn bệnh nhân --</option>
                <?php while ($row = $patients_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="doctor_id">Bác sĩ (*)</label>
            <select class="form-control" id="doctor_id" name="doctor_id" required>
                <option value="">-- Chọn bác sĩ --</option>
                <?php while ($row = $doctors_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="service_id">Dịch vụ (*)</label>
            <select class="form-control" id="service_id" name="service_id" required>
                <option value="">-- Chọn dịch vụ --</option>
                <?php while ($row = $services_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="appointment_time">Thời gian hẹn (*)</label>
            <input type="datetime-local" class="form-control" id="appointment_time" name="appointment_time" required>
        </div>
        
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                <option value="pending">Chờ xác nhận</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="completed">Đã hoàn thành</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Ghi chú</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        <a href="appointments.php" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</main>

<?php
$conn->close();
require 'includes/footer.php';
?>