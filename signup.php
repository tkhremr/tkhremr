<?php
  // データの受け取り
  $name = $_POST["name"];
  $pass = $_POST["pass"];
  $watchword = $_POST["watchword"]; 

  if (@$_POST["name"] && @$_POST["pass"] && @$_POST["watchword"]) {
    // 必須項目チェック（名前か本文が空ではないか？）
    if ($name == '' || $pass == '') {
      header('Location: signup.php'); // signup.phpへ移動
      exit(); // 終了
    }
    // 必須項目チェック（合言葉が正しいか？）
    if ($watchword == "watchword") {
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
        $stmt = $pdo->prepare("INSERT INTO users (name, password) VALUES (:name, :password)");
        // パラメータを割り当て
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        // クエリの実行
        $stmt->execute();
      } catch (PDOException $e) {
        die ('エラー:' . $e->getMessage());
      }
      print "ユーザ登録が完了しました。\n";
    } else {
      print "合言葉が正しくありません。\n";
    }
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

  <h2>新規登録</h2>
  <form action="signup.php" method="post">
    <p>ユーザ名：<input type="text" name="name"></p>
    <p>パスワード：<input type="text" name="pass"></p>
    <p>合言葉：<input type="password" name="watchword"></p>
    <p><input type="submit" value="新規登録"></p>
  </form>

  <p>
    <a href="login.php">ログインはこちらから ＞＞</a>
  </p>

</body>
</html>
