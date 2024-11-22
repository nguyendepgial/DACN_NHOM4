const mysql = require('mysql2');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '', 
  database: 'my_database', 
});

connection.connect((err) => {
  if (err) {
    console.error('Kết nối thất bại: ', err.stack);
    return;
  }
  console.log('Kết nối thành công tới cơ sở dữ liệu.');
});

module.exports = connection;
