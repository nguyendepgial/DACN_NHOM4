// router/index.js
import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '@/pages/index.vue';
import Products from '@/pages/products.vue';
import ProductDetails from '@/pages/product-details.vue';
import Checkout from '@/pages/checkout.vue';
import Contact from '@/pages/contact.vue';
import Admin from '@/pages/admin.vue'; // Trang quản lý cho Admin
import Login from 'my-nuxt-app/src/components/LoginModal.vue'; // Trang đăng nhập

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/products',
    name: 'Products',
    component: Products
  },
  {
    path: '/products/:id',
    name: 'ProductDetails',
    component: ProductDetails,
    props: true
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout,
    meta: { requiresAuth: true } // Yêu cầu đăng nhập
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
    meta: { requiresAdmin: true } // Yêu cầu quyền Admin
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

// Kiểm tra quyền truy cập trước khi vào mỗi route
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token'); // Lấy token từ localStorage
  const role = localStorage.getItem('role');   // Lấy role (admin hoặc user) từ localStorage

  if (to.matched.some(record => record.meta.requiresAuth) && !token) {
    next('/login'); // Nếu route yêu cầu đăng nhập mà không có token, chuyển đến trang đăng nhập
  } else if (to.matched.some(record => record.meta.requiresAdmin) && role !== 'admin') {
    next('/'); // Nếu yêu cầu quyền admin mà không phải admin, chuyển về trang chủ
  } else {
    next(); // Cho phép truy cập nếu đã đăng nhập hoặc không có yêu cầu đặc biệt
  }
});

export default router;
