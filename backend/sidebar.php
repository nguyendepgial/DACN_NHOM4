
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="sidebar">
    <div class="logo">
        <h2>Admin</h2>
    </div>
    <ul>
        <li><a href="/DACN_NHOM4/frontend/pages/admin_page.php"><i class="fas fa-tachometer-alt"></i> Trang Chủ</a></li>
        <li><a href="/DACN_NHOM4/frontend/pages/manage_product.php"><i class="fas fa-cogs"></i> Quản Lý Sản Phẩm</a></li>
        <li><a href="/DACN_NHOM4/frontend/pages/add_product.php"><i class="fas fa-users"></i> Thêm Sản Phẩm Mới</a></li>
        <li><a href="/DACN_NHOM4/frontend/pages/manage_order.php"><i class="fas fa-box"></i> Quản Lý Đơn Hàng</a></li>
        <li><a href="/DACN_NHOM4/backend/process_contact_message.php"><i class="fas fa-cogs"></i> Quản Lý Liên Hệ</a></li>
        <li><a href="/DACN_NHOM4/backend/manage_users.php"><i class="fas fa-users"></i> Quản Lý Người Dùng</a></li>
        <li><a href="/DACN_NHOM4/backend/add_user.php"><i class="fas fa-cogs"></i> Thêm Người Dùng Mới</a></li>
        <li><a href="/DACN_NHOM4/frontend/pages/statistics.php"><i class="fas fa-users"></i> Thống Kê</a></li>
        <li><a href="/DACN_NHOM4/backend/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
    </ul>
</div>
<style>/* Phần Sidebar */
.sidebar {
    position: fixed; /* Cố định sidebar */
    top: 0;
    left: 0;
    width: 250px; /* Kích thước sidebar */
    height: 100%;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transition: all 0.3s ease;
}

.sidebar .logo {
    text-align: center;
    margin-bottom: 30px;
}

.sidebar .logo h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #ecf0f1;
    margin: 0;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    margin: 20px 0;
}

.sidebar ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Nổi bật trang hiện tại */
.sidebar ul li a.active {
    background-color: #3498db;
    color: white;
}

/* Hiệu ứng hover cho các phần tử */
.sidebar ul li a:hover {
    background-color: #34495e;
    color: #fff;
}

.sidebar ul li a i {
    margin-right: 15px;
    font-size: 1.2rem;
}

/* Phần nội dung chính */
.main-content {
    margin-left: 270px; /* Đảm bảo có không gian cho sidebar */
    padding: 30px;
}

/* Thêm hiệu ứng hover cho các phần tử */
.sidebar ul li a:hover i {
    transform: rotate(10deg);
}

/* Mobile responsiveness */
@media screen and (max-width: 768px) {
    /* Sidebar vẫn cố định bên trái */
    .sidebar {
        width: 200px;
        position: fixed;
        height: 100%;
    }

    .main-content {
        margin-left: 220px; /* Điều chỉnh không gian cho nội dung */
    }

    .sidebar ul li a {
        font-size: 14px;
    }

    .sidebar .logo h2 {
        font-size: 1.5rem;
    }
}

/* Sidebar di động - Đảm bảo nó không bị ẩn */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .main-content {
        margin-left: 0; /* Nội dung chính không bị đẩy ra ngoài */
    }
}


/* Nổi bật trang hiện tại */
.sidebar ul li a.active {
    background-color: #3498db;
    color: white;
}

/* Hiệu ứng hover cho các phần tử */
.sidebar ul li a:hover {
    background-color: #34495e;
    color: #fff;
}

.sidebar ul li a i {
    margin-right: 15px;
    font-size: 1.2rem;
}

/* Phần nội dung chính */
.main-content {
    margin-left: 270px; /* Đảm bảo có không gian cho sidebar */
    padding: 30px;
}

.main-content h1 {
    font-size: 2.5rem;
    color: #2c3e50;
}

.main-content p {
    font-size: 1.2rem;
    color: #7f8c8d;
}

/* Thêm hiệu ứng hover cho các phần tử */
.sidebar ul li a:hover i {
    transform: rotate(10deg);
}

/* Mobile responsiveness */
@media screen and (max-width: 768px) {
    /* Đảm bảo sidebar thu nhỏ khi kích thước màn hình nhỏ */
    .sidebar {
        width: 200px; /* Kích thước nhỏ hơn trên mobile */
        position: fixed; /* Sidebar vẫn cố định bên trái */
        height: 100%; /* Không bị cắt */
    }

    .main-content {
        margin-left: 220px; /* Điều chỉnh nội dung tránh sidebar */
    }

    .sidebar ul li a {
        font-size: 14px; /* Font size nhỏ hơn cho mobile */
    }

    .sidebar .logo h2 {
        font-size: 1.5rem; /* Font size nhỏ cho logo */
    }
}

/* Đảm bảo sidebar không bị ẩn trong các thiết bị di động */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto; /* Đảm bảo sidebar không bị ẩn khi thu nhỏ */
        position: relative; /* Thay đổi position khi màn hình nhỏ */
    }

    .main-content {
        margin-left: 0; /* Nội dung chính không bị đẩy sang bên trái nữa */
    }
}

</style>
<script>

// Lấy URL hiện tại và xác định phần tử nào trong sidebar cần được đánh dấu là "active"
document.addEventListener("DOMContentLoaded", function() {
    const path = window.location.pathname;
    const currentPage = path.split("/").pop().split(".")[0]; // Lấy tên trang từ URL (ví dụ: "manage_product")

    // Lặp qua tất cả các liên kết và thêm class active vào liên kết tương ứng với trang hiện tại
    const links = document.querySelectorAll('.sidebar ul li a');
    links.forEach(link => {
        if (link.href.includes(currentPage)) {
            link.classList.add('active');
        }
    });
});
</script>