<template>
  <div>
    <!-- Main Content Section -->
    <main id="container">
      <div class="banner">
        <img :src="bannerImage" alt="Giới Thiệu" />
        <h1 class="banner-title">GIỚI THIỆU CỬA HÀNG</h1>
      </div>

      <h2 class="section-title">THÀNH LẬP &amp; PHÁT TRIỂN</h2>
      <div class="content">
        <div class="content-left">
          <img :src="establishmentImage" alt="Thành Lập" />
        </div>
        <div class="content-right">
          <p>
            Nội Thất Mộc Nguyên được xây dựng dựa trên tình yêu, đam mê của tôi đối với nghề mộc và khao
            khát mang những sản phẩm nội thất đẹp của mình đến với khách hàng thân yêu.
          </p>
        </div>
      </div>

      <h2 class="section-title">TẦM NHÌN</h2>
      <div class="content">
        <div class="content-right">
          <img :src="visionImage" alt="Tầm Nhìn" />
        </div>
        <div class="content-left">
          <p>
            Chúng tôi luôn hướng đến việc tạo ra các sản phẩm nội thất trên triết lý tôn trọng và giữ gìn
            những gì tự nhiên đã ban tặng cho con người.
          </p>
        </div>
      </div>

      <h2 class="section-title">SỨ MỆNH</h2>
      <div class="mission-content">
        <div class="mission-box">
          <img :src="socialImage" alt="Xã Hội" />
          <p>
            Hài hòa lợi ích doanh nghiệp với lợi ích xã hội, tích cực cùng cộng đồng xây dựng môi trường
            sống bền vững.
          </p>
        </div>
        <div class="mission-box">
          <img :src="employeeImage" alt="Nhân Viên" />
          <p>
            Xây dựng môi trường làm việc chuyên nghiệp, năng động, sáng tạo và nhân văn.
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
// Import ảnh từ thư mục assets
import bannerImage from '@/assets/images/AnhCat/banner-gioi-thieu.png';
import establishmentImage from '@/assets/images/AnhCat/thanh-lap.png';
import visionImage from '@/assets/images/AnhCat/gioi-thieu-tam-nhin.png';
import socialImage from '@/assets/images/AnhCat/voi-xa-hoi.png';
import employeeImage from '@/assets/images/AnhCat/voi-nhan-vien.jpg';

export default {
  name: 'AboutPage',
  data() {
    return {
      bannerImage,
      establishmentImage,
      visionImage,
      socialImage,
      employeeImage,
    };
  },
};
</script>

<style scoped>
/* Căn giữa và tạo kiểu cho phần banner */
.banner {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 0;
  margin-bottom: 20px;
  overflow: hidden;
  height: 400px;
}

.banner img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.banner-title {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 3rem;
  color: #fff;
  font-weight: bold;
  text-transform: uppercase;
}

/* Kiểu cho tiêu đề mỗi phần */
.section-title {
  text-align: center;
  font-size: 2rem;
  color: #c49363; /* Đặt màu cho tất cả tiêu đề */
  margin: 40px 0 20px;
  font-weight: bold;
}

/* Căn giữa các nội dung chính */
.content {
  display: flex;
  align-items: center;
  justify-content: center;
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.content-left,
.content-right {
  flex: 1;
  padding: 20px;
}

.content-left img,
.content-right img {
  width: 100%;
  height: auto;
  border-radius: 8px;
}

.mission-content {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.mission-box {
  width: 300px;
  text-align: center;
}

.mission-box img {
  width: 80px;
  height: auto;
  margin-bottom: 10px;
}

.mission-box p {
  font-size: 1rem;
  color: #333;
}

/* Responsive */
@media (max-width: 768px) {
  .banner img {
    max-width: 100%;
  }

  .content {
    flex-direction: column;
  }

  .mission-content {
    flex-direction: column;
    align-items: center;
  }
}
</style>
