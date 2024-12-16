

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
                </p><p class="com-email">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:DH52101717@student.stu.edu.vn">DH52101717@student.stu.edu.vn</a>
                </p>
                <p class="com-address">
                    <i class="fas fa-map-marker-alt"></i>
                    <a href="https://www.google.com/maps/place/290a+D.+B%C3%A1+Tr%E1%BA%A1c,+Ph%C6%B0%E1%BB%9Dng+1,+Qu%E1%BA%ADn+8,+TP+HCM">290A/34, Dương Bá Trạc, Phường 1, Quận 8, TP Hồ Chí Minh.</a>
                </p>
            </div>
            <div class="col-md-3">
                <h5>VỀ CHÚNG TÔI<span class="line-remove" style="width: 78px;"></span></h5>
                <ul>
                    <li><a href="frontend/gioithieu.php" title="Giới thiệu">Giới thiệu</a></li>
                    <li><a href="frontend/sanpham.php" title="Sản phẩm">Sản phẩm</a></li>
                    <li><a href="frontend/doitac.php" title="Đối tác">Đối tác</a></li>
                    <li><a href="frontend/contact.php" title="Liên hệ">Liên hệ</a></li>
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
<script>
    $(".slider").owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000, // 2000ms = 2s;
        autoplayHoverPause: true,
    });
</script>
</body>
</html>
<style>
    /* FOOTER */
footer {
    background: #363636;
    padding: 70px 20px 20px 20px;
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
}

footer ul li a:hover {
    text-decoration: none;
    color: #e0e0e0;
}

footer li a i {
    margin: 0 12px 0 0;
}

footer .menu-footer li {
    margin-bottom: 9px;
}

footer address,
footer p, footer p a {
    font-family: 'Gotham-Thin';
    color: #c1baba;
    font-size: 1.3rem;
    padding: 0.05rem 0;
}

footer i {
    margin-right: 1rem;
}

footer ul li a {
    color: #c1baba;
}

footer ul li a:hover {
    color: #a15a26;
    text-decoration: none;
}

footer .social-icon i,
footer .social-icon a {
    color: #fff;
}

footer .social-icon a i {
    font-size: 30px;
}

footer a:hover {
    text-decoration: none;
    color: #a15a26;
}

footer p a {
    color: #c1baba;
    font-size: 1em;
}

footer {
    min-height: 180px;
}

</style>