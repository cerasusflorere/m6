<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>編集ページ</title>
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

         /*if(empty($_GET)){
             header("Location:m6-login-form.php");
             exit();
         else{*/
             $id = isset($_SESSION["id"]) ? $_SESSION["id"] : NULL;
             $userid = isset($_SESSION["userid"]) ? $_SESSION["userid"] : NULL;
             
             if($id !== NULL && $userid !== NULL){
                 try{
                     $sql_show = 'SELECT * FROM impression WHERE id=:id AND user=:userid LIMIT 1';
                     $stmt_show = $pdo -> prepare($sql_show);
                     $stmt_show -> bindParam(':id', $id, PDO::PARAM_INT);
                     $stmt_show -> bindParam(':userid', $userid, PDO::PARAM_INT);
                     $stmt_show -> execute();
                     $results_show = $stmt_show -> fetchAll();
                     
                     foreach($results_show as $row){
                         $_SESSION['performance'] = isset($row['performance']) ? $row['performance'] : NULL;
                         $_SESSION['theater'] = isset($row['theater']) ? $row['theater'] : NULL;
                         $_SESSION['date'] = isset($row['date']) ? $row['date'] : NULL;
                         $_SESSION['open_time'] = isset($row['open_time']) ? $row['open_time'] : NULL;
                         $_SESSION['close_time'] = isset($row['close_time']) ? $row['close_time'] : NULL;
                         $_SESSION['stage'] = isset($row['stage']) ? $row['stage'] : NULL;
                         $_SESSION['seat'] = isset($row['seat']) ? $row['seat'] : NULL;
                         $_SESSION['first_date'] = isset($row['first_date']) ? $row['first_date'] : NULL;
                         $_SESSION['final_date'] = isset($row['final_date']) ? $row['final_date'] : NULL;
                         $_SESSION['organizer'] = isset($row['organizer']) ? $row['organizer'] : NULL;
                         $_SESSION['director'] = isset($row['director']) ? $row['director'] : NULL;
                         $_SESSION['author'] = isset($row['author']) ? $row['author'] : NULL;
                         $_SESSION['dance'] = isset($row['dance']) ? $row['dance'] : NULL;
                         $_SESSION['music'] = isset($row['music']) ? $row['music'] : NULL;
                         $_SESSION['lyrics'] = isset($row['lyrics']) ? $row['lyrics'] : NULL;
                         $_SESSION['cloth'] = isset($row['cloth']) ? $row['cloth'] : NULL;
                         $_SESSION['light'] = isset($row['light']) ? $row['light'] : NULL;
                         $_SESSION['property'] = isset($row['property']) ? $row['property'] : NULL;
                         $_SESSION['players'] = isset($row['players']) ? $row['players']: NULL;
                         $_SESSION['scenario'] = isset($row['scenario']) ? $row['scenario']: NULL;
                         $_SESSION['impression_all'] = isset($row['impression_all']) ? $row['impression_all'] : NULL;
                         for($i = 1; $i <= 50; $i++){
                             $_SESSION['player_impression_['.$i.']'] = isset($row['player_impression_['.$i.']']) ? $row['player_impression_['.$i.']'] : NULL;
                             $_SESSION['impression_player_['.$i.']'] = isset($row['impression_player_['.$i.']']) ? $row['impression_player_['.$i.']'] : NULL;
                             $_SESSION['impression_scene_['.$i.']'] = isset($row['impression_scene_['.$i.']']) ? $row['impression_scene_['.$i.']'] : NULL;
                             if($i <= 10){
                                 $_SESSION['related_performances_['.$i.']'] = isset($row['related_performances_['.$i.']']) ? $row['rerated_performances_['.$i.']'] : NULL;
                             }
                             if($i <= 30){
                                 $_SESSION['picture_['.$i.']'] = isset($row['picture_['.$i.']']) ? $row['picture_['.$i.']'] : NULL;
                             }
                         }
                         $_SESSION['impression_final'] = isset($row['impression_final']) ? $row['impression_final'] : NULL;
                     }
                 }catch(PDOException $e){
                     //トランザクション取り消し
                     $pdo -> rollBack();
                     $errors['error'] = "もう一度やり直してください。";
                     print('Error:'.$e->getMessage());
                 }
             }else{
                 $errors['error'] = "もう一度やり直してください。";
                 header("Location:m6-indivisual-subject-show.php");
             }
         //}
         
         /**
          * 確認する（btn_confirm)を押した後の処理
          */
         if(isset($_POSt['btn_confirm'])){
             if(empty($_GET)){
                 header("Location:m6-login-form.php");
                 exit();
             }else{
                 $_SESSION['performance'] = isset($_POST['performance']) ? $_POST['performance'] : NULL;
                 $_SESSION['theater'] = isset($_POST['theater']) ? $_POST['theater'] : NULL;
                 $_SESSION['date'] = isset($_POST['date']) ? $_POST['date'] : NULL;
                 $_SESSION['open_time'] = isset($_POST['open_time']) ? $_POST['open_time'] : NULL;
                 $_SESSION['close_time'] = isset($_POST['close_time']) ? $_POST['close_time'] : NULL;
                 $_SESSION['stage'] = isset($_POST['stage']) ? $_POST['stage'] : NULL;
                 $_SESSION['seat'] = isset($_POST['seat']) ? $_POST['seat'] : NULL;
                 $_SESSION['first_date'] = isset($_POST['first_date']) ? $_POST['first_date'] : NULL;
                 $_SESSION['final_date'] = isset($_POST['final_date']) ? $_POST['final_date'] : NULL;
                 $_SESSION['organizer'] = isset($_POST['organizer']) ? $_POST['organizer'] : NULL;
                 $_SESSION['director'] = isset($_POST['director']) ? $_POST['director'] : NULL;
                 $_SESSION['author'] = isset($_POST['author']) ? $_POST['author'] : NULL;
                 $_SESSION['dance'] = isset($_POST['dance']) ? $_POST['dance'] : NULL;
                 $_SESSION['music'] = isset($_POST['music']) ? $_POST['music'] : NULL;
                 $_SESSION['lyrics'] = isset($_POST['lyrics']) ? $_POST['lyrics'] : NULL;
                 $_SESSION['cloth'] = isset($_POST['cloth']) ? $_POST['cloth'] : NULL;
                 $_SESSION['light'] = isset($_POST['light']) ? $_POST['light'] : NULL;
                 $_SESSION['property'] = isset($_POST['property']) ? $_POST['property'] : NULL;
                 $_SESSION['players'] = isset($_POST['players']) ? $_POST['players']: NULL;
                 $_SESSION['scenario'] = isset($_POST['scenario']) ? $_POST['scenario']: NULL;
                 $_SESSION['impression_all'] = isset($_POST['impression_all']) ? $_POST['impression_all'] : NULL;
                 for($i = 1; $i <= 50; $i++){
                     $_SESSION['player_impression_['.$i.']'] = isset($_POST['player_impression_['.$i.']']) ? $_POST['player_impression_['.$i.']'] : NULL;
                     $_SESSION['impression_player_['.$i.']'] = isset($_POST['impression_player_['.$i.']']) ? $_POST['impression_player_['.$i.']'] : NULL;
                     $_SESSION['impression_scene_['.$i.']'] = isset($_POST['impression_scene_['.$i.']']) ? $_POST['impression_scene_['.$i.']'] : NULL;
                     if($i <= 10){
                         $_SESSION['related_performances_['.$i.']'] = isset($_POST['related_performances_['.$i.']']) ? $_POST['rerated_performances_['.$i.']'] : NULL;
                     }
                     if($i <= 30){
                         $_SESSION['picture_['.$i.']'] = isset($_POST['picture_['.$i.']']) ? $_POST['picture_['.$i.']'] : NULL;
                     }
                 }
                 $_SESSION['impression_final'] = isset($_POST['impression_final']) ? $_POST['impression_final'] : NULL;             
             }
         }
         
         /**
          * 戻る（btn_back）を押した後の処理
          */
         if(isset($_POST['btn_back'])){
             if(empty($_GET)){
                 header("Location:m6-login-form.php");
                 exit();
             }else{
                 header("Location:m6-indivisual-subject-edit.php");
                 exit();
             }
         }
         
         /**
          * 登録する(btn_submit)を押した後の処理
          */
         if(isset($_POST['btn_submit'])){
             if(empty($_GET)){
                 header("Location:m6-login-form.php");
                 exit();
             }else{
                 $id = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
                 $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;
                 if($id !== NULL && $userid !== NULL){
                     $performance = $_SESSION['performance'];
                     $theater = $_SESSION['theater'];
                     $date = $_SESSION['date'];
                     $open_time = $_SESSION['open_time'];
                     $close_time = $_SESSION['close_time'];
                     $stage = $_SESSION['stage'];
                     $seat = $_SESSION['seat'];
                     $first_date = $_SESSION['first_date'];
                     $final_date = $_SESSION['final_date'];
                     $organizer = $_SESSION['organizer'];
                     $director  = $_SESSION['director'];
                     $author = $_SESSION['author'];
                     $dance = $_SESSION['dance'];
                     $music = $_SESSION['music'];
                     $lyrics = $_SESSION['lyrics'];
                     $cloth = $_SESSION['cloth'];
                     $light = $_SESSION['light'];
                     $property = $_SESSION['property'];
                     $players = $_SESSION['players'];
                     $scenario = $_SESSION['scenario'];
                     $impression_all = $_SESSION['impression_all'];
                     for($i = 1; $i <= 50; $i++){
                         $player_impression[$i] = $_SESSION['player_impression_['.$i.']'];
                         $impression_player[$i] = $_SESSION['impression_player_['.$i.']'];
                         $impression_scene[$i] = $_SESSION['impression_scene_['.$i.']'];
                         if($i <= 10){
                             $related_performances[$i] = $_SESSION['related_performances_['.$i.']'];
                         }
                     }
                     $impression_final = $_SESSION['impression_final'];             
                     try{
                         $sql_edit = 'UPDATE impression 
                                      SET performance=:performance, theater=:theater, date=:date, open_time=:open_time, close_time=:close_time, stage=:stage, seat=:seat,
                                          first_day=:first_day, final_day=:final_day, organizer=:organizer, director=:director, author=:author, dance=:dance,
                                          music=:music, lyrics=:lyrics, cloth=:cloth, light=:light, property=:property, players=:players, scenario=:scenario, impression_all=:impression_all,
                                          player_impression[1]=:player_impression[1], player_impression[2]=:player_impression[2], player_impression[3]=:player_impression[3], player_impression[4]=:player_impression[4], player_impression[5]=:player_impression[5], 
                                          player_impression[6]=:player_impression[6], player_impression[7]=:player_impression[7], player_impression[8]=:player_impression[8], player_impression[9]=:player_impression[9], player_impression[10]=:player_impression[10], 
                                          player_impression[11]=:player_impression[11], player_impression[12]=:player_impression[12], player_impression[13]=:player_impression[13], player_impression[14]=:player_impression[14], player_impression[15]=:player_impression[15], 
                                          player_impression[16]=:player_impression[16], player_impression[17]=:player_impression[17], player_impression[18]=:player_impression[18], player_impression[19]=:player_impression[19], player_impression[20]=:player_impression[20], 
                                          player_impression[21]=:player_impression[21], player_impression[22]=:player_impression[22], player_impression[23]=:player_impression[23], player_impression[24]=:player_impression[24], player_impression[25]=:player_impression[25], 
                                          player_impression[26]=:player_impression[26], player_impression[27]:=player_impression[27], player_impression[28]=:player_impression[28], player_impression[29]=:player_impression[29], player_impression[30]=:player_impression[30], 
                                          player_impression[31]=:player_impression[31], player_impression[32]=:player_impression[32], player_impression[33]=:player_impression[33], player_impression[34]=:player_impression[34], player_impression[35]=:player_impression[35], 
                                          player_impression[36]=:player_impression[36], player_impression[37]=:player_impression[37], player_impression[38]=:player_impression[38], player_impression[39]=:player_impression[39], player_impression[40]=:player_impression[40], 
                                          player_impression[41]=:player_impression[41], player_impression[42]=:player_impression[42], player_impression[43]=:player_impression[43], player_impression[44]=:player_impression[44], player_impression[45]=:player_impression[45], 
                                          player_impression[46]=:player_impression[46], player_impression[47]=:player_impression[47], player_impression[48]=:player_impression[48], player_impression[49]=:player_impression[49], player_impression[50]=:player_impression[50], 
                                          impression_player[1]=:impression_player[1], impression_player[2]=:impression_player[2], impression_player[3]=:impression_player[3], impression_player[4]=:impression_player[4], impression_player[5]=:impression_player[5], 
                                          impression_player[6]=:impression_player[6], impression_player[7]=:impression_player[7], impression_player[8]=:impression_player[8], impression_player[9]=:impression_player[9], impression_player[10]=:impression_player[10], 
                                          impression_player[11]=:impression_player[11], impression_player[12]=:impression_player[12], impression_player[13]=:impression_player[13], impression_player[14]=:impression_player[14], impression_player[15]=:impression_player[15], 
                                          impression_player[16]=:impression_player[16], impression_player[17]=:impression_player[17], impression_player[18]=:impression_player[18], impression_player[19]=:impression_player[19], impression_player[20]=:impression_player[20], 
                                          impression_player[21]=:impression_player[21], impression_player[22]=:impression_player[22], impression_player[23]=:impression_player[23], impression_player[24]=:impression_player[24], impression_player[25]=:impression_player[25], 
                                          impression_player[26]=:impression_player[26], impression_player[27]:=impression_player[27], impression_player[28]=:impression_player[28], impression_player[29]=:impression_player[29], impression_player[30]=:impression_player[30], 
                                          impression_player[31]=:impression_player[31], impression_player[32]=:impression_player[32], impression_player[33]=:impression_player[33], impression_player[34]=:impression_player[34], impression_player[35]=:impression_player[35], 
                                          impression_player[36]=:impression_player[36], impression_player[37]=:impression_player[37], impression_player[38]=:impression_player[38], impression_player[39]=:impression_player[39], impression_player[40]=:impression_player[40], 
                                          impression_player[41]=:impression_player[41], impression_player[42]=:impression_player[42], impression_player[43]=:impression_player[43], impression_player[44]=:impression_player[44], impression_player[45]=:impression_player[45], 
                                          impression_player[46]=:impression_player[46], impression_player[47]=:impression_player[47], impression_player[48]=:impression_player[48], impression_player[49]=:impression_player[49], impression_player[50]=:impression_player[50],
                                          impression_final=:impression_final,
                                          related_performance[1]=:related_performance[1], related_performance[2]=:related_performance[2], related_performance[3]=:related_performance[3], related_performance[4]=:related_performance[4], related_performance[5]=:related_performance[5], 
                                          related_performance[6]=:related_performance[6], related_performance[7]=:related_performance[7], related_performance[8]=:related_performance[8], related_performance[9]=:related_performance[9], related_performance[10]=:related_performance[10]
                                      WHERE id=:id AND userid=:userid';
                         $stmt_edit = $pdo -> prepare($sql_edit);
                         $stmt_edit -> bindParam(':performance', $performance, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':theater', $theater, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':date', $date, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':open_time', $open_time, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':close_time', $close_time, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':stage', $stage, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':seat', $seat, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':first_date', $first_date, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':final_date', $final_date, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':organizer', $organizer, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':director', $director, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':author', $author, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':dance', $dance, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':music', $music, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':lyrics', $lyrics, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':cloth', $cloth, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':light', $light, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':property', $property, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':players', $players, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':scenario', $scenario, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':impression_all', $impression_all, PDO::PARAM_STR);
                         for($i=1; $i<51; $i++){
                             $stmt_edit -> bindParam(':player_impression['.$i.']', $player_impression[$i], PDO::PARAM_STR);
                             $stmt_edit -> bindParam(':impression_player['.$i.']', $impression_player[$i], PDO::PARAM_STR);
                             if($i<11){
                                 $stmt_edit -> bindParam(':related_performance['.$i.']', $related_performance[$i], PDO::PARAM_STR);
                             }
                         }
                         $stmt_edit -> bindParam(':impression_final', $impression_final, PDO::PARAM_STR);
                         $stmt_edit -> bindParam(':id', $id, PDO::PARAM_INT);
                         $stmt_edit -> bindParam(':userid', $userid, PDO::PARAM_INT);
                         $stmt_edit -> execute();
                         
                         $_SESSION = array();
                         $_SESSION['userid'] = $userid;
                     }catch(PDOException $e){
                         //トランザクション取り消し
                         $pdo -> rollBack();
                         $errors['error'] = "もう一度やり直してください。";
                         print('Error:'.$e->getMessage());
                     }
                 }
             }
         }
     ?>
     
<html>
<body>     
     <h1>楽しかった公演の記録をどうぞ！</h1>
   <!-- page3 完了画面 -->
     <?php if(count($errors) === 0 && isset($_POST['btn_submit'])): ?>
   　     追記されました。
   　<p>詳細ページ<a href="m6-indivisual-subject-show.php">こちら</a></p>
   　
   <!-- page2 確認画面 -->
     <?php elseif(count($errors) === 0 && isset($_POST["btn_confirm"])): ?>
         <form action="" method="post" enctype="multipart/form-data">
				   <p>公演：<?php echo $_SESSION['performance']; ?></p>
				   <p>劇団：<?php echo $_SESSION['theater']; ?></p>
				   <p>観劇日：<?php echo $_SESSION['date']; ?></p>
				   <p>開演時刻：<?php echo $_SESSION['open_time']; ?> ∼　終演時刻：<? $_SESSION['close_time'] ?></p>
				   <p>観劇した劇場：<?php echo $_SESSION['stage']; ?></p>
				   <p>座席：<?php echo $_SESSION['seat']; ?></p>
				   <p>主催：<?php echo $_SESSION['organizer']; ?></p>
				   <p>演出：<?php echo $_SESSION['director']; ?></p>
				   <p>作家：<?php echo $_SESSION['author']; ?></p>
				   <p>振付：<?php echo $_SESSION['dance']; ?></p>
				   <p>音楽：<?php echo $_SESSION['music']; ?></p>
				   <p>作詞：<?php echo $_SESSION['lyrics']; ?></p>
				   <p>衣装：<?php echo $_SESSION['cloth']; ?></p>
				   <p>照明：<?php echo $_SESSION['light']; ?></p>
				   <p>小道具：<?php echo $_SESSION['property']; ?></p>
				   <p>公演期間：<?php echo $_SESSION['first_date']; ?> ~
				                <?php echo $_SESSION['final_date']; ?></p>
				   <p>出演者：<?php echo $_SESSION['players']; ?></p>
				   <p>あらすじ：<?php echo $_SESSION['scenario']; ?></p>
				   <p>全体について思うこと：<?php echo $_SESSION['impression_all']; ?></p>
				   <?php for($i=1; $i<51; $i++){ 
				             if(isset($_SESSION['player_impression_['.$i.']'])): ?>
				   <p>出演者について感想：<?php echo $_SESSION['player_impression_['.$i.']']; ?> 
				      出演者に対するコメント：<?php echo $_SESSION['impression_player_['.$i.']']; ?></p>
				   <?php     else :
				                 break;
				             endif; 
				          }?>
				   <?php for ($i=1; $i<51; $i++){ 
				             if(isset($_SESSION['impression_scene_['.$i.']'])): ?>
				   <p>好きな場面とその理由：<?php echo $_SESSION['impression_scene_['.$i.']']; ?></p>
                   <?php     else :
                                 break;
                             endif; 
                         } ?>
	   			   <p>最後に：<?php echo $_SESSION['impression_final']; ?></p>
	   			   <?php for($i=1; $i<11; $i++){ 
	   			             if(isset($_SESSION['related_performance_['.$i.']'])): ?>
	   			   <p>関連のある公演：<?php echo $_SESSION['related_performances_['.$i.']']; ?></p>
	   			   <?php     else :
	   			                 break;
	   			             endif;
	   			         }
	   			   
             
             <input type="submit" name="btn_back" value="戻る">
             <input type="submit" name="btn_submit" value="登録する">
         </form>
   
     <!-- page1 登録画面 -->
     <?php if(count($errors) > 0):?>
             <?php 
             foreach($errors as $value){
                 echo "<p class='error'>".$value."</p>";
             }
             ?>
         <?php endif; ?>
     <?php elseif($flag === 1 || isset($_POST["btn_back"])): ?>
                 <form action="" method="post" enctype="multipart/form-data">
				   <p>公演：<input type="text" name="performance" value="<?php if( !empty($_SESSION['peformance']) ){ echo $_SESSION['peformance']; } ?>"></p>
				   <p>劇団：<input type="text" name="theater" value="<?php if( !empty($_SESSION['theater']) ){ echo $_SESSION['theater']; } ?>"></p>
				   <p>観劇日：<input type="date" name="date" value="<?php if( !empty($_SESSION['date']) ){ echo $_SESSION['date']; }else{ echo "2021-07-04"; } ?>"></p>
				   <p>開演時刻：<input type="time" name="open_time" value="<?php if( !empty($_SESSION['open_time']) ){ echo $_SESSION['open_time']; }else{ echo "13:00"; } ?>">
				                ~ 終演時刻：<input type="time" name="close_time" value="<?php if( !empty($_SESSION['close_time']) ){ echo $_SESSION['close_time']; }else{ echo "16:00"; } ?>"></p>
				   <p>観劇した劇場：<input type="text" name="stage" value="<?php if( !empty($_SESSION['stage']) ){ echo $_SESSION['stage']; } ?>"></p>
				   <p>座席：<input type="text" name="seat" value="<?php if(!empty($_SESSION['seat'])){ echo $_SESSION['seat']; } ?>"></p>
				   <p>公演期間：<input type="date" name="firstdate" value="<?php if( !empty($_SESSION['firstdate']) ){ echo $_SESSION['firstdate']; } ?>"> ~
				                <input type="date" name="finaldate" value="<?php if( !empty($_SESSION['finaldate']) ){ echo $_SESSION['finaldate']; } ?>"></p>
				   <p>主催：<input type="text" name="organizer" value="<?php if( !empty($_SESSION['organizer']) ){ echo $_SESSION['organizer']; } ?>"></p>
				   <p>演出：<input type="text" name="director" value="<?php if( !empty($_SESSION['value']) ){ echo $_SESSION['value']; } ?>"></p>
				   <p>作家：<input type="text" name="author" value="<?php if( !empty($_SESSION['author']) ){ echo $_SESSION['author']; } ?>"></p>
				   <p>振付：<input type="text" name="dance" value="<?php if( !empty($_SESSION['dance']) ){ echo $_SESSION['dance']; } ?>"></p>
                   <p>音楽：<input type="text" name="music" value="<?php if( !empty($_SESSION['music']) ){ echo $_SESSION['music']; } ?>"></p>
                   <p>作詞：<input type="text" name="lyrics" value="<?php if( !empty($_SESSION['lyrics']) ){ echo $_SESSION['lyrics']; } ?>"></p>
				   <p>衣装：<input type="text" name="cloth" value="<?php if( !empty($_SESSION['cloth']) ){ echo $_SESSION['cloth']; } ?>"></p>
				   <p>照明：<input type="text" name="light" value="<?php if( !empty($_SESSION['light']) ){ echo $_SESSION['light']; } ?>"></p>
				   <p>小道具：<input type="text" name="property" value="<?php if( !empty($_SESSION['property']) ){ echo $_SESSION['property']; } ?>"></p>
				   
				   <p>出演者：<input type="text" name="players" value="<?php if( !empty($_SESSION['players']) ){ echo $_SESSION['players']; } ?>"></p>
				   <p>あらすじ：<input type="text" name="scenario" value="<?php if( !empty($_SESSION['scenario']) ){ echo $_SESSION['scenario']; } ?>"></p>
				   <p>全体について思うこと：<input type="text" name="impression_all" value="<?php if( !empty($_SESSION['impression_all']) ){ echo $_SESSION['impression_all']; } ?>"></p>
				   <p>出演者：<input type="text" name="player_impression_[1]" class = "text" value="<?php if( !empty($_SESSION['player_impression_[1]']) ){ echo $_SESSION['player_impression_[1]']; } ?>"> 
				      出演者に対するコメント：<input type="text" name="impression_player_[1]" value="<?php if( !empty($_SESSION['impression_player_[1]']) ){ echo $_SESSION['impression_player_[1]']; } ?>"></p>
				   <?php for($i=2; $i <51; $i++){
				             if(isset($_SESSION['player_impression_['.$i.']'])): ?>
				   <p>出演者：<input type="text" name="player_impression_[<?php $i ?>]" class = "text" value="<?php if( !empty($_SESSION['player_impression_['.$i.']']) ){ echo $_SESSION['player_impression_['.$i.']']; } ?>"> 
				      出演者に対するコメント：<input type="text" name="impression_player_[<?php $i ?>]" value="<?php if( !empty($_SESSION['impression_player_['.$i.']']) ){ echo $_SESSION['impression_player_['.$i.']']; } ?>"></p>
                   <?php     else :
                                 break;
                             endif;
				          } ?>
				   <button id="add-player" type="button">追加</button>
				   <p>好きな場面とその理由：<input type="text" name="impression_scene_[1]" value="<?php if( !empty($_SESSION['impression_scene[1]']) ){ echo $_SESSION['impression_scene_[1]']; } ?>"></p>
				   <?php for($i=2; $i<51; $i++){
				             if(isset($_SESSION['impression_scene['.$i.']'])): ?>
				   <p><input type="text" name="impression_scene_[<?php $i ?>]" value="<?php if( !empty($_SESSION['impression_scene['.$i.']']) ){ echo $_SESSION['impression_scene_['.$i.']']; } ?>"></p>
	   			   <?php     else :
	   			                  break;
	   			             endif;
				          } ?>
	   			   <button id="add-scene" type="button">追加</button>
	   			   <p>最後に：<input type="text" name="impression_final" value="<?php if( !empty($_SESSION['impression_final']) ){ echo $_SESSION['impression_final']; } ?>"></p>
	   			   <p>関連のある公演：
	   			   <select name='related_performances_[1]' value="<?php if( !empty($_SESSION['related_performances_[1]']) ){ echo $_SESSION['related_performances_[1]']; } ?>">
	   			   <?php for($i=2; $i<11; $i++){
	   			             if(isset($_SESSION['related_performances_['.$i.']'])): ?>
	   			   <select name='related_performances_[<?php $i ?>]' value="<?php if( !empty($_SESSION['related_performances_['.$i.']']) ){ echo $_SESSION['related_performances_['.$i.']']; } ?>">
                         <?php // optionタグを出力
                             echo $stages_array; ?>
                   <?php     else :
                                  break;
                             endif;
	   			          } ?>
                   </select></p>
                   <td ><button id="add" type="button">追加</button></td>
                   
                     <input type="submit" name="btn_confirm" value="確認する">
                     <p><a href="m6-indivisual-home.php">戻る</a></p>
                 </form>
	<?php endif; ?>   
</body>
</html>    
