<!-- src/pages/admin.vue -->
<template>
    <div class="admin">
      <h1>Quản Lý</h1>
      <p>Trang quản lý dành cho admin.</p>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Admin',
    beforeRouteEnter(to, from, next) {
      const role = localStorage.getItem('role');
      if (role !== 'admin') {
        next('/');
      } else {
        next();
      }
    },
  };
  </script>
  
  <style scoped>
  .admin {
    text-align: center;
  }
  </style>
  