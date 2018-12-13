<?php
  session_start(); // セッション開始
  if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
  } 
?>