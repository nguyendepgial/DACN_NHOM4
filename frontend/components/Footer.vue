<template>
  <footer>
    <div class="footer-container">
      <div class="row mt-3 mb-3">
        <div class="col-md-6">
          <h5>THÔNG TIN CHUNG<span class="line-remove" style="width: 78px;"></span></h5>
          <h4 class="mt-2 pt-2 com-name">CÔNG TY TNHH HIẾU NGUYÊN</h4>
          <p class="com-phone">
            <i class="fas fa-phone-alt"></i>
            <a href="#" title="0354.331.794">0354 331 794</a>
          </p>
          <p class="com-email">
            <i class="fas fa-envelope"></i>
            <a href="mailto:DH52106256@student.stu.edu.vn">DH52106256@student.stu.edu.vn</a>
          </p>
          <p class="com-address">
            <i class="fas fa-map-marker-alt"></i>
            <a href="https://www.google.com/maps/place/290a+D.+B%C3%A1+Tr%E1%BA%A1c,+Ph%C6%B0%E1%BB%9Dng+1,+Qu%E1%BA%ADn+8,+TP+HCM">290A/34, Dương Bá Trạc, Phường 1, Quận 8, TP Hồ Chí Minh.</a>
          </p>
        </div>
        <div class="col-md-3">
          <h5>VỀ CHÚNG TÔI<span class="line-remove" style="width: 78px;"></span></h5>
          <ul>
            <li><nuxt-link to="/gioithieu" title="Giới thiệu">Giới thiệu</nuxt-link></li>
            <li><nuxt-link to="/sanpham" title="Sản phẩm">Sản phẩm</nuxt-link></li>
            <li><nuxt-link to="/news" title="Tin tức">Tin tức</nuxt-link></li>
            <li><nuxt-link to="/doitac" title="Đối tác">Đối tác</nuxt-link></li>
            <li><nuxt-link to="/lienhe" title="Liên hệ">Liên hệ</nuxt-link></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>KẾT NỐI VỚI CHÚNG TÔI<span class="line-remove" style="width: 78px;"></span></h5>
          <div class="mt-4 social-icon">
            <a href="https://www.facebook.com/profile.php?id=61567138755735" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://www.tiktok.com/@conchoancom1" target="_blank"><i class="fab fa-tiktok"></i></a>
            <a href="https://www.youtube.com/c/ĐồGỗMạnhSơn" target="_blank"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer'
}
</script>

<style scoped>
/* Add any additional styles here */
</style>
