<?php
//menyertakan file koneksi.php
require('../koneksi.php');
//inisialisasi session
session_start();

$error = '';
$validate = '';

//mengecek apakah session username tersedia atau tidak
if (isset($_SESSION['username'])) header('Location: ../index.php');

//mengecek apakah form disubmit atau tidak
if (isset($_POST['submit'])) {
    //menghilangkan backslash
    $username = stripslashes($_POST['username']);
    //cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    $captcha = $_POST['inputcaptcha'];

    if (!empty(trim($username)) && !empty(trim($password))) {
        // select data berdasarkan username dari database
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);

        if ($rows != 0) {
            $hash = mysqli_fetch_assoc($result)['password'];
            if (password_verify($password, $hash)) {
                if ($_SESSION['code'] != $captcha) {
                    $error = 'kode captcha salah';
                } else { // jika captcha benar, maka perintah yang bawah akan dijalankan
                    $_SESSION['username'] = $username;
                    echo "
                        <script>
                            alert('Selamat Datang')
                            document.location.href = '../index.php'
                        </script>
                    ";
                    // header('Location: index.php');
                }
            } else {
                $error = 'Password salah !!';
            }
            //jika gagal maka akan menampilkan pesan error
        } else {
            $error = 'Username tidak di temukan !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css//style.css">

    <title>Sistem Kepangkatan Login</title>
</head>

<body>
    <div class="container">
        <form action="login.php" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>

            <?php if ($error != '') { ?>
            <div class="alert alert-danger" role="alert"><?= $error; ?></div>
            <?php } ?>

            <div class="input-group">
                <input type="username" placeholder="username" name="username" required>
            </div>
            <div class="input-group">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group">
                <img src="captcha.php" alt="kode Captcha" class="mb-3" id="kodecaptcha">
            </div>
            <div class="input-group">
                <input type="text" class="form-control" id="in putcaptcha" name="inputcaptcha" required autocomplete="">
            </div>
            <div class="input-group">
                <button name="submit" class="btn">Login</button>
            </div>
            <!-- <p class="login-register-text">Anda belum punya akun? <a href="register.php">Register</a></p> -->
            <div class="login-register-text">
                <p>Belum punya account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYD1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>