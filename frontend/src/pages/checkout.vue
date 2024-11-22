<!-- pages/checkout.vue -->
<template>
    <div class="checkout-page">
      <h2>Thanh toán</h2>
      <div v-if="cart.length > 0">
        <ul>
          <li v-for="item in cart" :key="item.id">
            {{ item.name }} - {{ item.price }} VND
          </li>
        </ul>
        <p>Tổng cộng: {{ totalCartValue }} VND</p>
        <button @click="completePurchase">Hoàn tất thanh toán</button>
      </div>
      <p v-else>Không có sản phẩm trong giỏ hàng.</p>
    </div>
  </template>
  
  <script>
  export default {
    computed: {
      cart() {
        return this.$store.state.cart;
      },
      totalCartValue() {
        return this.cart.reduce((total, item) => total + parseInt(item.price.replace(/,/g, '')), 0);
      }
    },
    methods: {
      completePurchase() {
        alert("Cảm ơn bạn đã mua hàng!");
        this.$store.commit("clearCart");
        this.$router.push("/products");
      }
    }
  };
  </script>
  
  <style scoped>
  .checkout-page {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
  }
  </style>
  