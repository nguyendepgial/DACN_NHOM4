<<<<<<< HEAD
<?php
include '../backend/db_connect.php'; // Kết nối cơ sở dữ liệu
include '../backend/sidebar.php'; // Bao gồm sidebar

$message = ""; // Biến để lưu thông báo

// Lấy dữ liệu tìm kiếm từ form
$search_name = isset($_POST['search_name']) ? $_POST['search_name'] : '';
$search_phone = isset($_POST['search_phone']) ? $_POST['search_phone'] : '';
$search_email = isset($_POST['search_email']) ? $_POST['search_email'] : '';
$search_date_from = isset($_POST['search_date_from']) ? $_POST['search_date_from'] : '';
$search_date_to = isset($_POST['search_date_to']) ? $_POST['search_date_to'] : '';

// Xử lý xóa người dùng
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Kiểm tra xem `delete_id` có tồn tại không
    $sql_check = "SELECT ma_khach_hang FROM KhachHang WHERE ma_khach_hang = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $delete_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
        echo "<script>alert('Người dùng không tồn tại hoặc đã bị xóa trước đó!'); window.location.href='manage_users.php';</script>";
        exit();
    }
    $stmt_check->close();

    // Xóa người dùng
    $sql_delete = "DELETE FROM KhachHang WHERE ma_khach_hang = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Người dùng đã được xóa thành công!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Xóa không thành công. Vui lòng thử lại sau!'); window.location.href='manage_users.php';</script>";
    }

    $stmt_delete->close();
    exit();
}

// Xử lý cập nhật người dùng
if (isset($_POST['edit_user'])) {
    $user_id = $_POST['edit_user_id'];
    $ten_khach_hang = $_POST['edit_ten_khach_hang'];
    $so_dien_thoai = $_POST['edit_so_dien_thoai'];
    $email = $_POST['edit_email'];
    $address = $_POST['edit_address'];
    $password = $_POST['edit_password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE KhachHang SET ten_khach_hang = ?, so_dien_thoai = ?, email = ?, address = ?, password = ? WHERE ma_khach_hang = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssi", $ten_khach_hang, $so_dien_thoai, $email, $address, $hashed_password, $user_id);
    } else {
        $sql_update = "UPDATE KhachHang SET ten_khach_hang = ?, so_dien_thoai = ?, email = ?, address = ? WHERE ma_khach_hang = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $ten_khach_hang, $so_dien_thoai, $email, $address, $user_id);
    }

    $stmt_update->execute();
    $stmt_update->close();

    echo "<script>alert('Cập nhật thông tin người dùng thành công!'); window.location.href='manage_users.php';</script>";
    exit();
}

// Tạo câu lệnh SQL với các điều kiện tìm kiếm
$sql = "SELECT ma_khach_hang, ten_khach_hang, so_dien_thoai, email, address, ngay_tao FROM KhachHang WHERE role = 'user'";

if (!empty($search_name)) {
    $sql .= " AND ten_khach_hang LIKE ?";
}
if (!empty($search_phone)) {
    $sql .= " AND so_dien_thoai LIKE ?";
}
if (!empty($search_email)) {
    $sql .= " AND email LIKE ?";
}
if (!empty($search_date_from)) {
    $sql .= " AND ngay_tao >= ?";
}
if (!empty($search_date_to)) {
    $sql .= " AND ngay_tao <= ?";
}

// Chuẩn bị câu lệnh SQL
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số
$params = [];
if (!empty($search_name)) {
    $params[] = "%" . $search_name . "%";
}
if (!empty($search_phone)) {
    $params[] = "%" . $search_phone . "%";
}
if (!empty($search_email)) {
    $params[] = "%" . $search_email . "%";
}
if (!empty($search_date_from)) {
    $params[] = $search_date_from;
}
if (!empty($search_date_to)) {
    $params[] = $search_date_to;
}
if (count($params) > 0) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="../frontend/css/manage_users.css">
</head>
<body>
    <div class="content">
        <h1>Quản Lý Người Dùng</h1>

        <!-- Hiển thị thông báo -->
        <?php if (!empty($message)): ?>
            <div class="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form tìm kiếm với bộ lọc -->
        <form method="POST" class="search-form" id="search-form">
            <input type="text" name="search_name" placeholder="Tìm theo tên" value="<?php echo htmlspecialchars($search_name); ?>">
            <input type="text" name="search_phone" placeholder="Tìm theo số điện thoại" value="<?php echo htmlspecialchars($search_phone); ?>">
            <input type="text" name="search_email" placeholder="Tìm theo email" value="<?php echo htmlspecialchars($search_email); ?>">
            <input type="date" name="search_date_from" value="<?php echo htmlspecialchars($search_date_from); ?>">
            <input type="date" name="search_date_to" value="<?php echo htmlspecialchars($search_date_to); ?>">
            <button type="submit">Tìm kiếm</button>
            <button type="button" id="reset-button">Hủy lọc</button>
        </form>

        <!-- Bảng danh sách người dùng -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Địa Chỉ</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['ma_khach_hang']; ?></td>
                        <td><?php echo htmlspecialchars($user['ten_khach_hang']); ?></td>
                        <td><?php echo htmlspecialchars($user['so_dien_thoai']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                        <td><?php echo $user['ngay_tao']; ?></td>
                        <td>
                            <button type="button" class="edit-btn"
                                onclick='openEditModal(<?php echo json_encode($user, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>)'>
                                Sửa
                            </button>
                            <a href="manage_users.php?delete_id=<?php echo $user['ma_khach_hang']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');" class="delete-btn">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal chỉnh sửa -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Sửa Thông Tin Người Dùng</h3>
            <form method="POST">
                <input type="hidden" id="edit_user_id" name="edit_user_id">
                <div class="form-group">
                    <label for="edit_ten_khach_hang">Tên người dùng:</label>
                    <input type="text" id="edit_ten_khach_hang" name="edit_ten_khach_hang" required>
                </div>
                <div class="form-group">
                    <label for="edit_so_dien_thoai">Số điện thoại:</label>
                    <input type="text" id="edit_so_dien_thoai" name="edit_so_dien_thoai" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="edit_email" required>
                </div>
                <div class="form-group">
                    <label for="edit_address">Địa chỉ:</label>
                    <textarea id="edit_address" name="edit_address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_password">Mật khẩu mới (nếu có):</label>
                    <input type="password" id="edit_password" name="edit_password">
                </div>
                <button type="submit" name="edit_user">Lưu</button>
            </form>
        </div>
    </div>

    <script>
        // Hiển thị modal chỉnh sửa
        function openEditModal(user) {
            document.getElementById("edit_user_id").value = user.ma_khach_hang;
            document.getElementById("edit_ten_khach_hang").value = user.ten_khach_hang;
            document.getElementById("edit_so_dien_thoai").value = user.so_dien_thoai;
            document.getElementById("edit_email").value = user.email;
            document.getElementById("edit_address").value = user.address;

            document.getElementById("editModal").style.display = "block";
        }

        // Đóng modal
        document.querySelector(".close").onclick = function () {
            document.getElementById("editModal").style.display = "none";
        };

        window.onclick = function (event) {
            if (event.target == document.getElementById("editModal")) {
                document.getElementById("editModal").style.display = "none";
            }
        };

        // Nút hủy lọc
        document.getElementById('reset-button').addEventListener('click', function () {
            document.getElementById('search-form').reset();
            window.location.href = window.location.pathname;
        });
    </script>
</body>
</html>
=======
<?php
include '../backend/db_connect.php'; // Kết nối cơ sở dữ liệu
include '../backend/sidebar.php'; // Bao gồm sidebar

$message = ""; // Biến để lưu thông báo

// Lấy dữ liệu tìm kiếm từ form
$search_name = isset($_POST['search_name']) ? $_POST['search_name'] : '';
$search_phone = isset($_POST['search_phone']) ? $_POST['search_phone'] : '';
$search_email = isset($_POST['search_email']) ? $_POST['search_email'] : '';
$search_date_from = isset($_POST['search_date_from']) ? $_POST['search_date_from'] : '';
$search_date_to = isset($_POST['search_date_to']) ? $_POST['search_date_to'] : '';

// Xử lý xóa người dùng
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Kiểm tra xem `delete_id` có tồn tại không
    $sql_check = "SELECT ma_khach_hang FROM KhachHang WHERE ma_khach_hang = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $delete_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
        echo "<script>alert('Người dùng không tồn tại hoặc đã bị xóa trước đó!'); window.location.href='manage_users.php';</script>";
        exit();
    }
    $stmt_check->close();

    // Xóa người dùng
    $sql_delete = "DELETE FROM KhachHang WHERE ma_khach_hang = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Người dùng đã được xóa thành công!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Xóa không thành công. Vui lòng thử lại sau!'); window.location.href='manage_users.php';</script>";
    }

    $stmt_delete->close();
    exit();
}

// Xử lý cập nhật người dùng
if (isset($_POST['edit_user'])) {
    $user_id = $_POST['edit_user_id'];
    $ten_khach_hang = $_POST['edit_ten_khach_hang'];
    $so_dien_thoai = $_POST['edit_so_dien_thoai'];
    $email = $_POST['edit_email'];
    $address = $_POST['edit_address'];
    $password = $_POST['edit_password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE KhachHang SET ten_khach_hang = ?, so_dien_thoai = ?, email = ?, address = ?, password = ? WHERE ma_khach_hang = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssi", $ten_khach_hang, $so_dien_thoai, $email, $address, $hashed_password, $user_id);
    } else {
        $sql_update = "UPDATE KhachHang SET ten_khach_hang = ?, so_dien_thoai = ?, email = ?, address = ? WHERE ma_khach_hang = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $ten_khach_hang, $so_dien_thoai, $email, $address, $user_id);
    }

    $stmt_update->execute();
    $stmt_update->close();

    echo "<script>alert('Cập nhật thông tin người dùng thành công!'); window.location.href='manage_users.php';</script>";
    exit();
}

// Tạo câu lệnh SQL với các điều kiện tìm kiếm
$sql = "SELECT ma_khach_hang, ten_khach_hang, so_dien_thoai, email, address, ngay_tao FROM KhachHang WHERE role = 'user'";

if (!empty($search_name)) {
    $sql .= " AND ten_khach_hang LIKE ?";
}
if (!empty($search_phone)) {
    $sql .= " AND so_dien_thoai LIKE ?";
}
if (!empty($search_email)) {
    $sql .= " AND email LIKE ?";
}
if (!empty($search_date_from)) {
    $sql .= " AND ngay_tao >= ?";
}
if (!empty($search_date_to)) {
    $sql .= " AND ngay_tao <= ?";
}

// Chuẩn bị câu lệnh SQL
$stmt = $conn->prepare($sql);

// Gán giá trị cho các tham số
$params = [];
if (!empty($search_name)) {
    $params[] = "%" . $search_name . "%";
}
if (!empty($search_phone)) {
    $params[] = "%" . $search_phone . "%";
}
if (!empty($search_email)) {
    $params[] = "%" . $search_email . "%";
}
if (!empty($search_date_from)) {
    $params[] = $search_date_from;
}
if (!empty($search_date_to)) {
    $params[] = $search_date_to;
}
if (count($params) > 0) {
    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="../frontend/css/manage_users.css">
</head>
<body>
    <div class="content">
        <h1>Quản Lý Người Dùng</h1>

        <!-- Hiển thị thông báo -->
        <?php if (!empty($message)): ?>
            <div class="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form tìm kiếm với bộ lọc -->
        <form method="POST" class="search-form" id="search-form">
            <input type="text" name="search_name" placeholder="Tìm theo tên" value="<?php echo htmlspecialchars($search_name); ?>">
            <input type="text" name="search_phone" placeholder="Tìm theo số điện thoại" value="<?php echo htmlspecialchars($search_phone); ?>">
            <input type="text" name="search_email" placeholder="Tìm theo email" value="<?php echo htmlspecialchars($search_email); ?>">
            <input type="date" name="search_date_from" value="<?php echo htmlspecialchars($search_date_from); ?>">
            <input type="date" name="search_date_to" value="<?php echo htmlspecialchars($search_date_to); ?>">
            <button type="submit">Tìm kiếm</button>
            <button type="button" id="reset-button">Hủy lọc</button>
        </form>

        <!-- Bảng danh sách người dùng -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Số Điện Thoại</th>
                    <th>Email</th>
                    <th>Địa Chỉ</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['ma_khach_hang']; ?></td>
                        <td><?php echo htmlspecialchars($user['ten_khach_hang']); ?></td>
                        <td><?php echo htmlspecialchars($user['so_dien_thoai']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                        <td><?php echo $user['ngay_tao']; ?></td>
                        <td>
                            <button type="button" class="edit-btn"
                                onclick='openEditModal(<?php echo json_encode($user, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>)'>
                                Sửa
                            </button>
                            <a href="manage_users.php?delete_id=<?php echo $user['ma_khach_hang']; ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');" class="delete-btn">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal chỉnh sửa -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Sửa Thông Tin Người Dùng</h3>
            <form method="POST">
                <input type="hidden" id="edit_user_id" name="edit_user_id">
                <div class="form-group">
                    <label for="edit_ten_khach_hang">Tên người dùng:</label>
                    <input type="text" id="edit_ten_khach_hang" name="edit_ten_khach_hang" required>
                </div>
                <div class="form-group">
                    <label for="edit_so_dien_thoai">Số điện thoại:</label>
                    <input type="text" id="edit_so_dien_thoai" name="edit_so_dien_thoai" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="edit_email" required>
                </div>
                <div class="form-group">
                    <label for="edit_address">Địa chỉ:</label>
                    <textarea id="edit_address" name="edit_address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit_password">Mật khẩu mới (nếu có):</label>
                    <input type="password" id="edit_password" name="edit_password">
                </div>
                <button type="submit" name="edit_user">Lưu</button>
            </form>
        </div>
    </div>

    <script>
        // Hiển thị modal chỉnh sửa
        function openEditModal(user) {
            document.getElementById("edit_user_id").value = user.ma_khach_hang;
            document.getElementById("edit_ten_khach_hang").value = user.ten_khach_hang;
            document.getElementById("edit_so_dien_thoai").value = user.so_dien_thoai;
            document.getElementById("edit_email").value = user.email;
            document.getElementById("edit_address").value = user.address;

            document.getElementById("editModal").style.display = "block";
        }

        // Đóng modal
        document.querySelector(".close").onclick = function () {
            document.getElementById("editModal").style.display = "none";
        };

        window.onclick = function (event) {
            if (event.target == document.getElementById("editModal")) {
                document.getElementById("editModal").style.display = "none";
            }
        };

        // Nút hủy lọc
        document.getElementById('reset-button').addEventListener('click', function () {
            document.getElementById('search-form').reset();
            window.location.href = window.location.pathname;
        });
    </script>
</body>
</html>
>>>>>>> origin/thanhnguyen
