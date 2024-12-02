<template>
  <div style="margin-top: 5rem">
    <header>
      <Header />
    </header>
    <div class="container mt-5">
      <!-- Banner -->
      <div class="banner">
        <img src="/images/AnhCat/banner-doi-tac.png" alt="Đối tác" class="img-fluid">
        <h1 class="text-center mt-3">Đối tác</h1>
      </div>

      <!-- Nội dung chính -->
      <section class="partner-section mt-5">
        <h2 class="text-center">Chúng tôi tự hào hợp tác cùng</h2>
        <div class="row mt-4">
          <div v-for="partner in partners" :key="partner.name" class="col-md-4 mb-4">
            <div class="card text-center">
              <img :src="partner.image" :alt="partner.name" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">{{ partner.name }}</h5>
                <p class="card-text">{{ partner.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>
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
      partners: []
    };
  },
  created() {
    this.fetchPartners();
  },
  methods: {
    fetchPartners() {
      axios.get('/api-doitac.php')
        .then(response => {
          this.partners = response.data;
        })
        .catch(error => {
          console.error('An error occurred:', error);
        });
    }
  }
};
</script>

<style scoped>
.container {
  margin: 20px auto;
}

.banner img {
  width: 100%;
}

.partner-section {
  text-align: center;
}

.card {
  margin: 0 auto;
}

.card-img-top {
  max-height: 200px;
  object-fit: cover;
}

.card-title {
  font-size: 1.25rem;
  margin-top: 10px;
}

.card-text {
  font-size: 1rem;
  margin-top: 10px;
}
</style>
