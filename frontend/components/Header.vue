<template>
  <header>
    <nav class="navbar">
      <!-- Logo -->
      <nuxt-link to="/" class="logo">
        <img src="/images/logo.png" alt="logo">
        <h2>Hiếu Nguyên</h2>
      </nuxt-link>

      <!-- Menu -->
      <ul class="links">
        <li><nuxt-link to="/" exact-active-class="active">Trang chủ</nuxt-link></li>
        <li><nuxt-link to="/gioithieu" exact-active-class="active">Giới thiệu</nuxt-link></li>
        <li><nuxt-link to="/sanpham" exact-active-class="active">Sản phẩm</nuxt-link></li>
        <li><nuxt-link to="/order_details" exact-active-class="active">Đơn hàng</nuxt-link></li>
        <li><nuxt-link to="/doitac" exact-active-class="active">Đối tác</nuxt-link></li>
        <li><nuxt-link to="/lienhe" exact-active-class="active">Liên hệ</nuxt-link></li>
      </ul>

      <!-- Header Icons (Giỏ hàng, đăng nhập, lời chào) -->
      <div class="header-icons">
        <!-- Giỏ hàng -->
        <nuxt-link to="/cart" class="cart-btn">
          <i class="fas fa-shopping-cart"></i>
          <span id="cart-count">{{ cartCount }}</span>
        </nuxt-link>

        <!-- Kiểm tra trạng thái đăng nhập -->
        <div v-if="isLoggedIn" class="welcome-message">
          Xin chào, {{ userEmail }}
        </div>
        <a v-if="isLoggedIn" @click.prevent="logout" class="login-btn">ĐĂNG XUẤT</a>
        <nuxt-link v-else to="/login" class="login-btn">ĐĂNG NHẬP</nuxt-link>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  computed: {
    cartCount() {
      return this.$store.state.cart.length;
    },
    isLoggedIn() {
      return this.$store.getters.isLoggedIn;
    },
    userEmail() {
      return this.$store.getters.userEmail;
    }
  },
  methods: {
    logout() {
      this.$store.dispatch('logout');
      this.$router.push('/');
    }
  },
  watch: {
    isLoggedIn(newVal) {
      console.log('User login state changed:', newVal);
    },
    userEmail(newVal) {
      console.log('User email changed:', newVal);
    }
  }
}
</script>
