<<<<<<< HEAD
<?php
// Cấu hình kết nối cơ sở dữ liệu
$servername = "localhost";  // Địa chỉ máy chủ MySQL
$username = "root";         // Tên người dùng (mặc định của XAMPP là 'root')
$password = "";             // Mật khẩu (mặc định của XAMPP là trống)
$dbname = "moc_nguyen";     // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
=======
<?php
// Cấu hình kết nối cơ sở dữ liệu
$servername = "localhost";  // Địa chỉ máy chủ MySQL
$username = "root";         // Tên người dùng (mặc định của XAMPP là 'root')
$password = "";             // Mật khẩu (mặc định của XAMPP là trống)
$dbname = "moc_nguyen";     // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
>>>>>>> origin/thanhnguyen
