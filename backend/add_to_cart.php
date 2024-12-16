<<<<<<< HEAD
<?php
session_start();
header('Content-Type: application/json');

// Lấy dữ liệu từ JSON gửi đến
$data = json_decode(file_get_contents("php://input"), true);

$productId = $data['id'];
$productName = $data['name'];
$productPrice = $data['price'];
$productImage = "public/images/AnhCat/" . basename($data['image']); // Đường dẫn chính xác
$quantity = $data['quantity'];

// Kiểm tra nếu giỏ hàng chưa tồn tại
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu sản phẩm đã tồn tại, tăng số lượng
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] += $quantity;
} else {
    // Thêm sản phẩm mới vào giỏ hàng
    $_SESSION['cart'][$productId] = [
        'name' => $productName,
        'price' => $productPrice,
        'image' => $productImage, // Đường dẫn ảnh
        'quantity' => $quantity
    ];
}

// Phản hồi thành công
echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
?>
=======
<?php
session_start();
header('Content-Type: application/json');

// Lấy dữ liệu từ JSON gửi đến
$data = json_decode(file_get_contents("php://input"), true);

$productId = $data['id'];
$productName = $data['name'];
$productPrice = $data['price'];
$productImage = "public/images/AnhCat/" . basename($data['image']); // Đường dẫn chính xác
$quantity = $data['quantity'];

// Kiểm tra nếu giỏ hàng chưa tồn tại
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu sản phẩm đã tồn tại, tăng số lượng
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] += $quantity;
} else {
    // Thêm sản phẩm mới vào giỏ hàng
    $_SESSION['cart'][$productId] = [
        'name' => $productName,
        'price' => $productPrice,
        'image' => $productImage, // Đường dẫn ảnh
        'quantity' => $quantity
    ];
}

// Phản hồi thành công
echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
?>
>>>>>>> origin/thanhnguyen
