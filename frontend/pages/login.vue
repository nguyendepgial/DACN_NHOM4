<template>
  <div class="login-container">
    <h2>Đăng Nhập</h2>
    <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    <form @submit.prevent="login">
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="email" placeholder="Nhập Email" required>
      </div>
      <div class="input-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" v-model="password" placeholder="Nhập mật khẩu" required>
      </div>
      <button type="submit" class="btn-login">Đăng nhập</button>
    </form>
    <div class="signup-link">
      <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
      <p><a href="http://localhost/login_admin.php" style="color: black;">Admin login</a></p>
    </div>
  </div>
</template>

<script>
import Cookies from 'js-cookie';

export default {
  layout: false,
  data() {
    return {
      email: '',
      password: '',
      errorMessage: ''
    };
  },
  methods: {
    login() {
      fetch('http://localhost/api-login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          email: this.email,
          password: this.password
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Cookies.set('user', JSON.stringify(data.user), { expires: 7 });
            this.$store.commit('setUser', data.user);
            if (data.user.role === 'admin') {
              this.$router.push('admin_page.php');
            } else {
              this.$router.push('/');
            }
          } else {
            this.errorMessage = data.error;
          }
        })
        .catch(() => {
          this.errorMessage = 'An error occurred. Please try again.';
        });
    }
  }
};
</script>

<style scoped>
body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  background: linear-gradient(to right, white, #030320);
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
}

.login-container {
  background-color: #fff;
  padding: 30px 40px;
  border-radius: 10px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
  text-align: center;
  color: #333;
  width: 100%;
  max-width: 400px;
  position: relative;
  margin: 2rem auto;
  margin-top: 3rem;
}

.btn-login-back {
  position: absolute;
  top: 10px;
  left: 10px;
  background-color: #686879;
  color: #fff;
  padding: 5px 10px;
  text-decoration: none;
  border-radius: 5px;
  font-size: 12px;
  font-weight: bold;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
}

.btn-login-back:hover {
  background-color: #030320;
  text-decoration: none;
}

h2 {
  font-size: 24px;
  margin-bottom: 20px;
  color: #333;
}

label {
  display: block;
  font-size: 14px;
  margin-bottom: 5px;
  color: #555;
  text-align: left;
}

.input-group {
  margin-bottom: 15px;
  text-align: left;
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 14px;
  color: #333;
}

button.btn-login {
  background-color: #686879;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  width: 100%;
}

button.btn-login:hover {
  background-color: #030320;
}

a {
  color: #1a1a3d;
  text-decoration: none;
  font-size: 14px;
}

a:hover {
  text-decoration: underline;
}

.error-message {
  color: red;
  font-size: 14px;
  margin-bottom: 15px;
  text-align: center;
}
</style>
