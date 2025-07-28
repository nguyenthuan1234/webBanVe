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
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
     <div class="header-container">
        <div class="header-top">
            <div class="header-left">

                <a href="/Banve/web/trangchu.html">
                    <button class="btn-yellow" >🎟 ĐẶT VÉ NGAY</button>
                </a>

                <button class="btn-purple">🍿 ĐẶT BẮP NƯỚC</button>
            </div>

            <div class="header-search">
                <input type="text" placeholder="Tìm phim, rạp" />
                <button class="search-button" style="background: white; border: none;">
                    <i class="fas fa-search" ></i>
                </button>
            </div>

           <div class="header-right">
                <div class="login">
                    <div class="menu-item">
                        <a href="/Banve/web/dangnhap.html">
                            <i class="fas fa-user"></i> Đăng nhập
                        </a>
                    </div>
                </div>

                <div class="language">
                    <span class="star">★</span>
                    <span class="vn">VN ▾</span>
                </div>
            </div>

        </div>
        <hr />

        <!-- Bottom Nav -->
        <div class="header-bottom">
            <div class="ci-sh">
                <div class="cinema-dropdown">
                    <div class="cinema-title">📍 Chọn rạp</div>
                    <div class="cinema-menu">
                        <div>Cinestar Quốc Thanh (TP.HCM)</div>
                        <div>Cinestar Satra Quận 6 (TP.HCM)</div>
                        <div>Cinestar Hai Bà Trưng (TP.HCM)</div>
                        <div>Cinestar Sinh Viên (Bình Dương)</div>
                        <div>Cinestar Huế (TP. Huế)</div>
                        <div>Cinestar Đà Lạt (TP. Đà Lạt)</div>
                        <div>Cinestar Lâm Đồng (Đức Trọng)</div>
                        <div>Cinestar Mỹ Tho (Tiền Giang)</div>
                        <div>Cinestar Kiên Giang (Rạch Sỏi)</div>
                    </div>
                </div>
                <div class="show-schedule">📍 Lịch chiếu</div>
            </div>

            <div class="cinema-menu-left">
                <a href="/Banve/web/tinmoivauudai.html" class="menu-item">TIN MỚI & ƯU ĐÃI</a>
                <!-- <i class="menu-item"><a href="tinmoivauudai.html"> TIN MỚI & ƯU ĐÃI</a></i> -->
                <div>Thuê sự kiện</div>
                <a class="entertainment-link" href="/Banve/php/vecuatoi.php" >Vé Của Tôi</a>
                <a class="entertainment-link" href="/Banve/web/gioithieu.html" >Giới thiệu</a>
            </div>
        </div>
    </div>



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

<script src="../js/thongtinve.js"></script>

</body>
</html>
