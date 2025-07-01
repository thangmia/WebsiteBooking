<?php
// File: WebsiteBooking/admin/services.php

// Luôn gọi check_auth đầu tiên
require 'includes/check_auth.php';
// Nhúng file kết nối CSDL, lưu ý đường dẫn
require '../includes/db.php';

// Lấy tất cả dịch vụ từ CSDL
$sql = "SELECT id, name, description, duration_minutes, price FROM services ORDER BY id DESC";
$result = $conn->query($sql);

// Gọi header
require 'includes/header.php';
// Gọi sidebar
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý Dịch vụ</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="service_create.php" class="btn btn-sm btn-outline-success">
                Thêm Dịch vụ mới
            </a>
        </div>
    </div>

    <?php
        // Hiển thị thông báo (nếu có) từ các trang xử lý
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
    ?>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Dịch vụ</th>
                    <th>Thời lượng (phút)</th>
                    <th>Giá (VND)</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo $row['duration_minutes']; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="service_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Sửa</a>
                            <a href="service_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này không?');">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Không có dịch vụ nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
// Đóng kết nối và gọi footer
$conn->close();
require 'includes/footer.php';
?>