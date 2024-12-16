<?php
session_start(); // Khởi động session để kiểm tra trạng thái đăng nhập

// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moc_nguyen";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và loại bỏ dấu cách thừa
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Truy vấn để lấy thông tin người dùng
    $sql = "SELECT * FROM khachhang WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // "s" là kiểu dữ liệu string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Nếu tìm thấy người dùng, kiểm tra mật khẩu
        $row = $result->fetch_assoc();
        
        // So sánh mật khẩu
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email; // Lưu email vào session
            $_SESSION['ma_khach_hang'] = $row['ma_khach_hang']; // Lưu ID người dùng
            $_SESSION['role'] = $row['role']; // Lưu vai trò của người dùng

            $_SESSION['success_message'] = "Đăng nhập thành công! Chào mừng bạn, {$row['ten_khach_hang']}";

            // Chuyển hướng sau khi đăng nhập thành công
            if ($row['role'] === 'admin') {
                header("Location: ../frontend/pages/admin_page.php");
            } else {
                header("Location: ../frontend/pages/index.php");
            }
            exit();
        } else {
            $error_message = "Sai mật khẩu!";
        }
    } else {
        $error_message = "Không tìm thấy tài khoản!";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="../frontend/css/login.css">
</head>
<body>
    <div class="overlay"></div> <!-- Overlay mờ trên ảnh nền -->
    <div class="login-container">
        <a href="../frontend/pages/index.php" class="btn-login-back">Quay lại</a>
        <h2>Đăng Nhập</h2>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập Email" required>
            </div>
            <div class="input-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>
        <div class="signup-link">
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
            <p><a href="login_admin.php" style="color: black;">Admin login</a></p>
        </div>
    </div>
</body>
</html>
