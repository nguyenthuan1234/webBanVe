<?php 
include 'connect.php';
session_start();

if(isset($_SESSION['username'])) {
    header("Location:/Banve/web/trangchu.html"); 
    exit();
}

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Truy vấn người dùng theo email
    $query = "SELECT * FROM thanhvien WHERE Email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // So sánh mật khẩu đã hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['Email'];
            $_SESSION['role'] = $user['role'];
            header("Location:/Banve/web/trangchu.html");
            exit();
        } else {
            echo "Mật khẩu không đúng.";
        }
    } else {
        echo "Tài khoản không tồn tại.";
    }
}
?>
