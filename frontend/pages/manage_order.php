<?php
include '../../backend/db_connect.php'; // Kết nối cơ sở dữ liệu
include '../../backend/sidebar.php'; // Kết nối với sidebar

// Lấy dữ liệu từ form tìm kiếm
$search_order_id = isset($_GET['search_order_id']) ? trim($_GET['search_order_id']) : "";
$search_customer_name = isset($_GET['search_customer_name']) ? trim($_GET['search_customer_name']) : "";
$status_filter = isset($_GET['status_filter']) ? trim($_GET['status_filter']) : ""; // Trạng thái lọc

// Chuẩn bị câu truy vấn lọc
$sql_filter = "SELECT o.*, k.ten_khach_hang AS user_name 
               FROM orders o 
               LEFT JOIN khachhang k ON o.user_id = k.ma_khach_hang 
               WHERE 1";

$types = "";
$values = [];

// Lọc theo mã đơn hàng
if (!empty($search_order_id)) {
    $sql_filter .= " AND o.order_id = ?";
    $types .= "i";
    $values[] = $search_order_id;
}

// Lọc theo tên khách hàng
if (!empty($search_customer_name)) {
    $sql_filter .= " AND k.ten_khach_hang LIKE ?";
    $types .= "s";
    $values[] = "%" . $search_customer_name . "%";
}

// Lọc theo trạng thái đơn hàng
if ($status_filter !== "") { // Kiểm tra trạng thái không rỗng
    $sql_filter .= " AND o.status = ?";
    $types .= "s";
    $values[] = $status_filter; // Giá trị trạng thái
}

// Chuẩn bị và thực thi truy vấn
$stmt_filter = $conn->prepare($sql_filter);
if ($types) {
    $stmt_filter->bind_param($types, ...$values);
}
$stmt_filter->execute();
$result_filtered = $stmt_filter->get_result();
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>
    <link rel="stylesheet" href="../css/manage_order.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    
    <!-- Phần nội dung chính -->
    <div class="main-content">
        <h1>Quản Lý Đơn Hàng</h1>

        <!-- Form tìm kiếm -->
        <form method="GET" id="filter-form" class="filter-form">
            <div>
                <label for="search_order_id">Mã Đơn Hàng:</label>
                <input type="text" name="search_order_id" id="search_order_id" value="<?php echo htmlspecialchars($search_order_id); ?>" placeholder="Nhập mã đơn hàng">
            </div>
            <div>
                <label for="search_customer_name">Tên Khách Hàng:</label>
                <input type="text" name="search_customer_name" id="search_customer_name" value="<?php echo htmlspecialchars($search_customer_name); ?>" placeholder="Nhập tên khách hàng">
            </div>
            <div>
                <label for="status_filter">Trạng Thái:</label>
                <select name="status_filter" id="status_filter">
                    <option value="">Tất Cả</option>
                    <option value="confirmed" <?php echo $status_filter === 'confirmed' ? 'selected' : ''; ?>>Đã xác nhận</option>
                    <option value="awaiting confirmation" <?php echo $status_filter === 'awaiting confirmation' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                </select>
            </div>
            <button type="submit" name="search">Tìm Kiếm</button>
            <button type="button" id="reset-button">Xóa Bộ Lọc</button>
        </form>

        <!-- Hiển thị kết quả -->
        <div class="order-container">
            <table>
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Người Dùng</th>
                        <th>Ngày Đặt</th>
                        <th>Trạng Thái</th>
                        <th>Tổng Tiền</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_filtered->num_rows > 0): ?>
                        <?php while ($row = $result_filtered->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td><?php echo $row['status'] === 'confirmed' ? 'Đã xác nhận' : 'Đang chờ xác nhận'; ?></td>
                                <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <button class="btn-details" data-order='<?php echo json_encode($row); ?>'>Xem Chi Tiết</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Không có đơn hàng nào phù hợp.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal hiển thị chi tiết -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Chi Tiết Đơn Hàng</h2>
            <div id="order-info">
                <!-- Nội dung chi tiết đơn hàng sẽ được chèn qua JavaScript -->
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Xử lý nút "Xóa Bộ Lọc"
            const resetButton = document.getElementById('reset-button');
            const filterForm = document.getElementById('filter-form');

            if (resetButton && filterForm) {
                resetButton.addEventListener('click', function () {
                    filterForm.reset(); // Xóa toàn bộ giá trị trong form
                    window.location.href = window.location.pathname; // Tải lại trang không có tham số GET
                });
            }

            // Đảm bảo modal được ẩn khi load trang
            document.getElementById('orderModal').style.display = 'none';

            // Hiển thị modal chi tiết đơn hàng
            document.querySelectorAll('.btn-details').forEach(button => {
                button.addEventListener('click', () => {
                    const order = JSON.parse(button.getAttribute('data-order'));
                    const modalContent = `
                        <p><strong>Mã Đơn Hàng:</strong> ${order.order_id}</p>
                        <p><strong>Người Dùng:</strong> ${order.user_name}</p>
                        <p><strong>Ngày Đặt:</strong> ${order.order_date}</p>
                        <p><strong>Địa Chỉ:</strong> ${order.address}</p>
                        <p><strong>Phương Thức Thanh Toán:</strong> ${order.payment_method}</p>
                        <p><strong>Trạng Thái:</strong> ${order.status === 'confirmed' ? 'Đã xác nhận' : 'Đang chờ xác nhận'}</p>
                        <p><strong>Tổng Tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.total_price)}</p>
                    `;
                    document.getElementById('order-info').innerHTML = modalContent;
                    document.getElementById('orderModal').style.display = 'flex';
                });
            });

            // Đóng modal
            document.querySelector('.close-modal').addEventListener('click', () => {
                document.getElementById('orderModal').style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === document.getElementById('orderModal')) {
                    document.getElementById('orderModal').style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>
