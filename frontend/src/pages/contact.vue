<template>
  <div class="page-content">
    <h1>Liên Hệ</h1>
    <form class="contact-form">
      <label>Họ và Tên</label>
      <input type="text" placeholder="Nhập họ và tên" />

      <label>Email</label>
      <input type="email" placeholder="Nhập email" />

      <label>Nội dung</label>
      <textarea placeholder="Nội dung"></textarea>

      <button type="submit">Gửi</button>
    </form>
  </div>
</template>

<style scoped>
.page-content {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}
</style>
