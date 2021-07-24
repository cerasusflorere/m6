<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>編集ページ</title>
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

         $errors = [];
         $success = "";
         
         $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;
         $performance = isset($_SESSION['performance']) ? $_SESSION['performance'] : NULL;
         
         if($performance !== NULL && $userid !== NULL){
             try{
                 $sql_show = 'SELECT * FROM impression WHERE userid=:userid AND performance=:performance';
                 $stmt_show = $pdo -> prepare($sql_show);
                 $stmt_show -> bindParam(':userid', $userid, PDO::PARAM_INT);
                 $stmt_show -> bindParam(':performance', $performance, PDO::PARAM_STR);
                 $stmt_show -> execute();
                 $results_show = $stmt_show -> fetchAll();
                    
                 foreach($results_show as $row){
                     $_SESSION['id'] = $row['id'];
                     $_SESSION['performance'] = $row['performance'];
                     $_SESSION['theater'] = $row['theater'];
                     $_SESSION['date'] = $row['date'];
                     $_SESSION['open_time'] = $row['open_time'];
                     $_SESSION['close_time'] = $row['close_time'];
                     $_SESSION['stage'] = $row['stage'];
                     $_SESSION['seat'] = $row['seat'];
                     $_SESSION['first_date'] = $row['first_date'];
                     $_SESSION['final_date'] = $row['final_date'];
                     $_SESSION['organizer'] = $row['organizer'];
                     $_SESSION['director'] = $row['director'];
                     $_SESSION['author'] = $row['author'];
                     $_SESSION['dance'] = $row['dance'];
                     $_SESSION['music'] = $row['music'];
                     $_SESSION['lyrics'] = $row['lyrics'];
                     $_SESSION['cloth'] = $row['cloth'];
                     $_SESSION['light'] = $row['light'];
                     $_SESSION['property'] = $row['property'];
                     $_SESSION['players'] = $row['players'];
                     $_SESSION['scenario'] = $row['scenario'];
                     $_SESSION['impression_all'] = $row['impression_all'];
                     for($i = 1; $i < 51; $i++){
                         $_SESSION['player_impression_['.$i.']'] = isset($row['player_impression_'.$i]) ? $row['player_impression_'.$i] : NULL;
                         $_SESSION['impression_player_['.$i.']'] = isset($row['impression_player_'.$i]) ? $row['impression_player_'.$i] : NULL;
                         $_SESSION['impression_scene_['.$i.']'] = isset($row['impression_scene_'.$i]) ? $row['impression_scene_'.$i] : NULL;
                         if($i < 11){
                             $_SESSION['related_performance_['.$i.']'] = isset($row['related_performance_'.$i]) ? $row['rerated_performance_'.$i] : NULL;
                          }
                     }
                     $_SESSION['impression_final'] = isset($row['impression_final']) ? $row['impression_final'] : NULL;
                 }
                 $flag = 1;
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
         
         
         /**
          * 確認する（btn_confirm)を押した後の処理
          */
         if(isset($_POST['btn_confirm'])){
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
             }
             $_SESSION['impression_final'] = isset($_POST['impression_final']) ? $_POST['impression_final'] : NULL;
         }
         
         /**
          * 戻る（btn_back）を押した後の処理
          */
         if(isset($_POST['btn_back'])){
                 header("Location:m6-indivisual-subject-edit.php");
                 exit();
         }
         
         /**
          * 登録する(btn_submit)を押した後の処理
          */
         if(isset($_POST['btn_submit'])){
             $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : NULL;
                 
             if($userid !== NULL){
                 $id = $_SESSION['id'];
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
                 for($i = 1; $i < 51; $i++){
                     $player_impression[$i] = $_SESSION['player_impression_['.$i.']'];
                     $impression_player[$i] = $_SESSION['impression_player_['.$i.']'];
                     $impression_scene[$i] = $_SESSION['impression_scene_['.$i.']'];
                     if($i < 11){
                         $related_performances[$i] = $_SESSION['related_performances_['.$i.']'];
                     }
                 }
                 $impression_final = $_SESSION['impression_final'];             
                 try{
                     $sql_edit = 'UPDATE impression 
                                  SET performance=:performance, theater=:theater, date=:date, open_time=:open_time, close_time=:close_time, stage=:stage, seat=:seat,
                                      first_date=:first_date, final_date=:final_date, organizer=:organizer, director=:director, author=:author, dance=:dance,
                                      music=:music, lyrics=:lyrics, cloth=:cloth, light=:light, property=:property, players=:players, scenario=:scenario, impression_all=:impression_all,
                                      player_impression_1=:player_impression_1, player_impression_2=:player_impression_2, player_impression_3=:player_impression_3, player_impression_4=:player_impression_4, player_impression_5=:player_impression_5, 
                                      player_impression_6=:player_impression_6, player_impression_7=:player_impression_7, player_impression_8=:player_impression_8, player_impression_9=:player_impression_9, player_impression_10=:player_impression_10, 
                                      player_impression_11=:player_impression_11, player_impression_12=:player_impression_12, player_impression_13=:player_impression_13, player_impression_14=:player_impression_14, player_impression_15=:player_impression_15,
                                      player_impression_16=:player_impression_16, player_impression_17=:player_impression_17, player_impression_18=:player_impression_18, player_impression_19=:player_impression_19, player_impression_20=:player_impression_20, 
                                      player_impression_21=:player_impression_21, player_impression_22=:player_impression_22, player_impression_23=:player_impression_23, player_impression_24=:player_impression_24, player_impression_25=:player_impression_25, 
                                      player_impression_26=:player_impression_26, player_impression_27=:player_impression_27, player_impression_28=:player_impression_28, player_impression_29=:player_impression_29, player_impression_30=:player_impression_30, 
                                      player_impression_31=:player_impression_31, player_impression_32=:player_impression_32, player_impression_33=:player_impression_33, player_impression_34=:player_impression_34, player_impression_35=:player_impression_35, 
                                      player_impression_36=:player_impression_36, player_impression_37=:player_impression_37, player_impression_38=:player_impression_38, player_impression_39=:player_impression_39, player_impression_40=:player_impression_40, 
                                      player_impression_41=:player_impression_41, player_impression_42=:player_impression_42, player_impression_43=:player_impression_43, player_impression_44=:player_impression_44, player_impression_45=:player_impression_45, 
                                      player_impression_46=:player_impression_46, player_impression_47=:player_impression_47, player_impression_48=:player_impression_48, player_impression_49=:player_impression_49, player_impression_50=:player_impression_50, 
                                      impression_player_1=:impression_player_1, impression_player_2=:impression_player_2, impression_player_3=:impression_player_3, impression_player_4=:impression_player_4, impression_player_5=:impression_player_5, 
                                      impression_player_6=:impression_player_6, impression_player_7=:impression_player_7, impression_player_8=:impression_player_8, impression_player_9=:impression_player_9, impression_player_10=:impression_player_10, 
                                      impression_player_11=:impression_player_11, impression_player_12=:impression_player_12, impression_player_13=:impression_player_13, impression_player_14=:impression_player_14, impression_player_15=:impression_player_15, 
                                      impression_player_16=:impression_player_16, impression_player_17=:impression_player_17, impression_player_18=:impression_player_18, impression_player_19=:impression_player_19, impression_player_20=:impression_player_20, 
                                      impression_player_21=:impression_player_21, impression_player_22=:impression_player_22, impression_player_23=:impression_player_23, impression_player_24=:impression_player_24, impression_player_25=:impression_player_25, 
                                      impression_player_26=:impression_player_26, impression_player_27=:impression_player_27, impression_player_28=:impression_player_28, impression_player_29=:impression_player_29, impression_player_30=:impression_player_30, 
                                      impression_player_31=:impression_player_31, impression_player_32=:impression_player_32, impression_player_33=:impression_player_33, impression_player_34=:impression_player_34, impression_player_35=:impression_player_35, 
                                      impression_player_36=:impression_player_36, impression_player_37=:impression_player_37, impression_player_38=:impression_player_38, impression_player_39=:impression_player_39, impression_player_40=:impression_player_40, 
                                      impression_player_41=:impression_player_41, impression_player_42=:impression_player_42, impression_player_43=:impression_player_43, impression_player_44=:impression_player_44, impression_player_45=:impression_player_45, 
                                      impression_player_46=:impression_player_46, impression_player_47=:impression_player_47, impression_player_48=:impression_player_48, impression_player_49=:impression_player_49, impression_player_50=:impression_player_50, 
                                      impression_scene_1=:impression_scene_1, impression_scene_2=:impression_scene_2, impression_scene_3=:impression_scene_3, impression_scene_4=:impression_scene_4, impression_scene_5=:impression_scene_5, 
                                      impression_scene_6=:impression_scene_6, impression_scene_7=:impression_scene_7, impression_scene_8=:impression_scene_8, impression_scene_9=:impression_scene_9, impression_scene_10=:impression_scene_10, 
                                      impression_scene_11=:impression_scene_11, impression_scene_12=:impression_scene_12, impression_scene_13=:impression_scene_13, impression_scene_14=:impression_scene_14, impression_scene_15=:impression_scene_15, 
                                      impression_scene_16=:impression_scene_16, impression_scene_17=:impression_scene_17, impression_scene_18=:impression_scene_18, impression_scene_19=:impression_scene_19, impression_scene_20=:impression_scene_20, 
                                      impression_scene_21=:impression_scene_21, impression_scene_22=:impression_scene_22, impression_scene_23=:impression_scene_23, impression_scene_24=:impression_scene_24, impression_scene_25=:impression_scene_25, 
                                      impression_scene_26=:impression_scene_26, impression_scene_27=:impression_scene_27, impression_scene_28=:impression_scene_28, impression_scene_29=:impression_scene_29, impression_scene_30=:impression_scene_30, 
                                      impression_scene_31=:impression_scene_31, impression_scene_32=:impression_scene_32, impression_scene_33=:impression_scene_33, impression_scene_34=:impression_scene_34, impression_scene_35=:impression_scene_35, 
                                      impression_scene_36=:impression_scene_36, impression_scene_37=:impression_scene_37, impression_scene_38=:impression_scene_38, impression_scene_39=:impression_scene_39, impression_scene_40=:impression_scene_40,
                                      impression_scene_41=:impression_scene_41, impression_scene_42=:impression_scene_42, impression_scene_43=:impression_scene_43, impression_scene_44=:impression_scene_44, impression_scene_45=:impression_scene_45, 
                                      impression_scene_46=:impression_scene_46, impression_scene_47=:impression_scene_47, impression_scene_48=:impression_scene_48, impression_scene_49=:impression_scene_49, impression_scene_50=:impression_scene_50,                                                     
                                      impression_final=:impression_final,
                                      related_performance_1=:related_performance_1, related_performance_2=:related_performance_2, related_performance_3=:related_performance_3, related_performance_4=:related_performance_4, related_performance_5=:related_performance_5, 
                                      related_performance_6=:related_performance_6, related_performance_7=:related_performance_7, related_performance_8=:related_performance_8, related_performance_9=:related_performance_9, related_performance_10=:related_performance_10
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
                         $stmt_edit -> bindParam(":player_impression_{$i}", $player_impression[$i], PDO::PARAM_STR);
                         $stmt_edit -> bindParam(":impression_player_{$i}", $impression_player[$i], PDO::PARAM_STR);
                         $stmt_edit -> bindParam(":impression_scene_{$i}", $impression_scene[$i], PDO::PARAM_STR);
                         if($i<11){
                             $stmt_edit -> bindParam("related_performance_{$i}", $related_performance[$i], PDO::PARAM_STR);
                         }
                     }
                     $stmt_edit -> bindParam(':impression_final', $impression_final, PDO::PARAM_STR);
                     $stmt_edit -> bindParam(':id', $id, PDO::PARAM_INT);
                     $stmt_edit -> bindParam(':userid', $userid, PDO::PARAM_INT);
                     
                     $stmt_edit -> execute();
                         
                     $_SESSION = array();
                     $_SESSION['userid'] = $userid;
                     $success = "編集できました。";
                 }catch(PDOException $e){
                     //トランザクション取り消し
                     $pdo -> rollBack();
                     $errors['error'] = "もう一度やり直してください。";
                     print('Error:'.$e->getMessage());
                 }
             }
         }
     ?>
     
<html>
<body>     
     <h1>楽しかった公演の記録をどうぞ！</h1>
   <!-- page3 完了画面 -->
     <?php if(count($errors) === 0 && isset($_POST['btn_submit'])): ?>
        <?php echo $success; ?>
     <form action="m6-indivisual-subject-show.php" method="post" name="<?php echo $_SESSION['performance'] ?>">
                     <p>詳細ページは
                     <a href="m6-indivisual-subject-show.php" onClick="<?php echo 'document.'.$_SESSION['performance'].'.submit();return false;' ?>"><?php echo $_SESSION['performance']; ?></a></p>
                     <input type=hidden name="performance_name" value="<?php echo $_SESSION['performance']; ?>">
     </form>
   　
   <!-- page2 確認画面 -->
          <?php elseif(count($errors) === 0 && isset($_POST['btn_confirm'])): ?>
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
	   			         } ?>
             
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
     <?php elseif($flag === 1 || isset($_POST['btn_back'])): ?>
                 <form action="" method="post" enctype="multipart/form-data">
				   <p>公演：<input type="text" name="performance" value="<?php if( !empty($_SESSION['performance']) ){ echo $_SESSION['performance']; } ?>"></p>
				   <p>劇団：<input type="text" name="theater" value="<?php if( !empty($_SESSION['theater']) ){ echo $_SESSION['theater']; } ?>"></p>
				   <p>観劇日：<input type="date" name="date" value="<?php if( !empty($_SESSION['date']) ){ echo $_SESSION['date']; }else{ echo "2021-07-04"; } ?>"></p>
				   <p>公演時間：<input type="time" name="open_time" value="<?php if( !empty($_SESSION['open_time']) ){ echo $_SESSION['open_time']; }else{ echo "13:00"; } ?>"> ~
				                <input type="time" name="close_time" value="<?php if( !empty($_SESSION['close_time']) ){ echo $_SESSION['close_time']; }else{ echo "16:00"; } ?>"></p>
				   <p>観劇した劇場：<input type="text" name="stage" value="<?php if( !empty($_SESSION['stage']) ){ echo $_SESSION['stage']; } ?>"></p>
				   <p>座席：<input type="text" name="seat" value="<?php if(!empty($_SESSION['stage'])){ echo $_SESSION['seat']; } ?>"></p>
				   <p>公演期間：<input type="date" name="first_date" value="<?php if( !empty($_SESSION['first_date']) ){ echo $_SESSION['first_date']; } ?>"> ~
				                <input type="date" name="final_date" value="<?php if( !empty($_SESSION['final_date']) ){ echo $_SESSION['final_date']; } ?>"></p>
				   <p>主催：<input type="text" name="organizer" value="<?php if( !empty($_SESSION['organizer']) ){ echo $_SESSION['organizer']; } ?>"></p>
				   <p>演出：<input type="text" name="director" value="<?php if( !empty($_SESSION['director']) ){ echo $_SESSION['director']; } ?>"></p>
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
				   <?php for($i=2; $i<51; $i++){
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
				             if(isset($_SESSION['impression_scene_['.$i.']'])): ?>
	   			   <p>好きな場面とその理由：<input type="text" name="impression_scene_[<?php $i ?>]" value="<?php if( !empty($_SESSION['impression_scene['.$i.']']) ){ echo $_SESSION['impression_scene_['.$i.']']; } ?>"></p>
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
                   <td ><button id="add-stage" type="button">追加</button></td><br>
                   
                     <input type="submit" name="btn_confirm" value="確認する"><br>
                     <p><a href="m6-indivisual-home.php">戻る</a></p>
                 </form>
	<?php endif; ?>   
</body>
</html>     
