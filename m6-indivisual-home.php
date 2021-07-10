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

         // DB接続設定
         $dsn = 'mysql:dbname=***;host=***';
         $user = '***';
         $password = '***';
         $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

         $username = isset($_SESSION["username"]) ? $_SESSION["username"] : NULL;
         define("table_name", $username);
             
         $sql = "CREATE TABLE IF NOT EXISTS table_name"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
         . "username varchar(280),"
         . "subject varchar(280)"
         .");";
         $stmt = $pdo->query($sql); 
         
         try{
             $sql_home = "SELECT * FROM table_name ";
             $stmt_home = $pdo -> prepare($sql_home);
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
                 echo "まだデータがありません。<br>";
             }
         }catch(PDOException $e){
             //トランザクション取り消し
             $pdo -> rollBack();
             $errors['error'] = "もう一度やり直してください。";
             print('Error:'.$e->getMessage());
         }
     
         /** 
          * 追加する（btn_add）を押した後の処理
         */
         if(isset($_POST['btn_add'])){
             unset($_SESSION['id']);
             header("Location:m6-indivisual-subject-add.php");
             exit();
         }
     ?>
     
     <form action="" method="post">     
         <input type="submit" name="btn_add" value="追加する">
         <p><a href = "m6-logout.php">ログアウトはこちら</a></p>
         <p><a href = "m6-withdrow.php">退会する</a></p>
     </form>
</html>  
