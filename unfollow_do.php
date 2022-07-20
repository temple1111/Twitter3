<?php
  //ログインチェック
  require('login_check.php');
  $unfollow_id = $_GET['id'];
  $my_id = $_SESSION['user_id'];
  //データベース接続
  require_once 'dbconnect.php';
  $obj = new dbconnect();
  //noticeテーブルのフォロー解除したユーザーのfollow_checkをfalseにする
  $sql = "UPDATE notice SET follow_check = false WHERE user_id = :user_id AND following_id = :following_id";
  $execute_sql = $obj->update_notice($sql,$my_id,$unfollow_id);
  //自信のidを取得
  $self_id = $_SESSION['user_id'];
  //フォロー解除したい相手のfollowing_idをデータベースから削除
  $sql = "DELETE FROM followers WHERE following_id = :following_id AND user_id = :user_id";
  $execute_sql = $obj->delete_follow($sql,$unfollow_id,$self_id);
  //index.phpに遷移
  header('Location:index.php');
 ?>
