<?php
session_start();

$cart = $_SESSION['cart'] ?? []; // Lấy giỏ hàng từ session
$total = 0; // Biến tổng tiền

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Kiểm tra nếu sản phẩm có trong giỏ hàng và xóa nó
    if (isset($cart[$productId])) {
        unset($cart[$productId]);
        $_SESSION['cart'] = $cart; // Cập nhật lại giỏ hàng trong session
    }
    // Chuyển hướng lại giỏ hàng sau khi xóa
    header("Location: cart.php");
    exit();
}

// Cập nhật số lượng sản phẩm trong giỏ hàng
if (isset($_POST['update'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity; // Cập nhật số lượng
        }
    }
    $_SESSION['cart'] = $cart; // Cập nhật lại giỏ hàng trong session
    header("Location: cart.php");
    exit();
}

// Kiểm tra nếu người dùng nhấn nút Thanh Toán
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!isset($_SESSION['email'])) {
        $_SESSION['redirect_after_login'] = 'checkout.php'; // Lưu URL để quay lại sau đăng nhập
        header("Location: login.php");
        exit();
    } else {
        // Nếu đã đăng nhập, chuyển hướng thẳng tới trang thanh toán
        header("Location: checkout.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="../frontend/css/cart.css">
</head>
<body>
<p><a href="../frontend/pages/sanpham.php" class="btn">Quay lại trang sản phẩm</a></p>
    <div class="cart-container">
        <h1>Giỏ Hàng</h1>
        
        <?php if (!empty($cart)): ?>
            <form method="POST" action="">
                <div class="cart-items">
                    <?php foreach ($cart as $id => $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <div class="cart-item">
                            <div class="cart-item-image">
                            <img src="http://localhost/DACN_NHOM4/<?php echo htmlspecialchars($item['image']); ?>" class="product-image">
                            </div>
                            <div class="cart-item-details">
                                <h3><?php echo $item['name']; ?></h3>
                                <p><strong>Giá:</strong> <?php echo number_format($item['price']); ?> VNĐ</p>
                                <p><strong>Số lượng:</strong> 
                                    <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                </p>
                                <p><strong>Tổng cộng:</strong> <?php echo number_format($subtotal); ?> VNĐ</p>
                            </div>
                            <div class="cart-item-actions">
                                <a href="cart.php?action=remove&id=<?php echo $id; ?>" class="remove-item" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h3>Tổng tiền: <?php echo number_format($total); ?> VNĐ</h3>
                    <button type="submit" name="update" class="btn update-btn">Cập nhật giỏ hàng</button>
                    <form method="POST" action="">
                        <button type="submit" class="btn checkout-btn">Thanh Toán</button>
                    </form>
                </div>
            </form>

        <?php else: ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php endif; ?>
    </div>
</body>
</html>
