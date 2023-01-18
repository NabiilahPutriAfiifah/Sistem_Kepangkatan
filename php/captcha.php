<?php
session_start();
function acakCaptcha()
{
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';

    //untuk menyatakan $pass sebagai array
    $pass = array();

    //masukan -2 dalam string length
    $panjangAlpha = strlen($alphabet) - 2;
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangAlpha);
        $pass[] = $alphabet[$n];
    }

    //ubah array string
    return implode(($pass));
}

//untuk mengacak captcha
$code = acakCaptcha();
$_SESSION['code'] = $code;

//lebar dan tinggi captcha
$wh = imagecreatetruecolor(173, 50);

//background color captcha
$bgc = imagecolorallocate($wh, 24, 41, 88);

//text color
$fc = imagecolorallocate($wh, 223, 230, 233);

imagefill($wh, 0, 0, $bgc);

//($image, $fontsize, $string, $fontcolor)  
imagestring($wh, 10, 50, 15, $code, $fc);

//buat gambar
header('content-type: image/jpg');
imagejpeg($wh);
imagedestroy($wh);