<?php
include 'connect.php';

$keyword = $_GET['q'] ?? '';
$like = "%$keyword%";

// ✅ Viết câu SQL với đầy đủ cột và dùng prepare để tránh lỗi SQL injection
$sql = "SELECT id, title, poster, time, trailer_link, release_date, age, format, category, ticket_price, phim_type, actors, director, description FROM movies WHERE title LIKE ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $like);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'poster' => $row['poster'],
            'release_date' => $row['release_date'],
            'trailer_link' => $row['trailer_link'],
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
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
