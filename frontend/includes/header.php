<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start nếu chưa có session nào
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/bf61fecb7c.js" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Icon -->
    <link rel="icon" href="../../public/images/logo.png" type="image/png">
    <title>Hiếu Nguyên</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <img src="../../public/images/logo.png" alt="logo">
                <h2>Hiếu Nguyên</h2>
            </a>

            <!-- Toggle menu (nút thu gọn) -->
            <button class="menu-toggle" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Menu -->
            <ul class="links">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="../pages/gioithieu.php">Giới thiệu</a></li>
                <li><a href="../pages/sanpham.php">Sản phẩm</a></li>
                <li><a href="../pages/order_details.php">Đơn hàng</a></li>
                <li><a href="../pages/doitac.php">Đối tác</a></li>
                <li><a href="../pages/contact.php">Liên hệ</a></li>
            </ul>

            <!-- Header Icons (Giỏ hàng, đăng nhập, lời chào) -->
            <div class="header-icons">
                <!-- Giỏ hàng -->
                <a href="../../backend/cart.php" class="cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count">
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </span>
                </a>

                <!-- Kiểm tra trạng thái đăng nhập -->
                <?php if (isset($_SESSION['email'])): ?>
                    <div class="welcome-message">
                        <?php echo "Xin chào, " . $_SESSION['email']; ?>
                    </div>
                    <a href="../pages/profile.php" class="profile-btn"><i class="fas fa-user-circle"></i></a>
                    <a href="../../backend/logout.php" class="login-btn">ĐĂNG XUẤT</a>
                <?php else: ?>
                    <a href="../../backend/login.php" class="login-btn">ĐĂNG NHẬP</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.querySelector('.menu-toggle');
            const menuLinks = document.querySelector('.links');

            // Thêm sự kiện khi nhấn vào nút toggle
            toggleButton.addEventListener('click', function () {
                menuLinks.classList.toggle('active'); // Bật/tắt lớp "active" để hiển thị/ẩn menu
            });
        });
    </script>
    
</body>
</html>
<style>/* Header container */
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: #f3ecec;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

/* Nút menu thu gọn */
.menu-toggle {
    display: none; /* Ẩn trên màn hình lớn */
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #333;
}

/* Navbar container */
.navbar {
    display: flex;
    justify-content: space-between; /* Logo trái, menu giữa, icons phải */
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 15px 20px;
}

/* Logo container */
.logo {
    display: flex;
    align-items: center; /* Căn giữa logo và tên theo chiều dọc */
    text-decoration: none;
    gap: 10px; /* Khoảng cách giữa logo và tên */
}

.logo img {
    width: 60px; /* Kích thước logo lớn hơn một chút */
    height: 60px; /* Đảm bảo logo có hình vuông */
    object-fit: contain; /* Đảm bảo logo không bị méo */
}

.logo h2 {
    font-size: 28px; /* Kích thước chữ lớn hơn */
    font-weight: 700; /* Chữ đậm hơn */
    color: #8b5e34; /* Màu chữ sang trọng */
    margin: 0; /* Xóa khoảng cách thừa */
    letter-spacing: 1px; /* Tạo khoảng cách giữa các chữ */
    text-decoration: none;
    margin-right: 30px;
}
.logo h2:hover {
    text-decoration: none;

}
/* Điều chỉnh căn chỉnh logo khi responsive */
@media (max-width: 768px) {
    .logo img {
        width: 50px;
        height: 50px;
    }

    .logo h2 {
        font-size: 22px;
    }
}


/* Menu */
.links {
    display: flex;
    list-style: none;
    gap: 25px;
    justify-content: center;
    margin: 0;
    padding: 0;
    transition: all 0.3s ease-in-out;
}

.links.active {
    display: block; /* Hiển thị menu trên màn hình nhỏ */
    flex-direction: column;
    background: #f3ecec;
    padding: 10px 0;
    border-radius: 5px;
}

/* Ẩn menu mặc định trên màn hình nhỏ */
@media (max-width: 768px) {
    .menu-toggle {
        display: block; /* Hiển thị nút menu */
    }

    .links {
        display: none; /* Ẩn menu */
        flex-direction: column;
        text-align: center;
    }

    .header-icons {
        flex-direction: column;
        gap: 10px;
        margin-top: 15px;
    }
}

/* Menu items */
.links a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
    font-weight: 500;
    padding: 10px 15px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.links a:hover {
    background-color: rgb(189, 148, 95);
    color: #fff;
}

/* Header Icons */
.header-icons {
    display: flex;
    align-items: center;
    gap: 15px;
    justify-content: flex-end; /* Đưa các phần tử sang bên phải */
    margin-left: auto; /* Đẩy các phần tử sang phải hoàn toàn */
}
.header-icons:hover {
    color: #8b5e34;
}
/* Giỏ hàng */
.cart-btn {
    position: relative;
    color: #333;
    font-size: 20px;
    text-decoration: none;
}

.cart-btn i {
    font-size: 24px;

}


/* Số lượng trong giỏ hàng */
#cart-count {
    position: absolute;
    top: -5px;
    right: -10px;
    background: red;
    color: white;
    font-size: 12px;
    border-radius: 50%;
    padding: 2px 6px;
}

/* Lời chào và Đăng nhập/Đăng xuất */
.welcome-message {
    font-size: 16px;
    color: #555;
}

.login-btn {
    background-color: rgb(189, 148, 95);
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.login-btn:hover {
    background-color: #8b5e34;
    text-decoration: none;
    color: white;

}

/* Profile button */
.profile-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: rgb(189, 148, 95);
    color: white;
    text-decoration: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 20px;
    transition: background-color 0.3s, transform 0.3s;
}

.profile-btn i {
    margin: 0;
}

.profile-btn:hover {
    background-color: #8b5e34;
    transform: scale(1.1); /* Phóng to nhẹ khi hover */
    color: white;

}
</style>