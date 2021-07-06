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
         . "flag tinyint"
         .");";
         $stmt_pre = $pdo->query($sql_pre);
         
         $sql_user = "CREATE TABLE IF NOT EXISTS user"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
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
                 
                 //エラーがない場合、pre_userテーブルに挿入する
                 if (count($errors) === 0){
                     $urltoken = hash('sha256',uniqid(rand(),1));
                     $url = "http://localhost:10011/m6-create.php?urltoken=".$urltoken;
                     $receivernamearray = explode("@", $email);
                     $receivername = $receivernamearray[0];
                     $_SESSION['email'] = $email;
                     
                     // データベースに登録する
                     try{
                         $newdate = date('Y-m-d H:i:s');
                         $stmtpre = $pdo -> prepare("INSERT  INTO pre_user (urltoken, email, date, flag) VALUES (:urltoken, :email, :date, '0')");
                         $stmtpre -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
                         $stmtpre -> bindParam(':email', $email, PDO::PARAM_STR);
                         $stmtpre -> bindParam(':date', $newdate, PDO::PARAM_STR);
                         $stmtpre -> execute();
                         
                         $_SESSION['body'] = $receivername."様<br>この度はご利用くださりありがとうございます。<br>下記URLにて24時間以内に本登録をお済ませください。<br>".$url;
                         
                         require_once 'phpmailer/send_test.php';
                         
                         $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";     
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
