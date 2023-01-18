<?php
session_start(); //inisialisasi session

$_SESSION = [];

if (session_destroy()) { //menghapus session
    header("Location: ../index.php"); //jika berhasil maka akan di redirect ke file index.php
}