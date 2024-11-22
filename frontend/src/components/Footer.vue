<template>
  <footer>
      <div class="footer-container">
          <div class="row mt-3 mb-3">
              <div class="col-md-6">
                  <h5>
                      THÔNG TIN CHUNG
                      <span class="line-remove" style="width: 78px;"></span>
                  </h5>
                  <h4 class="mt-2 pt-2 com-name">CÔNG TY TNHH MỘC NGUYÊN</h4>
                  <p class="com-phone">
                      <i class="fas fa-phone-alt"></i>
                      <a href="tel:0354331794" title="0354.331.794">0354 331 794</a><br>
                      <i class="fas fa-phone-alt"></i>
                      <a href="tel:0392092713" title="0392.092.713">0392 092 713</a>
                  </p>
                  <p class="com-email">
                      <i class="fas fa-envelope"></i>
                      <a href="mailto:DH52101717@student.stu.edu.vn" title="DH52101717@student.stu.edu.vn">DH52101717@student.stu.edu.vn</a><br>
                      <i class="fas fa-envelope"></i>
                      <a href="mailto:DH52106256@student.stu.edu.vn" title="DH52106256@student.stu.edu.vn">DH52106256@student.stu.edu.vn</a>
                  </p>
                  <p class="com-address">
                      <i class="fas fa-map-marker-alt"></i>
                      <a href="https://www.google.com/maps/place/290a+D.+B%C3%A1+Tr%E1%BA%A1c,+Ph%C6%B0%E1%BB%9Dng+1,+Qu%E1%BA%ADn+8,+Th%C3%A0nh+ph%E1%BB%9F+H%E1%BB%93+Ch%C3%AD+Minh,+Vi%E1%BB%87t+Nam/@10.7436876,106.6858092,17z/data=!3m1!4b1!4m6!3m5!1s0x31752fa632015555:0x172f16046cccdc57!8m2!3d10.7436823!4d106.6883841!16s%2Fg%2F11hz0gqgdm?hl=vi-VN&entry=ttu" target="_blank">290A/34, Dương Bá Trạc, Phường 1, Quận 8, TP Hồ Chí Minh.</a>
                  </p>
              </div>
              <div class="col-md-3">
                  <h5>
                      VỀ CHÚNG TÔI
                      <span class="line-remove" style="width: 78px;"></span>
                  </h5>
                  <ul>
                      <li><a href="about.html" title="Giới thiệu">Giới thiệu</a></li>
                      <li><a href="product.html" title="Sản phẩm">Sản phẩm</a></li>
                      <li><a href="news.html" title="Tin tức">Tin tức</a></li>
                      <li><a href="partner.html" title="Đối tác">Đối tác</a></li>
                      <li><a href="contact.html" title="Liên hệ">Liên hệ</a></li>
                  </ul>
              </div>
              <div class="col-md-3">
                  <h5>
                      KẾT NỐI VỚI CHÚNG TÔI
                      <span class="line-remove" style="width: 78px;"></span>
                  </h5>
                  <div class="mt-4 social-icon">
                      <a href="https://www.facebook.com/profile.php?id=61567138755735" target="_blank"><i class="fab fa-facebook"></i></a>
                      <a href="https://www.tiktok.com/@conchoancom1" target="_blank"><i class="fab fa-tiktok"></i></a>
                      <a href="https://www.youtube.com/c/%C4%90%E1%BB%93G%E1%BB%97M%E1%BA%A1nhS%C6%A1n" target="_blank"><i class="fab fa-youtube"></i></a>
                  </div>
              </div>
          </div>
      </div>
  </footer>
</template>

<script>
import '@/assets/js/slider.js';
import $ from 'jquery'; // Thêm dòng này nếu cần

export default {
name: 'Footer'
}


</script>
  
<style scoped>
footer {
  background: #363636;
  padding: 70px 20px 20px 20px;
  min-height: 180px;
}

footer h5 {
  color: #fff;
  text-transform: uppercase;
  font-size: 18px;
  position: relative;
  padding: 5px 0;
  margin-bottom: 16px;
}

footer h5:before {
  position: absolute;
  content: '';
  top: 100%;
  left: 0;
  width: 60px;
  height: 1px;
  border: 2px solid #fff;
}

footer h4 {
  font-size: 24px;
  text-transform: uppercase;
  color: #fff;
  margin-bottom: 24px;
}

footer ul li {
  margin-bottom: 16px;
  font-family: 'Gotham-Thin';
  color: #c1baba;
  font-size: 1.3rem;
  padding: 0.05rem 0;
}

footer ul li a {
  color: #d6d6d6;
  text-decoration: none;
}

footer ul li a:hover {
  color: #e0e0e0;
  text-decoration: none;
}

footer address a,
footer p a {
  color: #c1baba;
  text-decoration: none;
}

footer address a:hover,
footer p a:hover {
  color: #e0e0e0;
  text-decoration: none;
}

footer i {
  margin-right: 1rem;
  color: #c1baba;
}

footer .social-icon i,
footer .social-icon a {
  color: #c1baba;
}

footer .social-icon a i {
  font-size: 30px;
}

footer a:hover {
  color: #a15a26;
}
</style>
