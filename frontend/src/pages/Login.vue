<template>
    <div class="login-container">
      <h1>Đăng Nhập</h1>
      <form @submit.prevent="loginUser">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" v-model="username" placeholder="Tên đăng nhập" id="username" />
  
        <label for="password">Mật khẩu:</label>
        <input type="password" v-model="password" placeholder="Mật khẩu" id="password" />
  
        <button type="submit">Đăng Nhập</button>
      </form>
      <p>{{ message }}</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        username: '',
        password: '',
        message: ''
      };
    },
    methods: {
      async loginUser() {
        try {
          const response = await axios.post('http://localhost:3001/api/login', {
            username: this.username,
            password: this.password
          });
          this.message = response.data;  // Hiển thị thông báo thành công
        } catch (error) {
          console.error('Lỗi khi đăng nhập:', error.response ? error.response.data : error.message);
          this.message = error.response ? error.response.data : 'Đăng nhập không thành công';  // Hiển thị thông báo lỗi
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .login-container {
    margin-top: 80px;
    padding: 20px;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  label, input, button {
    margin-bottom: 10px;
  }
  </style>
  