// backend/controllers/userController.js
const db = require('../config/db');

exports.getAllUsers = (req, res) => {
  db.query('SELECT * FROM users', (err, results) => {
    if (err) {
      res.status(500).send('Lỗi khi lấy dữ liệu người dùng');
    } else {
      res.json(results);
    }
  });
};

exports.createUser = (req, res) => {
  const { name, email } = req.body;
  const sql = 'INSERT INTO users (name, email) VALUES (?, ?)';
  db.query(sql, [name, email], (err, result) => {
    if (err) {
      res.status(500).send('Lỗi khi thêm người dùng');
    } else {
      res.send('Người dùng đã được thêm thành công');
    }
  });
};
