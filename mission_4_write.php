<?php
  // データの受け取り
  $name = $_POST["name"];
  $comment = $_POST["comment"];
  $editing = $_POST["editing"];
  $pass = $_POST["pass"];

  // 必須項目チェック 
  if ($name == '' || $comment == '' || $pass == '') {
    header('Location: mission_4.php'); // mission_4.phpへ移動
    exit(); // 終了
  }

  if (!empty($_POST["editing"])) {
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
      $stmt = $pdo->prepare("UPDATE mission_4 SET name = '$name', comment = '$comment', pass = '$pass' WHERE id = $editing");
      // クエリの実行
      $stmt->execute();
    } catch (PDOException $e) {
      echo "エラー:" . $e->getMessage();
    }
    //mission_4.phpに戻る
    header('Location: mission_4.php');
    exit(); // 終了
  } else {
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
      $stmt = $pdo->prepare("INSERT INTO mission_4 (name, comment, date, pass) VALUES (:name, :comment, now(), :pass)");
      // パラメータを割り当て
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
      $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
      // クエリの実行
      $stmt->execute();

      //mission_4.phpに戻る
      header('Location: mission_4.php');
      exit(); // 終了
    } catch (PDOException $e) {
      die ('エラー:' . $e->getMessage());
    }
  }
?>