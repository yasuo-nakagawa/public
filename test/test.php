<?php
// defineの値は環境によって変えてください。
define('HOSTNAME', 'db');
define('DATABASE', 'database');
define('USERNAME', 'db-user');
define('PASSWORD', 'db-pass');

try {
  /// DB接続を試みる
  $db  = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DATABASE, USERNAME, PASSWORD);
  $msg = "MySQL への接続確認が取れました。";


  $sql = 'select * from test';
  foreach ($db->query($sql) as $row) {
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
    <title>MySQL接続確認</title>
  </head>
  <body>
    <h1>MySQL接続確認</h1>
    <p><?php echo $msg; ?></p>
  </body>
</html>