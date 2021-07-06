<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
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
         // の学生の場合：

         // DB接続設定
         $dsn = 'mysql:dbname=***;host=***';
         $user = '***';
         $password = '***';
         $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

         if(empty($_GET)){
             header("Location:m6-login-form.php");
             exit();
         else{
             $username = isset($_SESSION["username"]) ? $_SESSION["username"] : NULL;
             
             $sql = "CREATE TABLE IF NOT EXISTS '{$username}'"
             ." ("
             . "id INT AUTO_INCREMENT PRIMARY KEY,"
             . "username varchar(280),"
             . "subject varchar(280)"
             .");";
             $stmt = $pdo->query($sql); 
             
             try{
                 $sql_home = "SELECT * FROM '$username' ";
                 $stmt_home = $pdo -> query($sql_home);
                 $stmt_home -> execute();
                 $results  = $stmt_home -> fetch();
             
                 if(is_array($results)){
                     foreach($results as $row){
                         $_SESSION['id'] = $row['id'];
                         echo intval($row['id'])-1; 
                         $link = '<a href = "m6-indivisual-subject-show.php">'.$row['subject'].'</a>';
                         echo ": ".$link."<br>";
                     }
                 }else{
                     echo "まだデータがありません。";
                     $sql_first = $pdo -> prepare("INSERT INTO {'$username'} (username) VAULE (:username)");
                     $sql_first -> bindValue(':username', $username, PDO::PARAM_STR);
                     $sql_first -> execute();
                 }
             }catch(PDOException $e){
                 //トランザクション取り消し
                 $pdo -> rollBack();
                 $errors['error'] = "もう一度やり直してください。";
                 print('Error:'.$e->getMessage());
             }
         }
         
         /** 
          * 追加する（btn_edit）を押した後の処理
         */
         if(isset($_POST['btn_edit'])){
             if(empty($_GET)){
                 header("Location:m6-login-form.php");
                 exit();
             }else{
                 $_SESSION['id'] = NULL;
                 header("Location:m6-indivisual-add.php");
                 exit();
             }
         }
     ?>
     
     <input type="submit" name="btn_edit" value="追加する"><br>
     <p><a href = "m6-logout.php">ログアウトはこちら</a></p>
     <p><a href = "m6-withdrow.php">退会する</a></p>
     </html>  
