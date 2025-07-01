<?php
// File: WebsiteBooking/admin/service_edit.php

require 'includes/check_auth.php';
require '../includes/db.php';

$id = $_GET['id'];
if (!is_numeric($id)) {
    die("ID không hợp lệ.");
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $duration_minutes = $_POST['duration_minutes'];
    $price = $_POST['price'];

    // Validate
    if (!empty($name) && is_numeric($duration_minutes) && is_numeric($price)) {
        $sql = "UPDATE services SET name = ?, description = ?, duration_minutes = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $name, $description, $duration_minutes, $price, $id);

        if ($stmt->execute()) {
            header("Location: services.php?success=Cập nhật dịch vụ thành công!");
            exit();
        } else {
            $error = "Lỗi khi cập nhật: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Vui lòng điền đầy đủ và đúng định dạng các trường bắt buộc.";
    }
}

// Lấy thông tin dịch vụ hiện tại để điền vào form
$sql_select = "SELECT name, description, duration_minutes, price FROM services WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 1) {
    $service = $result->fetch_assoc();
} else {
    die("Không tìm thấy dịch vụ.");
}
$stmt_select->close();
$conn->close();


require 'includes/header.php';
require 'includes/sidebar.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Chỉnh sửa Dịch vụ</h1>
    </div>

    <?php
    if (isset($error)) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    ?>

    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="name">Tên Dịch vụ (*)</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($service['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="duration_minutes">Thời lượng (phút) (*)</label>
            <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" value="<?php echo $service['duration_minutes']; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Giá (VND) (*)</label>
            <input type="number" class="form-control" id="price" name="price" step="1000" value="<?php echo $service['price']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="services.php" class="btn btn-secondary">Hủy</a>
    </form>
</main>

<?php
require 'includes/footer.php';
?>