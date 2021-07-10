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
         // 成功・エラーメッセージの初期化
         $errors = array();
         
         // ログインボタン(btn_login)が押された後の処理
         if(isset($_POST['btn_login'])){
             $username = isset($_POST["username"]) ? $_POST["username"] : NULL;
             $password = isset($_POST["password"]) ? $_POST["password"] : NULL;
             
             if($username != "" && $password != ""){
                 $sql_login = "SELECT * FROM user WHERE username=:username";
                 $stmt_login = $pdo -> prepare($sql_login);
                 $stmt_login -> bindValue(':username', $username);
                 $stmt_login -> execute();
                 $count_login = $stmt_login -> rowCount();
                 
                 if($count_login === 1){
                     $sql_password = "SELECT * FROM user WHERE username=:username";
                     $stmt_password = $pdo -> prepare($sql_password);
                     $stmt_password -> bindValue(':username', $username);
                     $stmt_password -> execute();
                     $members = $stmt_password -> fetchAll();
                     
                     foreach($members as $member){
                         $id = $member['id'];
                         $correct_password = $member['password'];
                     }
                     // 指定したハッシュがパスワードとあっているか
                     if(password_verify($password, $correct_password)){
                         // データベースの値をセッションに保存
                         $_SESSION['id'] = $id;
                         $_SESSION['username'] = $correct_password;
                         
                         header("Location:m6-indivisual-home.php");
                         exit();
                     }else{
                         $errors['confirm_password'] = "パスワードが一致しません。";
                     }
                 }else{
                     $errors['confirm_username'] = "そのユーザ名は登録されていません。";
                 }
             }else{
                 if($username === ""){
                     $errors['username'] = "ユーザ名が未入力です。";
                 }
                 if($password === ""){
                     $errors['password'] = "パスワードが未入力です。";
                 }
             }
         }
     ?>
 <body>
         <?php if(count($errors) > 0):?>
             <?php 
                 foreach($errors as $value){
                     echo "<p class='error'>".$value."</p>";
                 }
             ?>
         <?php endif; ?>
         <h1>ようこそ、ログインしてください。</h1>
         <form  action="" method="post">
		     <p>ユーザー名：<input type="text" name="username"></p>
		     <p>パスワード：<input type="password" name="password"></p>
             <button type="submit" name="btn_login">ログイン</button>
         </form>
         <br>
         <a href="m6-pre-create.php" target="_blank">初めての方はこちら</a><br>
         <a href="m6-foget-username-form.php" target="_blank">ユーザー名をお忘れの方はこちら</a><br>
         <a href="m6-forget-password-form.php" target"_blank">パスワードをお忘れの方はこちら</a>
</body>
</html>
