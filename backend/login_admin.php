<<<<<<< HEAD
<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moc_nguyen";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error_message = ""; // Khởi tạo biến lỗi

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password, role FROM khachhang WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password) && $role === 'admin') {
        session_start();
        $_SESSION['admin'] = $username;
        header("Location: ../frontend/pages/admin_page.php");
        exit();
    } else {
        $error_message = "Sai thông tin đăng nhập hoặc không có quyền admin.";
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
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="../frontend/css/login_admin.css"> <!-- Link đến file CSS -->
</head>
<body>
    <div class="login-container">

        <div class="login-box">
        <a href="login.php" class="btn-login-back">Quay lại</a>

            <h1>Đăng Nhập Admin</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>
</html>
=======
<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moc_nguyen";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error_message = ""; // Khởi tạo biến lỗi

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password, role FROM khachhang WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password) && $role === 'admin') {
        session_start();
        $_SESSION['admin'] = $username;
        header("Location: ../frontend/pages/admin_page.php");
        exit();
    } else {
        $error_message = "Sai thông tin đăng nhập hoặc không có quyền admin.";
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
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="../frontend/css/login_admin.css"> <!-- Link đến file CSS -->
</head>
<body>
    <div class="login-container">

        <div class="login-box">
        <a href="login.php" class="btn-login-back">Quay lại</a>

            <h1>Đăng Nhập Admin</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                <button type="submit">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>
</html>
>>>>>>> origin/thanhnguyen
