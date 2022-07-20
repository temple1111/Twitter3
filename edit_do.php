<?php
  require('login_check.php');
  function edit_tweet(){
    $edit_id = $_POST['id'];
    $edit_tweet = $_POST['edit_tweet'];
    require_once 'dbconnect.php';
    $obj = new dbconnect();
    $sql = "UPDATE tweets SET tweet = :tweet WHERE id = :id";
    $exec = $obj->edit($sql,$edit_tweet,$edit_id);
    echo '<p>編集が完了しました。</p>';
  }
?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>編集完了画面</title>
   </head>
   <body>
     <?php echo edit_tweet(); ?>
     <a href="index.php">Homeへ戻る</a>
   </body>
 </html>
