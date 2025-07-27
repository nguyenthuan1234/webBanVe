<?php
session_start();
require_once 'connect.php'; // Kết nối $conn

// 👉 XỬ LÝ GET: Trả danh sách phim cho JavaScript
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    header('Content-Type: application/json; charset=utf-8');

    $sql = "SELECT * FROM movies WHERE phim_type = 'phim3' AND is_active = 1 ORDER BY release_date DESC";
    $result = $conn->query($sql);

    $movies = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $movies[] = [
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
        }
    }

    $role = $_SESSION['role'] ?? 'user';
    $loggedIn = isset($_SESSION['username']);

    echo json_encode([
        'movies' => $movies,
        'role' => $role,
        'logged_in' => $loggedIn
    ]);
    exit;
}

// 👉 XỬ LÝ POST: Thêm phim mới từ form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $releaseDate = $_POST['releaseDate'] ?? '';
    $trailerLink = $_POST['trailerLink'] ?? '';
    $age = $_POST['age'] ?? '';
    $format = $_POST['format'] ?? '';
    $time = $_POST['time'] ?? '';
    $category = $_POST['category'] ?? '';
    $ticketPrice = $_POST['ticketPrice'] ?? 0;
    $actors = $_POST['actors'] ?? '';
    $director = $_POST['director'] ?? '';
    $description = $_POST['description'] ?? '';
    $posterPath = "";
    $isActive = 1;
    $phimType = $_POST['phim'] ?? 'phim1';

    // Xử lý upload ảnh
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../img/";
        $fileName = basename($_FILES['poster']['name']);
        $targetPath = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $fileType = mime_content_type($_FILES['poster']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            die("Chỉ cho phép định dạng ảnh JPEG, PNG, WEBP!");
        }

        if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetPath)) {
            $posterPath = "/Banve/img/" . $fileName;
        } else {
            die("Lỗi upload ảnh!");
        }
    } else {
        die("Chưa chọn ảnh hoặc ảnh lỗi!");
    }

    // ✅ Thêm actors, director, description vào INSERT
    $stmt = $conn->prepare("INSERT INTO movies 
        (title, poster, release_date, trailer_link, age, format, time, category, ticket_price, is_active, phim_type, actors, director, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssdissss", 
        $title, $posterPath, $releaseDate, $trailerLink, $age, $format, $time, 
        $category, $ticketPrice, $isActive, $phimType, $actors, $director, $description);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: /Banve/web/trangchu.html");
        exit;
    } else {
        echo "Lỗi thêm phim: " . $stmt->error;
        $stmt->close();
        $conn->close();
    }
}
?>
