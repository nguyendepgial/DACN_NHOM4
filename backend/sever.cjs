// Cấu hình và khởi tạo server với Express và MySQL
const express = require('express');
const mysql = require('mysql');
const app = express();

// Kết nối tới cơ sở dữ liệu MySQL
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'yourUsername',     // Thay 'yourUsername' bằng tên người dùng của bạn
  password: 'yourPassword', // Thay 'yourPassword' bằng mật khẩu của bạn
  database: 'yourDatabase', // Thay 'yourDatabase' bằng tên cơ sở dữ liệu của bạn
});

// Kết nối cơ sở dữ liệu
connection.connect(err => {
  if (err) {
    console.error('Lỗi kết nối cơ sở dữ liệu: ' + err.stack);
    return;
  }
  console.log('Đã kết nối tới cơ sở dữ liệu với ID: ' + connection.threadId);
});

// Tạo API endpoint để lấy sản phẩm
app.get('/api/products', (req, res) => {
  const query = 'SELECT * FROM products'; // Truy vấn tất cả sản phẩm từ bảng 'products'

  connection.query(query, (err, results) => {
    if (err) {
      return res.status(500).json({ error: 'Không thể lấy dữ liệu' });
    }
    res.json(results); // Trả về dữ liệu dạng JSON
  });
});

// Khởi động server tại cổng 3000
app.listen(3000, () => {
  console.log('Server đang chạy tại http://localhost:3000');
});
