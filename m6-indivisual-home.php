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
         define('USERNAME', $username);
             
         $sql = "CREATE TABLE IF NOT EXISTS USERNAME"
         ." ("
         . "id INT AUTO_INCREMENT PRIMARY KEY,"
         . "performance varchar(280),"
         . "theater varchar(100),"
         . "date DATE,"
         . "open_time TIME,"
         . "close_time TIME,"
         . "stage varchar(100),"
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
         $stmt = $pdo->prepare($sql); 
         
         try{
             $sql_home = "SELECT * FROM".$username;
             $stmt_home = $pdo -> prepare($sql_home);
             $stmt_home -> execute();
             $results  = $stmt_home -> fetchAll();
         
             if(is_array($results)){
                 foreach($results as $row){
                     $_SESSION['id'] = $row['id'];
                     echo intval($row['id']); 
                     $link = '<a href = "m6-indivisual-subject-show.php">'.$row['performance'].'</a>';
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
