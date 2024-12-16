<?php
session_start();

// Kiểm tra nếu không có thông tin đơn hàng trong session, chuyển hướng về trang thanh toán
if (!isset($_SESSION['order_info'])) {
    header("Location: checkout.php");
    exit();
}

// Lấy thông tin đơn hàng từ session
$order_info = $_SESSION['order_info'];
$name = $order_info['name'];
$phone = $order_info['phone'];
$address = $order_info['address'];
$payment_method = $order_info['payment_method'];
$total_amount = $order_info['total_amount'];
$order_id = $order_info['order_id'];  // Lấy order_id từ session

// Kiểm tra phương thức thanh toán
if ($payment_method !== 'bank') {
    // Nếu phương thức thanh toán không phải là chuyển khoản, chuyển về trang chủ
    header("Location: index.php");
    exit();
}

include 'phpqrcode.php';  // Bao gồm thư viện phpqrcode

// Cấu hình nội dung cho mã QR
$qr_content = "Thông tin thanh toán:\n";
$qr_content .= "Ngân hàng: Ngân hàng A\n";
$qr_content .= "Số tài khoản: 1234567890\n";
$qr_content .= "Chủ tài khoản: $name\n";
$qr_content .= "Số tiền: $total_amount VNĐ\n";
$qr_content .= "Mã đơn hàng: $order_id";  // Thêm mã đơn hàng

// Tạo mã QR
$file = 'qrcode.png';  // Đặt tên file hình ảnh mã QR
QRcode::png($qr_content, $file, 'L', 10, 2);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quét Mã QR Thanh Toán</title>
    <link rel="stylesheet" href="../frontend/css/bank_transfer.css">
</head>
<body>
    <div class="container">
        <h1>Quét Mã QR Để Thanh Toán</h1>
        <p>Hãy quét mã QR dưới đây để hoàn tất thanh toán:</p>
        <div class="qr-container">
            <img src="<?php echo $file; ?>" alt="QR Code">
        </div>
        <div class="payment-info">
            <h3>Thông Tin Thanh Toán:</h3>
            <p><strong>Ngân hàng:</strong> Ngân hàng A</p>
            <p><strong>Số tài khoản:</strong> 1234567890</p>    
            <p><strong>Chủ tài khoản:</strong> Le Thanh Nguyen </p>
            <p><strong>Số tiền cần chuyển:</strong> <?php echo number_format($total_amount, 0, ',', '.'); ?> VNĐ</p>
            <p><strong>Mã đơn hàng:</strong> <?php echo $order_id; ?></p>
        </div>
        <div class="back-btn">
            <a href="../frontend/pages/index.php">Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>
