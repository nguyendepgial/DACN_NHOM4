<?php
session_start();

include('../../backend/db_connect.php');
include('../../backend/sidebar.php');

$sql_new_orders = "SELECT * FROM orders WHERE status = 'awaiting confirmation'";
$result_new_orders = $conn->query($sql_new_orders);

$sql_products = "SELECT COUNT(*) AS total FROM products";
$result_products = $conn->query($sql_products);
$total_products = $result_products->fetch_assoc()['total'];

$sql_orders_processed = "SELECT COUNT(*) AS total FROM orders WHERE status = 'confirmed'";
$result_orders_processed = $conn->query($sql_orders_processed);
$total_orders_processed = $result_orders_processed->fetch_assoc()['total'];

$sql_users = "SELECT COUNT(*) AS total FROM khachhang";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total'];

$sql_revenue = "SELECT SUM(total_price) AS total FROM orders WHERE status = 'confirmed' AND MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE())";
$result_revenue = $conn->query($sql_revenue);
$total_revenue = $result_revenue->fetch_assoc()['total'] ?: 0;

$sql_orders = "SELECT COUNT(*) AS total FROM orders WHERE MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE())";
$result_orders = $conn->query($sql_orders);
$total_orders = $result_orders->fetch_assoc()['total'];

$sql_orders_shipped = "SELECT COUNT(*) AS total FROM orders WHERE MONTH(order_date) = MONTH(CURRENT_DATE()) AND YEAR(order_date) = YEAR(CURRENT_DATE()) AND status = 'shipped'";
$result_orders_shipped = $conn->query($sql_orders_shipped);
$total_orders_shipped = $result_orders_shipped->fetch_assoc()['total'];

$sql_contact_messages = "SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5";
$result_contact_messages = $conn->query($sql_contact_messages);


$sql_contact_messages_1 = "SELECT COUNT(*) AS total FROM contact_messages WHERE status = 'processed'";
$result_contact_messages_1 = $conn->query($sql_contact_messages_1);
$total_contact_messages_1 = $result_contact_messages_1->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Admin</title>
    <link rel="stylesheet" href="../css/admin_page.css">
</head>
<body>
    <div class="wrapper">
    

        <!-- Main Content -->
        <div class="main-content">
            <h1>Quản Lý Hệ Thống</h1>
            <div class="content">
                <!-- Phần thống kê -->
                <div class="stats-summary">
                    <div class="stat-item">
                        <h3>Sản Phẩm Hiện Có</h3>
                        <p class="stat-value"><?php echo $total_products; ?></p>
                    </div>
                    <div class="stat-item">
                        <h3>Đơn Hàng Đã Xử Lý</h3>
                        <p class="stat-value"><?php echo $total_orders_processed; ?></p>
                    </div>
                    <div class="stat-item">
                        <h3>Người Dùng Đã Đăng Ký</h3>
                        <p class="stat-value"><?php echo $total_users; ?></p>
                    </div>
                    <div class="stat-item">
                        <h3>Doanh Thu Tháng Này</h3>
                        <p class="stat-value"><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</p>
                    </div>
                    <div class="stat-item">
                        <h3>Liên Hệ Đã Xử Lí</h3>
                        <p class="stat-value"><?php echo $total_contact_messages_1?></p>
                    </div>
                </div>

                <!-- Danh sách đơn hàng mới chờ xác nhận -->
                <div class="orders-management">
                    <h2>Đơn Hàng Mới Chờ Xác Nhận</h2>
                    <div class="orders-table-wrapper">
                        <?php if ($result_new_orders->num_rows > 0): ?>
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Mã Đơn Hàng</th>
                                        <th>Người Nhận</th>
                                        <th>Ngày Đặt</th>
                                        <th>Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = $result_new_orders->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $order['order_id']; ?></td>
                                            <td><?php echo $order['name']; ?></td>
                                            <td><?php echo date('d-m-Y H:i', strtotime($order['order_date'])); ?></td>
                                            <td class="status">
                                                <?php 
                                                if ($order['status'] == 'awaiting confirmation') {
                                                    echo 'Chờ Xác Nhận';
                                                } elseif ($order['status'] == 'confirmed') {
                                                    echo 'Đã Xác Nhận';
                                                } elseif ($order['status'] == 'shipped') {
                                                    echo 'Đã Giao';
                                                } else {
                                                    echo $order['status'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($order['status'] == 'awaiting confirmation'): ?>
                                                    <form method="POST" action="confirm_order.php">
                                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                        <button type="submit" class="btn-confirm">Xác Nhận</button>
                                                    </form>
                                                <?php else: ?>
                                                    <span>Đã xác nhận</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Hiện tại không có đơn hàng nào mới chờ xác nhận.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Thông báo liên hệ của khách hàng -->
                <div class="contact-messages">
                    <h2>Thông Báo Liên Hệ Của Khách Hàng</h2>
                    <div class="messages-table-wrapper">
                        <?php if ($result_contact_messages->num_rows > 0): ?>
                            <table class="messages-table">
                                <thead>
                                    <tr>
                                        <th>Người Gửi</th>
                                        <th>Danh Mục</th>
                                        <th>Thời Gian</th>
                                        <th>Chi Tiết</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php while ($message = $result_contact_messages->fetch_assoc()): ?>
        <tr>
            <td><?php echo $message['name']; ?></td>
            <td><?php echo $message['category']; ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($message['created_at'])); ?></td>
            <td><?php echo $message['message']; ?></td>
            <td>
                <?php if ($message['status'] === 'pending'): ?>
                    <!-- Form gửi dữ liệu đến process_contact_message.php -->
                    <form method="POST" action="process_contact_message.php">
                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                        <button type="submit" class="btn-process">Xử Lý</button>
                    </form>
                <?php else: ?>
                    <span class="processed-status">Đã Xử Lý</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

                            </table>
                        <?php else: ?>
                            <p>Không có thông báo liên hệ nào từ khách hàng.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
