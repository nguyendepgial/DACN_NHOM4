<template>
  <div class="products-page">
    <!-- Menu Danh Mục -->
    <div class="menu-wrapper">
      <div class="hamburger-menu" @mouseenter="showMenu = true" @mouseleave="showMenu = false">
        <button class="hamburger-btn">DANH MỤC SẢN PHẨM</button>
        <span class="arrow-icon">▼</span>
        <div class="dropdown-menu" v-if="showMenu">
          <div
            v-for="subCategory in subCategories"
            :key="subCategory.id"
            class="dropdown-item"
            @click="selectCategory(subCategory.name)"
          >
            <img :src="subCategory.icon" alt="icon" class="dropdown-icon" />
            {{ subCategory.name }}
          </div>
        </div>
      </div>
      <div class="category-menu">
        <button
          class="category-btn"
          v-for="category in categories"
          :key="category.id"
          @click="selectCategory(category.name)"
          :class="{ active: selectedCategory === category.name }"
        >
          {{ category.name }}
        </button>
      </div>
    </div>

    <!-- Tìm Kiếm -->
    <div class="search-section">
      <label for="searchInput">Tìm kiếm sản phẩm:</label>
      <input
        id="searchInput"
        v-model="searchQuery"
        type="text"
        placeholder="Nhập tên sản phẩm để tìm"
        @input="filterProducts"
      />
    </div>

    <!-- Hiển Thị Sản Phẩm -->
    <div class="products-display">
      <h2>{{ selectedCategory ? `Sản phẩm cho ${selectedCategory}` : "Tất cả sản phẩm" }}</h2>
      <div class="product-list">
        <div v-for="product in filteredProducts" :key="product.id" class="product-item">
          <img :src="product.image" :alt="product.name" />
          <h3>{{ product.name }}</h3>
          <p>Giá: {{ formatPrice(product.price) }} VND</p>
          <div class="rating">
            <span
              v-for="star in 5"
              :key="star"
              class="star"
              :class="{ filled: star <= product.rating }"
            >★</span>
          </div>
          <button @click="viewProduct(product.id)">Xem</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showMenu: false,
      selectedCategory: null,
      searchQuery: '',
      products: [],
      filteredProducts: [],
      categories: [
        { id: 1, name: "Nội Thất Phòng Khách" },
        { id: 2, name: "Nội Thất Phòng Ngủ" },
        { id: 3, name: "Nội Thất Phòng Bếp" },
        { id: 4, name: "Nội Thất Phòng Thờ" },
        { id: 5, name: "Nội Thất Trang Trí" },
        { id: 6, name: "Nội Thất Văn Phòng" },
      ],
      subCategories: [
        { id: 1, name: "Sofa", icon: "/images/icons/sofa.png" },
        { id: 2, name: "Bàn Ghế", icon: "/images/icons/table.png" },
        { id: 3, name: "Tủ Kệ", icon: "/images/icons/cabinet.png" },
      ],
    };
  },
  created() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await fetch("http://localhost/api/data.php");
        const data = await response.json();
        this.products = data.map((product) => ({
          ...product,
          image: `/images/${product.image}`, // Sử dụng đường dẫn đúng từ static/images/
        }));
        this.filteredProducts = this.products;
      } catch (error) {
        console.error("Lỗi khi gọi API:", error);
      }
    },
    viewProduct(id) {
      console.log(`Điều hướng tới sản phẩm ID: ${id}`);
      this.$router.push(`/product/${id}`).catch((err) => {
        console.error("Lỗi điều hướng:", err.message);
      });
    },
    filterProducts() {
      this.filteredProducts = this.products.filter((product) =>
        product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
    selectCategory(category) {
      this.selectedCategory = category;
      this.filteredProducts = this.products.filter(
        (product) => product.category === category
      );
    },
    formatPrice(price) {
      return new Intl.NumberFormat("vi-VN").format(price);
    },
  },
};
</script>


<style scoped>
.products-page {
  padding: 20px;
  padding-top: 80px;
  position: relative;
}
.menu-wrapper {
  display: flex;
  align-items: center;
  gap: 10px;
  border-bottom: 2px solid #ccc;
  padding-bottom: 10px;
  margin-bottom: 20px;
}
.hamburger-menu {
  position: relative;
}
.hamburger-btn {
  font-size: 16px;
  font-weight: bold;
  padding: 10px 15px;
  background: #f0f0f0;
  border: none;
  cursor: pointer;
}
.category-menu {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}
.category-btn {
  padding: 10px 20px;
  background: #f0f0f0;
  border: 2px solid transparent;
  cursor: pointer;
  font-weight: bold;
  border-radius: 5px;
  transition: all 0.3s ease;
}
.category-btn:hover {
  background: #007bff;
  color: white;
  border-color: #007bff;
}
.category-btn.active {
  background: #28a745;
  color: white;
  border-color: #28a745;
}
.dropdown-menu {
  position: absolute;
  top: 40px;
  left: 0;
  width: 250px;
  background: #ffffff;
  border: 1px solid #ddd;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  z-index: 10;
  display: flex;
  flex-direction: column;
}
.dropdown-item {
  display: flex;
  align-items: center;
  padding: 10px;
  cursor: pointer;
}
.dropdown-item:hover {
  background-color: #f5f5f5;
}
.dropdown-icon {
  width: 24px;
  height: 24px;
  margin-right: 10px;
}
.products-display {
  text-align: center;
}
.product-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: center;
}
.product-item {
  width: 200px;
  border: 1px solid #ccc;
  padding: 10px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.product-item:hover {
  transform: scale(1.05);
}
.product-item img {
  width: 100%;
  height: auto;
}
.rating {
  color: #ccc;
}
.star.filled {
  color: gold;
}
.search-section {
  margin: 20px 0;
}
.search-section input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-top: 10px;
}
</style>
