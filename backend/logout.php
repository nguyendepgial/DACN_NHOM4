<?php
// Bắt đầu phiên làm việc
session_start();

// Xóa toàn bộ biến session
session_unset();

// Kết thúc session
session_destroy();

// Chuyển hướng người dùng về trang chính
header("Location: /DACN_NHOM4/frontend/pages/index.php");
exit();
?>
