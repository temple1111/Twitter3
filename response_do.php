<?php
  //ログインしているかチェック
  require('login_check.php');
  $reply_text = $_POST['reply_message'];
  //ログインしているユーザーのid
  $reply_from_id = $_SESSION['user_id'];
  //リプライを受けたtweetのid
  $replied_tweet_id = $_POST['original_tweet_id'];
  //データベースに接続
  require_once 'dbconnect.php';
  $obj = new dbconnect();
  //実行するSQL文
  //データベースに$reply_textと$reply_from_idをINSERT
  $sql = 'INSERT INTO reply(reply_user,reply_message,replied_tweet_id) VALUES (:reply_user,:reply_message,:replied_tweet_id)';
  $exec_insert = $obj->insert_reply($sql,$reply_from_id,$reply_text,$replied_tweet_id);

  //replied_tweet_idからreply_userを取得
  $sql = "SELECT * FROM tweets WHERE id = :id";
  $get_id = $obj->get_id($sql,$replied_tweet_id);
  foreach ($get_id as $item) {
    $reply_user = $item['user_id'];
  }

  //noticeテーブルのuser_idに$reply_from_id,reply_checkにtrue,reply_userにリプライしてきたユーザーのidをINSERTする
  $sql = 'INSERT INTO notice(created_at,user_id,reply_check,reply_user) VALUES (NOW(),:user_id,true,:reply_user)';
  //reply_check=trueとして通知を挟む
  $exec_insert_check = $obj->insert_check($sql,$reply_from_id,$reply_user);
  //index.phpに遷移
  header('Location:index.php');
 ?>
