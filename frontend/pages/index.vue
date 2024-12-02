<template>
  <main>
    <div id="container">
      <!-- BANNER -->
      <div class="banner">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="images/AnhCat/banner.png" class="d-block w-100" alt="Banner">
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
                <a href="lienhe.php" class="text-uppercase btn-banner"> Liên hệ ngay </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SẢN PHẨM NỔI BẬT -->
      <h2 class="hot-product-title">Sản phẩm nổi bật</h2>
      <div class="slider owl-carousel">
        <!-- Sản phẩm 1 -->
        <div class="card">
          <div class="img">
            <img src="images/AnhCat/sp-1.png" alt="Giường kiểu Âu">
          </div>
          <div class="content">
            <div class="title">Giường kiểu Âu</div>
            <div class="sub-title">8,999,999 VND</div>
            <p>
              Mang đến sự tinh tế và thanh lịch cho không gian phòng ngủ của bạn, chiếc giường hiện đại
              châu Âu màu trắng là sự kết hợp hoàn hảo giữa thiết kế tối giản và chất lượng cao cấp.
            </p>
            <div class="btn">
              <a href="product_detail.php?id=1" class="btn-view">Xem thêm</a>
            </div>
          </div>
        </div>
        <!-- Sản phẩm 2 -->
        <div class="card">
          <div class="img">
            <img src="images/AnhCat/sp-2.png" alt="Bàn làm việc">
          </div>
          <div class="content">
            <div class="title">Bàn làm việc</div>
            <div class="sub-title">3,499,999 VND</div>
            <p>
              Mang lại không gian làm việc thanh lịch và hiện đại, chiếc bàn làm việc màu trắng là lựa
              chọn hoàn hảo cho mọi văn phòng và phòng làm việc tại nhà.
            </p>
            <div class="btn">
              <a href="product_detail.php?id=2" class="btn-view">Xem thêm</a>
            </div>
          </div>
        </div>
        <!-- Sản phẩm 3 -->
        <div class="card">
          <div class="img">
            <img src="images/AnhCat/sp-3.png" alt="Tủ Đồ Cao Hiện Đại">
          </div>
          <div class="content">
            <div class="title">Tủ Đồ Cao Hiện Đại</div>
            <div class="sub-title">12,199,999 VND</div>
            <p>
              Chiếc tủ đồ cao màu trắng mang đến vẻ đẹp hiện đại và sự tiện lợi cho không gian sống của bạn,
              là giải pháp hoàn hảo cho việc lưu trữ và tổ chức đồ dùng một cách thông minh và phong cách.
            </p>
            <div class="btn">
              <a href="product_detail.php?id=3" class="btn-view">Xem thêm</a>
            </div>
          </div>
        </div>
        <!-- Sản phẩm 4 -->
        <div class="card">
          <div class="img">
            <img src="images/AnhCat/sp-4.png" alt="Kệ Phòng Ngủ Hiện Đại">
          </div>
          <div class="content">
            <div class="title">Kệ Phòng Ngủ Hiện Đại</div>
            <div class="sub-title">4,999,999 VND</div>
            <p>
              Tạo điểm nhấn thanh lịch và tiện ích cho không gian phòng ngủ của bạn với chiếc kệ phòng ngủ
              hiện đại màu trắng. Đây là sự kết hợp hoàn hảo giữa thiết kế tinh tế và chức năng tiện dụng.
            </p>
            <div class="btn">
              <a href="product_detail.php?id=4" class="btn-view">Xem thêm</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'Index'
}
</script>
