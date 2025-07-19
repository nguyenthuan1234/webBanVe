<?php
    session_start();
    session_unset(); 
    session_destroy(); 

    header("Location:/Banve/web/dangnhap.html"); 
    exit();
    
?>