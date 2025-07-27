<?php
require_once 'connect.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Nhận ID từ query string (?id=1)
    $movieId = $_GET['id'] ?? null;

    if (!$movieId) {
        echo json_encode(["error" => "Thiếu ID phim."]);
        exit;
    }

    // Truy vấn theo ID
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ? AND is_active = 1 LIMIT 1");
    $stmt->bind_param("s", $movieId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Trả kết quả JSON
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $movie = [
            "id" => $row["id"],
            "title" => $row["title"],
            "poster" => $row["poster"],
            "release_date" => $row["release_date"],
            "trailerLink" => $row["trailer_link"], 
            "age" => $row["age"],
            "format" => $row["format"],
            "time" => $row["time"],
            "category" => $row["category"],
            "ticket_price" => $row["ticket_price"],
            "phim_type" => $row["phim_type"],
            "actors" => $row["actors"],
            "director" => $row["director"],
            "description" => $row["description"]

        ];
        echo json_encode($movie);
    } else {
        echo json_encode(["error" => "Không tìm thấy phim."]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
