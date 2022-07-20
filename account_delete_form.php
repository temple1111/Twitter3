<?php
  //ログインしているかチェック
  require('login_check.php');
  //データベースに接続する
  require('dbconnect.php');
  $obj = new dbconnect();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <title>アカウント削除画面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <h3>アカウント情報を記入して下さい</h3>
            <h3>※ツイートも削除されます</h3>
            <form action="account_delete.php" method="post">
              <div class="form-group row">
               <br><label for="inputEmail" class="col-sm-12 col-lg-2 col-form-label">Eメール</label>
               <div class="col-sm-12 col-lg-10">
                 <input type="email" class="form-control" id="inputEmail" name="email" required>
               </div>
             </div>
             <div class="form-group row">
               <label for="inputPassword" class="col-sm-12 col-lg-2 col-form-label">パスワード</label>
               <div class="col-sm-12 col-lg-10">
                 <input type="password" class="form-control" id="inputPassword" placeholder="4桁の半角数字" name="password" required>
               </div>
             </div>
             <div class="form-group row">
               <div class="col-sm-12 offset-lg-2 col-lg-10">
                 <button type="submit" class="btn btn-outline-danger btn-block">アカウント削除</button><br>
                 <div class="text-center">
                   <a class="btn btn-outline-secondary btn-block" href="index.php">メイン画面へ</a>
                 </div>
               </div>
             </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
