<!-- Header.vue -->
<template>
  <header class="header">
    <nav class="navbar">
      <!-- Nút Hamburger để mở menu trên màn hình nhỏ -->
      <span class="hamburger-btn" @click="toggleMenu">☰</span>

      <!-- Logo -->
      <a href="/" class="logo">
        <img src="@/assets/images/AnhCat/logo.png" alt="logo" />
        <h2>Hiếu Nguyên</h2>
      </a>

      <!-- Menu chính và nút đăng nhập/đăng xuất -->
      <div class="menu-container">
        <ul :class="['links', { 'show-menu': isMenuOpen }]">
          <span class="close-btn" @click="toggleMenu">✖</span>
          <li><a href="/">Trang chủ</a></li>
          <li><a href="/about">Giới thiệu</a></li>
          <li><a href="/products">Sản phẩm</a></li>
          <li><a href="/partners">Đối tác</a></li>
          <li><a href="/contact">Liên hệ</a></li>
          <li v-if="isLoggedIn"><a href="/checkout">Thanh toán</a></li>
          <li v-if="isLoggedIn"><a href="/cart">Giỏ hàng</a></li>
          <li v-if="isAdmin"><a href="/admin">Quản lý</a></li>
        </ul>

        <!-- Hiển thị nút Đăng nhập hoặc Đăng xuất -->
        <div class="auth-buttons">
          <!-- Dùng sự kiện điều hướng thay vì href -->
          <button v-if="!isLoggedIn" class="login-btn" @click="goToLogin">ĐĂNG NHẬP</button>
          <div v-else>
            <span class="user-info">Xin chào, {{ username }}</span>
            <button class="logout-btn" @click="logout">Đăng xuất</button>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'Header',
  data() {
    return {
      isMenuOpen: false,
      username: '',
    };
  },
  computed: {
    isLoggedIn() {
      return process.client && !!localStorage.getItem('token');
    },
    isAdmin() {
      return process.client && localStorage.getItem('role') === 'admin';
    },
  },
  mounted() {
    if (this.isLoggedIn) {
      this.username = localStorage.getItem('username');
    }
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
    goToLogin() {
      this.$router.push('/login/login'); // Điều hướng đến trang đăng nhập mới
    },
    logout() {
      if (process.client) {
        localStorage.removeItem('token');
        localStorage.removeItem('role');
        localStorage.removeItem('username');
        this.$router.push('/');
      }
    },
  },
};
</script>
<style scoped>
/* Header Styles */
.header {
  background-color: #f8f9fa;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  position: fixed;
  width: 100%;
  top: 0;
  z-index: 10;
  display: flex;
  align-items: center;
}

.navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  padding: 10px 20px;
  height: 70px;
}

/* Hamburger và Close Buttons */
.hamburger-btn,
.close-btn {
  display: none;
  font-size: 1.8rem;
  cursor: pointer;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}

.logo img {
  width: 40px;
}

.logo h2 {
  color: #c49363;
  font-size: 1.4rem;
  font-weight: 700;
}

/* Container chứa menu và nút đăng nhập */
.menu-container {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap; /* Cho phép xuống dòng khi không đủ không gian */
  justify-content: center;
}

.links {
  display: flex;
  gap: 20px;
  list-style: none;
  align-items: center;
  flex-wrap: wrap; /* Đảm bảo các mục xuống dòng nếu không đủ chỗ */
}

.links li {
  display: flex;
  align-items: center;
}

.links li a {
  color: #000;
  font-size: 1.1rem;
  font-weight: 500;
  text-decoration: none;
  padding: 8px 0;
  transition: color 0.3s ease;
}

.links li a:hover {
  color: #a15a26;
}

.login-btn {
  background-color: #c49363;
  color: #fff;
  padding: 6px 12px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.login-btn:hover {
  background-color: #b07853;
}

/* Responsive styling cho các màn hình nhỏ */
@media (max-width: 1024px) {
  .menu-container {
    flex-direction: row;
    gap: 10px;
  }

  .links {
    gap: 10px;
  }

  .links li a {
    font-size: 1rem;
    padding: 6px;
  }

  .logo h2 {
    font-size: 1.2rem;
  }

  .login-btn {
    padding: 5px 10px;
    font-size: 0.9rem;
  }
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .hamburger-btn {
    display: inline;
  }

  .menu-container {
    flex-direction: column;
    align-items: center;
  }

  .links {
    position: fixed;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 1);
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: left 0.3s ease;
    padding-top: 60px;
  }

  .links.show-menu {
    left: 0;
  }

  .close-btn {
    display: inline;
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 2rem;
  }

  .links li {
    margin: 10px 0;
  }

  .links li a {
    font-size: 1.2rem;
  }

  .login-btn {
    font-size: 1.2rem;
  }
}
</style>
