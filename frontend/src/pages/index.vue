<template>
  <div>
    <!-- Banner Section -->
    <div class="banner">
      <img :src="bannerImage" alt="Banner Background" class="banner-image" />
      <div class="content-box-banner">
        <h2 class="header-banner">
          THẾ GIỚI NỘI THẤT SỐ 1 VIỆT NAM <br />
          <span class="hieu-nguyen">Hiếu Nguyên</span>
        </h2>
        <div class="sapo-banner">
          <p>
            Sứ mệnh của chúng tôi là kết hợp hài hòa giữa ý tưởng và mong muốn của khách hàng, đem lại
            những phút giây thư giãn tuyệt vời bên gia đình và những người thân yêu.
          </p>
        </div>
        <a href="/contact" class="btn-banner"> Liên hệ ngay </a>
      </div>
    </div>

    <!-- Featured Products Section -->
    <h2 class="hot-product-title">Sản phẩm nổi bật</h2>
    <div class="product-section">
      <div class="product-card" v-for="product in featuredProducts" :key="product.id">
        <img :src="product.image" alt="" class="product-image" />
        <div class="product-content">
          <h3 class="product-title">{{ product.title }}</h3>
          <p class="product-price">{{ product.price }} VND</p>
          <p class="product-description">{{ product.description }}</p>
          <button class="product-button" @click="viewProduct(product.id)">Xem thêm</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import bannerImage from '@/assets/images/AnhCat/banner.png';
import axios from 'axios'; // Import axios để gọi API

export default {
  data() {
    return {
      bannerImage,
      featuredProducts: [] // Danh sách sản phẩm nổi bật sẽ được tải từ API
    };
  },
  created() {
    this.fetchFeaturedProducts(); // Gọi hàm lấy sản phẩm khi component được tạo
  },
  methods: {
    async fetchFeaturedProducts() {
      try {
        // Gọi API PHP để lấy danh sách sản phẩm
        const response = await axios.get('http://localhost/api/data.php');
        this.featuredProducts = response.data; // Lưu dữ liệu sản phẩm vào biến
      } catch (error) {
        console.error("Lỗi khi gọi API:", error); // In lỗi nếu có
      }
    },
    viewProduct(id) {
      this.$router.push({ path: `/products/${id}` }); // Chuyển đến trang chi tiết sản phẩm
    }
  }
};
</script>

<style scoped>
/* Banner Styles */
.banner {
  position: relative;
  width: 100%;
  height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.banner-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
}

.content-box-banner {
  position: relative;
  z-index: 2;
  text-align: left;
  color: #333;
  padding: 20px;
  max-width: 600px;
}

.header-banner {
  font-size: 3rem;
  color: #2c2e53;
  font-weight: bold;
  line-height: 1.2;
  margin: 0;
}

.header-banner span.hieu-nguyen {
  font-size: 3.5rem;
  color: #c49363;
  font-weight: bold;
  display: block;
  margin-top: 0.5rem;
}

.sapo-banner {
  margin: 1rem 0;
  font-size: 1rem;
  color: #555;
}

.btn-banner {
  display: inline-block;
  padding: 10px 20px;
  background-color: #bd945f;
  color: white;
  text-decoration: none;
  font-weight: bold;
  border-radius: 5px;
  margin-top: 10px;
}

.btn-banner:hover {
  background-color: #a15a26;
}

/* Featured Products Section */
.hot-product-title {
  margin-top: 40px;
  font-size: 24px;
  text-align: center;
  color: #2c2e53;
}

.product-section {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  padding: 20px;
}

.product-card {
  width: 250px;
  margin: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
  background: white;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.product-image {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.product-content {
  padding: 15px;
}

.product-title {
  font-size: 1.2rem;
  color: #2c2e53;
  margin: 10px 0;
}

.product-price {
  font-size: 1rem;
  color: #c49363;
  margin: 5px 0;
}

.product-description {
  font-size: 0.9rem;
  color: #666;
}

.product-button {
  padding: 8px 15px;
  background-color: #c49363;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.product-button:hover {
  background-color: #a15a26;
}

@media (max-width: 768px) {
  .banner {
    height: 350px;
  }

  .header-banner {
    font-size: 2.5rem;
  }

  .header-banner span.hieu-nguyen {
    font-size: 3rem;
  }

  .sapo-banner {
    font-size: 0.9rem;
  }

  .btn-banner {
    font-size: 0.8rem;
    padding: 8px 16px;
  }

  .product-card {
    width: 100%;
    max-width: 320px;
  }
}
</style>
