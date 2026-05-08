<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Halaman Form Pendaftaran Ekstrakurikuler</title>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 10px;
        }

        td {
            padding: 5px;
        }

        input[type="text"],
        textarea {
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
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $tgl = $_POST['tgl'];
        $bln = $_POST['bln'];
        $thn = $_POST['thn'];
        $alamat = $_POST['alamat'];
        $kota = $_POST['kota'];
        $jk = $_POST['jk'];
        $hobby = isset($_POST['hobby']) ? implode(", ", $_POST['hobby']) : '';
        $ekskul = isset($_POST['ekskul']) ? implode(", ", $_POST['ekskul']) : '';

        echo "<h2>Data Pendaftaran Berhasil:</h2>";
        echo "NIS: $nis<br>";
        echo "Nama: $nama<br>";
        echo "Kelas: $kelas<br>";
        echo "Tanggal Lahir: $tgl/$bln/$thn<br>";
        echo "Alamat: $alamat<br>";
        echo "Kota: $kota<br>";
        echo "Jenis Kelamin: $jk<br>";
        echo "Hobby: $hobby<br>";
        echo "Pilihan Ekskul: $ekskul<br>";
        echo "<hr>";
    }
    ?>

    <h2>Pendaftaran Ekstrakurikuler</h2>
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
                    <label><input type="radio" name="jk" value="Perempuan" required> Perempuan</label>
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
                <td colspan="2"><input type="submit" value="KIRIM"><input type="reset" value="CANCEL"></td>
            </tr>
        </table>
    </form>
</body>

</html>