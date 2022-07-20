<?php
  //ログインしているかチェックする
  require('login_check.php');
  $tweet_id = $_GET['tweet_id'];
  //データベースに接続する
  require_once 'dbconnect.php';
  $obj = new dbconnect();
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
    <title>返信投稿</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2><?php
          //返信したいtweetの文章を表示
          $sql = 'SELECT * FROM tweets WHERE id = :id';
          // $sql = "SELECT * FROM tweets WHERE id = '".$tweet_id."'";
          $items = $obj->plural($sql,$tweet_id);
          foreach($items as $item){
            echo htmlspecialchars($item['tweet'], ENT_QUOTES, "UTF-8");
            echo ' に対して返信します。';
          }
           ?></h2>
          <form action="response_do.php" method="post">
            <div class="mb-3">
              <label for="validationTextarea">テキストエリア</label>
              <textarea class="form-control" id="validationTextarea" rows="8" placeholder="返信を入力してください" name="reply_message" required></textarea>
              <div class="invalid-feedback">
                テキストエリアにメッセージを入力してください。
              </div>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <button class="btn btn-outline-primary btn-block" type="submit" class="btn btn-primary">返信</button>
              </div>
            </div>
            <input type="hidden" name="original_tweet_id" value=
            "<?php echo htmlspecialchars($tweet_id, ENT_QUOTES, "UTF-8"); ?>">
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
