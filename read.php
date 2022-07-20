<?php
  require('login_check.php');
 ?>
<?php
  //データベースに接続する
  require_once 'dbconnect.php';
  $obj = new dbconnect();
  //投稿者のidを取得
  $get_user_id = $_SESSION['user_id'];
  //create.phpでPOSTされた内容を取得
  $message = $_POST['message'];
  //tweetsテーブルにPOSTされた$messageをINSERTする
  $sql = "INSERT INTO tweets(created_at,tweet,user_id) VALUES (NOW(),:tweet,:user_id)";
  $insert_message = $obj->insert_message($sql,$message,$get_user_id);
  //index.phpに遷移
  header('Location: index.php');
 ?>
