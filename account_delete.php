<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除画面</title>
  </head>
  <body>
    <?php
      require('login_check.php');
      //データベースに接続する
      require_once 'dbconnect.php';
      $obj = new dbconnect();
      $email = $_POST['email'];
      $password = $_POST['password'];

      //SESSION情報と照らし合わせて一致したらアカウントを削除する
      if(($email == $_SESSION['email']) AND ($password == $_SESSION['password'])){
        //データベースからツイートを削除
        $sql = "DELETE FROM tweets WHERE user_id = :user_id";
        $delete_tweet_db = $obj->delete_tweet_db($sql,$_SESSION['user_id']);
        //データベースからリプライを削除
        $sql = "DELETE FROM reply WHERE reply_user = :reply_user";
        $delete_reply_db = $obj->delete_reply_db($sql,$_SESSION['user_id']);
        //データベースからアカウントを削除
        $sql = "DELETE FROM users WHERE email = :email AND password = :password";
        $delete_account_db = $obj->delete_account_db($sql,$_SESSION['email'],$_SESSION['password']);
        echo 'アカウントの削除が完了しました。<br>';
        echo '<a href="login.php">ログインフォームへ</a>';
      }else{
        //入力された情報が間違っている場合
        echo '<p>入力されたアカウント情報が間違っています</p>';
        echo '<a href="account_delete_form.php">フォームへ戻る</a>';
      }
     ?>
  </body>
</html>
