<template>
  <div id="app">
    <!-- Header -->
    <header>
      <nav>
        <h1>Website</h1>
        <button @click="openLoginModal">Đăng nhập</button> <!-- Nút Đăng nhập -->
      </nav>
    </header>

    <!-- Modal đăng nhập -->
    <LoginModal v-if="showLoginModal" :showModal="showLoginModal" @close="closeLoginModal" @login-success="handleLoginSuccess" />

    <!-- Nội dung chính -->
    <router-view />
  </div>
</template>

<script>
import LoginModal from './components/LoginModal.vue';

export default {
  components: {
    LoginModal
  },
  data() {
    return {
      showLoginModal: false
    };
  },
  methods: {
    openLoginModal() {
      this.showLoginModal = true;
    },
    closeLoginModal() {
      this.showLoginModal = false;
    },
    handleLoginSuccess() {
      this.showLoginModal = false;
      // Xử lý các hành động sau khi đăng nhập thành công, ví dụ: cập nhật trạng thái người dùng
    }
  }
};
</script>

<style>
/* CSS cho header và nút Đăng nhập */
header {
  background: #333;
  padding: 10px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

header nav h1 {
  margin: 0;
}

header nav button {
  padding: 5px 10px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

header nav button:hover {
  background: #0056b3;
}
</style>
