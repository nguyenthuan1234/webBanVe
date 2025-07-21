<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];
    $seat = $_POST['seats'];
    $total = $_POST['total_amount'];
    $date = $_POST['real_date'] ?? date('Y-m-d');
    $time = $_POST['time'];

    $stmt = $conn->prepare("INSERT INTO datve (user_id, movie_id, seat, total_amount, booking_date, booking_time) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisiss", $user_id, $movie_id, $seat, $total, $date, $time);

    if ($stmt->execute()) {
        echo "✅ Đặt vé thành công!";
        echo "<br><a href='/Banve/php/thongtinve.php?id=" . $conn->insert_id . "'>Xem vé</a>";
    } else {
        echo "❌ Lỗi khi đặt vé: " . $conn->error;
    }
}
?>
