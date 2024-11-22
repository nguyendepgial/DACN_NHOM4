const express = require('express');
const router = express.Router();
const db = require('../config/db');

// API đăng ký người dùng (không sử dụng bcrypt)
router.post('/register', (req, res) => {
  const { username, password } = req.body;

  // Thêm người dùng vào cơ sở dữ liệu mà không mã hóa mật khẩu
  const sql = 'INSERT INTO users (username, password) VALUES (?, ?)';
  db.query(sql, [username, password], (err, result) => {
    if (err) {
      console.error('Lỗi khi đăng ký người dùng:', err); // Log lỗi chi tiết
      return res.status(500).send('Lỗi khi đăng ký người dùng');
    }
    res.send('Đăng ký thành công');
  });
});

// API đăng nhập người dùng (không sử dụng bcrypt)
router.post('/login', (req, res) => {
  const { username, password } = req.body;

  const sql = 'SELECT * FROM users WHERE username = ?';
  db.query(sql, [username], (err, results) => {
    if (err) {
      console.error('Lỗi khi truy vấn cơ sở dữ liệu:', err);  // Log lỗi truy vấn SQL
      return res.status(500).send('Lỗi server');
    }
    if (results.length === 0) {
      console.log('Sai tên đăng nhập:', username);  // Log nếu không tìm thấy người dùng
      return res.status(400).send('Sai tên đăng nhập');
    }

    const user = results[0]; // Lấy người dùng đầu tiên từ kết quả truy vấn
    if (user.password !== password) { // So sánh mật khẩu thuần
      console.log('Sai mật khẩu cho người dùng:', username);  // Log nếu mật khẩu sai
      return res.status(400).send('Sai mật khẩu');
    }

    res.send('Đăng nhập thành công');
  });
});

module.exports = router;
