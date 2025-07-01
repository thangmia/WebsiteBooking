<?php
// File: WebsiteBooking/admin/patients.php

require 'includes/check_auth.php';
require '../includes/db.php';

// Lấy tất cả user có vai trò là 'patient'
$sql = "SELECT id, name, email, phone FROM users WHERE role = 'patient' ORDER BY created_at DESC";
$result = $conn->query($sql);

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý Bệnh nhân</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="patient_create.php" class="btn btn-sm btn-outline-success">
                Thêm Bệnh nhân mới
            </a>
        </div>
    </div>

    <?php
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
        }
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>
                            <a href="patient_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Sửa</a>
                            <a href="patient_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bệnh nhân này?');">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Chưa có bệnh nhân nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
$conn->close();
require 'includes/footer.php';
?>