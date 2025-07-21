<?php
include 'connect.php';
$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT 
      m.title, m.time AS duration, m.release_date AS date, m.format,
      t.fullname AS user_name, t.Email AS email,
      d.seat, d.total_amount, d.booking_time
    FROM datve d
    JOIN movies m ON d.movie_id = m.id
    JOIN thanhvien t ON d.user_id = t.id
    WHERE d.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

echo "Tên phim      : " . $row['title'] . "<br>";
echo "Thời lượng    : " . $row['duration'] . " phút<br>";
echo "Ngày chiếu    : " . date("d/m/Y", strtotime($row['date'])) . "<br>";
echo "Giờ chiếu     : " . $row['booking_time'] . "<br>";
echo "Khách hàng    : " . $row['user_name'] . "<br>";
echo "Email         : " . $row['email'] . "<br>";
$seats = explode(',', $row['seat']);
echo "Số ghế        : " . implode(', ', $seats) . "<br>";
echo "Tổng tiền     : " . number_format($row['total_amount'], 0, ',', '.') . " VNĐ<br>";
