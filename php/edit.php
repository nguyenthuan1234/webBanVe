<?php
include 'connect.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $release_date = $_POST['release_date'];
    $trailer_link = $_POST['trailer_link'];
    $category = $_POST['category'];
    $ticket_price = $_POST['ticket_price'];
    $age = $_POST['age'];
    $format = $_POST['format'];
    $time = $_POST['time'];
    $actors = $_POST['actors'];
    $director = $_POST['director'];
    $description = $_POST['description'];
    $phim_type = $_POST['phim'];

    // Xử lý ảnh poster
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
        $posterPath = $_POST['old_poster'];
    }

    $stmt = $conn->prepare("UPDATE movies SET title=?, poster=?, release_date=?, trailer_link=?, age=?, format=?, time=?, category=?, ticket_price=?, actors=?, director=?, description=?, phim_type=? WHERE id=?");
    $stmt->bind_param("ssssssssdssssi", $title, $posterPath, $release_date, $trailer_link, $age, $format, $time, $category, $ticket_price, $actors, $director, $description, $phim_type, $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../web/trangchu.html");
        exit();
    } else {
        echo "Lỗi cập nhật: " . $stmt->error;
    }
}

// Lấy dữ liệu phim
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM movies WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật phim</title>
    <link rel="stylesheet" href="/Banve/css/edit.css">
</head>
<body>
<div class="form-container">
    <h2>Cập nhật phim</h2>
    <form action="/Banve/php/edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <label>Tiêu đề phim:</label>
        <input type="text" name="title" value="<?= $row['title'] ?>" required>

        <label>Ảnh poster:</label>
        <input type="file" name="poster">
        <img src="<?= $row['poster'] ?>" width="80" height="80">
        <input type="hidden" name="old_poster" value="<?= $row['poster'] ?>">

        <label>Ngày khởi chiếu:</label>
        <input type="text" name="release_date" value="<?= $row['release_date'] ?>" required>

        <label>Link trailer:</label>
        <input type="text" name="trailer_link" value="<?= $row['trailer_link'] ?>">

        <label>Thể loại:</label>
        <select name="category" required>
            <?php
            $categories = ["Hành động", "Hài hước", "Kinh dị", "Tình cảm", "Hoạt hình", "Phiêu lưu", "Khoa học viễn tưởng", "Tài liệu", "Khác"];
            foreach ($categories as $cat) {
                $selected = ($row['category'] == $cat) ? "selected" : "";
                echo "<option value=\"$cat\" $selected>$cat</option>";
            }
            ?>
        </select>

        <label>Diễn viên:</label>
        <input type="text" name="actors" value="<?= $row['actors'] ?>" required>

        <label>Đạo diễn:</label>
        <input type="text" name="director" value="<?= $row['director'] ?>" required>

        <label>Nội dung phim:</label>
        <textarea name="description" required><?= $row['description'] ?></textarea>

        <label>Giá vé:</label>
        <input type="number" name="ticket_price" value="<?= $row['ticket_price'] ?>" required>

        <label>Thời lượng phim:</label>
        <input type="text" name="time" value="<?= $row['time'] ?>" required>

        <label>Giới hạn tuổi:</label>
        <select name="age" required>
            <option value="T13" <?= $row['age'] == 'T13' ? 'selected' : '' ?>>T13</option>
            <option value="T16" <?= $row['age'] == 'T16' ? 'selected' : '' ?>>T16</option>
            <option value="T18" <?= $row['age'] == 'T18' ? 'selected' : '' ?>>T18</option>
        </select>

        <label>Định dạng:</label>
        <select name="format" required>
            <option value="2D" <?= $row['format'] == '2D' ? 'selected' : '' ?>>2D</option>
            <option value="3D" <?= $row['format'] == '3D' ? 'selected' : '' ?>>3D</option>
        </select>

        <label>Phim:</label>
        <select name="phim" required>
            <option value="phim1" <?= $row['phim_type'] == 'phim1' ? 'selected' : '' ?>>Phim 1</option>
            <option value="phim2" <?= $row['phim_type'] == 'phim2' ? 'selected' : '' ?>>Phim 2</option>
            <option value="phim3" <?= $row['phim_type'] == 'phim3' ? 'selected' : '' ?>>Phim 3</option>
        </select>

        <button type="submit" name="update">Cập nhật</button>
    </form>
</div>
</body>
</html>
