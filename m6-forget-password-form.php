<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワードリセット申請</title>
</head>
<body>
    <?php
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
    
         //エラーメッセージの初期化
         $errors = array();
         
         if(isset($_POST["submit"])){
             //メールアドレスとユーザー名空欄の場合
             if(empty($_POST["email"]) || empty($_POST["username"])){
                 if(empty($_POST["empty"])){
                     $errors["email"] = "メールアドレスが未入力です。";
                 }
                 if(empty($_POST["username"])){
                     $errors["username"] = "ユーザー名が未入力です。";
                 }
                 
             }else{
                 //POSTされたデータを変数に入れる
                 $email = !isset($_POST['email']) ? $_POST['email'] : NULL;
                 $username = !isset($_POST['username']) ? $_POST['username'] : NULL;
   
                 //メールアドレス構文チェック
                 if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			        $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
                 }
                 
                 //DB確認        
                 $sql = "SELECT COUNT (*) FROM user WHERE email=:email AND username=:username LIMIT 1";
                 $stmt = $pdo->prepare($sql);
                 $stmt->execute();
                 $result = $stmt->fetch(PDO::FETCH_ASSOC);
                 
                 // password_resetsテーブルに挿入
                 if (count($errors) === 0 && $result === 1){
                     $urltoken = hash('sha256',uniqid(rand(),1));
                     $url = "http://localhost:10011/m6-create.php?urltoken=".$urltoken;
                     $receivernames = explode("@", $email);
                     $receivername = $receivernames[0];
                     
                     // データベースに登録する
                     try{
                         $newdate = date('Y-m-d H:i:s');
                         $flag = 0;
                         $stmt_password_resete = $pdo -> prepare("INSERT  INTO password_resets (urltoken, flag, date) VALUES (:urltoken, :flag, :date)");
                         $stmt_password_resete -> bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
                         $stmt_password_resete -> bindParam(':flag', $flag, PDO::PARAM_INT);
                         $stmt_password_resete -> bindParam(':date', $newdate, PDO::PARAM_STR);
                         $stmt_password_resete -> execute();
                         
                         $_SESSION['body'] = $receivername."様<br>ご利用くださりありがとうございます。<br>下記URLにて24時間以内にパスワードを再入力してください。<br>".$url;
                         
                         //require_once 'phpmailer/send_test.php';
                         
                         $message = "メールをお送りしました。24時間以内にメールに記載されたURLからご変更下さい。";
                     }catch (PDOException $e){
                         print('Error:'.$e->getMessage());
                         die();
                     }  
                 }
             }
         }
    ?>
    
 <h1>どうぞ、パスワードリセットを申請してください。</h1>
 <p>すでにご登録済みの方は<a href="m6-login-form.php">こちら</a></p>
    
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
             <p>ユーザー名    ：<input type="text" name="username" size="50"></p>
             <input type="hidden" name="token" value="<?=$token?>">
             <input type="submit" name="submit" value="送信">
         </form>
</body>
</html>
