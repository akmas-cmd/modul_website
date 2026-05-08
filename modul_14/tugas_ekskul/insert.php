<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            margin-top: 10px;
        }

        td {
            padding: 5px;
        }

        input[type="text"] {
            width: 200px;
        }

        textarea {
            width: 643px;
            height: 60px;
        }

        .radio-group {
            display: flex;
            gap: 10px;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        select[multiple] {
            height: 100px;
        }

        .button-row input {
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <a href="tampil.php">Kembali ke Daftar</a>
    <h2>Pendaftaran Ekstrakurikuler</h2>

    <?php
    include "koneksi.php";

    if (isset($_POST['submit'])) {
        $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
        $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
        $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
        $kota = mysqli_real_escape_string($koneksi, $_POST['kota']);
        $jk = mysqli_real_escape_string($koneksi, $_POST['jk']); // 'Laki-Laki' atau 'Perempuan'
        $hobi = isset($_POST['hobby']) ? implode(", ", $_POST['hobby']) : '';
        $ekskul = isset($_POST['ekskul']) ? implode(", ", $_POST['ekskul']) : '';

        $query = "INSERT INTO tb_siswa (nis, nama, kelas, ttl, alamat, kota, jk, hobi, ekskul)
              VALUES ('$nis', '$nama', '$kelas', '$tgl', '$alamat', '$kota', '$jk', '$hobi', '$ekskul')";
        $hasil = mysqli_query($koneksi, $query);

        if ($hasil) {
            echo "<p style='color:green;'>Data berhasil disimpan! <a href='tampil.php'>Lihat Data</a></p>";
        } else {
            echo "<p style='color:red;'>Gagal: " . mysqli_error($koneksi) . "</p>";
        }
    }
    ?>

    <form action="" method="post">
        <table>
            <tr>
                <td>NIS</td>
                <td><input type="text" name="nis" required></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" required></td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>
                    <select name="kelas" required>
                        <option value="X" selected>X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tgl Lahir</td>
                <td>
                    <input type="text" name="tgl" maxlength="2" required> /
                    <input type="text" name="bln" maxlength="2" required> /
                    <input type="text" name="thn" maxlength="4" required>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><textarea name="alamat" required></textarea></td>
            </tr>
            <tr>
                <td>Kota</td>
                <td><input type="text" name="kota" required></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td class="radio-group">
                    <label><input type="radio" name="jk" value="Laki-Laki" required> Laki-Laki</label>
                    <label><input type="radio" name="jk" value="Perempuan"> Perempuan</label>
                </td>
            </tr>
            <tr>
                <td>Hobby</td>
                <td class="checkbox-group">
                    <label><input type="checkbox" name="hobby[]" value="Membaca"> Membaca</label>
                    <label><input type="checkbox" name="hobby[]" value="Olahraga"> Olahraga</label>
                    <label><input type="checkbox" name="hobby[]" value="Menyanyi"> Menyanyi</label>
                    <label><input type="checkbox" name="hobby[]" value="Menari"> Menari</label>
                    <label><input type="checkbox" name="hobby[]" value="Travelling"> Travelling</label>
                </td>
            </tr>
            <tr>
                <td>Pilihan Ekskul</td>
                <td>
                    <select name="ekskul[]" multiple required>
                        <option value="Pramuka">Pramuka</option>
                        <option value="Basket">Basket</option>
                        <option value="Volly">Volly</option>
                        <option value="Band">Band</option>
                        <option value="Seni Tari">Seni Tari</option>
                        <option value="Robotic">Robotic</option>
                        <option value="Bulu Tangkis">Bulu Tangkis</option>
                    </select>
                </td>
            </tr>
            <tr class="button-row">
                <td colspan="2">
                    <input type="submit" name="submit" value="KIRIM">
                    <input type="reset" value="CANCEL">
                </td>
            </tr>
        </table>
    </form>

</body>

</html>