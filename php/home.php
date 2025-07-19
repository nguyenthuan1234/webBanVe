<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header("Location: /Banve/web/dangnhap.html");
        exit();
    }
?>