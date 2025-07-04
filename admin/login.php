<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../includes/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Vui lòng nhập đầy đủ email và mật khẩu.";
    } else {
        $sql = "SELECT id, name, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                if ($user['role'] == 'admin' || $user['role'] == 'doctor') {
                     $_SESSION['user_id'] = $user['id'];
                     $_SESSION['user_name'] = $user['name'];
                     $_SESSION['user_role'] = $user['role'];

             if ($user['role'] == 'admin') {
                header("Location: index.php");
            } elseif ($user['role'] == 'doctor') {
                header("Location: doctor_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
                } else {
                    $error_message = "Tài khoản của bạn không có quyền truy cập trang này.";
                }
            } else {
                $error_message = "Email hoặc mật khẩu không chính xác.";
            }
        } else {
            $error_message = "Email hoặc mật khẩu không chính xác.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập trang Quản trị</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }
        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }
        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
    <form class="form-signin" method="POST" action="login.php">
        <h1 class="h3 mb-3 font-weight-normal">Đăng nhập Admin</h1>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <label for="inputEmail" class="sr-only">Địa chỉ email</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Địa chỉ email" required autofocus>
        
        <label for="inputPassword" class="sr-only">Mật khẩu</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Mật khẩu" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2025 - Phòng khám Nha Khoa</p>
    </form>
</body>
</html>