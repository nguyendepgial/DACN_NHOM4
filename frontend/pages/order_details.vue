<template>
  <div style="margin: 0 auto; margin-top: 4rem; ">
    <a href="/sanpham" class="back-btn">Quay lại</a>
    <header>
      <Header />
    </header>
    <div class="order-container" style="margin: 0 auto">
      <h2>Danh Sách Đơn Hàng Của Tôi</h2>
      <table v-if="orders.length" class="order-table">
        <thead>
        <tr>
          <th>Mã Đơn Hàng</th>
          <th>Ngày Đặt</th>
          <th>Thanh Toán</th>
          <th>Tổng Tiền</th>
          <th>Chi Tiết</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="order in orders" :key="order.order_id">
          <td>{{ order.order_id }}</td>
          <td>{{ formatDate(order.order_date) }}</td>
          <td>{{ order.payment_method }}</td>
          <td>{{ formatCurrency(order.total_price) }} VNĐ</td>
          <td><a :href="`/view_orders?order_id=${order.order_id}`" class="btn-details">Xem Chi Tiết</a></td>
        </tr>
        </tbody>
      </table>
      <p v-else>Bạn chưa có đơn hàng nào.</p>
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
      orders: []
    };
  },
  created() {
    this.fetchOrders();
  },
  methods: {
    fetchOrders() {
      axios.get('/api-order-detail.php')
        .then(response => {
          if (response.data.error) {
            alert(response.data.error);
            this.$router.push('/login');
          } else {
            this.orders = response.data;
          }
        })
        .catch(error => {
          console.error('An error occurred:', error);
        });
    },
    formatDate(date) {
      const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
      return new Date(date).toLocaleDateString('vi-VN', options);
    },
    formatCurrency(value) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value).replace('₫', '');
    }
  }
};
</script>

<style scoped>
.back-btn {
  display: inline-block;
  margin: 10px 0;
  padding: 10px 20px;
  background-color: #686879;
  color: white;
  text-decoration: none;
  border-radius: 5px;
}

.order-container {
  margin: 20px;
}

.order-table {
  width: 100%;
  border-collapse: collapse;
}

.order-table th, .order-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.order-table th {
  background-color: #f2f2f2;
}

.btn-details {
  color: #1a1a3d;
  text-decoration: none;
}

.btn-details:hover {
  text-decoration: underline;
}
</style>
