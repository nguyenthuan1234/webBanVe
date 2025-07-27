<?php
session_start();
include 'connect.php';

// ✅ Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: /Banve/web/dangnhap.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Truy vấn tất cả các vé đã đặt của người dùng
$sql = "
    SELECT 
        d.id AS booking_id, m.title, m.poster, m.time AS duration, m.release_date AS date,
        d.seat, d.money, d.booking_time, d.cinema
    FROM datve d
    JOIN movies m ON d.movie_id = m.id
    WHERE d.user_id = ?
    ORDER BY d.booking_time DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Vé của tôi</title>
    <link rel="stylesheet" href="/Banve/css/vecuatoi.css">
</head>
<body>

<h2 class="heading">🎫 Vé của tôi</h2>

<?php if ($result->num_rows > 0): ?>
<div class="ticket-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="ticket-card">
            <img src="<?= htmlspecialchars($row['poster']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="ticket-poster">
            <div class="ticket-details">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><strong>Ngày chiếu:</strong> <?= date("d/m/Y", strtotime($row['date'])) ?></p>
                <p><strong>Giờ chiếu:</strong> <?= htmlspecialchars($row['booking_time']) ?></p>
                <p><strong>Rạp:</strong> <?= htmlspecialchars($row['cinema']) ?></p>
                <p><strong>Ghế:</strong> <?= htmlspecialchars($row['seat']) ?></p>
                <p><strong>Giá:</strong> <?= number_format($row['money'], 0, ',', '.') ?> VNĐ</p>
                <a href="/Banve/php/thongtinve.php?id=<?= $row['booking_id'] ?>" class="view-details">Xem chi tiết</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php else: ?>
    <p class="no-ticket">Bạn chưa đặt vé nào.</p>
<?php endif; ?>

</body>
</html>
