<?php
include 'connect.php';
$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT 
      m.title, m.poster,m.time AS duration, m.release_date AS date, m.format,
      t.fullname AS user_name, t.Email AS email,
      d.seat, d.money, d.booking_time,cinema
    FROM datve d
    JOIN movies m ON d.movie_id = m.id
    JOIN thanhvien t ON d.user_id = t.id
    WHERE d.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chi tiết đặt vé</title>
  <link rel="stylesheet" href="../css//thongtinve.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <div class="header-container">
        <div class="header-top">
            <div class="header-left">

                <a href="/Banve/web/trangchu.html">
                    <button class="btn-yellow">🎟 ĐẶT VÉ NGAY</button>
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

            <d class="cinema-menu-left">
                <a href="tinmoivauudai.html" class="menu-item">TIN MỚI & ƯU ĐÃI</a>
                <!-- <i class="menu-item"><a href="tinmoivauudai.html"> TIN MỚI & ƯU ĐÃI</a></i> -->
                <div>Thuê sự kiện</div>
                <div>Tất cả các giải trí</div>
                <a class="entertainment-link" href="gioithieu.html" >Giới thiệu</a>
            </div>
        </div>
    </div>

  <div class="ticket-info">
    <div class="img_poster">'
      <img class="img_booking" src="<?= $row['poster'] ?>" alt="Ảnh phim <?= $row['title'] ?>" ></div>
    <div class="tieude">
      <h2>Thông Tin Vé</h2>
    <p><strong>Tên phim:</strong> <?= $row['title'] ?></p>
    <p><strong>Thời lượng:</strong> <?= $row['duration'] ?> phút</p>
    <p><strong>Ngày chiếu:</strong> <?= date("d/m/Y", strtotime($row['date'])) ?></p>
    <p><strong>Giờ chiếu:</strong> <?= $row['booking_time'] ?></p>
    <p><strong>Khách hàng:</strong> <?= $row['user_name'] ?></p>
    <p><strong>Rạp:</strong> <?= $row['cinema'] ?></p>
    <p><strong>Số ghế:</strong> <?= implode(', ', explode(',', $row['seat'])) ?></p>
    <p><strong>Tổng tiền:</strong> <?= number_format($row['money'], 0, ',', '.') ?> VNĐ</p>
    </div>
  </div>
  
  <script src="../js/thongtinve.js"></script>
</body>
</html>
