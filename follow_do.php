<?php
  //ログインしているかのチェック
  require('login_check.php');
  $follow_id = $_GET['id'];
  $my_id = $_SESSION['user_id'];
  //データベース接続
  require_once 'dbconnect.php';
  $obj = new dbconnect();
  $check_insert_sql = 'INSERT INTO notice(created_at,user_id,follow_check,following_id) VALUES (NOW(),:user_id,true,:following_id)';
  $check_exec = $obj->checksqlfollow($check_insert_sql,$my_id,$follow_id);
  //noticeテーブルのuser_idに$my_id,follow_checkにtrueをINSERTする。
  $self_id = $_SESSION['user_id'];
  //フォローする相手のidをfollowing_idにINSERTする
  $id_insert_sql = 'INSERT INTO followers(following_id,user_id) VALUES (:following_id,:user_id)';
  $insert_exec = $obj->id_insert($id_insert_sql,$follow_id,$self_id);
  //index.phpに戻る
  header('Location:index.php');
 ?>
