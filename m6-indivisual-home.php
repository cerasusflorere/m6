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

         $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;
         $performance = array();
         $count_results;
         
         try{
             $sql_home = "SELECT * FROM impression WHERE userid=:userid";
             $stmt_home = $pdo -> prepare($sql_home);
             $stmt_home -> bindParam(':userid', $userid, PDO::PARAM_INT);
             $results  = $stmt_home -> fetchAll();
         
             if(is_array($results)){
                 $count_results = 0;
                 foreach($results as $row){
                     $count_results++;
                     $performance[$count_results] = $row['performance'];
                 }
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
         <?php if($count_results >= 1): ?>
             <?php for($i=1; $i<=$count_results; $i++){ ?>
                 <p><?php echo $i.":" ?>
                 <input type="hidden" name="performance_name" value="<?php echo $performance[$i] ?>">
                 <a href="m6-indivisual-subject-show.php"><?php echo $performance[$i] ?></a></p>
             <?php } ?>
         <?php else :
                 echo "データありません。<br>";
               endif; ?>
         <input type="submit" name="btn_add" value="追加する">
         <p><a href = "m6-logout.php">ログアウトはこちら</a></p>
         <p><a href = "m6-withdrow.php">退会する</a></p>
     </form>
</html>  
