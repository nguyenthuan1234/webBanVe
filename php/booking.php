<?php
include 'connect.php';
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: /Banve/web/dangnhap.html");
    exit();
}

$movie_id = $_GET['id'];
$user_email = $_SESSION['username']; // giả sử lưu email khi login

// Lấy thông tin phim
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

// Lấy thông tin người dùng
$stmt_user = $conn->prepare("SELECT * FROM thanhvien WHERE Email = ?");
$stmt_user->bind_param("s", $user_email);
$stmt_user->execute();
$user = $stmt_user->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/Banve/css/booking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
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
                <div>Tất cả các giải trí</div>
                <a class="entertainment-link" href="gioithieu.html" >Giới thiệu</a>
            </div>
        </div>
    </div>


    

   

    <form  class="cangchinh"  action="/Banve/php/datve_xuly.php" method="POST">
        

     <div><img  class="img_booking" src="<?= $movie['poster'] ?>" alt="Ảnh phim <?= $movie['title'] ?>" ></div>
    
     <div>
        <h2>Thông tin đặt vé</h2>
        
     <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
    <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">

    <p><strong>Tên phim:</strong> <?= $movie['title'] ?></p>
    <p><strong>Thời lượng:</strong> <?= $movie['time'] ?> phút</p>
    <p><strong>Ngày chiếu:</strong> <?= date("d/m/Y", strtotime($movie['release_date'])) ?></p>

    <h3>Chọn ghế:</h3>
    <div class="seat-container" id="seatContainer"></div>

    <input type="hidden" name="seats" id="selectedSeats">
    <input type="hidden" name="total_amount" id="totalAmount">

    <label for="time">Chọn giờ chiếu:</label>
    <select name="time" id="time" required>
        <option value="">-- Chọn giờ --</option>
        <option value="09:00">09:00</option>
        <option value="13:00">13:00</option>
        <option value="17:00">17:00</option>
        <option value="20:00">20:00</option>
    </select>


    <p><strong>Tổng tiền (VNĐ):</strong> <span id="totalAmountDisplay">0</span></p> 

    <button class="btn_submit" type="submit">Đặt vé</button></div>
    </form>
    
    <script src="../js/booking.js"></script>

    
    
</body>
</html>
