const express = require('express');
const router = express.Router();
const db = require('../config/db');

// Lấy toàn bộ sản phẩm
router.get('/', (req, res) => {
  const query = 'SELECT * FROM products';
  db.query(query, (err, results) => {
    if (err) {
      console.error('Lỗi khi lấy sản phẩm:', err);
      res.status(500).json({ error: 'Lỗi server' });
    } else {
      res.json(results);
    }
  });
});

// Lấy toàn bộ sản phẩm
router.get('/', (req, res) => {
    const query = 'SELECT * FROM products';
    db.query(query, (err, results) => {
      if (err) {
        res.status(500).json({ error: 'Lỗi server' });
      } else {
        res.json(results);
      }
    });
  });
  
  // Lấy chi tiết sản phẩm theo ID
  router.get('/:id', (req, res) => {
    const productId = req.params.id;
    const query = 'SELECT * FROM products WHERE id = ?';
    db.query(query, [productId], (err, result) => {
      if (err) {
        res.status(500).json({ error: 'Lỗi server' });
      } else if (result.length === 0) {
        res.status(404).json({ error: 'Không tìm thấy sản phẩm' });
      } else {
        res.json(result[0]);
      }
    });
  });
  

module.exports = router;
