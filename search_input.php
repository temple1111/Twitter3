<?php
  //ログインしているかチェック
  require('login_check.php');
 ?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300&display=swap" rel="stylesheet">
    <title>Tweet検索</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <h2>検索語句を入力して下さい</h2>
            <form action="search_result.php" method="post">
              <div class="mb-3">
                <label for="validationTextarea">テキストエリア</label>
                <textarea class="form-control" id="validationTextarea" rows="8" name="search_word" required></textarea>
                <div class="invalid-feedback">
                  テキストエリアにメッセージを入力してください。
                </div>
              </div>
              <div class="form-group row">
                <div class="col-12">
                  <button type="submit" class="btn btn-outline-primary btn-block">検索</button>
                </div>
              </div>
            </form>
            <a class="btn btn-outline-secondary btn-block" href="index.php">Homeに戻る</a>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
