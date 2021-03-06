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
         $errors = [];
             
         $performance = isset($_POST['performance_name']) ? $_POST['performance_name'] : NULL;
         $userid= isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;
        
         try{
             $sql_show = "SELECT * FROM impression WHERE userid=:userid AND performance=:performance";
             $stmt_show = $pdo -> prepare($sql_show);
             $stmt_show -> bindParam(':userid', $userid, PDO::PARAM_INT);
             $stmt_show -> bindParam(':performance', $performance, PDO::PARAM_STR);
             $stmt_show -> execute();
             $results = $stmt_show -> fetchAll();
             foreach ($results as $row){
                 echo "<h1>".$row['performance']."</h1><br>";
                 $_SESSION['performance'] = $row['performance'];
                 if($row['theater'] !== ""){
                     echo "劇団：".$row['theater']."<br>";
                 }
                 echo "観劇日：".$row['date']."  観劇した劇場：".$row['stage']."<br>";
                 echo "開演時刻：".$row['open_time']." ~ 終演時刻：".$row['close_time']."<br>";
                 echo "観劇した劇場：".$row['stage']."<br>";
                 echo "観劇した座席：".$row['seat']."<br>";
                 echo "公演期間：".$row['first_date']." ~ ".$row['final_date']."<br>";
                 echo "主催：".$row['organizer']."<br>";
                 echo "演出：".$row['director']."  作家：".$row['author'];
                 echo "振付：".$row['dance']."  音楽：".$row['music']."  作詞：".$row['lyrics']."<br>";
                 echo "衣装：".$row['cloth']."  照明：".$row['light']."  小道具：".$row['property']."<br>";
                 echo "出演者：".$row['players']."<br>";
                 echo "あらすじ：<br>".$row['scenario']."<br>";
                 echo "全体について思うこと：<br>".$row['impression_all']."<br>";
                 echo "出演者について<br>";
                 for($i=1; $i < 51; $i++){
                     if(isset($row['player_impression_'.$i])){
                         echo $row['player_impression_'.$i]."<br>";
                         echo $row['impression_player_'.$i]."<br>";
                     }else{
                         break;
                     }
                 }
                 echo "好きな場面とその理由<br>";
                 for($i=1; $i < 51; $i++){
                     if(isset($row['impression_scene_'.$i])){
                         echo $row['impression_scene_'.$i]."<br>";
                     }else{
                         break;
                     }
                 }
                 echo "最後に：<br>".$row['impression_final']."<br>";
                 echo "関連のある公演：<br>";
                 for($i=1; $i < 11; $i++){
                     if(isset($row['related_performance_'.$i])){
                         echo $row['related_performance_'.$i];
                     }
                 }
             }
             $flag = 1;
         }catch(PDOException $e){
             //トランザクション取り消し
             $pdo -> rollBack();
             $errors['error'] = "もう一度やり直してください。";
             print('Error:'.$e->getMessage());
         }
         
         /**
          * 編集する（btn_edit）を押した後の処理
         */
         if(isset($_POST['btn_edit'])){
             header("Location:m6-indivisual-subject-edit.php");
             exit();
         }
         
     ?>
     
     <form action="" method="post" name="error">
         <?php if(count($errors) > 0): ?>
             <?php foreach($errors as $value){
                       echo "<p class='error'>".$value."</p>";
                   } 
             ?>
     </form>
         <?php elseif($flag = 1): ?>
     <form action="" method="post" name="edit">
             <input type="submit" name="btn_edit" value="編集する"><br>
             <br>
             <a href="m6-indivisual-home.php">戻る</a> 
         <?php endif; ?>
     </form>
</body>
</html>
