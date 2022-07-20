<?php
  //ログインしているかチェック
  require('login_check.php');
  $user_id = $_SESSION['user_id'];
  //データベースに接続
  require_once 'dbconnect.php';
  //noticeのfollow_ckeck or reply_checkがtrueの件数を取得して返す
  function count_notice($my_id){
    $obj = new dbconnect();
    //noticeのfollow_ckeck or reply_checkがtrueの件数を取得して返す
    $sql = "SELECT * FROM notice WHERE user_id != :user_id AND ( reply_check = true AND reply_user = :reply_user) OR (follow_check = true AND following_id = :following_id)";
    $count_notice_var = $obj->count_notice_func($sql,$my_id);
    return $count_notice_var;
  }

  //リプライしてきたidを取得
  function notice_reply($my_id){
    $obj = new dbconnect();
    //リプライしてきたidを取得
    $sql = "SELECT * FROM notice WHERE user_id != :user_id AND reply_check = true AND reply_user = :reply_user";
    $get_reply_id = $obj->get_reply_id($sql,$my_id);
    foreach ($get_reply_id as $item) {
      if(id_convert_name($item['user_id']) != null){
        echo htmlspecialchars(id_convert_name($item['user_id']), ENT_QUOTES, "UTF-8").'さんからリプライがありました。<br>';
      }else{
        echo '【退会したアカウント】からリプライがありました。<br>';
      }
    }
  }
  //フォローしてきたidを取得
  function notice_follow($my_id){
    $obj = new dbconnect();
    $sql = "SELECT * FROM notice WHERE user_id != :user_id AND follow_check = true AND following_id = :following_id";
    $get_follow_id = $obj->get_follow_id($sql,$my_id);
    foreach($get_follow_id as $item){
      if(id_convert_name($item['user_id']) != null){
        echo htmlspecialchars(id_convert_name($item['user_id']), ENT_QUOTES, "UTF-8").'さんからフォローされました。<br>';
      }else{
        echo '【退会したアカウント】からフォローされました。<br>';
      }
    }
  }
  //idをアカウント名に変換する関数
  function id_convert_name($id){
    $obj = new dbconnect();
    $sql = "SELECT * FROM users WHERE id = :id";
    $get_name_exec = $obj->get_name_exec($sql,$id);
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
    <title>通知確認</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <h2><?php
              $display_notice_number = count_notice($user_id);
              if($display_notice_number == 0){
                echo '最新の通知はありません。';
              }else{
                echo htmlspecialchars($display_notice_number, ENT_QUOTES, "UTF-8").'件の新規通知があります。';
              }
             ?></h2>
            <p>新規通知</p><br>
            <p><?php
                //新規リプライが存在する場合
                if(empty(notice_reply($user_id))){
                //処理を実行する
                }else{
                  //何もしない。
                }
             ?></p>
             <p><?php
                 //新規リプライが存在する場合
                 if(empty(notice_follow($user_id))){
                   //処理を実行する
                 }else{
                   //何もしない。
                 }
              ?></p>
            <a class="btn btn-outline-info btn-block" href="notice_done.php">チェック済みにする</a>
            <a class="btn btn-outline-primary btn-block" href="index.php">Homeに戻る</a>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
