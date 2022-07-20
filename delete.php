<?php
  function delete_tweet(){
    $delete_id = $_GET['id'];
    require_once 'dbconnect.php';
    $obj = new dbconnect();
    $sql = "DELETE FROM tweets WHERE id = :id";
    $delete = $obj->plural($sql,$delete_id);
    echo '<p>削除が完了しました。</p>';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除画面</title>
  </head>
  <body>
    <?php
      echo delete_tweet();
    ?>
    <a href="index.php">Homeに戻る</a>
  </body>
</html>
