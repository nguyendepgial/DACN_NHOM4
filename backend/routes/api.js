// backend/routes/api.js
const express = require('express');
const router = express.Router();
const db = require('../config/db');

// API thêm người dùng
router.post('/add-user', (req, res) => {
  const { name, email } = req.body;

  const sql = 'INSERT INTO users (name, email) VALUES (?, ?)';
  db.query(sql, [name, email], (err, result) => {
    if (err) {
      res.status(500).send('Lỗi khi thêm người dùng');
    } else {
      res.send('Người dùng đã được thêm thành công');
    }
  });
});

module.exports = router;
