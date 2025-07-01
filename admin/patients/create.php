<?php
// File: WebsiteBooking/admin/patient_create.php

require 'includes/check_auth.php';

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../includes/db.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = 'patient'; // Luôn là patient

    // Validate
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Vui lòng điền vào các trường bắt buộc (*).";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)";
        
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $role);
            $stmt->execute();
            header("Location: patients.php?success=Thêm bệnh nhân thành công!");
            exit();
        } catch (mysqli_sql_exception $exception) {
             if ($conn->errno == 1062) {
                $error = "Lỗi: Email đã tồn tại trong hệ thống.";
            } else {
                $error = "Đã xảy ra lỗi: " . $exception->getMessage();
            }
        }
        $stmt->close();
        $conn->close();
    }
}

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Thêm Bệnh nhân mới</h1>

    <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

    <form action="create.php" method="POST">
        <div class="form-group">
            <label for="name">Họ và Tên (*)</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email (*)</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu (*)</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        <a href="patients.php" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</main>

<?php require 'includes/footer.php'; ?>