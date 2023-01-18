<?php
    $db_host = 'localhost'; //server
    $db_user = 'root'; //username
    $db_pass = ''; //password
    $db_name = 'sistem_kepangkatan_uas'; //nama database
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn){
        die ('Gagal terhubung dengan database MySQL : ' . mysqli_connect_error());
    }
?>