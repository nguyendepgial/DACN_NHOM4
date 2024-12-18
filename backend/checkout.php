
<?php
session_start();

// Kiểm tra nếu chưa đăng nhập, chuyển hướng về trang giỏ hàng
if (!isset($_SESSION['email'])) {
    header("Location: cart.php");
    exit();
}

// Lấy giỏ hàng từ session
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "<script>alert('Giỏ hàng của bạn trống!');</script>";
    echo "<script>window.location.href = 'cart.php';</script>";
    exit();
}

// Khởi tạo giá trị ban đầu cho các biến
$name = $phone = $address = $payment_method = "";
$error_message = "";

// Xử lý form khi người dùng nhấn nút "Xác nhận"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Kết nối cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "moc_nguyen";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }

    // Lưu đơn hàng vào bảng `orders` (không cần `total_amount` vì sẽ tính sau)
    $user_id = $_SESSION['ma_khach_hang']; // Đảm bảo bạn đã lưu `ma_khach_hang` trong session
    $sql = "INSERT INTO orders (user_id, name, phone, address, order_date, payment_method, status) 
        VALUES (?, ?, ?, ?, NOW(), ?, 'awaiting confirmation')";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("issss", $user_id, $name, $phone, $address, $payment_method);
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Lưu chi tiết đơn hàng vào bảng `order_details`
            foreach ($cart as $product_id => $item) {
                $sql_details = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmt_details = $conn->prepare($sql_details);
                $stmt_details->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
                $stmt_details->execute();
            }

            // Tính tổng tiền đơn hàng
            $total_amount = 0;
            foreach ($cart as $item) {
                $total_amount += $item['quantity'] * $item['price'];
            }

            // Xóa giỏ hàng sau khi đặt hàng thành công
            unset($_SESSION['cart']);

            // Lưu thông tin đơn hàng và tổng tiền vào session
            $_SESSION['order_info'] = [
                'name' => $name,
                'phone' => $phone,
                'address' => $address,
                'payment_method' => $payment_method,
                'total_amount' => $total_amount,
                'order_id' => $order_id  // Lưu thêm order_id vào session
            ];

            // Kiểm tra phương thức thanh toán và chuyển hướng nếu là "Chuyển khoản"
            if ($payment_method === 'bank') {
                header("Location: bank_transfer.php");
                exit();
            }

            // Nếu không phải chuyển khoản, hiển thị thông báo và chuyển hướng
            echo "<script>alert('Đơn hàng đã được đặt và đang chờ xác nhận!');</script>";
            echo "<script>window.location.href = '../frontend/pages/sanpham.php';</script>";
            exit();
        } else {
            $error_message = "Lỗi khi lưu đơn hàng: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="../frontend/css/checkout.css">
</head>
<body>
    <h1>Thanh Toán</h1>
    <?php if ($error_message): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="checkout.php">
        <label for="name">Tên người nhận:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

        <label for="payment_method">Phương thức thanh toán:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="cash" <?php echo $payment_method === "cash" ? "selected" : ""; ?>>Tiền mặt</option>
            <option value="bank" <?php echo $payment_method === "bank" ? "selected" : ""; ?>>Chuyển khoản</option>
        </select>

        <button type="submit">Xác nhận</button>
    </form>
</body>
</html>
