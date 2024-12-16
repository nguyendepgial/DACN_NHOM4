<?php
include '../backend/db_connect.php'; // Kết nối cơ sở dữ liệu
include '../backend/sidebar.php'; // Bao gồm sidebar

$message = ""; // Biến lưu thông báo trạng thái

// Xử lý thêm người dùng mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['password'], $_POST['role'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
    $role = $_POST['role'];

    // Thêm người dùng vào cơ sở dữ liệu
    $sql = "INSERT INTO khachhang (ten_khach_hang, email, so_dien_thoai, password, role, ngay_tao, address) VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $name, $email, $phone, $password, $role, $address);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm người dùng thành công!'); window.location.href='add_user.php';</script>";
        exit();
    } else {
        $message = "Có lỗi xảy ra khi thêm người dùng!";
    }
}

// Lấy danh sách người dùng chỉ có vai trò là 'user'
$sql_users = "SELECT * FROM khachhang WHERE role = 'user'";
$result_users = $conn->query($sql_users);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Người Dùng</title>
    <link rel="stylesheet" href="../frontend/css/add_user.css">
</head>
<body>
    <div class="main-content">
        <div class="content-container">
            <!-- Phần thêm người dùng -->
            <div class="add-form">
                <h2>Nhập Thông Tin Người Dùng</h2>
                <?php if (!empty($message)): ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <label for="name">Tên Người Dùng:</label>
                    <input type="text" id="name" name="name" required placeholder="Nhập tên người dùng">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Nhập email người dùng">

                    <label for="phone">Số Điện Thoại:</label>
                    <input type="text" id="phone" name="phone" required placeholder="Nhập số điện thoại">

                    <label for="address">Địa Chỉ:</label>
                    <textarea id="address" name="address" required placeholder="Nhập địa chỉ"></textarea>

                    <label for="password">Mật Khẩu:</label>
                    <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">

                    <input type="hidden" name="role" value="user">
                    <button type="submit">Thêm Người Dùng</button>
                </form>
            </div>

            <!-- Phần danh sách người dùng -->
            <div class="user-list">
                <h2>Danh Sách Người Dùng</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Số Điện Thoại</th>
                                <th>Email</th>
                                <th>Địa Chỉ</th>
                                <th>Ngày Tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['ma_khach_hang']; ?></td>
                                <td><?php echo htmlspecialchars($row['ten_khach_hang']); ?></td>
                                <td><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo $row['ngay_tao']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
