<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'db_biodata';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    echo 'Koneksi gagal: ' . mysqli_connect_error();
    exit(1);
}
$res = mysqli_query($conn, 'DESCRIBE tb_siswaa');
if (!$res) {
    echo 'Error: ' . mysqli_error($conn);
    exit(1);
}
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . '|' . $row['Type'] . '|' . $row['Null'] . '|' . $row['Key'] . '|' . $row['Default'] . "\n";
}
