<?php
session_start();

if (!isset($_SESSION['namauser'])) {
  echo "Anda belum login";
  exit;
}
?>