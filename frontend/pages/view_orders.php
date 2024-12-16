<?php
// Bao gồm kết nối cơ sở dữ liệu từ file header.php
include '../includes/header.php';
include '../../backend/db_connect.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['ma_khach_hang'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem chi tiết đơn hàng!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

// Lấy thông tin đơn hàng từ query string
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

// Truy vấn để lấy thông tin đơn hàng, chỉ cho phép xem đơn hàng của người dùng hiện tại
$sql = "SELECT o.order_id, o.order_date, o.name, o.phone, o.address, o.payment_method, o.total_price, o.status, o.estimated_delivery_date
        FROM orders o
        WHERE o.order_id = ? AND o.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $_SESSION['ma_khach_hang']);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();

    // Truy vấn để lấy chi tiết đơn hàng
    $sql_details = "SELECT od.quantity, p.name AS product_name, od.price, (od.quantity * od.price) AS total_price, p.image 
                    FROM order_details od
                    JOIN products p ON od.product_id = p.id
                    WHERE od.order_id = ?";

    $stmt_details = $conn->prepare($sql_details);
    $stmt_details->bind_param("i", $order_id);
    $stmt_details->execute();
    $details_result = $stmt_details->get_result();
} else {
    echo "<script>alert('Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.');</script>";
    echo "<script>window.location.href = 'order_details.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="../css/view_orders.css">
</head>
<body>
    <div class="order-details-container">
        <a href="order_details.php" class="btn">Quay lại danh sách đơn hàng</a>
        <h2>Chi Tiết Đơn Hàng</h2>

        <!-- Thông tin đơn hàng -->
        <div class="order-info">
            <p><strong>Mã Đơn Hàng:</strong> <?php echo $order['order_id']; ?></p>
            <p><strong>Ngày Đặt:</strong> <?php echo date('d-m-Y H:i', strtotime($order['order_date'])); ?></p>
            <p><strong>Người Nhận:</strong> <?php echo $order['name']; ?></p>
            <p><strong>Số Điện Thoại:</strong> <?php echo $order['phone']; ?></p>
            <p><strong>Địa Chỉ:</strong> <?php echo $order['address']; ?></p>
            <p><strong>Phương Thức Thanh Toán:</strong> 
                <?php
                if ($order['payment_method'] === 'bank') {
                    echo "Chuyển khoản";
                } elseif ($order['payment_method'] === 'cash') {
                    echo "Thanh toán khi nhận hàng";
                }
                ?>
            </p>
            <p><strong>Trạng Thái:</strong> 
                <?php 
                echo $order['status'] === 'awaiting confirmation'
                    ? "Đang chờ xác nhận"
                    : "Đang giao hàng";
                ?>
            </p>
            <p><strong>Thời Gian Giao Hàng Dự Kiến:</strong> 
                <?php
                echo !empty($order['estimated_delivery_date'])
                    ? date('d-m-Y', strtotime($order['estimated_delivery_date']))
                    : "Chưa xác định";
                ?>
            </p>
        </div>

        <!-- Danh sách sản phẩm -->
        <h3>Danh Sách Sản Phẩm Đã Đặt</h3>

        <?php if ($details_result->num_rows > 0): ?>
            <table class="order-details-table">
                <thead>
                    <tr>
                        <th>Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_order = 0; // Biến tổng tiền
                    while ($detail = $details_result->fetch_assoc()): 
                        $total_order += $detail['total_price'];
                    ?>
                        <tr>
                            <td>
                                <img src="<?php echo $detail['image']; ?>" alt="<?php echo $detail['product_name']; ?>" width="50" height="50">
                            </td>
                            <td><?php echo $detail['product_name']; ?></td>
                            <td><?php echo $detail['quantity']; ?></td>
                            <td><?php echo number_format($detail['price'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo number_format($detail['total_price'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            
            <div class="total-price">
                <h4><strong>Tổng Tiền:</strong> <?php echo number_format($total_order, 0, ',', '.'); ?> VNĐ</h4>
            </div>
        <?php else: ?>
            <p>Không có sản phẩm trong đơn hàng này.</p>
        <?php endif; ?>
    </div>

    <?php
    $stmt->close();
    $stmt_details->close();
    $conn->close();
    ?>
</body>
</html>
