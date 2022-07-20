<?php
  session_start();
  $_SESSION = array();
  session_destroy();
  echo 'ログアウトしました。<br>';
  echo '<a href="login.php">ログイン画面へ進む</a>';
 ?>
