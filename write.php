<?php
  include 'includes/login.php';
  // データの受け取り
  $name = $_POST["name"];
  $title = $_POST["title"];
  $body = $_POST["body"];
  $pass = $_POST["pass"];

  // 必須項目チェック（名前か本文が空ではないか？）
  if ($name == '' || $body == '') {
    header('Location: bbs.php'); // bbs.phpへ移動
    exit(); // 終了
  }
  // 必須項目チェック（パスワードは4桁の数字か？）
  if (!preg_match("/^[0-9]{4}$/", $pass)) {
    header('Location: bbs.php'); // bbs.phpへ移動
    exit(); // 終了
  }
  // 名前をクッキーにセット
  setcookie('name', $name, time() + 60 * 60 * 24 * 30);
  // データベースに接続
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';

  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // プリペアドステートメントを作成
    $stmt = $pdo->prepare("INSERT INTO mission_6 (name, title, body, date, pass) VALUES (:name, :title, :body, now(), :pass)");
    // パラメータを割り当て
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    // クエリの実行
    $stmt->execute();

    //bbs.phpに戻る
    header('Location: bbs.php');
    exit(); // 終了
  } catch (PDOException $e) {
    die ('エラー:' . $e->getMessage());
  }
?>