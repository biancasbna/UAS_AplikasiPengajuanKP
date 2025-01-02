<?php
    $dbCrud = new mysqli ("localhost", "root", "", "kp");

    if(mysqli_connect_errno()){
        echo ("Koneksi Gagal" . mysqli_connect_error());
        exit();
    }
?>