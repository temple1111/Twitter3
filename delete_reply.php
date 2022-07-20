<?php
  require('login_check.php');
  function delete_reply(){
    require_once 'dbconnect.php';
    $obj = new dbconnect();
    $delete_reply_id = $_GET['delete_reply_id'];
    $sql = "DELETE FROM reply WHERE id = :id";
    $exec = $obj->plural($sql,$delete_reply_id);
  }

  echo delete_reply();
  
  header('Location:index.php');
 ?>
