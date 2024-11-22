<template>
    <div class="register-container">
      <h1>Đăng Ký</h1>
      <form @submit.prevent="registerUser">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" v-model="username" placeholder="Tên đăng nhập" id="username" />
  
        <label for="password">Mật khẩu:</label>
        <input type="password" v-model="password" placeholder="Mật khẩu" id="password" />
  
        <button type="submit">Đăng Ký</button>
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
      async registerUser() {
        try {
          const response = await axios.post('http://localhost:3001/api/register', {
            username: this.username,
            password: this.password
          });
          this.message = response.data;
        } catch (error) {
          console.error('Lỗi khi đăng ký:', error);
          this.message = 'Đăng ký không thành công';
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .register-container {
    margin-top: 80px; /* Tạo khoảng cách để không bị che bởi header */
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
  