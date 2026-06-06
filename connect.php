<?php
// connect.php
$host = "localhost";
$username = "root";
$password = "123456";
$dbname = "quan_ly_ban_hang"; // <-- Đảm bảo điền đúng tên Database của ông ở đây

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>
