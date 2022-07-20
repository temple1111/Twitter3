<?php
session_start();
if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
  //正常処理
} else {
  //CSRF攻撃が発生
  echo '不正ログインです。';
  exit;
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ログイン判定</title>
  </head>
  <body>
    <p><?php
      $name = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      //データベース接続ファイル
      require_once 'dbconnect.php';
      $obj = new dbconnect();
      $sql = "SELECT * FROM users WHERE email = :email AND password = :password AND name = :name";
      $account = $obj->count_account($sql,$email,$password,$name);
      //データベース内にアカウントが存在した場合
      if($account == 1){
        //ログイン成功
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        //ユーザーidを取得してsessionに保存
        $sql = "SELECT * FROM users WHERE email = :email AND name = :name";
        $get_id = $obj->get_own_id($sql,$email,$name);
        foreach($get_id as $item){
            $_SESSION['user_id'] = $item['id'];
        }
        //index.phpに遷移
        header("Location:index.php");
      }else{
        //ログイン失敗
        echo 'パスワードおよびメールアドレスが間違っています。<br>';
        echo '<a href="login.php">戻る</a>';
      }
    ?></p>
  </body>
</html>
