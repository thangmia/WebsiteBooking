<?php
// File: WebsiteBooking/login.php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'patient') {
    header("Location: profile.php");
    exit();
}
$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../includes/db.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $error_message = "Vui lòng nhập email và mật khẩu.";
    } else {
        $sql = "SELECT id, name, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                if ($user['role'] == 'patient') {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];
                    header("Location: profile.php");
                    exit();
                } else {
                    $error_message = "Tài khoản này không phải là tài khoản bệnh nhân.";
                }
            } else {
                $error_message = "Email hoặc mật khẩu không chính xác.";
            }
        } else {
            $error_message = "Email hoặc mật khẩu không chính xác.";
        }
    }
}

// Nhúng header
require '../includes/header_public.php';
?>
<title>Đăng nhập - Phòng khám Nha Khoa</title>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Đăng nhập</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Nhúng footer
require '../includes/footer_public.php'; 
?>