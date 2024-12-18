
<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $estimated_delivery_date = date('Y-m-d', strtotime('+3 days'));

    // Cập nhật trạng thái và ngày giao hàng
    $sql = "UPDATE orders SET status = 'confirmed', estimated_delivery_date = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estimated_delivery_date, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Đơn hàng đã được xác nhận!');</script>";
        echo "<script>window.location.href = 'admin_page.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xác nhận đơn hàng.');</script>";
    }
}
?>
<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $estimated_delivery_date = date('Y-m-d', strtotime('+3 days'));

    // Cập nhật trạng thái và ngày giao hàng
    $sql = "UPDATE orders SET status = 'confirmed', estimated_delivery_date = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estimated_delivery_date, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Đơn hàng đã được xác nhận!');</script>";
        echo "<script>window.location.href = 'admin_page.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xác nhận đơn hàng.');</script>";
    }
}
?>

