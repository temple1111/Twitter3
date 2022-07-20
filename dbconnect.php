<?php
//.envファイルの読み込み
// require_once 'config.php';
//環境設定ファイルの読み込み
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class dbconnect{
  public $db_name;
  public $db_username;
  public $db_password;
  public $host;
  public $utf;

  public function __construct() {
    $this->db_name = $_ENV['DB_NAME'];
    $this->db_username = $_ENV['DB_USERNAME'];
    $this->db_password = $_ENV['DB_PASSWORD'];
    $this->host = $_ENV['HOST'];
    $this->utf = $_ENV['UTF'];
  }
  //データベースに接続する関数
  public function pdo(){
    // $dsn="mysql:dbname=".self::$this-db_name.";host=".self::HOST.";charset=".self::UTF;
    $dsn = "mysql:host=$this->host;dbname=$this->db_name";
    $user=$this->db_username;
    $pass=$this->db_password;
    $utf=$this->utf;

    try {
      $pdo=new PDO($dsn,$user,$pass);
    } catch (Exception $e) {
      echo 'error'.$e->getMessage();
      die();
    }
    //エラー表示
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $pdo;
    }

  //SELECT文のときに使用する関数。
  function select($sql){
    $hoge=$this->pdo();
    $stmt=$hoge->query($sql);
    $items=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }
  //SELECT,INSERT,UPDATE,DELETE文の時に使用する関数。
  function plural($sql,$item){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':id'=>$item));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function edit($sql,$tweet,$id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':tweet'=>$tweet,':id'=>$id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function checksqlfollow($sql,$user_id,$following_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$user_id,':following_id'=>$following_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function id_insert($sql,$follow_id,$self_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':following_id'=>$follow_id,':user_id'=>$self_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function insert_reply($sql,$reply_from_id,$reply_message,$replied_tweet_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':reply_user'=>$reply_from_id,':reply_message'=>$reply_message,':replied_tweet_id'=>$replied_tweet_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function get_id($sql,$replied_tweet_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':id'=>$replied_tweet_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function insert_check($sql,$reply_from_id,$reply_user){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$reply_from_id,':reply_user'=>$reply_user));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function update_notice($sql,$my_id,$unfollow_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$my_id,':following_id'=>$unfollow_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function delete_follow($sql,$unfollow_id,$self_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':following_id'=>$unfollow_id,':user_id'=>$self_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function count_account($sql,$email,$password,$name){
    $hoge = $this->pdo();
    $stmt = $hoge->prepare($sql);
    $stmt->execute(array(':email'=>$email,':password'=>$password,':name'=>$name));
    $count = $stmt->rowCount();
    return $count;
  }

  function get_own_id($sql,$email,$name){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':email'=>$email,':name'=>$name));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function read_get_id($sql,$email){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':email'=>$email));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function insert_message($sql,$message,$get_user_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':tweet'=>$message,':user_id'=>$get_user_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function get_following_id($sql,$self_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$self_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }
  //$following_idと同じidを持つアカウントのnameを返すメソッド
  function get_name_exec($sql,$following_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':id'=>$following_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function get_followed_id($sql,$self_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$self_id,':following_id'=>$self_id));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }

  function count_notice_func($sql,$my_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$my_id,':reply_user'=>$my_id,':following_id'=>$my_id));
    $count = $stmt->rowCount();//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $count;
  }

  function get_reply_id($sql,$my_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$my_id,':reply_user'=>$my_id));
    return $stmt;
  }

  function get_follow_id($sql,$my_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$my_id,':following_id'=>$my_id));
    return $stmt;
  }

  function verify_account($sql,$email){
    $hoge = $this->pdo();
    $stmt = $hoge->prepare($sql);
    $stmt->execute(array(':email'=>$email));
    $count = $stmt->rowCount();
    return $count;
  }

  function register_do($sql,$username,$email,$password){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':name'=>$username,':email'=>$email,':password'=>$password));
    return $stmt;
  }

  function get_this_id($sql,$email,$username){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':name'=>$username,':email'=>$email));
    return $stmt;
  }

  function check_exec($sql,$target_id,$this_id){
    $hoge = $this->pdo();
    $stmt = $hoge->prepare($sql);
    $stmt->execute(array(':following_id'=>$target_id,'user_id'=>$this_id));
    $count = $stmt->rowCount();
    return $count;
  }

  function get_reply_message($sql,$tweet_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':replied_tweet_id'=>$tweet_id));
    return $stmt;
  }

  function delete_tweet_db($sql,$user_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':user_id'=>$user_id));
    return $stmt;
  }

  function delete_reply_db($sql,$user_id){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':reply_user'=>$user_id));
    return $stmt;
  }

  function delete_account_db($sql,$email,$password){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':email'=>$email,':password'=>$password));
    return $stmt;
  }
}
?>
