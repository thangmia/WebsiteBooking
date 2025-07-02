<?php
// File: WebsiteBooking/booking.php

require 'includes/header_public.php';
require 'includes/db.php';
require 'includes/check_patient_auth.php'; // Đảm bảo chỉ bệnh nhân đã đăng nhập mới vào được

// Lấy danh sách dịch vụ
$services_result = $conn->query("SELECT id, name FROM services ORDER BY name");

// Lấy danh sách bác sĩ
$doctors_result = $conn->query("SELECT d.id, u.name FROM doctors d JOIN users u ON d.user_id = u.id WHERE u.role = 'doctor' ORDER BY u.name");

?>

<title>Đặt Lịch Hẹn - Nha Khoa Hạnh Phúc</title>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Tạo Lịch Hẹn Mới</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php 
                                echo $_SESSION['error_message']; 
                                unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="handle_booking.php" method="POST">
                        <div class="form-group">
                            <label for="service_id">Chọn dịch vụ</label>
                            <select class="form-control" id="service_id" name="service_id" required>
                                <option value="">-- Vui lòng chọn dịch vụ --</option>
                                <?php while($service = $services_result->fetch_assoc()): ?>
                                    <option value="<?php echo $service['id']; ?>"><?php echo htmlspecialchars($service['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="doctor_id">Chọn bác sĩ</label>
                            <select class="form-control" id="doctor_id" name="doctor_id" required>
                                <option value="">-- Vui lòng chọn bác sĩ --</option>
                                <?php while($doctor = $doctors_result->fetch_assoc()): ?>
                                    <option value="<?php echo $doctor['id']; ?>"><?php echo htmlspecialchars($doctor['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="appointment_date">Chọn ngày hẹn</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="form-group">
                            <label for="appointment_time">Chọn giờ hẹn</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" required>
                            <small class="form-text text-muted">Giờ làm việc: 08:00 AM - 08:00 PM</small>
                        </div>

                        <div class="form-group">
                            <label for="notes">Ghi chú (nếu có)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Xác nhận Đặt lịch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$conn->close();
require 'includes/footer_public.php'; 
?>