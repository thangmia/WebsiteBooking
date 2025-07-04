<?php

session_start();
require 'includes/db.php';
require 'includes/check_patient_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $notes = $_POST['notes'] ?? '';
    $stmt = $conn->prepare("SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'Đã hủy'");
    $stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Khung giờ này đã có người đặt. Vui lòng chọn thời gian khác.";
        header("Location: booking.php");
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, appointment_time, notes, status) VALUES (?, ?, ?, ?, ?, ?, 'Chờ xác nhận')");
    $stmt->bind_param("iiisss", $patient_id, $doctor_id, $service_id, $appointment_date, $appointment_time, $notes);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Bạn đã đặt lịch hẹn thành công! Chúng tôi sẽ sớm liên hệ để xác nhận.";
        header("Location: index.php"); 
        exit();
    } else {
        $_SESSION['error_message'] = "Đã xảy ra lỗi. Vui lòng thử lại.";
        header("Location: booking.php");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: index.php");
    exit();
}
?>