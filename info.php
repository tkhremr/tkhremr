<?php
  include 'includes/login.php';
  $fp = fopen("info-2.txt", "r"); // ファイルを開く
  $line = array(); // ファイル内容を1行1要素に格納する配列
  // ファイルが正しく開けたとき
  if ($fp) {
    while (!feof($fp)) {
      $line[] = fgets($fp);
    }
    fclose($fp);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>サークル交流サイト</title>
</head>
<body>
  <h1>サークル交流サイト</h1>
  <p><a href="index.php">トップページへ戻る</a></p>
  <h2>お知らせ</h2>
  <?php
    if (count($line) > 0) {
      for ($i = 0; $i < count($line); $i++) {
        if ($i == 0) { // はじめの行はタイトル
          echo '<h3>' . $line[0] . '</h3>';
        } else {
          echo $line[$i] . '<br>';
        }
      }
    } else {
      // ファイルの中身が空だったとき
      echo 'お知らせはありません。';
    }
  ?>
</body>
</html>