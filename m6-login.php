<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
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
  
         session_start();
         $username = $_POST["username"];
         
         $sql_login = "SELECT * FROM user WHERE username=:username";
         $stmt_login = $pdo -> prepare($sql_login);
         $stmt_login -> bindValue(':username', $username);
         $stmt_login -> execute();
         $members  = $stmt_login -> fetch();
         
         // 指定したハッシュがパスワードとあっているか
         if(password_verify($_POST['password'], $members['password'])){
             // データベースの値をセッションに保存
             $_SESSION['id'] = $members['id'];
             $_SESSION['username'] = $members['username'];
             
             $message = "ログインしました。";
             
             $link = '<a href = "m6-indivisual-home.php">ホーム</a>';
         }else{
             $message = "ユーザー名もしくはパスワードが間違ってます。";
             $link = '<a href = "m6-login-form.php">戻る</a>';
         }
     ?>
         
     <h1><?php echo $message; ?></h1>
     <?php echo $link; ?>
</html>       
