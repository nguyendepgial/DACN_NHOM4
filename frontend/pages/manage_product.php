<?php
include '../../backend/db_connect.php'; 
include '../../backend/sidebar.php'; 

$message = "";

$sql_categories = "SELECT * FROM categories";
$result_categories = $conn->query($sql_categories);
$categories = [];
while ($row = $result_categories->fetch_assoc()) {
    $categories[$row['slug']] = $row['name'];
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql_delete = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $message = "Xóa sản phẩm thành công!";
    } else {
        $message = "Có lỗi xảy ra khi xóa sản phẩm!";
    }
    $stmt->close();
}

if (isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_slug = $_POST['category_slug'];
    $description = $_POST['description'];

    $image = "D:\xampp\htdocs\DACN_NHOM4\public\uploads\products";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = "" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    if ($image) {
        $sql_update = "UPDATE products SET name = ?, price = ?, category_slug = ?, description = ?, image = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sdsssi", $name, $price, $category_slug, $description, $image, $id);
    } else {
        $sql_update = "UPDATE products SET name = ?, price = ?, category_slug = ?, description = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sdssi", $name, $price, $category_slug, $description, $id);
    }

    if ($stmt_update->execute()) {
        $message = "Cập nhật sản phẩm thành công!";
        
    } else {
        $message = "Có lỗi xảy ra khi cập nhật sản phẩm!";
    }
    $stmt_update->close();
}

$search_name = "";
$search_category = "";
$search_price_min = "";
$search_price_max = "";

if (isset($_GET['search'])) {
    $search_name = $_GET['search_name'];
    $search_category = $_GET['search_category'];
    $search_price_min = $_GET['search_price_min'];
    $search_price_max = $_GET['search_price_max'];
}

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
    <title>Quản Lý Sản Phẩm</title>
    <link rel="stylesheet" href="../css/manage_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
   

    <!-- Phần nội dung chính -->
    <div class="main-content">
        <h1>Quản Lý Sản Phẩm</h1>

        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <div class="search-filter">
            <form method="GET" action="manage_product.php">
                <input type="text" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>" placeholder="Tìm theo tên sản phẩm" class="search-input">
                <select name="search_category">
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $slug => $name): ?>
                        <option value="<?php echo htmlspecialchars($slug); ?>" <?php echo ($slug == $search_category) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="search_price_min" value="<?php echo htmlspecialchars($search_price_min); ?>" placeholder="Giá từ" class="search-input">
                <input type="number" name="search_price_max" value="<?php echo htmlspecialchars($search_price_max); ?>" placeholder="Giá đến" class="search-input">
                <button type="submit" name="search" class="search-btn">Tìm kiếm</button>
                <a href="manage_product.php" class="cancel-filter-btn">Xóa Bộ Lọc</a>
            </form>
        </div>

        <!-- Danh sách sản phẩm -->
        <h2>Danh Sách Sản Phẩm</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_filtered->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                    <td><?php echo htmlspecialchars($categories[$row['category_slug']] ?? ''); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Hình ảnh" width="50"></td>
                    <td class="action-buttons">
                        <button class="select-btn" onclick="openModal('modal-<?php echo $row['id']; ?>')">Chọn</button>
                        <a href="manage_product.php?delete_id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                    </td>
                </tr>

                <!-- Modal Sửa Sản Phẩm -->
                <div id="modal-<?php echo $row['id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('modal-<?php echo $row['id']; ?>')">&times;</span>
                        <h2>Sửa Sản Phẩm</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

                            <label for="name-<?php echo $row['id']; ?>">Tên sản phẩm:</label>
                            <input type="text" id="name-<?php echo $row['id']; ?>" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>

                            <label for="price-<?php echo $row['id']; ?>">Giá:</label>
                            <input type="number" id="price-<?php echo $row['id']; ?>" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>

                            <label for="category_slug-<?php echo $row['id']; ?>">Danh mục:</label>
                            <select id="category_slug-<?php echo $row['id']; ?>" name="category_slug" required>
                                <?php foreach ($categories as $slug => $name): ?>
                                    <option value="<?php echo htmlspecialchars($slug); ?>" <?php echo ($slug === ($row['category_slug'] ?? '')) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="description-<?php echo $row['id']; ?>">Mô tả:</label>
                            <textarea id="description-<?php echo $row['id']; ?>" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>

                            <label for="image-<?php echo $row['id']; ?>">Hình ảnh:</label>
                            <input type="file" name="image" id="image-<?php echo $row['id']; ?>">
                            <?php if (!empty($row['image'])): ?>
                                 <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                    <?php endif; ?>


                            <button type="submit" name="update_product" class="btn update-btn">Cập nhật sản phẩm</button>
                            <button type="button" class="btn cancel-btn" onclick="closeModal('modal-<?php echo $row['id']; ?>')">Thoát</button>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript để xử lý modal -->
    <script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    window.onclick = function(event) {
        var modals = document.getElementsByClassName('modal');
        for (var i = 0; i < modals.length; i++) {
            if (event.target == modals[i]) {
                modals[i].style.display = "none";
            }
        }
    }
    </script>
</body>
</html>

