<?php
// Bao gồm kết nối cơ sở dữ liệu
include('../../backend/db_connect.php');
include('../includes/header.php');

// Kiểm tra nếu session chưa được bắt đầu thì khởi tạo session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang login
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Vui lòng đăng nhập để gửi liên hệ!');</script>";
    echo "<script>window.location.href = '../../backend/login.php';</script>";
    exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['ma_khach_hang']; // ID người dùng từ session

// Kiểm tra xem user_id có tồn tại trong bảng users không
$sql_check_user = "SELECT ma_khach_hang FROM khachhang WHERE ma_khach_hang = ?";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("i", $user_id);
$stmt_check_user->execute();
$stmt_check_user->store_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy thông tin từ form
    $category = $_POST['category'];
    $message = $_POST['message'];

    // Insert dữ liệu vào bảng contact_messages
    $sql = "INSERT INTO contact_messages (user_id, name, email, category, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $user_id, $_SESSION['email'], $_SESSION['email'], $category, $message);
        if ($stmt->execute()) {
            // Thông báo gửi thành công
            echo "<script>alert('Liên hệ của bạn đã được gửi thành công!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Có lỗi khi gửi thông tin. Vui lòng thử lại sau.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Lỗi kết nối cơ sở dữ liệu.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="../css/contact.css">
</head>
<body>
    <main>
        <div class="container">
            <h1 class="text-center">Liên hệ</h1>
            <h3>Chào mừng, <?php echo $_SESSION['email']; ?>!</h3>
            <p>Hãy điền vào form dưới đây để gửi yêu cầu hoặc câu hỏi của bạn. Chúng tôi sẽ phản hồi sớm nhất có thể!</p>

            <form action="contact.php" method="post">
                <div class="form-group">
                    <label for="category">Nội dung cần liên hệ</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Chọn danh mục</option>
                        <option value="Bảo hành">Bảo hành</option>
                        <option value="Vấn đề sản phẩm">Vấn đề sản phẩm</option>
                        <option value="Vấn đề tài khoản">Vấn đề tài khoản</option>
                        <option value="Vấn đề đặt hàng">Vấn đề đặt hàng</option>
                        <option value="Vấn đề khác">Vấn đề khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Chi tiết yêu cầu</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi</button>
            </form>
        </div>
    </main>
   
</body>
</html>
