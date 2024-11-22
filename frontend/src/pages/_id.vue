<template>
  <div v-if="product" class="product-details">
    <h1>{{ product.name }}</h1>
    <img :src="product.image" alt="Product Image" />
    <p><strong>Giá:</strong> {{ formatPrice(product.price) }} VND</p>
    <p><strong>Mô tả:</strong> {{ product.description }}</p>
    <nuxt-link to="/products">Quay lại danh sách sản phẩm</nuxt-link>
  </div>
  <div v-else class="error-message">
    <p>Không tìm thấy sản phẩm.</p>
    <nuxt-link to="/products">Quay lại danh sách sản phẩm</nuxt-link>
  </div>
</template>

<script>
export default {
  async asyncData({ params }) {
    try {
      const response = await fetch(`http://localhost/api/products/${params.id}`);
      if (!response.ok) throw new Error("Không tìm thấy sản phẩm");
      const product = await response.json();
      return { product };
    } catch (error) {
      console.error("Lỗi khi tải sản phẩm:", error.message);
      return { product: null };
    }
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat("vi-VN").format(price);
    },
  },
};
</script>

<style scoped>
.product-details {
  padding: 20px;
  text-align: center;
}
.product-details img {
  max-width: 400px;
  height: auto;
}
.error-message {
  text-align: center;
  padding: 20px;
}
</style>
