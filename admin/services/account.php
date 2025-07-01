<?php
echo password_hash('123456', PASSWORD_DEFAULT);
// Kết quả sẽ là một chuỗi dài, ví dụ: $2y$10$... Hãy copy chuỗi này
?>