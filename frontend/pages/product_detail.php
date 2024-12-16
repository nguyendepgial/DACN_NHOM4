<?php
include '../includes/header.php';
include '../../backend/db_connect.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT id, name, category_slug, price, image, description FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo '<p>Sản phẩm không tồn tại!</p>';
        exit;
    }
    $stmt->close();
} else {
    echo '<p>Không có sản phẩm được chọn!</p>';
    exit;
}

$imagePath = 'images/' . htmlspecialchars($product['image']);
if (!file_exists($imagePath) || empty($product['image'])) {
    $imagePath = 'images/default.jpg';  // Nếu không có ảnh, sử dụng ảnh mặc định
}
?>

<link rel="stylesheet" href="../css/product_detail.css">

<main>
    <div class="container mt-5">
        <!-- Hiển thị chi tiết sản phẩm -->
        <div class="product-detail row">
            <div class="col-md-6">
                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><strong>Giá: </strong><?php echo number_format($product['price']); ?> VNĐ</p>
                <p><strong>Mô tả: </strong><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Danh mục: </strong><?php echo htmlspecialchars($product['category_slug']); ?></p>

                <div class="d-flex align-items-center">
                    <a href="sanpham.php" class="btn btn-back">Quay lại</a>

                    <button class="btn btn-add-to-cart" id="add-to-cart-btn">Thêm vào giỏ hàng</button>
                    
                    <input type="number" id="quantity" value="1" min="1" class="form-control" style="width: 100px; margin-left: 10px;">
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Liên kết CSS -->
<link rel="stylesheet" href="css/product_detail.css">

<?php
include '../includes/footer.php';
?>

<!-- JavaScript -->
<script>
    document.getElementById('add-to-cart-btn').addEventListener('click', function() {
        const productId = <?php echo $product['id']; ?>;
        const productName = "<?php echo addslashes($product['name']); ?>";
        const productPrice = <?php echo $product['price']; ?>;
        const productImage = "<?php echo addslashes($product['image']); ?>";
        const quantity = document.getElementById('quantity').value;

        fetch('../../backend/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Sản phẩm đã được thêm vào giỏ hàng!");
            } else {
                alert("Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.");
            }
        })
        .catch(error => {
            console.error("Lỗi khi thêm vào giỏ hàng:", error);
            alert("Có lỗi xảy ra. Vui lòng thử lại.");
        });
    });
</script>
