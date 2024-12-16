<?php
include('../../backend/db_connect.php'); 
include('../../backend/sidebar.php'); 

$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('m');

$sql_orders_month = "
    SELECT 
        COUNT(DISTINCT orders.order_id) AS total_orders, 
        SUM(order_details.quantity) AS total_quantity, 
        SUM(order_details.quantity * order_details.price) AS total_amount
    FROM orders
    JOIN order_details ON orders.order_id = order_details.order_id
    WHERE YEAR(orders.order_date) = ? AND MONTH(orders.order_date) = ?
";
$stmt_month = $conn->prepare($sql_orders_month);
$stmt_month->bind_param('ii', $year, $month);
$stmt_month->execute();
$result_month = $stmt_month->get_result();
$month_stats = $result_month->fetch_assoc();

$sql_monthly_revenue = "
    SELECT MONTH(order_date) AS month, 
           SUM(order_details.quantity * order_details.price) AS revenue 
    FROM orders 
    JOIN order_details ON orders.order_id = order_details.order_id 
    WHERE YEAR(order_date) = ? 
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
";
$stmt_revenue = $conn->prepare($sql_monthly_revenue);
$stmt_revenue->bind_param('i', $year);
$stmt_revenue->execute();
$result_revenue = $stmt_revenue->get_result();
$monthly_revenues = [];
while ($row = $result_revenue->fetch_assoc()) {
    $monthly_revenues[$row['month']] = $row['revenue'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Doanh Thu</title>
    <link rel="stylesheet" href="../css/statistics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <div class="main-content">
            <h1>Thống Kê Doanh Thu</h1>

            <!-- Form chọn năm và tháng -->
            <form method="GET" class="filter-form">
                <label for="year">Năm:</label>
                <select name="year" id="year">
                    <?php for ($i = 2020; $i <= date('Y'); $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $i == $year ? 'selected' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <label for="month">Tháng:</label>
                <select name="month" id="month">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $i == $month ? 'selected' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <button type="submit">Xem Thống Kê</button>
            </form>

            <!-- Tổng quan -->
            <div class="overview">
                <div class="card">
                    <h3>Tổng Đơn Hàng</h3>
                    <p><?php echo $month_stats['total_orders'] ?? 0; ?></p>
                </div>
                <div class="card">
                    <h3>Tổng Sản Phẩm Bán Ra</h3>
                    <p><?php echo $month_stats['total_quantity'] ?? 0; ?></p>
                </div>
                <div class="card">
                    <h3>Doanh Thu Tháng</h3>
                    <p><?php echo number_format($month_stats['total_amount'] ?? 0, 0, ',', '.'); ?> VNĐ</p>
                </div>
            </div>

            <!-- Biểu đồ doanh thu -->
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        '<?php echo "Tháng $i"; ?>',
                    <?php endfor; ?>
                ],
                datasets: [{
                    label: 'Doanh Thu (VNĐ)',
                    data: [
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <?php echo $monthly_revenues[$i] ?? 0; ?>,
                        <?php endfor; ?>
                    ],
                    backgroundColor: '#2c3e50',
                    borderColor: '#3375FF',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw.toLocaleString('vi-VN') + ' VNĐ';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Doanh Thu (VNĐ)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
