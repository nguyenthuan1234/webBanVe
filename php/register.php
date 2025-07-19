<?php

    include 'connect.php';
    session_start();

    if(isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        // Truy vấn để kiểm tra xem email đã tồn tại chưa
        $query = "SELECT * FROM thanhvien WHERE Email='$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Email đã tồn tại
            echo "Email đã được sử dụng. Vui lòng chọn email khác.";
        }elseif (strlen($password) < 6) {
            // Mật khẩu quá ngắn
            echo "Mật khẩu phải có ít nhất 6 ký tự.";
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Email không hợp lệ
            echo "Địa chỉ email không hợp lệ.";
        }elseif ($_POST['confirmPassword'] !== $password) {
            // Mật khẩu xác nhận không khớp
            echo "Mật khẩu xác nhận không khớp.";

        }
        else {
            // Thêm thành viên mới
            $insertQuery = "INSERT INTO thanhvien (fullName, Email, Password) VALUES ('$fullName', '$email', '$hashedPassword')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Đăng ký thành công!";
                $_SESSION['username'] = $email; // Đăng nhập ngay sau khi đăng ký
                header("Location:/Banve/web/dangnhap.html");
                exit();
            } else {
                echo "Lỗi khi đăng ký: " . mysqli_error($conn);
            }
        }
    }
    if(isset($_POST['btn_dangnhap'])) {
        header("Location:/Banve/web/dangky.html");
        exit();
    }

   
?>
 <form action="register.php" method="post">
    <button name="btn_dangnhap">Quay lại Đăng Nhập</button>

 </form>