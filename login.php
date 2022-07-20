<!-- CSRF対策 -->
<?php
session_start();
$toke_byte = openssl_random_pseudo_bytes(16);
$csrf_token = bin2hex($toke_byte);
// 生成したトークンをセッションに保存します
$_SESSION['csrf_token'] = $csrf_token;
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
    <title>ログイン画面</title>
  </head>
  <body>
    <section id="login_form">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
              <h2>ユーザー情報を入力して下さい</h2>
            </div>
            <form action="session.php" method="post">
              <div class="form-group row">
                <label for="inputName" class="col-sm-12 col-md-2 col-form-label"><p>ユーザー名</p></label>
                <div class="col-sm-12 col-md-10">
                  <input type="text" class="form-control" name="username" id="inputName">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail" class="col-sm-12 col-md-2 col-form-label"><p>Eメール</p></label>
                <div class="col-sm-12 col-md-10">
                  <input type="email" class="form-control" id="inputEmail" name="email">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-12 col-md-2 col-form-label"><p>パスワード</p></label>
                <div class="col-sm-12 col-md-10">
                  <input type="password" class="form-control" id="inputPassword" placeholder="4桁の半角数字" name="password">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 offset-md-2 col-md-10">
                  <button type="submit" class="btn btn-outline-primary btn-block"><p>ログイン</p></button>
                  <a class="btn btn-outline-secondary btn-block" href="register.php">新規登録はこちら</a>
                </div>
              </div>
              <input type='hidden' name="csrf_token" value="<?=$csrf_token?>">
            </form>
          </div>
        </div>
      </div>
    </section>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
