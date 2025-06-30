<?php
// Bắt đầu session để có thể lưu thông tin đăng nhập
session_start();

// Nếu đã đăng nhập, chuyển thẳng vào dashboard
if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'doctor')) {
    header('Location: index.php');
    exit();
}

// Kiểm tra xem form đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhúng file kết nối CSDL
    // Lưu ý đường dẫn: file login.php nằm trong /admin, nên cần đi ra 1 cấp (../)
    require '../includes/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Chuẩn bị câu lệnh SQL để tránh SQL Injection
    $sql = "SELECT id, name, password, role FROM users WHERE email = ? AND (role = 'admin' OR role = 'doctor')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // So sánh mật khẩu đã hash
        if (password_verify($password, $user['password'])) {
            // Mật khẩu chính xác, lưu thông tin vào Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Chuyển hướng tới trang dashboard
            header('Location: index.php');
            exit();
        }
    }

    // Nếu email không tồn tại hoặc mật khẩu sai, chuyển hướng về lại trang login với thông báo lỗi
    header('Location: login.php?error=1');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
    
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h1 class="text-center mt-5">Admin Đăng Nhập</h1>
                <?php
                    // Hiển thị thông báo lỗi nếu có
                    if (isset($_GET['error'])) {
                        echo '<p class="alert alert-danger">Email hoặc mật khẩu không đúng!</p>';
                    }
                ?>
                <form action="login.php" method="POST" class="mt-4">
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
        </div>
    </div>
</body>
</html>