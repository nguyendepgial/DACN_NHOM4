<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../../backend/login.php");
    exit();
}

include('../../backend/db_connect.php');

$sql = "SELECT * FROM khachhang WHERE email = '" . $_SESSION['email'] . "' LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khach_hang = $_POST['ten_khach_hang'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $address = $_POST['address'];

    $avatar = $user['avatar'];
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatar_dir = "uploads/avatars/";
        $avatar_dir = __DIR__ . "/../../public/uploads/avatars/"; // Đường dẫn tuyệt đối

            if (!is_dir($avatar_dir)) {
                mkdir($avatar_dir, 0777, true);
            }

        $avatar_name = uniqid() . '-' . basename($_FILES['avatar']['name']);
        $avatar_path = $avatar_dir . $avatar_name;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
        // Lưu đường dẫn tương đối vào database
        $avatar = "uploads/avatars/" . $avatar_name;
            } else {
                echo "Không thể tải ảnh lên.";
                    exit();         
}

    }

    $update_sql = "UPDATE khachhang SET 
                    ten_khach_hang = '$ten_khach_hang', 
                    so_dien_thoai = '$so_dien_thoai', 
                    address = '$address', 
                    avatar = '$avatar' 
                    WHERE email = '" . $_SESSION['email'] . "'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Cập nhật thất bại.";
    }
}

$sql_contacts = "SELECT * FROM contact_messages WHERE email = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql_contacts);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result_contacts = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" href="images/logo.png" type="image/png">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="profile-container">
        <div class="profile-header">
            <div class="avatar">
            <img src="<?php echo isset($user['avatar']) && !empty($user['avatar']) ? '../../public/uploads/avatars/' . basename($user['avatar']) : '/images/avatar.jpg'; ?>" alt="Avatar">


            </div>
            <h2><?php echo $user['ten_khach_hang']; ?></h2>
            <p class="user-email"><i class="fas fa-envelope"></i> <?php echo $user['email']; ?></p>
            <p class="user-phone"><i class="fas fa-phone"></i> <?php echo $user['so_dien_thoai']; ?></p>    
            <p class="user-address"><i class="fas fa-map-marker-alt"></i> <?php echo $user['address']; ?></p>
            <p class="user-role"><i class="fas fa-user-tag"></i> Vai trò: <?php echo ucfirst($user['role']); ?></p>
        </div>

        <div class="profile-actions">
            <button class="btn" id="btn-update-profile">Cập nhật thông tin cá nhân</button>
            <button class="btn" id="btn-check-contacts">Kiểm tra liên hệ</button>
        </div>
    </div>

    <div class="popup" id="popup-update-profile">
        <div class="popup-content">
            <span class="close-popup" id="close-update-profile">&times;</span>
            <h3>Cập nhật thông tin cá nhân</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="ten_khach_hang">Tên khách hàng:</label>
                    <input type="text" name="ten_khach_hang" id="ten_khach_hang" value="<?php echo $user['ten_khach_hang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="so_dien_thoai">Số điện thoại:</label>
                    <input type="text" name="so_dien_thoai" id="so_dien_thoai" value="<?php echo $user['so_dien_thoai']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" id="address" value="<?php echo $user['address']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="avatar">Ảnh đại diện:</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*">
                </div>
                <button type="submit">Cập nhật</button>
            </form>
        </div>
    </div>

    <div class="popup" id="popup-check-contacts">
        <div class="popup-content">
            <span class="close-popup" id="close-check-contacts">&times;</span>
            <h3>Kiểm tra liên hệ</h3>
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>Danh mục</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Phản hồi</th>
                        <th>Ngày gửi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($contact = $result_contacts->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['category']); ?></td>
                            <td><?php echo htmlspecialchars($contact['message']); ?></td>
                            <td><?php echo $contact['status'] === 'processed' ? 'Đã xử lý' : 'Đang chờ xử lý'; ?></td>
                            <td><?php echo $contact['resolution'] ? $contact['resolution'] : 'Chưa có phản hồi'; ?></td>
                            <td><?php echo date("d-m-Y H:i", strtotime($contact['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>document.addEventListener('DOMContentLoaded', () => {
    const btnUpdateProfile = document.getElementById('btn-update-profile');
    const popupUpdateProfile = document.getElementById('popup-update-profile');
    const closeUpdateProfile = document.getElementById('close-update-profile');

    const btnCheckContacts = document.getElementById('btn-check-contacts');
    const popupCheckContacts = document.getElementById('popup-check-contacts');
    const closeCheckContacts = document.getElementById('close-check-contacts');

    btnUpdateProfile.addEventListener('click', () => {
        popupUpdateProfile.style.display = 'flex';
    });

    closeUpdateProfile.addEventListener('click', () => {
        popupUpdateProfile.style.display = 'none';
    });

    btnCheckContacts.addEventListener('click', () => {
        popupCheckContacts.style.display = 'flex';
    });

    closeCheckContacts.addEventListener('click', () => {
        popupCheckContacts.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === popupUpdateProfile) {
            popupUpdateProfile.style.display = 'none';
        }
        if (event.target === popupCheckContacts) {
            popupCheckContacts.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
