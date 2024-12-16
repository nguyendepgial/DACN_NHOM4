<?php
session_start();  
include '../includes/header.php';

if (!isset($_SESSION['ma_khach_hang'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem đơn hàng!');</script>";
    echo "<script>window.location.href = '../../backend/login.php';</script>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moc_nguyen";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$user_id = $_SESSION['ma_khach_hang'];

$sql = "SELECT o.order_id, o.order_date, o.name, o.phone, o.address, o.payment_method, 
                o.status, SUM(od.quantity * od.price) AS total_price
        FROM orders o
        JOIN order_details od ON o.order_id = od.order_id
        WHERE o.user_id = ? 
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // "i" là kiểu dữ liệu integer cho user_id
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng Của Tôi</title>
    <link rel="stylesheet" href="../css/order_details.css">
</head>
<body>
    <div class="order-container">
        <a href="sanpham.php" class="back-btn">Quay lại</a>
        <h2>Danh Sách Đơn Hàng Của Tôi</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Thanh Toán</th>
                        <th>Trạng thái</th>
                        <th>Tổng Tiền</th>
                        <th>Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($row['order_date'])); ?></td>
                            <td>
                                <?php
                                echo $row['payment_method'] === 'cash'
                                    ? 'Thanh toán khi nhận hàng'
                                    : 'Chuyển khoản';
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo $row['status'] === 'awaiting confirmation'
                                    ? "Đang chờ xác nhận"
                                    : "Đang giao hàng";
                                ?>
                            </td>
                            <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?> VNĐ</td>             
                            <td>
                                <a href="view_orders.php?order_id=<?php echo $row['order_id']; ?>" class="btn-details">Xem Chi Tiết</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
