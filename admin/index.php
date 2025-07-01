<?php

require 'includes/check_auth.php';
require 'includes/header.php';
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <div class="alert alert-success">
        Chào mừng <strong><?php echo $_SESSION['user_name']; ?></strong> đã trở lại!
    </div>

    <h2>Thông tin nhanh</h2>
    <p>Đây là khu vực hiển thị các thống kê nhanh, ví dụ như số lịch hẹn đang chờ, danh sách lịch hẹn hôm nay...</p>
    <p>Chúng ta sẽ xây dựng chức năng này ở các bước tiếp theo.</p>

</main>

<?php
// BƯỚC 4: GỌI FOOTER
// Footer chứa phần cuối HTML và các file Javascript
require 'includes/footer.php';
?>