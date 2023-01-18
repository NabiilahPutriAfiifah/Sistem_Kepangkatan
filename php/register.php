    <?php
    // menyertakan file program koneksi.php kepada register
    require('../koneksi.php');

    //inisialisasi session
    session_start();

    $error = '';
    $validate = '';

    if (isset($_SESSION['user'])) header('location:../index.php');

    //mengecek apakah data username yang di input kosong atau tidak
    if (isset($_POST['submit'])) {
        //menghilangkan backslash
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($conn, $username);
        $name = stripslashes($_POST['name']);
        $name = mysqli_real_escape_string($conn, $name);
        $email = stripslashes($_POST['email']);
        $email = mysqli_real_escape_string($conn, $email);
        $password = stripslashes($_POST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        $repass = stripslashes($_POST['repassword']);
        $repass = mysqli_real_escape_string($conn, $repass);

        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))) {
            //mengecek apakah password sama dengan repassword yang diketikan
            if ($password == $repass) {
                //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar apa belum
                if (cek_nama($name, $conn) == 0) {
                    //hashing password sebelum disimpan di database
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    //insert data kedalam database
                    $query = "INSERT INTO user (name, username, email, password ) VALUES ('$name', '$username', '$email', '$pass')";
                    $result = mysqli_query($conn, $query);
                    //jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan data username ke session
                    if ($result) {
                        $_SESSION['username'] = $username;
                        header('Location: ../index.php');

                        //jika gagal maka akan menampilkan pesar enror
                    } else {
                        $error = 'Register User Gagal !!';
                    }
                } else {
                    $error = 'Username Tidak Terdaftar !!';
                }
            } else {
                $validate = 'Password Tidak Sama !!';
            }
        } else {
            $error = 'Data Tidak Boleh Kosong !!';
        }
    }

    //fungsi untuk mengecek username apakah sudah terdaftar atau belum
    function cek_nama($username, $conn)
    {
        $nama = mysqli_real_escape_string($conn, $username);
        $query = "SELECT * FROM user WHERE username = '$nama'";
        if ($result = mysqli_query($conn, $query)) return mysqli_num_rows($result);
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../assets/css//style.css">

        <title>Sistem Kepangkatan Register</title>
    </head>

    <body>
        <div class="container">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
                <div class="input-group">
                    <input type="text" placeholder="name" name="name" required>
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Confirm Password" name="repassword" required>
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Register</button>
                </div>
                <p class="login-register-text">Anda sudah punya akun? <a href="login.php">Login </a></p>
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