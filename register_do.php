<?php
//CSRF対策
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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300&display=swap" rel="stylesheet">
    <title>会員登録判定ページ</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <?php
            //データベースに接続する
            require('dbconnect.php');
            $obj = new dbconnect();
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $input_check = true;
            /*ログインエラーが発生した場合の
            シチュエーションによる場合分けの変数*/
            $error_case = 0;
            //$error_case = 0 の場合は何もしない（ログイン）
            /*
            ログイン成功->0
            パスワード間違い->1
            メールアドレス間違い->2
            */
            $error_case = 0;

            //$input_check=trueの場合はチェックする。
            if($input_check == true){
              //パスワードのチェック
              if(preg_match("/^[0-9]{4}+$/",$password)){
                //ログインする
                //SESSIONへのユーザー情報の登録とデータベースへのINSERTを行う
                $sql = "SELECT * FROM users WHERE email = :email";
                $account = $obj->verify_account($sql,$email);
                if($account >= 1){
                  $input_check = false;
                  $error_case = 2;
                  login_status($error_case,$username,$email);
                }

                //$input_check=trueの場合にINSERTする。
                if($input_check == true){
                  //INSERTする。
                  $sql = 'INSERT INTO users(name,email,password,created_at) VALUES (:name,:email,:password,NOW())';
                  $register_do = $obj->register_do($sql,$username,$email,$password);
                  //セッション開始
                  $_SESSION['name'] = $username;
                  $_SESSION['email'] = $email;
                  $_SESSION['password'] = $password;

                  //$_SESSION['user_id']にログインしているアカウントのidを代入
                  $sql = "SELECT * FROM users WHERE email = :email AND name = :name";
                  $get_this_id = $obj->get_this_id($sql,$email,$username);
                  foreach ($get_this_id as $item) {
                    $_SESSION['user_id'] = $item['id'];
                  }
                  //index.phpに遷移
                  $error_case = 0;
                  echo login_status($error_case,$username,$email);
                }else{
                  //何もデータベースに挿入しない
                  //ログイン失敗のため
                }

              }else{
                //パスワードの入力ミス
                $error_case = 1;
                echo login_status($error_case,$username,$email);
              }
            }

            function login_status($error_case,$username,$email){
              switch ($error_case) {
                //ログイン成功のため、登録したname,email,passwordを表示
                case 0:
                echo 'ユーザー名：'.$username.'<br>';
                echo 'メールアドレス：'.$email.'<br>';
                echo 'パスワード：****<br>';
                echo 'にて登録完了しました。<br>';
                echo '<a href="index.php" class="btn btn-outline-primary">メイン画面へ</a>';
                  break;
                //passwordの入力ミス
                case 1:
                echo 'パスワードは4桁の半角数字で入力してください。<br>';
                echo '<a href="register.php" class="btn btn-outline-primary">戻る</a>';
                  break;
                //emailの入力ミス
                case 2:
                echo 'メールアドレス'.$email.'は既に登録されています。<br>';
                echo '<a href="register.php" class="btn btn-outline-primary">戻る</a>';
                  break;
                //どれにも当てはまらないエラーの場合
                default:
                  header('Location:register.php');
                  break;
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
     <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
     <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
