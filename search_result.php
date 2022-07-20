<?php
  //ログインしているかチェック
  require('login_check.php');
  //データベースに接続する
  require('dbconnect.php');

  function display_result(){
      $obj = new dbconnect();
      $search_word = htmlspecialchars($_POST['search_word']);
      if($search_word == ""){
        //入力フォームが空だった場合
        echo "検索語句を入力してください。";
      }else{
        //語句が入力されていた場合
        $sql = "SELECT * FROM tweets WHERE tweet
        LIKE '%$search_word%' ORDER BY id DESC";
        $items = $obj->select($sql);
        foreach($items as $item){
          echo '<p>'.htmlspecialchars($item['tweet'], ENT_QUOTES, "UTF-8").'<p>';
          echo ':';
          echo '<p>'.htmlspecialchars($item['created_at'], ENT_QUOTES, "UTF-8").'</p><br>';
        }
      }
  }
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
    <title>検索結果</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php echo display_result();?>
          <a class="btn btn-outline-primary btn-block" href="search_input.php">検索画面に戻る</a>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
