<?php

require 'includes/check_auth.php';

if (!is_admin()) {
    die("Bạn không có quyền truy cập trang này.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../includes/db.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = 'doctor'; 

    $specialty = $_POST['specialty'];
    $bio = $_POST['bio'];
    
    if (empty($name) || empty($email) || empty($password) || empty($specialty)) {
        $error = "Vui lòng điền vào các trường bắt buộc (*).";
    } else {
        $conn->begin_transaction();

        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_user = "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bind_param("sssss", $name, $email, $hashed_password, $phone, $role);
            $stmt_user->execute();

            $user_id = $conn->insert_id;
            $stmt_user->close();

            $sql_doctor = "INSERT INTO doctors (user_id, specialty, bio) VALUES (?, ?, ?)";
            $stmt_doctor = $conn->prepare($sql_doctor);
            $stmt_doctor->bind_param("iss", $user_id, $specialty, $bio);
            $stmt_doctor->execute();
            $stmt_doctor->close();

            $conn->commit();

            header("Location: doctors.php?success=Thêm bác sĩ thành công!");
            exit();

        } catch (mysqli_sql_exception $exception) {
            $conn->rollback();
            
            if ($conn->errno == 1062) {
                $error = "Lỗi: Email đã tồn tại trong hệ thống.";
            } else {
                $error = "Đã xảy ra lỗi khi thêm bác sĩ: " . $exception->getMessage();
            }
        }
    }
    $conn->close();
}

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Thêm Bác sĩ mới</h1>

    <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

    <form action="create.php" method="POST">
        <h5>Thông tin tài khoản</h5>
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

        <hr>
        
        <h5>Thông tin chuyên môn</h5>
        <div class="form-group">
            <label for="specialty">Chuyên khoa (*)</label>
            <input type="text" class="form-control" id="specialty" name="specialty" required>
        </div>
        <div class="form-group">
            <label for="bio">Tiểu sử</label>
            <textarea class="form-control" id="bio" name="bio" rows="4"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
        <a href="doctors.php" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</main>

<?php require 'includes/footer.php'; ?>