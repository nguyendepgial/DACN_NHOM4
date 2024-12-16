<?php
include 'db_connect.php'; // Kết nối cơ sở dữ liệu

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và loại bỏ dấu cách thừa
    $ten_khach_hang = trim($_POST['ten_khach_hang']);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Mã hóa mật khẩu
    $role = "user"; // Mặc định là user

    // Kiểm tra xem email đã tồn tại chưa
    $sql_check = "SELECT * FROM KhachHang WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email đã tồn tại, vui lòng sử dụng email khác!";
    } else {
        // Thêm người dùng mới vào bảng KhachHang
        $sql_insert = "INSERT INTO KhachHang (ten_khach_hang, so_dien_thoai, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $ten_khach_hang, $so_dien_thoai, $email, $hashed_password, $role);

        if ($stmt_insert->execute()) {
            $success_message = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
        } else {
            $error_message = "Lỗi khi thêm người dùng: " . $stmt_insert->error;
        }
    }
    $stmt_check->close();
    // $stmt_insert->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="../frontend/css/register.css">
</head>
<body>
    <div class="register-container">

        <div class="register-box">
        <a href="login.php" class="btn-back">Quay lại</a>

            <h1>Đăng Ký</h1>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="input-group">
                    <label for="ten_khach_hang">Tên đầy đủ:</label>
                    <input type="text" id="ten_khach_hang" name="ten_khach_hang" placeholder="Nhập tên của bạn" required>
                </div>
                <div class="input-group">
                    <label for="so_dien_thoai">Số điện thoại:</label>
                    <input type="text" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email" required>
                </div>
                <div class="input-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="btn-register">Đăng Ký</button>
            </form>
        </div>
    </div>
</body>
</html>
