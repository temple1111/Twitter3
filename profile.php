<?php
  //ログインしているかチェック
  require('login_check.php');
  //データベースに接続する
  require_once 'dbconnect.php';
  //自身のidを取得
  $self_id = $_SESSION['user_id'];
  $obj = new dbconnect();

  /*ログインしているアカウントがフォローしている
    アカウントを表示*/
  function display_following_name($self_id){
    $obj = new dbconnect();
    //フォローしているアカウントのidを取得
    $sql = "SELECT * FROM followers WHERE user_id = :user_id";
    $get_following_id = $obj->get_following_id($sql,$self_id);
    foreach ($get_following_id as $item) {
      $get_following_id = $item['following_id'];
      if(convert_followedid_name($get_following_id) != null){
        echo htmlspecialchars(convert_followingid_name($get_following_id),ENT_QUOTES, "UTF-8").'<br>';
      }else{
        echo '退会したアカウント<br>';
      }
    }
  }

  //$get_following_idをアカウントが保持しているnameに変換するメソッド
  function convert_followingid_name($following_id){
    $obj = new dbconnect();
    //$following_idと同じidを持つユーザーアカウントのnameを取得
    $sql = "SELECT * FROM users WHERE id = :id";
    $get_name_exec = $obj->get_name_exec($sql,$following_id);
    foreach($get_name_exec as $item){
      return $item['name'];
    }
  }
  /*ログインしているアカウントのことをフォローしている
  アカウントを表示*/
  function display_followed_name(){
    $self_id = $_SESSION['user_id'];
    $obj = new dbconnect();
    /*followersテーブルから現在ログインしているアカウント
    をフォローしているアカウントのuser_idを取得*/
    $sql = "SELECT * FROM followers WHERE user_id != :user_id AND following_id = :following_id";
    $get_followed_id = $obj->get_followed_id($sql,$self_id);
    foreach ($get_followed_id as $item) {
      $get_followed_id = $item['user_id'];
      if(convert_followedid_name($get_followed_id) != null){
        echo htmlspecialchars(convert_followedid_name($get_followed_id),ENT_QUOTES, "UTF-8").'<br>';
      }else{
        echo '退会したアカウント<br>';
      }
    }
  }
  /*現在ログインしているアカウントをフォローしている
  アカウントのnameを取得*/
  function convert_followedid_name($followed_id){
    $obj = new dbconnect();
    //$followed_idと同じidを持つアカウントのnameを表示する
    $sql = "SELECT * FROM users WHERE id = :id";
    $get_name_exec = $obj->get_name_exec($sql,$followed_id);
    foreach($get_name_exec as $item){
      return $item['name'];
    }

  }
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300&display=swap" rel="stylesheet">
    <title>プロフィール</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <p>フォローリスト</p><br>
            <p><?php
              echo display_following_name($self_id);
             ?></p><br>
            <p>フォロワーリスト</p><br>
            <p><?php
              echo display_followed_name();
             ?></p>
           </div>
           <div class="text-center">
             <br><a class="btn btn-outline-primary btn-lg" href="index.php">Homeに戻る</a>
           </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
