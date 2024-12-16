<?php
include '../../backend/db_connect.php'; // Kết nối cơ sở dữ liệu
include '../../backend/sidebar.php'; // Kết nối với sidebar

// Thông báo trạng thái
$message = "";

// Lấy danh sách danh mục
$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);
$categories = [];
while ($row = $result_categories->fetch_assoc()) {
    $categories[$row['slug']] = $row['name'];
}

// Xử lý thêm sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['category_slug'], $_POST['price'], $_FILES['image'])) {
    $name = $_POST['name'];
    $category_slug = $_POST['category_slug'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Kiểm tra hình ảnh và upload
    $upload_dir = '../../public/uploads/products/';
    $image_name = basename($image['name']);
    $target_file = $upload_dir . $image_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra loại file ảnh
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $image_max_size = 5 * 1024 * 1024; // 5MB
    if (in_array($image_file_type, $allowed_extensions)) {
        if ($image['size'] > $image_max_size) {
            $message = "Kích thước ảnh phải nhỏ hơn 5MB!";
        } else {
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Thêm sản phẩm vào cơ sở dữ liệu
                $sql = "INSERT INTO products (name, category_slug, price, image) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssis', $name, $category_slug, $price, $target_file);

                if ($stmt->execute()) {
                    $message = "Sản phẩm đã được thêm thành công!";
                } else {
                    $message = "Có lỗi xảy ra khi thêm sản phẩm!";
                }
            } else {
                $message = "Lỗi trong quá trình upload hình ảnh!";
            }
        }
    } else {
        $message = "Chỉ chấp nhận các file hình ảnh với định dạng JPG, JPEG, PNG, GIF!";
    }
}

// Lọc và tìm kiếm sản phẩm
$search_name = "";
$search_category = "";
$search_price_min = "";
$search_price_max = "";

// Lọc theo tên sản phẩm, danh mục, và giá
if (isset($_GET['search'])) {
    $search_name = $_GET['search_name'];
    $search_category = $_GET['search_category'];
    $search_price_min = $_GET['search_price_min'];
    $search_price_max = $_GET['search_price_max'];
}

// Chuẩn bị câu truy vấn lọc
$sql_filter = "SELECT * FROM products WHERE 1";
if ($search_name) {
    $sql_filter .= " AND name LIKE ?";
}
if ($search_category) {
    $sql_filter .= " AND category_slug = ?";
}
if ($search_price_min) {
    $sql_filter .= " AND price >= ?";
}
if ($search_price_max) {
    $sql_filter .= " AND price <= ?";
}

// Thực hiện truy vấn lọc
$stmt_filter = $conn->prepare($sql_filter);
$types = "";
$values = [];
if ($search_name) {
    $types .= "s";
    $values[] = "%" . $search_name . "%";
}
if ($search_category) {
    $types .= "s";
    $values[] = $search_category;
}
if ($search_price_min) {
    $types .= "d";
    $values[] = $search_price_min;
}
if ($search_price_max) {
    $types .= "d";
    $values[] = $search_price_max;
}

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
    <title>Thêm Sản Phẩm</title>
    <link rel="stylesheet" href="../css/add_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Phần nội dung chính -->
    <div class="main-content">
        <div class="content-container">
            <!-- Phần hiển thị sản phẩm bên trái -->
            <div class="product-list">
                <h2>Danh Sách Sản Phẩm</h2>

                <!-- Form tìm kiếm và lọc sản phẩm -->
                <div class="search-filter">
                    <form method="GET" action="add_product.php">
                        <input type="text" name="search_name" value="<?php echo $search_name; ?>" placeholder="Tìm theo tên sản phẩm" class="search-input">
                        <select name="search_category">
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $slug => $name): ?>
                                <option value="<?php echo $slug; ?>" <?php echo $slug == $search_category ? 'selected' : ''; ?>><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" name="search_price_min" value="<?php echo $search_price_min; ?>" placeholder="Giá từ" class="search-input">
                        <input type="number" name="search_price_max" value="<?php echo $search_price_max; ?>" placeholder="Giá đến" class="search-input">
                        <button type="submit" name="search" class="search-btn">Tìm kiếm</button>
                        <button type="reset" class="reset-btn">Xóa Bộ Lọc</button>
                    </form>
                </div>

                <!-- Danh sách sản phẩm -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th>Hình ảnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_filtered->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                            <td><?php echo $categories[$row['category_slug']] ?? ''; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="Hình ảnh" width="50"></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Phần thêm sản phẩm bên phải -->
            <div class="add-form">
                <h2>Nhập Thông Tin Sản Phẩm</h2>

                <!-- Hiển thị thông báo trạng thái -->
                <?php if ($message): ?>
                <div class="message <?php echo strpos($message, 'thành công') ? 'success' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <label for="name">Tên Sản Phẩm:</label>
                    <input type="text" id="name" name="name" required placeholder="Nhập tên sản phẩm">

                    <label for="category_slug">Danh Mục:</label>
                    <select id="category_slug" name="category_slug">
                        <?php foreach ($categories as $slug => $name): ?>
                            <option value="<?php echo $slug; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="price">Giá:</label>
                    <input type="number" id="price" name="price" required placeholder="Nhập giá sản phẩm">

                    <label for="image">Hình Ảnh:</label>
                    <input type="file" id="image" name="image" required>

                    <button type="submit">Thêm Sản Phẩm</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
