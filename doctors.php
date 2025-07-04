<?php

require 'includes/header_public.php';
require 'includes/db.php';

$sql = "SELECT u.name, d.specialty, d.bio 
        FROM doctors d 
        JOIN users u ON d.user_id = u.id 
        WHERE u.role = 'doctor'
        ORDER BY u.name ASC";

$doctors_result = $conn->query($sql);
?>

<title>Đội ngũ Bác sĩ - Nha Khoa Hạnh Phúc</title>

<div class="jumbotron jumbotron-fluid text-center bg-primary text-white" style="padding: 3rem 1rem;">
    <div class="container">
        <h1 class="display-4">Đội ngũ Bác sĩ</h1>
        <p class="lead">Những chuyên gia tận tâm và giàu kinh nghiệm của chúng tôi.</p>
    </div>
</div>


<div class="container my-5">
    <div class="row">
        <?php if ($doctors_result && $doctors_result->num_rows > 0): ?>
            <?php while($doctor = $doctors_result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                            
                            <h5 class="card-title"><?php echo htmlspecialchars($doctor['name']); ?></h5>
                            
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($doctor['specialty']); ?></h6>
                            
                            <p class="card-text">
                                <?php 
                                    $bio = htmlspecialchars($doctor['bio']);
                                    echo strlen($bio) > 100 ? substr($bio, 0, 100) . '...' : $bio;
                                ?>
                            </p>
                        </div>
                        <div class="card-footer">
                             <a href="#" class="btn btn-outline-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Hiện chưa có thông tin về đội ngũ bác sĩ.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


<?php
$conn->close();
require 'includes/footer_public.php';
?>