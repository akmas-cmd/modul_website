<?php
if (isset($_POST['Pilih'])) {
    $jurusan = $_POST['jurusan'];
    echo "Jurusan Anda salah
    <b><font color='red'>$jurusan</font></b>";
}
?>