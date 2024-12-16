<?php
include '../includes/header.php';
include '../../backend/db_connect.php';

$query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
$result = $conn->query($query);
?>

<main>
    <div id="container">
        <!-- BANNER -->
        <div class="banner">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../../public/images/AnhCat/banner.png" class="d-block w-100" alt="Banner">
                        <div class="content-box-banner">
                            <h2 class="text-uppercase header-banner">
                                THẾ GIỚI NỘI THẤT SỐ 1 VIỆT NAM <br> <span> Mộc Nguyên </span>
                            </h2>
                            <div class="sapo-banner">
                                <p>
                                    Sứ mệnh của chúng tôi là kết hợp hài hòa giữa ý tưởng và mong muốn của khách hàng,
                                    đem lại những phút giây thư giãn tuyệt vời bên gia đình và những người thân yêu.
                                </p>
                            </div>
                            <a href="../pages/contact.php" class="text-uppercase btn-banner"> Liên hệ ngay </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SẢN PHẨM NỔI BẬT -->
        <h2 class="hot-product-title">Sản phẩm nổi bật</h2>
        <div class="slider owl-carousel">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="img">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>">
                    </div>
                    <div class="content">
                        <div class="title"><?php echo htmlspecialchars($row['name']); ?></div>
                        <div class="sub-title"><?php echo number_format($row['price'], 0, ',', '.') . ' VND'; ?></div>
                        <p>
                            <?php echo htmlspecialchars($row['description'] ?? 'Không có mô tả'); ?>
                        </p>
                        <div class="btn">
                        <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn-view">Xem thêm</a>

                              
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>




<style>
 /* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Banner */
.banner {
    width: 100%;
    height: 600px; 
    display: inline-block;
    font-size: 16px;
    position: relative;
}

.content-box-banner {
    position: absolute;
    top: 30%;
    z-index: 1;
    margin: 0 20%;
}

.header-banner {
    font-family: Gotham-Ultra;
    text-align: left;
    font-size: 2.0em;
    color: #2c2e53;
    margin-bottom: 0.5em;
}

.header-banner span {
    color: #bd945f;
    font-family: Gotham-Ultra;
}

.sapo-banner {
    text-align: justify;
    margin-bottom: 2em;
    font-size: 1.1em;
    color: #000;
}

.btn-banner {
    display: inline-block;
    padding: 0.8em 1.5em 0.6em 1.5em;
    background: #bd945f;
    color: #fff;
    font-size: 1em;
    margin-left: 0;
}

/* Sản phẩm nổi bật */
.hot-product-title {
    text-align: center;
    font-size: 2em;
    margin: 20px 0;
    color: #2c2e53;
}

/* Cấu hình cho Slider */
.slider {
    max-width: 1200px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 0 auto;
    padding: 20px 0;
}

.slider .card {
    flex: 0 0 23%; 
    margin: 0 15px;
    background: #fff;
    border-radius: 10px; 
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.slider .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2); 
}

.slider .card .img {
    height: 200px;
    width: 100%;
    overflow: hidden;
}

.slider .card .img img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

.slider .card:hover .img img {
    transform: scale(1.05);
}

.slider .card .content {
    padding: 15px;
}

.card .content .title {
    font-size: 22px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.card .content .sub-title {
    font-size: 16px;
    font-weight: 600;
    color: #e53e3e;
    margin-bottom: 10px;
}

.card .content p {
    text-align: justify;
    margin-bottom: 15px;
    font-size: 14px;
    color: #777;
}

.card .content .btn {
    display: block;
    text-align: left;
    margin-top: 10px;
}

.card .content .btn .btn-view {
    background: rgb(189, 148, 95);
    color: #fff;
    padding: 10px 15px;
    font-size: 16px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    transition: 0.3s ease;
}

.card .content .btn .btn-view:hover {
    background: #2c2e53;
    transform: scale(1.05);
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
    .slider .card {
        flex: 0 0 45%;
    }
}

@media screen and (max-width: 768px) {
    .slider .card {
        flex: 0 0 90%;
    }
}

@media screen and (max-width: 480px) {
    .slider .card {
        flex: 0 0 100%;
    }
}


/* Clearfix */
.clearfix::after {
    content: "";
    clear: both;
    display: block;
}

</style>