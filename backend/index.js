const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Routes
const productRoutes = require('./routes/products');
app.use('/api/products', productRoutes);

// Lắng nghe cổng
app.listen(port, () => {
  console.log(`Server đang chạy tại http://localhost:${port}`);
});
