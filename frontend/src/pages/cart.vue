<!-- pages/cart.vue -->
<template>
    <div class="cart-page">
      <h2>Giỏ hàng của bạn</h2>
      <div v-if="cart.length > 0">
        <ul>
          <li v-for="item in cart" :key="item.id">
            {{ item.name }} - {{ item.price }} VND
          </li>
        </ul>
        <p>Tổng cộng: {{ totalCartValue }} VND</p>
        <button @click="proceedToCheckout">Tiến hành thanh toán</button>
      </div>
      <p v-else>Giỏ hàng của bạn đang trống.</p>
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
      proceedToCheckout() {
        this.$router.push("/checkout");
      }
    }
  };
  </script>
  
  <style scoped>
  .cart-page {
    max-width: 600px;
    margin: 0 auto;
  }
  </style>
  