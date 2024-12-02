<template>
  <main>
    <div id="container">
      <div class="banner">
        <img src="images/AnhCat/banner-gioi-thieu.png" alt="Giới thiệu cửa hàng">
        <h1>Giới thiệu cửa hàng</h1>
      </div>
      <h2>Thành lập & phát triển</h2>
      <div class="content">
        <div class="content-left">
          <img src="images/AnhCat/thanh-lap.png" alt="Thành lập">
        </div>
        <div class="content-right">
          <p>
            Nội Thất Hiếu Nguyên được xây dựng dựa trên tình yêu, đam mê của nghề mộc và sứ mệnh "đem đến cho
            khách hàng không gian nội thất hoàn hảo".
          </p>
        </div>
      </div>
      <h2>Tầm nhìn</h2>
      <div class="content1">
        <div class="content1-right">
          <img src="images/AnhCat/gioi-thieu-tam-nhin.png" alt="Tầm nhìn">
        </div>
        <div class="content1-left">
          <p>
            Tạo ra các sản phẩm nội thất trên triết lý tôn trọng và giữ gìn những gì tự nhiên ban tặng, kết
            hợp công nghệ tiên tiến.
          </p>
        </div>
      </div>
      <h2>Sứ mệnh</h2>
      <div class="content2">
        <div class="content2-right">
          <img src="images/AnhCat/voi-xa-hoi.png" alt="Sứ mệnh với xã hội">
          <p>Hài hòa lợi ích doanh nghiệp với lợi ích xã hội, xây dựng môi trường sống bền vững.</p>
        </div>
        <div class="content2-left">
          <img src="images/AnhCat/voi-nhan-vien.jpg" alt="Sứ mệnh với nhân viên">
          <p>Xây dựng môi trường làm việc chuyên nghiệp, năng động, sáng tạo và nhân văn.</p>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'IndexPage'
}
</script>
<style scoped>
#container{
  margin: 80px;
}

.banner img {
  width: 100%;
}
.banner h1 {
  position: absolute;
  bottom: 60%;
  right:  33%;
  font-size: 3rem;
  color: #fff;
}
h2{

  text-align: center;
  color: #cc9267;
  text-decoration: none;
  padding-top: 20px;
}
.content{
  margin: 0 70px;
  display: flex;
}
.content-left{
  width: 50%;

}
.content-left img{
  width: 100%;

}

.content-right{
  width: 50%;

}
.content-right p{
  font-size: 1.2rem;
  padding: 0 10px;
}
.content1{
  margin: 0 70px;
  display: block ;
  justify-content: center;
}
.content1-right{
  width: 100%;

}

.content1-right img{
  width: 100%;

}
.content1-left{
  width: 100%;

}

.content1-left p{
  font-size: 1.2rem;
  padding: 10px 0;

}
.content2{
  display: flex;
  margin:  40px;
  justify-content: space-around;

}
.content2-right {
  width: 48%;
  padding: 5px;
  border: 3px solid #000;
}
.content2-right img {
  width: 30%;


}
.content2-right p{
  font-size: 1.6rem;
}
.content2-left {
  width: 48%;
  padding: 5px;
  border: 3px solid #000;
  text-align:end;
}
.content2-left img {
  width: 30%;


}
.content2-left p{
  font-size: 1.6rem;
}
</style>
