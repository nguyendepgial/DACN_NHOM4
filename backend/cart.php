<?php
session_start();

$cart = $_SESSION['cart'] ?? []; 
$total = 0;  

 if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $productId = $_GET['id'];
     if (isset($cart[$productId])) {
        unset($cart[$productId]);
        $_SESSION['cart'] = $cart;  
    }
     header("Location: cart.php");
    exit();
}

 
if (isset($_POST['update'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;  
        }
    }
    $_SESSION['cart'] = $cart;  
    header("Location: cart.php");
    exit();
}

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (!isset($_SESSION['email'])) {
        $_SESSION['redirect_after_login'] = 'checkout.php';  
        header("Location: login.php");
        exit();
    } else {
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
