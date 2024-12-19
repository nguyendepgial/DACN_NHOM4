<?php
include '../../backend/db_connect.php'; // Kết nối cơ sở dữ liệu
include '../includes/header.php';
// Lấy danh sách danh mục
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);
$categories = [];
while ($row = $result_categories->fetch_assoc()) {
    $categories[$row['slug']] = $row['name'];
}

// Lọc và tìm kiếm sản phẩm
$search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
$search_category = isset($_GET['search_category']) ? $_GET['search_category'] : '';
$search_price_min = isset($_GET['search_price_min']) ? $_GET['search_price_min'] : '';
$search_price_max = isset($_GET['search_price_max']) ? $_GET['search_price_max'] : '';

// Chuẩn bị câu truy vấn
$sql_filter = "SELECT * FROM products WHERE 1";
$types = "";
$values = [];

// Lọc theo tên
if (!empty($search_name)) {
    $sql_filter .= " AND name LIKE ?";
    $types .= "s";
    $values[] = "%" . $search_name . "%";
}

// Lọc theo danh mục
if (!empty($search_category)) {
    $sql_filter .= " AND category_slug = ?";
    $types .= "s";
    $values[] = $search_category;
}

// Lọc theo giá
if (!empty($search_price_min)) {
    $sql_filter .= " AND price >= ?";
    $types .= "d";
    $values[] = $search_price_min;
}
if (!empty($search_price_max)) {
    $sql_filter .= " AND price <= ?";
    $types .= "d";
    $values[] = $search_price_max;
}

// Thực hiện truy vấn
$stmt = $conn->prepare($sql_filter);
if (!empty($types)) {
    $stmt->bind_param($types, ...$values);
}
$stmt->execute();
$result_products = $stmt->get_result();
?>

<link rel="stylesheet" href="../css/sanpham.css">

<main>
    <div class="container mt-5">
        <!-- Danh mục sản phẩm (menu ngang) -->
        <div class="menu-categories">
            <ul class="category-list">
                <li><a href="sanpham.php" class="category-item">Tất cả sản phẩm</a></li>
                <?php foreach ($categories as $slug => $name): ?>
                    <li><a href="sanpham.php?search_category=<?php echo htmlspecialchars($slug); ?>" 
                           class="category-item <?php echo ($search_category === $slug) ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($name); ?>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Thanh lọc sản phẩm -->
        <div class="filter-bar mb-4">
            <form id="filter-form" method="GET" action="sanpham.php" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>" class="form-control" placeholder="Tìm theo tên sản phẩm">
                </div>
                <div class="col-md-3">
                    <select name="search_category" class="form-control">
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($categories as $slug => $name): ?>
                            <option value="<?php echo htmlspecialchars($slug); ?>" <?php echo ($search_category === $slug) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="search_price_min" value="<?php echo htmlspecialchars($search_price_min); ?>" class="form-control" placeholder="Giá từ">
                </div>
                <div class="col-md-2">
                    <input type="number" name="search_price_max" value="<?php echo htmlspecialchars($search_price_max); ?>" class="form-control" placeholder="Giá đến">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-search">Tìm kiếm</button>
                    <a href="sanpham.php" class="btn btn-secondary">Hủy lọc</a>
                </div>
            </form>
        </div>

        <!-- Hiển thị sản phẩm -->
        <div id="product-list" class="row mt-4">
            <?php while ($row = $result_products->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-price"><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</p>
                            <p class="card-description"><?php echo htmlspecialchars($row['description']); ?></p>
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
