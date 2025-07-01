<?php
// File: WebsiteBooking/admin/patient_edit.php

require 'includes/check_auth.php';
require '../includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID bệnh nhân không hợp lệ.");
}
$id = $_GET['id'];

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Câu lệnh SQL cơ bản để cập nhật thông tin
    $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ? AND role = 'patient'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $phone, $id);
    $stmt->execute();
    $stmt->close();

    // Nếu người dùng nhập mật khẩu mới thì cập nhật
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_pass = "UPDATE users SET password = ? WHERE id = ?";
        $stmt_pass = $conn->prepare($sql_pass);
        $stmt_pass->bind_param("si", $hashed_password, $id);
        $stmt_pass->execute();
        $stmt_pass->close();
    }
    
    header("Location: patients.php?success=Cập nhật thông tin bệnh nhân thành công!");
    exit();
}

// Lấy thông tin hiện tại của bệnh nhân để điền vào form
$sql_select = "SELECT name, email, phone FROM users WHERE id = ? AND role = 'patient'";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 1) {
    $patient = $result->fetch_assoc();
} else {
    die("Không tìm thấy bệnh nhân.");
}
$stmt_select->close();
$conn->close();

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <h1 class="h2 pt-3 pb-2 mb-3 border-bottom">Chỉnh sửa thông tin Bệnh nhân</h1>

    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="name">Họ và Tên (*)</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email (*)</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Để trống nếu không muốn thay đổi">
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>">
        </div>
        
        <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
        <a href="patients.php" class="btn btn-secondary mt-3">Hủy</a>
    </form>
</main>

<?php require 'includes/footer.php'; ?>