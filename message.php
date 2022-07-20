<?php
//ログインしているかチェック
require('login_check.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>メッセージ作成画面</title>
  </head>
  <body>
    <form action="message_send.php" method="post">
      <textarea name="message" rows="8" cols="80"></textarea>
      <input type="submit" value="送信">
    </form>
  </body>
</html>
