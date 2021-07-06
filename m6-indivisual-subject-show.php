<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>個別ページ</title>
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

         $flag = 0;
         if(empty($_GET)){
             header("Location:m6-login-form.php");
             exit();
         else{
             $id = isset($_SESSION["id"]) ? $_SESSION["id"] : NULL;
             $username = isset($_SESSION["username"]) ? $_SESSION["username"] : NULL;
             
             try{
                 $sql_show = "SELECT * FROM {'$username'} WHERE id=:id";
                 $stmt_show = $pdo -> query($sql_show);
                 $results = $stmt_show -> fetchAll();
                 foreach ($results as $row){
                     echo "<h1>公演名：".$row['username']."</h1>";
                     echo "観劇日：".$row['date']."  観劇した劇場：".$row['stage']."<br>";
                     echo "公演期間：".$row['duration']."  ";
                     if(!empty($row['stages'])){
                         echo "ほかの劇場：".$row['stages']."<br>";           
                     }
                     echo "演出：".$row['director']."  作家：".$row['author'];
                     echo ""
                 }
                 $flag = 1;
             }catch(PDOException $e){
                 //トランザクション取り消し
                 $pdo -> rollBack();
                 $errors['error'] = "もう一度やり直してください。";
                 print('Error:'.$e->getMessage());
             }
         }
         
         /**
          * 編集する（btn_edit）を押した後の処理
         */
         if(isset($_POST['btn_edit'])){
             if(empty($_GET)){
                 header("Location:m6-login-form.php");
                 exit();
             }else{
                 header("Location:m6-indivisual-edit.php");
                 exit();
             }
         }
         
         /**
          * 戻る（btn_return）が押された後の処理
         */
         if(isset($_POST['btn_return'])){
             if(empty($_GET)){
                 header("Location:m6-login-form.php");
                 exit();
             }else{
                 header("Loction:m6-indivisual-home.php");
                 exit();
             }
         }
     ?>
     <?php if($flag = 1): ?>
             <input type="submit" name="btn_edit" value="編集する"><br>
             <br>
             <input type="submit" name="btn_return" value="戻る">
     <?php endif; ?>
</html>
