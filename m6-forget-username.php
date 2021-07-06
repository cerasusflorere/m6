<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー名メール送信申請</title>
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
             //メールアドレス空欄の場合
             if(empty($_POST["email"])){
                 if(empty($_POST["empty"])){
                     $errors["email"] = "メールアドレスが未入力です。";
                 }
             }else{
                 //POSTされたデータを変数に入れる
                 $email = !isset($_POST['email']) ? $_POST['email'] : NULL;
   
                 //メールアドレス構文チェック
                 if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			        $errors['mail_check'] = "メールアドレスの形式が正しくありません。";
                 }
                 
                 //DB確認        
                 $sql = "SELECT * FROM user WHERE email=:email LIMIT 1";
                 $stmt = $pdo->query($sql);
                 $results = $stmt->fetchAll();
                 
                 
                 // password_resetsテーブルにインサート
                 if (count($errors) === 0 && $results['id'] != NULL){
                     $urltoken = hash('sha256',uniqid(rand(),1));
                     $url = "http://localhost:10011/m6-create.php?urltoken=".$urltoken;
                    
                     // ユーザー名を送信する
                     try{
                         $_SESSION['body'] = $receivername."様<br>ご利用くださりありがとうございます。<br>あなたのユーザ名は<br>".$results['username']."<br>です。ログインはこちら<br>".$url;
                         
                         require_once 'phpmailer/send_test.php';
                         
                         $message = "メールをお送りしました。";
                     }catch (PDOException $e){
                         print('Error:'.$e->getMessage());
                         die();
                     }  
                 }
             }
         }
    ?>
    
 <h1>ユーザー名を登録されているメールアドレス宛に送信致します。</h1>
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
             <input type="hidden" name="token" value="<?=$token?>">
             <input type="submit" name="submit" value="送信">
         </form>
</body>
</html>
