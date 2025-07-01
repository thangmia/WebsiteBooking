<?php
// File: WebsiteBooking/admin/doctor_edit.php

require 'includes/check_auth.php';
require '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID bác sĩ không hợp lệ.");
}
$doctor_id = $_GET['id'];

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dữ liệu từ form
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialty = $_POST['specialty'];
    $bio = $_POST['bio'];
    $password = $_POST['password']; // Lấy mật khẩu mới (nếu có)

    // Bắt đầu transaction
    $conn->begin_transaction();
    try {
        // Cập nhật bảng `users`
        $sql_user = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("sssi", $name, $email, $phone, $user_id);
        $stmt_user->execute();
        $stmt_user->close();

        // Nếu người dùng nhập mật khẩu mới, cập nhật nó
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql_pass = "UPDATE users SET password = ? WHERE id = ?";
            $stmt_pass = $conn->prepare($sql_pass);
            $stmt_pass->bind_param("si", $hashed_password, $user_id);
            $stmt_pass->execute();
            $stmt_pass->close();
        }

        // Cập nhật bảng `doctors`
        $sql_doctor = "UPDATE doctors SET specialty = ?, bio = ? WHERE id = ?";
        $stmt_doctor = $conn->prepare($sql_doctor);
        $stmt_doctor->bind_param("ssi", $specialty, $bio, $doctor_id);
        $stmt_doctor->execute();
        $stmt_doctor->close();

        $conn->commit();
        header("Location: doctors.php?success=Cập nhật thông tin bác sĩ thành công!");
        exit();

    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        $error = "Lỗi khi cập nhật: " . $exception->getMessage();
    }
}

// Lấy thông tin hiện tại của bác sĩ để điền vào form
$sql_select = "SELECT d.id as doctor_id, u.id as user_id, u.name, u.email, u.phone, d.specialty, d.bio 
               FROM doctors d 
               JOIN users u ON d.user_id = u.id 
               WHERE d.id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $doctor_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 1) {
    $doctor = $result->fetch_assoc();
} else {
    die("Không tìm thấy bác sĩ.");
}
$stmt_select->close();

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Chỉnh sửa thông tin Bác sĩ</h1>
    
    <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

    <form action="edit.php?id=<?php echo $doctor_id; ?>" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $doctor['user_id']; ?>">

        <h5>Thông tin tài khoản</h5>
        <div class="form-group">
            <label for="name">Họ và Tên (*)</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email (*)</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Để trống nếu không muốn thay đổi">
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($doctor['phone']); ?>">
        </div>

        <hr>
        
        <h5>Thông tin chuyên môn</h5>
        <div class="form-group">
            <label for="specialty">Chuyên khoa (*)</label>
            <input type="text" class="form-control" id="specialty" name="specialty" value="<?php echo htmlspecialchars($doctor['specialty']); ?>" required>
        </div>
        <div class="form-group">
            <label for="bio">Tiểu sử</label>
            <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo htmlspecialchars($doctor['bio']); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
        <a href="doctors.php" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</main>

<?php
$conn->close();
require 'includes/footer.php';
?>