<?php
  // データの受け取り
  $id = intval($_POST['id']);
  $pass = $_POST['pass'];

  if (@$_POST["id"] && @$_POST["pass"]) {
    // 必須項目チェック
    if ($id == '' || $pass == '') {
      header('Location: mission_4.php'); // mission_4.phpへ移動
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
      // SQL文を作成
      $sql = "SELECT * FROM mission_4 WHERE id=$id AND pass='$pass'";
      // プリペアドステートメントを作成
      $stmt = $pdo->prepare($sql);
      // SQL文を実行
      $stmt->execute();
      // 結果の取得
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      // 配列に格納
      $t_name = $rec['name'];
      $t_comment = $rec['comment'];
    } catch (PDOException $e) {
      echo "エラー:" . $e->getMessage();
    }
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>ミッション4</title>
</head>
<body>
  <form method="post" action="write.php">
    <input type="text" name="name" placeholder="名前" value="<?php echo $t_name; ?>"><br/>
    <input type="text" name="comment" placeholder="コメント" value="<?php echo $t_comment; ?>"><br/>
    <input type="hidden" name="editing" value="<?php echo $id; ?>">
    <input type="text" name="pass" placeholder="パスワード">
    <input type="submit" value="送信"><br/><br/>
  </form>
  <form method="post" action="delete.php">
    <input type="text" name="id" placeholder="削除対象番号"><br/>
    <input type="text" name="pass" placeholder="パスワード">
    <input type="submit" value="削除"><br/><br/>
  </form>
  <form method="post" action="mission_4.php">
    <input type="text" name="id" placeholder="編集対象番号"><br/>
    <input type="text" name="pass" placeholder="パスワード">
    <input type="submit" value="編集"><br/><br/>
  </form>
<?php
  // データベースに接続
  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn, $user, $password);

  // SQL文を作成
  $sql = 'SELECT * FROM mission_4 WHERE 1 ORDER BY date ASC';
  // プリペアドステートメントを作成
  $stmt = $pdo->prepare($sql);
  // SQL文を実行
  $stmt->execute();

  while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC); // 1レコード取り出し
    if ($rec == FALSE) {
      break; //ループを脱出
    }
    // 1レコード分のデータを表示
    print $rec['id'];
    print $rec['name'];
    print $rec['comment'];
    print $rec['date'];
    print '<br/>';
  }
?>
</body>
</html>