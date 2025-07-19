<?php 
    include 'connect.php';
    $this_id=$_GET['this_id'];

    $sql = "DELETE FROM movies WHERE id=$this_id";

    mysqli_query($conn,$sql);

    header('location:/Banve/web/trangchu.html');

?>

