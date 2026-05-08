<!DOCTYPE html>
<html>

<head>
    <title>Halaman Login Form Pendaftaran Ekstrakurikuler</title>
</head>

<body>
    <?php
    if (isset($_POST['Login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        if ($user == "guest" && $pass == "guest123") {
            echo "<h2>Login Berhasil</h2>";
            echo "<p><a href='Form_PendaftaranEkstrakurikuler.php'>Lanjut ke Pendaftaran Ekstrakurikuler</a></p>";
        } else {
            echo "<h2>Login Gagal</h2>";
        }
    }
    ?>

    <!-- Form login -->
    <form action="" method="post" name="input">
        <h2>Halaman Login</h2>
        Username : <input type="text" name="username"><br>
        Password : <input type="password" name="password"><br>
        <input type="submit" name="Login" value="Login">
        <input type="reset" name="reset" value="Reset">
    </form>
</body>

</html>