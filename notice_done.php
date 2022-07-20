<?php
  require('login_check.php');
  $my_id = $_SESSION['user_id'];
  //UPDATEを使用して、user_idが$my_idのfollow_checkとreply_chekiをfalseにする
  try {
    $pdo = new PDO('mysql:dbname=twitter_clone;host=127.0.0.1;charset=utf8',
    'root','');
    $sql = "UPDATE notice SET follow_check = :follow_check , reply_check = :reply_check WHERE user_id != '".$my_id."' AND (following_id = '".$my_id."' OR reply_user = '".$my_id."')";
    $statement = $pdo->prepare($sql);
    $params = array(':follow_check'=>false,':reply_check'=>false);
    $statement->execute($params);
  } catch (PDOException $e) {
    exit('データベース接続失敗:' . $e->getMessage());
  }
  header('Location:notice_check.php');
 ?>
