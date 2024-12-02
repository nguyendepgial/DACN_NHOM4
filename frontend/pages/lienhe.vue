<template>
  <div style="margin-top: 5rem">
    <header>
      <Header />
    </header>
    <div class="container">
      <h1 class="text-center">Liên hệ</h1>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="name">Họ và tên</label>
          <input type="text" class="form-control" id="name" v-model="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="message">Nội dung</label>
          <textarea class="form-control" id="message" v-model="message" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi</button>
      </form>
      <p v-if="responseMessage">{{ responseMessage }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Header from '@/components/Header.vue';

export default {
  components: {
    Header
  },
  data() {
    return {
      name: '',
      email: '',
      message: '',
      responseMessage: ''
    };
  },
  methods: {
    submitForm() {
      axios.post('/api-lienhe.php', {
        name: this.name,
        email: this.email,
        message: this.message
      })
        .then(response => {
          if (response.data.error) {
            this.responseMessage = response.data.error;
          } else {
            this.responseMessage = response.data.success;
            this.name = '';
            this.email = '';
            this.message = '';
          }
        })
        .catch(error => {
          console.error('An error occurred:', error);
          this.responseMessage = 'Đã xảy ra lỗi. Vui lòng thử lại!';
        });
    }
  }
};
</script>

<style scoped>
.container {
  margin: 20px auto;
}

.form-group {
  margin-bottom: 15px;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.text-center {
  text-align: center;
}
</style>
