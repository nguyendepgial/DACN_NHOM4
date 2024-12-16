<?php
session_start();
include '../backend/db_connect.php'; // Kết nối cơ sở dữ liệu

// Xử lý trạng thái thông báo và lưu phương thức xử lý
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_message'])) {
    $message_id = intval($_POST['message_id']);
    $resolution = trim($_POST['resolution']);

    $sql_update_status = "UPDATE contact_messages SET status = 'processed', resolution = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update_status);
    if (!$stmt) {
        $_SESSION['error'] = "Lỗi chuẩn bị truy vấn: " . $conn->error;
        header("Location: process_contact_messages.php");
        exit;
    }

    $stmt->bind_param("si", $resolution, $message_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Thông báo đã được xử lý thành công.";
    } else {
        $_SESSION['error'] = "Lỗi khi xử lý thông báo: " . $stmt->error;
    }
    $stmt->close();
    header("Location: /DACN_NHOM4/backend/process_contact_message.php");
    exit;
}

// Lấy danh sách thông báo liên hệ
$sql_contact_messages = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result_contact_messages = $conn->query($sql_contact_messages);

// $sql_contact_messages_resolution = "SELECT * FROM contact_messages ORDER BY resolution DESC";
// $result_contact_messages_resolution = $conn->query($sql_contact_messages_resolution);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thông Báo Liên Hệ</title>
    <link rel="stylesheet" href="../frontend/css/admin_page.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('../backend/sidebar.php'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Thông Báo Liên Hệ Của Khách Hàng</h1>

            <!-- Thông báo xử lý -->
            <?php if (isset($_SESSION['message'])): ?>
                <script>
                    alert("<?php echo $_SESSION['message']; ?>");
                </script>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <script>
                    alert("<?php echo $_SESSION['error']; ?>");
                </script>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Danh sách thông báo -->
            <div class="contact-messages">
                <div class="messages-table-wrapper">
                    <?php if ($result_contact_messages->num_rows > 0): ?>
                        <table class="messages-table">
                            <thead>
                                <tr>
                                    <th>Người Gửi</th>
                                    <th>Danh Mục</th>
                                    <th>Thời Gian</th>
                                    <th>Chi Tiết</th>
                                    <th>Phương Thức Xử Lí</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_contact_messages->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                        <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                                        <td>
                                            <?php if ($row['status'] === 'pending'): ?>
                                                <button 
                                                    class="btn-process" 
                                                    data-message-id="<?php echo $row['id']; ?>" 
                                                    data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                                                    data-category="<?php echo htmlspecialchars($row['category']); ?>" 
                                                    data-time="<?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?>" 
                                                    data-message="<?php echo htmlspecialchars($row['message']); ?>"
                                                >
                                                    Xử Lý
                                                </button>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($row['resolution']); ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Không có thông báo liên hệ nào từ khách hàng.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xử Lý -->
    <div id="processModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Xử Lý Thông Báo</h2>
            <form method="POST">
                <input type="hidden" name="message_id" id="modal-message-id">
                <p><strong>Người Gửi:</strong> <span id="modal-name"></span></p>
                <p><strong>Danh Mục:</strong> <span id="modal-category"></span></p>
                <p><strong>Thời Gian:</strong> <span id="modal-time"></span></p>
                <p><strong>Nội Dung:</strong> <span id="modal-message"></span></p>
                <div>
                    <label for="resolution">Phương Thức Xử Lý:</label>
                    <textarea name="resolution" id="resolution" rows="4" placeholder="Nhập phương thức xử lý..." required></textarea>
                </div>
                <button type="submit" name="process_message" class="btn-confirm">Xác Nhận</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Ẩn modal khi tải trang
            $("#processModal").hide();

            // Hiển thị modal khi nhấn nút Xử Lý
            $(".btn-process").click(function () {
                const messageId = $(this).data("message-id");
                const name = $(this).data("name");
                const category = $(this).data("category");
                const time = $(this).data("time");
                const message = $(this).data("message");

                // Gán giá trị vào các trường trong modal
                $("#modal-message-id").val(messageId);
                $("#modal-name").text(name);
                $("#modal-category").text(category);
                $("#modal-time").text(time);
                $("#modal-message").text(message);

                // Hiển thị modal
                $("#processModal").fadeIn();
            });

            // Đóng modal khi nhấn vào nút đóng
            $(".close-modal").click(function () {
                $("#processModal").fadeOut();
            });

            // Đóng modal khi nhấn ra ngoài vùng modal
            $(window).click(function (e) {
                if ($(e.target).is("#processModal")) {
                    $("#processModal").fadeOut();
                }
            });
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>

<style>
/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    position: relative;
    animation: scaleIn 0.3s ease;
}

.modal-content h2 {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.modal-content p {
    font-size: 16px;
    margin-bottom: 10px;
    color: #555;
}

.modal-content label {
    display: block;
    margin-bottom: 5px;
}

.modal-content textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.modal-content .btn-confirm {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.modal-content .btn-confirm:hover {
    background-color: #2980b9;
}

.close-modal {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
    color: #aaa;
}

.close-modal:hover {
    color: #e74c3c;
}
</style>
