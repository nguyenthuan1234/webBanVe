<?php 
include 'connect.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $release_date = $_POST['release_date'];
    $trailer_link = $_POST['trailer_link'];
    $age = $_POST['age'];
    $format = $_POST['format'];
    $time = $_POST['time'];

    // Xử lý ảnh poster
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../img/";
        $fileName = basename($_FILES['poster']['name']);
        $targetPath = $uploadDir . $fileName;

        // Kiểm tra định dạng ảnh hợp lệ
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

    // Cập nhật phim (đã thêm trường time)
    $stmt = $conn->prepare("UPDATE movies SET title=?, poster=?, release_date=?, trailer_link=?, age=?, format=?, time=? WHERE id=?");
    $stmt->bind_param("sssssssi", $title, $posterPath, $release_date, $trailer_link, $age, $format, $time, $id);

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

<!-- Giao diện form -->
<form action="/Banve/php/edit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <p>Tiêu đề phim:</p>
    <input type="text" name="title" value="<?php echo $row['title']; ?>">

    <p>Poster (ảnh):</p>
    <input type="file" name="poster"><br>
    <img src="<?php echo $row['poster']; ?>" width="80" height="80">
    <input type="hidden" name="old_poster" value="<?php echo $row['poster']; ?>">

    <p>Ngày phát hành:</p>
    <input type="date" name="release_date" value="<?php echo $row['release_date']; ?>">

    <p>Link trailer:</p>
    <input type="text" name="trailer_link" value="<?php echo $row['trailer_link']; ?>">

    <p>Độ tuổi:</p>
    <input type="text" name="age" value="<?php echo $row['age']; ?>">

    <p>Định dạng:</p>
    <input type="text" name="format" value="<?php echo $row['format']; ?>">

    <p>Thời lượng (phút):</p>
    <input type="text" name="time" value="<?php echo $row['time']; ?>">

    <br><br>
    <button type="submit" name="update">Cập nhật</button>
</form>
