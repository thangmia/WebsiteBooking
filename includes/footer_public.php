<?php
?>
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading">Nha Khoa Hạnh Phúc</h5>
                <p class="footer-text">Với đội ngũ y bác sĩ chuyên nghiệp và trang thiết bị hiện đại, chúng tôi cam kết mang đến cho bạn nụ cười tự tin và sức khỏe răng miệng toàn diện.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading">Dịch vụ</h5>
                <ul class="list-unstyled footer-links">
                    <?php
                    include 'db.php'; 
                    if ($conn) {
                        $footer_services_result = $conn->query("SELECT name FROM services LIMIT 5");
                        if ($footer_services_result && $footer_services_result->num_rows > 0) {
                            while($service = $footer_services_result->fetch_assoc()) {
                                echo '<li><a href="#">' . htmlspecialchars($service['name']) . '</a></li>';
                            }
                        }
                        $conn->close(); 
                    }
                    ?>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading">Liên hệ</h5>
                <ul class="list-unstyled footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                    <li><i class="fas fa-phone"></i> (028) 3812 3456</li>
                    <li><i class="fas fa-envelope"></i> contact@nhakhoahanhphuc.com</li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                 <h5 class="footer-heading">Giờ làm việc</h5>
                 <ul class="list-unstyled footer-contact">
                    <li>Thứ 2 - Thứ 7: 08:00 - 20:00</li>
                    <li>Chủ nhật: 08:00 - 17:00</li>
                 </ul>
            </div>

        </div>
    </div>
    <div class="footer-bottom">
        <div class="container text-center">
            <p class="mb-0">Bản quyền &copy; <?php echo date('Y'); ?> Nha Khoa Hạnh Phúc. All Rights Reserved.</p>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>