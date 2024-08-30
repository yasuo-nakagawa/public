<?php
session_start();
//セッションIDを推測されてしまう値に設定しない
//echo session_id();
session_regenerate_id(true); // 新しい、セッションIDを生成する
echo session_id(); // 上のセッションIDとは違うIDが生成されます

if(isset($_SESSION['count'])) {
  $count = $_SESSION['count'];
} else {
  $count = 0;
}
 
echo "更新回数" . $count . "回"; 
$count++;
$_SESSION['count'] = $count;


// defineの値は環境によって変えてください。.
define('HOSTNAME', 'db');
define('DATABASE', 'database');
define('USERNAME', 'db-user');
define('PASSWORD', 'db-pass');

try {
  /// DB接続を試みる
  $db  = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DATABASE, USERNAME, PASSWORD);
  $msg = "MySQL への接続確認が取れました。";

  //SQLインジェクション↓ダメな例
  // $sql = 'select * from test';
  // foreach ($db->query($sql) as $row) {
  //     print($row['test_name']);
  //     print($row['test_add'].'<br>');
  // }

  //SQLインジェクション対策(プリペアドステートメント)
  $stmt = $db->prepare('SELECT * FROM test WHERE test_id = :test_id');
  $stmt->bindValue(':test_id', 1, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetchAll();
  foreach ($data as $row) {
    print($row['test_name']);
    print($row['test_add'].'<br>');
}




} catch (PDOException $e) {
  $isConnect = false;
  $msg       = "MySQL への接続に失敗しました。<br>(" . $e->getMessage() . ")";
}
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>色々テスト</title>
  </head>
  <body>
    <p><?php echo $msg; ?></p>
    <a href="destroy.php">セッション破棄する</a>
  </body>
</html>