<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>仮登録画面</title>
</head>
  
    <?php
         
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
         . "first_day DATE,"
         . "final_day DATE,"
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
         . "player_impression[1] varchar(100),"
         . "player_impression[2] varchar(100),"
         . "player_impression[3] varchar(100),"
         . "player_impression[4] varchar(100),"
         . "player_impression[5] varchar(100),"
         . "player_impression[6] varchar(100),"
         . "player_impression[7] varchar(100),"
         . "player_impression[8] varchar(100),"
         . "player_impression[9] varchar(100),"
         . "player_impression[10] varchar(100),"
         . "player_impression[11] varchar(100),"
         . "player_impression[12] varchar(100),"
         . "player_impression[13] varchar(100),"
         . "player_impression[14] varchar(100),"
         . "player_impression[15] varchar(100),"
         . "player_impression[16] varchar(100),"
         . "player_impression[17] varchar(100),"
         . "player_impression[18] varchar(100),"
         . "player_impression[19] varchar(100),"
         . "player_impression[20] varchar(100),"
         . "player_impression[21] varchar(100),"
         . "player_impression[22] varchar(100),"
         . "player_impression[23] varchar(100),"
         . "player_impression[24] varchar(100),"
         . "player_impression[25] varchar(100),"
         . "player_impression[26] varchar(100),"
         . "player_impression[27] varchar(100),"
         . "player_impression[28] varchar(100),"
         . "player_impression[29] varchar(100),"
         . "player_impression[30] varchar(100),"
         . "player_impression[31] varchar(100),"
         . "player_impression[32] varchar(100),"
         . "player_impression[33] varchar(100),"
         . "player_impression[34] varchar(100),"
         . "player_impression[35] varchar(100),"
         . "player_impression[36] varchar(100),"
         . "player_impression[37] varchar(100),"
         . "player_impression[38] varchar(100),"
         . "player_impression[39] varchar(100),"
         . "player_impression[40] varchar(100),"
         . "player_impression[41] varchar(100),"
         . "player_impression[42] varchar(100),"
         . "player_impression[43] varchar(100),"
         . "player_impression[44] varchar(100),"
         . "player_impression[45] varchar(100),"
         . "player_impression[46] varchar(100),"
         . "player_impression[47] varchar(100),"
         . "player_impression[48] varchar(100),"
         . "player_impression[49] varchar(100),"
         . "player_impression[50] varchar(100),"
         . "impression_player[1] TEXT,"
         . "impression_player[2] TEXT,"
         . "impression_player[3] TEXT,"
         . "impression_player[4] TEXT,"
         . "impression_player[5] TEXT,"
         . "impression_player[6] TEXT,"
         . "impression_player[7] TEXT,"
         . "impression_player[8] TEXT,"
         . "impression_player[9] TEXT,"
         . "impression_player[10] TEXT,"
         . "impression_player[11] TEXT,"
         . "impression_player[12] TEXT,"
         . "impression_player[13] TEXT,"
         . "impression_player[14] TEXT,"
         . "impression_player[15] TEXT,"
         . "impression_player[16] TEXT,"
         . "impression_player[17] TEXT,"
         . "impression_player[18] TEXT,"
         . "impression_player[19] TEXT,"
         . "impression_player[20] TEXT,"
         . "impression_player[21] TEXT,"
         . "impression_player[22] TEXT,"
         . "impression_player[23] TEXT,"
         . "impression_player[24] TEXT,"
         . "impression_player[25] TEXT,"
         . "impression_player[26] TEXT,"
         . "impression_player[27] TEXT,"
         . "impression_player[28] TEXT,"
         . "impression_player[29] TEXT,"
         . "impression_player[30] TEXT,"
         . "impression_player[31] TEXT,"
         . "impression_player[32] TEXT,"
         . "impression_player[33] TEXT,"
         . "impression_player[34] TEXT,"
         . "impression_player[35] TEXT,"
         . "impression_player[36] TEXT,"
         . "impression_player[37] TEXT,"
         . "impression_player[38] TEXT,"
         . "impression_player[39] TEXT,"
         . "impression_player[40] TEXT,"
         . "impression_player[41] TEXT,"
         . "impression_player[42] TEXT,"
         . "impression_player[43] TEXT,"
         . "impression_player[44] TEXT,"
         . "impression_player[45] TEXT,"
         . "impression_player[46] TEXT,"
         . "impression_player[47] TEXT,"
         . "impression_player[48] TEXT,"
         . "impression_player[49] TEXT,"
         . "impression_player[50] TEXT,"
         . "impression_final TEXT,"
         . "related_performance[1] TEXT,"
         . "related_performance[2] TEXT,"
         . "related_performance[3] TEXT,"
         . "related_performance[4] TEXT,"
         . "related_performance[5] TEXT,"
         . "related_performance[6] TEXT,"
         . "related_performance[7] TEXT,"
         . "related_performance[8] TEXT,"
         . "related_performance[9] TEXT,"
         . "related_performance[10] TEXT"
         .");";
         $stmt_impression = $pdo->prepare($sql_impression);
         
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
