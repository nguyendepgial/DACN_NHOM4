<template>
  <main>
    <div class="container mt-5">
      <!-- Danh mục sản phẩm (menu ngang) -->
      <div class="menu-categories">
        <ul class="category-list">
          <li><a href="#" class="category-item" @click.prevent="filterProducts('all')">Tất cả sản phẩm</a></li>
          <li v-for="category in categories" :key="category.slug">
            <a href="#" class="category-item" @click.prevent="filterProducts(category.slug)">{{ category.name }}</a>
          </li>
        </ul>
      </div>

      <!-- Hiển thị sản phẩm -->
      <div id="product-list" class="row mt-4">
        <div v-for="product in filteredProducts" :key="product.id" class="col-md-4 mb-4 product-item">
          <div class="card">
            <img :src="product.image" class="card-img-top" :alt="product.name">
            <div class="card-body text-center">
              <h5 class="card-title">{{ product.name }}</h5>
              <p class="card-price">{{ formatPrice(product.price) }} VNĐ</p>
              <p class="card-description">{{ product.description }}</p>
              <a :href="`product_detail.php?id=${product.id}`" class="btn btn-primary">Xem chi tiết</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      categories: [],
      products: [],
      filteredProducts: []
    };
  },
  created() {
    this.fetchCategories();
    this.fetchProducts();
  },
  methods: {
    fetchCategories() {
      // Fetch categories from API or store
      fetch('http://localhost/api.php?endpoint=categories')
        .then(response => response.json())
        .then(data => {
          this.categories = data;
        });
    },
    fetchProducts() {
      // Fetch products from API or store
      fetch('http://localhost/api.php?endpoint=products')
        .then(response => response.json())
        .then(data => {
          this.products = data;
          this.filteredProducts = data;
        });
    },
    filterProducts(categorySlug) {
      if (categorySlug === 'all') {
        this.filteredProducts = this.products;
      } else {
        this.filteredProducts = this.products.filter(product => product.category_slug === categorySlug);
      }
    },
    formatPrice(price) {
      return new Intl.NumberFormat().format(price);
    }
  }
};
</script>

<style scoped>
/* ========================
   Cấu trúc chung và căn chỉnh
========================== */
body {
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f4f4;
  color: #333;
}
.add-to-cart-btn {
  background-color: #28a745;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.add-to-cart-btn:hover {
  background-color: #218838;
}
/* Nút "Xem chi tiết" */
.btn-primary {
  background-color: #007bff;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  margin-right: 5px;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

/* Nút "Thêm vào giỏ hàng" */
.add-to-cart-btn {
  background-color: #28a745;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  padding: 10px 15px;
  transition: background-color 0.3s ease;
}

.add-to-cart-btn:hover {
  background-color: #218838;
}

/* Đảm bảo container không bị che khuất */
.container {
  margin: 0 auto;
  padding: 120px 15px 30px; /* Thêm 120px padding-top để đẩy nội dung xuống dưới header */
  max-width: 1200px;
}

/* Tiêu đề danh mục sản phẩm */
h2 {
  font-size: 1.5em;
  font-weight: bold;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

/* ========================
   Menu danh mục sản phẩm (Nằm ngang)
========================== */
.menu-categories {
  display: flex;
  justify-content: center;
  margin-bottom: 30px;
}

.category-list {
  list-style-type: none;
  padding: 0;
  display: flex;
  gap: 20px;
}

.category-list li {
  font-size: 1.1em;
}

.category-list li a {
  text-decoration: none;
  color: #333;
  font-weight: bold;
}

.category-list li a:hover {
  color: #c49363;
}

/* ========================
   Các phần tử Card Sản phẩm
========================== */

/* Mỗi sản phẩm trong card */
.card {
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transition: all 0.3s ease-in-out;
  margin-bottom: 20px;
  overflow: hidden;
  flex-basis: calc(33.33% - 20px); /* Ba sản phẩm mỗi hàng */
  display: flex;
  flex-direction: column;
  max-width: 100%; /* Đảm bảo card không bị cắt bớt */
}

/* Hiệu ứng hover cho card */
.card:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

/* Hình ảnh sản phẩm */
.card-img-top {
  width: 100%;
  height: 250px;
  object-fit: cover;  /* Đảm bảo ảnh không bị méo */
}

/* Phần thông tin bên trong card */
.card-body {
  padding: 15px;
  text-align: center;
  flex-grow: 1;
}

/* Tiêu đề sản phẩm */
.card-title {
  font-size: 1.25em;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

/* Giá sản phẩm */
.card-price {
  font-size: 1.1em;
  color: #e74c3c;
  margin-bottom: 10px;
}

/* Mô tả sản phẩm */
.card-description {
  font-size: 1em;
  color: #555;
  margin-bottom: 15px;
}

/* Nút "Xem chi tiết" */
.card .btn {
  background-color: #c49363;
  color: #fff;
  padding: 10px;
  text-align: center;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.card .btn:hover {
  background-color: #2980b9;
}

/* ========================
   Đảm bảo tính responsive
========================== */

/* Cho các màn hình nhỏ (dưới 768px) */
@media (max-width: 768px) {
  .card {
    flex-basis: calc(50% - 20px); /* Hai sản phẩm mỗi hàng */
  }

  .category-list li a {
    font-size: 1.1em;
  }
}

/* Cho các màn hình rất nhỏ (dưới 480px) */
@media (max-width: 480px) {
  .card {
    flex-basis: 100%; /* Một sản phẩm mỗi hàng */
  }

  .category-list li a {
    font-size: 1em;
  }
}

</style>
