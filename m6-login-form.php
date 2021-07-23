<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>ログイン画面</title>
 </head>
 
     <?php
         session_start();
         //クロスサイトリクエストフォージェリ（CSRF）対策
             $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
             $token = $_SESSION['token'];
         //クリックジャッキング対策
             header('X-FRAME-OPTIONS: SAMEORIGIN'); 
             
         //4-2以降でも毎回接続は必要。
         //$dsnの式の中にスペースを入れないこと！

         // 【サンプル】
         // ・データベース名：***
         // ・ユーザー名：***
         // ・パスワード：***

         // DB接続設定
         $dsn = 'mysql:dbname=***;host=***';
         $user = '***';
         $password = '***';
         $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
         
         //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
         $sql_pre = "CREATE TABLE IF NOT EXISTS pre_user"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
         . "urltoken varchar(280),"
         . "email varchar(280),"
         . "date DATETIME,"
         . "flag int"
         .");";
         $stmt_pre = $pdo->query($sql_pre);
         
         $sql_user = "CREATE TABLE IF NOT EXISTS user"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
         . "userid int(100),"
         . "email varchar(280),"
         . "username varchar(60),"
         . "password varchar(60),"
         . "status int(1),"
         . "createddate DATETIME,"
         . "updateddate DATETIME"
         .");";
         $stmt_user = $pdo->query($sql_user); 
         
         $sql_password_resets = "CREATE TABLE IF NOT EXISTS password_resets"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
         . "urltoken varchar(280),"
         . "email varchar(280),"
         . "date DATETIME,"
         . "flag tinyint"
         .");";
         $stmt_password_resets = $pdo->query($sql_password_resets); 
         
         $sql_impression = "CREATE TABLE IF NOT EXISTS impression"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
         . "userid int(100),"
         . "performance varchar(280),"
         . "theater varchar(100),"
         . "date DATE,"
         . "open_time TIME,"
         . "close_time TIME,"
         . "stage varchar(100),"
         . "seat varchar(50),"
         . "first_date DATE,"
         . "final_date DATE,"
         . "organizer varchar(100),"
         . "director varchar(100),"
         . "author varchar(100),"
         . "dance varchar(100),"
         . "music varchar(100),"
         . "lyrics varchar(100),"
         . "cloth varchar(100),"
         . "light varchar(100),"
         . "property varchar(100),"
         . "players varchar(100),"
         . "scenario TEXT,"
         . "impression_all TEXT,"
         . "player_impression_1 varchar(100),"
         . "player_impression_2 varchar(100),"
         . "player_impression_3 varchar(100),"
         . "player_impression_4 varchar(100),"
         . "player_impression_5 varchar(100),"
         . "player_impression_6 varchar(100),"
         . "player_impression_7 varchar(100),"
         . "player_impression_8 varchar(100),"
         . "player_impression_9 varchar(100),"
         . "player_impression_10 varchar(100),"
         . "player_impression_11 varchar(100),"
         . "player_impression_12 varchar(100),"
         . "player_impression_13 varchar(100),"
         . "player_impression_14 varchar(100),"
         . "player_impression_15 varchar(100),"
         . "player_impression_16 varchar(100),"
         . "player_impression_17 varchar(100),"
         . "player_impression_18 varchar(100),"
         . "player_impression_19 varchar(100),"
         . "player_impression_20 varchar(100),"
         . "player_impression_21 varchar(100),"
         . "player_impression_22 varchar(100),"
         . "player_impression_23 varchar(100),"
         . "player_impression_24 varchar(100),"
         . "player_impression_25 varchar(100),"
         . "player_impression_26 varchar(100),"
         . "player_impression_27 varchar(100),"
         . "player_impression_28 varchar(100),"
         . "player_impression_29 varchar(100),"
         . "player_impression_30 varchar(100),"
         . "player_impression_31 varchar(100),"
         . "player_impression_32 varchar(100),"
         . "player_impression_33 varchar(100),"
         . "player_impression_34 varchar(100),"
         . "player_impression_35 varchar(100),"
         . "player_impression_36 varchar(100),"
         . "player_impression_37 varchar(100),"
         . "player_impression_38 varchar(100),"
         . "player_impression_39 varchar(100),"
         . "player_impression_40 varchar(100),"
         . "player_impression_41 varchar(100),"
         . "player_impression_42 varchar(100),"
         . "player_impression_43 varchar(100),"
         . "player_impression_44 varchar(100),"
         . "player_impression_45 varchar(100),"
         . "player_impression_46 varchar(100),"
         . "player_impression_47 varchar(100),"
         . "player_impression_48 varchar(100),"
         . "player_impression_49 varchar(100),"
         . "player_impression_50 varchar(100),"
         . "impression_player_1 TEXT,"
         . "impression_player_2 TEXT,"
         . "impression_player_3 TEXT,"
         . "impression_player_4 TEXT,"
         . "impression_player_5 TEXT,"
         . "impression_player_6 TEXT,"
         . "impression_player_7 TEXT,"
         . "impression_player_8 TEXT,"
         . "impression_player_9 TEXT,"
         . "impression_player_10 TEXT,"
         . "impression_player_11 TEXT,"
         . "impression_player_12 TEXT,"
         . "impression_player_13 TEXT,"
         . "impression_player_14 TEXT,"
         . "impression_player_15 TEXT,"
         . "impression_player_16 TEXT,"
         . "impression_player_17 TEXT,"
         . "impression_player_18 TEXT,"
         . "impression_player_19 TEXT,"
         . "impression_player_20 TEXT,"
         . "impression_player_21 TEXT,"
         . "impression_player_22 TEXT,"
         . "impression_player_23 TEXT,"
         . "impression_player_24 TEXT,"
         . "impression_player_25 TEXT,"
         . "impression_player_26 TEXT,"
         . "impression_player_27 TEXT,"
         . "impression_player_28 TEXT,"
         . "impression_player_29 TEXT,"
         . "impression_player_30 TEXT,"
         . "impression_player_31 TEXT,"
         . "impression_player_32 TEXT,"
         . "impression_player_33 TEXT,"
         . "impression_player_34 TEXT,"
         . "impression_player_35 TEXT,"
         . "impression_player_36 TEXT,"
         . "impression_player_37 TEXT,"
         . "impression_player_38 TEXT,"
         . "impression_player_39 TEXT,"
         . "impression_player_40 TEXT,"
         . "impression_player_41 TEXT,"
         . "impression_player_42 TEXT,"
         . "impression_player_43 TEXT,"
         . "impression_player_44 TEXT,"
         . "impression_player_45 TEXT,"
         . "impression_player_46 TEXT,"
         . "impression_player_47 TEXT,"
         . "impression_player_48 TEXT,"
         . "impression_player_49 TEXT,"
         . "impression_player_50 TEXT,"
         . "impression_scene_1 TEXT,"
         . "impression_scene_2 TEXT,"
         . "impression_scene_3 TEXT,"
         . "impression_scene_4 TEXT,"
         . "impression_scene_5 TEXT,"
         . "impression_scene_6 TEXT,"
         . "impression_scene_7 TEXT,"
         . "impression_scene_8 TEXT,"
         . "impression_scene_9 TEXT,"
         . "impression_scene_10 TEXT,"
         . "impression_scene_11 TEXT,"
         . "impression_scene_12 TEXT,"
         . "impression_scene_13 TEXT,"
         . "impression_scene_14 TEXT,"
         . "impression_scene_15 TEXT,"
         . "impression_scene_16 TEXT,"
         . "impression_scene_17 TEXT,"
         . "impression_scene_18 TEXT,"
         . "impression_scene_19 TEXT,"
         . "impression_scene_20 TEXT,"
         . "impression_scene_21 TEXT,"
         . "impression_scene_22 TEXT,"
         . "impression_scene_23 TEXT,"
         . "impression_scene_24 TEXT,"
         . "impression_scene_25 TEXT,"
         . "impression_scene_26 TEXT,"
         . "impression_scene_27 TEXT,"
         . "impression_scene_28 TEXT,"
         . "impression_scene_29 TEXT,"
         . "impression_scene_30 TEXT,"
         . "impression_scene_31 TEXT,"
         . "impression_scene_32 TEXT,"
         . "impression_scene_33 TEXT,"
         . "impression_scene_34 TEXT,"
         . "impression_scene_35 TEXT,"
         . "impression_scene_36 TEXT,"
         . "impression_scene_37 TEXT,"
         . "impression_scene_38 TEXT,"
         . "impression_scene_39 TEXT,"
         . "impression_scene_40 TEXT,"
         . "impression_scene_41 TEXT,"
         . "impression_scene_42 TEXT,"
         . "impression_scene_43 TEXT,"
         . "impression_scene_44 TEXT,"
         . "impression_scene_45 TEXT,"
         . "impression_scene_46 TEXT,"
         . "impression_scene_47 TEXT,"
         . "impression_scene_48 TEXT,"
         . "impression_scene_49 TEXT,"
         . "impression_scene_50 TEXT,"
         . "impression_final TEXT,"
         . "related_performance_1 varchar(280),"
         . "related_performance_2 varchar(280),"
         . "related_performance_3 varchar(280),"
         . "related_performance_4 varchar(280),"
         . "related_performance_5 varchar(280),"
         . "related_performance_6 varchar(280),"
         . "related_performance_7 varchar(280),"
         . "related_performance_8 varchar(280),"
         . "related_performance_9 varchar(280),"
         . "related_performance_10 varchar(280)"
         .");";
         $stmt_impression = $pdo->query($sql_impression);
         
         session_start();
         
         //エラーメッセージの初期化
         $errors = array();
         
         if(isset($_POST["submit"])){
             //メールアドレス空欄の場合
             if(empty($_POST["email"])){
                 $errors['email'] = "メールアドレスが未入力です。";
             }else{
                 //POSTされたデータを変数に入れる
                 $email = isset($_POST['email']) ? $_POST['email'] : NULL;
   
                 //メールアドレス構文チェック
                 if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
			        $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
                 }
                 
                 //DB確認        
                 $sql = "SELECT id FROM user WHERE email=:email LIMIT 1";
                 $stm = $pdo->prepare($sql);
                 $stm->bindValue(':email', $email, PDO::PARAM_STR);
       
                 $stm->execute();
                 $result = $stm->fetch(PDO::FETCH_ASSOC);
                 
                 //user テーブルに同じメールアドレスがある場合、エラー表示
                 if(isset($result["id"])){
			         $errors['user_check'] = "このメールアドレスはすでに利用されております。";
                 }
                 
                 //エラーがない場合、pre_userテーブルにインサート
                 if (count($errors) === 0){
                     $urltoken = hash('sha256',uniqid(rand(),1));
                     $url = "https://tech-base.net/tb-230045/m6/m6-create.php?urltoken=".$urltoken;
                     $receivernamearray = explode("@", $email);
                     $receivername = $receivernamearray[0];
                     $_SESSION['email'] = $email;
                     
                     // データベースに登録する
                     try{
                         $newdate = date('Y-m-d H:i:s');
                         $flag = 0;
                         $stmtpre = $pdo -> prepare("INSERT  INTO pre_user (urltoken, email, date, flag) VALUES (:urltoken, :email, :date, :flag)");
                         $stmtpre -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
                         $stmtpre -> bindParam(':email', $email, PDO::PARAM_STR);
                         $stmtpre -> bindParam(':date', $newdate, PDO::PARAM_STR);
                         $stmtpre -> bindParam(':flag', $flag, PDO::PARAM_INT);
                         $stmtpre -> execute();
                         
                         $_SESSION['body'] = $receivername."様<br>この度はご利用くださりありがとうございます。<br>下記URLにて24時間以内に本登録をお済ませください。<br>".$url;
                         
                         require_once 'phpmailer/send_test.php';
                         
                         $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";     
                         
                         //データベースの接続切断
                         $stmtpre = NULL;
             
                         //セッション変数をすべて解除
                         $_SESSION = array();
             
                         //セッションクッキーの削除
                         if (isset($_COOKIE["PHPSESSID"])) {
				             setcookie("PHPSESSID", '', time() - 1800, '/');
                         }
		     
		                 //セッションを破棄する
		                 session_destroy();

                     }catch (PDOException $e){
                         print('Error:'.$e->getMessage());
                         die();
                     }
                 }
             }
         }
    ?>
 <h1>ようこそ、新規登録をお願いします。</h1>
 <p>すでに登録済みの方は<a href="m6-login-form.php">こちら</a></p>
    
     <!-- 登録完了画面 -->
         <?php if(isset($_POST['submit']) && count($errors) === 0): ?>
             <p><?=$message?></p>
         <?php endif; ?>
         
     <!-- 登録画面 -->
         <?php if(count($errors) > 0): ?>
             <?php
                 foreach($errors as $value){
                 echo "<p class='error'>".$value."</p>";
             }
             ?>
         <?php endif; ?>
         <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
             <p>メールアドレス：<input type="text" name="email" size="50" value="<?php if(!empty($_POST['email'])){echo $_POST['email'];} ?>"></p> 
             <input type="hidden" name="token" value="<?=$token?>">
             <input type="submit" name="submit" value="送信">
         </form>

</body>
</html>
