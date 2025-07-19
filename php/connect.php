<?php
    
$host = 'localhost';
$user = 'root'; // Thay đổi nếu user khác
$password = ''; // Thay đổi nếu có mật khẩu
$database = 'webBanVe'; // Thay đổi tên database của bạn

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die('Kết nối thất bại: ' . mysqli_connect_error());
}
// echo 'Kết nối thành công';

?>