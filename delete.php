<?php
  include 'includes/login.php';
  // データの受け取り
  $id = intval($_POST['id']);
  $pass = $_POST['pass'];

  // 必須項目チェック
  if ($id == '' || $pass == '') {
    header('Location: bbs.php'); // bbs.phpへ移動
    exit(); // 終了
  }

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
    $stmt = $pdo->prepare("DELETE FROM mission_6 WHERE id=:id AND pass=:pass");
    // パラメータを割り当て
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    // クエリの実行
    $stmt->execute();
  } catch (PDOException $e) {
    echo "エラー:" . $e->getMessage();
  }
  // bbs.phpに戻る
  header('Location: bbs.php');
  exit(); // 終了
?>
