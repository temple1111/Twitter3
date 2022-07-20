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
    <title>タイムライン</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1p:wght@300&display=swap" rel="stylesheet">
  </head>
  <body>
    <section id="header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-6">
            <p><?php echo 'Name：'.htmlspecialchars($_SESSION['name'], ENT_QUOTES, "UTF-8"); ?></p>
            <p><?php echo 'Email：'.htmlspecialchars($_SESSION['email'], ENT_QUOTES, "UTF-8"); ?></p><br>
            <a class="btn btn-outline-danger btn-sm btn-block" href="account_delete_form.php">退会はこちら</a>
          </div>
          <div id="logout" class="col-lg-12 col-xl-6">
            <li><a class="btn btn-outline-info btn-sm btn-block" href="profile.php">フォロー/フォロワーリスト</a></li>
            <li><a class="btn btn-outline-secondary btn-sm btn-block" href="logout.php">ログアウト</a></li>
          </div>
        </div>
      </div>
    </section>
    <section id="timeline">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-0 col-md-2">
            <!-- レイアウト調整の余白 -->
          </div>
          <div class="col-sm-12 col-md-8">
            <div class="text-center">
              <?php
                echo '<h2>Tweet</h2>';
                //ログインしているアカウントのid
                $this_id = $_SESSION['user_id'];
                //ログインしているアカウントのname
                $this_name = $_SESSION['name'];
                //tweetを全件取得
                $sql = "SELECT * FROM tweets";
                $get_tweet = $obj->select($sql);
                foreach ($get_tweet as $item) {
                  echo '<br>';
                  echo '<p>【投稿】</p>';
                  echo '<p>'.htmlspecialchars(mb_substr($item['tweet'],0,40), ENT_QUOTES, "UTF-8").'</p><br>';
                  //自分のtweetの場合は削除および編集を可能とする
                  if($item['user_id'] == $_SESSION['user_id']){
                    echo edit_tweet($item['id']);
                    echo delete_tweet($item['id']);
                  }
                  echo follow($item['user_id']);
                  if($item['user_id'] != $_SESSION['user_id']){
                    echo response_tweet($item['id']);
                  }
                  echo '<br><p>【投稿者】</p><h4>'.display_name($item['user_id']).'</h4>';
                  // echo '<br><p>【投稿日時】'.$item['created_at'].'</p>';
                  echo '<br>';
                  //リプライがあるか判定して、あれば表示
                  echo htmlspecialchars(reply_check($item['id']), ENT_QUOTES, "UTF-8");
                }
              ?>
              <?php
              function follow($target_id){
              $this_id = $_SESSION['user_id'];
             //フォローしていれば、フォロー解除を返してそれ以外はフォローを返す
             //$target_idはフォローしたい投稿者のid
             //フォローしているかのチェック
             $obj = new dbconnect();
             $sql = "SELECT * FROM followers WHERE following_id = :following_id AND user_id = :user_id";
             $follow_check = $obj->check_exec($sql,$target_id,$_SESSION['user_id']);
             if($target_id == $this_id){
               //自分の投稿だった場合何も表示しない
             }else{

              if($follow_check != 1){
                //フォローしていた場合は$follow_checkに1が入っている。
                 return '<p>  </p><a class="btn btn-outline-primary btn-sm" href="follow_do.php?id='.$target_id.'">フォロー</a>';
              }else if($follow_check == 1){
                return '<p>  </p><a class="btn btn-outline-danger btn-sm" href="unfollow_do.php?id='.$target_id.'">フォロー解除</a>';
              }
            }
           }
           function display_name($post_id){
             $obj = new dbconnect();
             //投稿者のnameを取得
              $sql = "SELECT * FROM users WHERE id = :id";
              $exec_sql = $obj->plural($sql,$post_id);
              foreach ($exec_sql as $item) {
                return $item['name'];
              }
            }

          //編集と投稿を同一アカウントにだけ表示
           function edit_tweet($tweet_id){
             echo '<a class="btn btn-outline-info btn-sm" href="edit.php?id='.$tweet_id.'">編集</a>';
             echo ' ';
           }

           function delete_tweet($tweet_id){
             echo '<a class="btn btn-outline-danger btn-sm" href="delete.php?id='.$tweet_id.'">削除</a>';
           }

           function response_tweet($tweet_id){
             echo '<a class="btn btn-outline-primary btn-sm" href="response.php?tweet_id='.$tweet_id.'">返信</a>';
           }

           //tweetに対してリプライがあれば表示する
           function reply_check($tweet_id){
             $obj = new dbconnect();
             //$tweet_idは現在表示されているtweetのid
             //このidとsqlのreplied_tweet_idを照合して合致すればreply_messageを表示
             $sql = "SELECT * FROM reply WHERE replied_tweet_id = :replied_tweet_id";
             $exec_sql = $obj->get_reply_message($sql,$tweet_id);
             foreach ($exec_sql as $item) {
               echo '<p>|</p><br>';
               echo '<p>【リプライ】</p>';
               echo '<p>'.$item['reply_message'].'</p>';
               echo '<p>【返信者】</p>';
               echo '<p>'.get_name($item['reply_user']).'</p>';
               if($_SESSION['user_id'] == $item['reply_user']){
                 $delete_reply_id = $item['id'];
                 echo '<a class="btn btn-outline-danger btn-sm" href="delete_reply.php?delete_reply_id='.$delete_reply_id.'">削除</a>';
               }
               echo '<br>';
             }
           }

           function get_name($convert_id){
             $obj = new dbconnect();
             $sql = "SELECT * FROM users WHERE id = :id";
             $exec_sql = $obj->plural($sql,$convert_id);
             foreach($exec_sql as $item){
               return $item['name'];
             }
           }

          ?>
        </div>
      </div>
      <div class="col-sm-0 col-md-2">
          <!-- レイアウト調整の余白 -->
      </div>
     </div>
    </div>
    </section>
    <section id="footer">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <br><a class="btn btn-outline-primary btn-lg" href="search_input.php">tweet検索</a>
            <a class="btn btn-outline-secondary btn-lg" href="notice_check.php">通知チェック</a>
            <a class="btn btn-outline-info btn-lg" href="create.php">tweetを投稿</a>
          </div>
        </div>
      </div>
    </section>
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
  </body>
</html>
