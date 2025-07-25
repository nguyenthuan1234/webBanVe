<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];
    $seat = $_POST['seats'];
    $money = $_POST['total_amount'];
    $date = $_POST['real_date'] ?? date('Y-m-d');
    $time = $_POST['time'];
    $cinema = $_POST['cinema'];

    $stmt = $conn->prepare("INSERT INTO datve (user_id, movie_id, seat, money, booking_date, booking_time, cinema) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisdsss", $user_id, $movie_id, $seat, $money, $date, $time, $cinema);

    if ($stmt->execute()) {
        echo "✅ Đặt vé thành công!";
        echo "<br><a href='/Banve/php/thongtinve.php?id=" . $conn->insert_id . "'>Xem vé</a>";
    } else {
        echo "❌ Lỗi khi đặt vé: " . $conn->error;
    }
}
?>
