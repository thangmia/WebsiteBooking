<?php
// File: WebsiteBooking/handle_booking.php

session_start();
require 'includes/db.php';
require 'includes/check_patient_auth.php';

// Chỉ xử lý nếu request là POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Lấy dữ liệu từ form và session
    $patient_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $notes = $_POST['notes'] ?? '';

    // 2. Kiểm tra xem lịch có bị trùng không
    $stmt = $conn->prepare("SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'Đã hủy'");
    $stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu có lịch trùng, báo lỗi và quay lại trang đặt lịch
        $_SESSION['error_message'] = "Khung giờ này đã có người đặt. Vui lòng chọn thời gian khác.";
        header("Location: booking.php");
        exit();
    }

    // 3. Nếu không trùng, thêm lịch hẹn vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, appointment_time, notes, status) VALUES (?, ?, ?, ?, ?, ?, 'Chờ xác nhận')");
    $stmt->bind_param("iiisss", $patient_id, $doctor_id, $service_id, $appointment_date, $appointment_time, $notes);
    
    if ($stmt->execute()) {
        // Nếu thành công, chuyển hướng đến trang thông báo thành công hoặc trang lịch hẹn của tôi
        // Tạm thời chuyển về trang chủ với thông báo
        $_SESSION['success_message'] = "Bạn đã đặt lịch hẹn thành công! Chúng tôi sẽ sớm liên hệ để xác nhận.";
        header("Location: index.php"); // Sau này sẽ đổi thành trang "Lịch hẹn của tôi"
        exit();
    } else {
        // Nếu có lỗi khi thêm vào DB
        $_SESSION['error_message'] = "Đã xảy ra lỗi. Vui lòng thử lại.";
        header("Location: booking.php");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    // Nếu không phải là POST request, chuyển về trang chủ
    header("Location: index.php");
    exit();
}
?>