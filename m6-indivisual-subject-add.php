<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>追加ページ</title>
</head>
</html>
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
         
         $stages_array = array();
         $flag = 0;

         if(empty($_GET)){
             header("Location:m6-login-form.php");
             exit();
         }else{
             $username = isset($_SESSION["username"]) ? $_SESSION["username"] : NULL;
             
             $sql_stages = "SELECT * FROM '{$username}'";
             $stmt_stages = $pdo -> prepare($sql_stages);
             $results_stages = $stmt_stages -> fetchAll();
             foreach($results_stages as $row_stages){
                 $stages_array = $row_stages['performance'];
             }
             foreach($stages_array as $stages_array_key => $stages_array_val){
                 $stages_array .= "<option value='". $stages_array_key;
                 $stages_array .= "'>". $stages_array_val. "</option>";
             }
             $flag = 1;
         }
        
        /**
         * 確認する（btn_confirm）を押した後の処理
        */
         if(isset($_POST('btn_confirm'))){
             if(empty($_GET)){
                 header('Location:m6-login-form.php');
                 exit();
             }else{
                 $_SESSION['performance'] = $_POST['performance'];
                 $_SESSION['date'] = $_POST['date'];
                 $_SESSION['open_time'] = $_POST['open_time'];
                 $_SESSION['close_time'] = $_POST['close_date'];
                 $_SESSION['stage'] = $_POST['stage'];
                 $_SESSION['oraganizer'] = $_POST['organizer'];
                 $_SESSION['director'] = $_POST['director'];
                 $_SESSION['author'] = $_POST['author'];
                 $_SESSION['cloth'] = $_POST['cloth'];
                 $_SESSION['light'] = $_POST['light'];
                 $_SESSION['property'] = $_POST['property'];
                 $_SESSION['firstdate'] = $_POST['firstdate'];
                 $_SESSION['finaldate'] = $_POST['finaldate'];
                 $_SESSION['players'] = $_POST['players'];
                 $_SESSION['scenario'] = $_POST['scenario'];
                 $_SESSION['impression_all'] = $_POST['impression_all'];
                 for($i = 1; $i < )
                 
                 $_SESSION['impression_final'] = $_POST['impression_all'];
                 
             }
         }
     


<script type="text/javascript">
     document.write("Samurai");
     $(function(){
         //出演者に対する感想
         var add_player = $('.add-player');
         
         add_player.click(function(){
             var text = $('.text').last();
             text
                 .clone();
                 .val('');
                 .insertAfter(text);
         });
     });  
</script>

?>
<html>
<body>     
     <h1>楽しかった公演の記録をどうぞ！</h1>
   <!-- page3 完了画面 -->
   <?php if(isset($_POST['btn_submit'])): ?>
   　本登録されました。
   　<p>ログインは<a href="m6-login-form.php">こちら</a></p>
   　
   <!-- page2 確認画面 -->
   <?php elseif(isset($_POST['btn_confirm'])): ?>
         <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
				   <p>公演名：<? $_SESSION['peformance'] ?></p>
				   <p>観劇日：<? $_SESSION['date'] ?></p>
				   <p>開演時刻：<? $_SESSION['open_time'] ?> ∼　終演時刻：<? $_SESSION['close_time'] ?></p>
				   <p>観劇した劇場：<? $_SESSION['stage'] ?></p>
				   <p>主催：<? $_SESSION['organizer'] ?></p>
				   <p>演出：<? $_SESSION['director'] ?></p>
				   <p>作家：<? $_SESSION['author'] ?></p>
				   <p>衣装：<? $_SESSION['cloth'] ?></p>
				   <p>照明：<? $_SESSION['light'] ?></p>
				   <p>小道具：<? $_SESSION['property'] ?></p>
				   <p>公演期間：<? $_SESSION['firstdate'] ?> ~
				                <? $_SESSION['finaldate'] ?></p>
				   <p>出演者：<? $_SESSION['players'] ?></p>
				   <p>あらすじ：<? $_SESSION['scenario'] ?></p>
				   <p>全体について思うこと：<? $_SESSION['impression_all'] ?></p>
				   <p>出演者について感想：<? $_SESSION['player_impression_[]'] ?> 
				      出演者に対するコメント：<? $_SESSION['impression_player_[]'] ?></p>
				   <p>好きな場面とその理由：<? $_SESSION['impression_scene[]'] ?></p>
	   			   <p>最後に：<? $_SESSION['impression_final'] ?></p>
	   			   <p>関連のある公演：<? $_SESSION['rerated_performances_[]'] ?></p>
                   <p>画像：<? $_SESSION['picture_[]'] ?></p>
             
             <input type="submit" name="btn_back" value="戻る">
             <input type="submit" name="btn_submit" value="登録する">
         </form>
   
     <!-- page1 登録画面 -->
    <?php elseif($flag === 1 || isset($_POSET['btn_back'])): ?>
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
				   <p>公演名：<input type="text" name="performance" value="<?php if( !empty($_SESSION['peformance']) ){ echo $_SESSION['peformance']; } ?>"></p>
				   <p>観劇日：<input type="date" name="date" value="<?php if( !empty($_SESSION['date']) ){ echo $_SESSION['date']; }else{ echo "2021-07-04"; } ?>"></p>
				   <p>開演時刻：<input type="time" name="open_time" value="<?php if( !empty($_SESSION['open_time']) ){ echo $_SESSION['open_time']; }else{ echo "13:00"; } ?>">
				                ~ 終演時刻：<input type="time" name="close_time" value="<?php if( !empty($_SESSION['close_time']) ){ echo $_SESSION['close_time']; }else{ echo "16:00"; } ?>"></p>
				   <p>観劇した劇場：<input type="text" name="stage" value="<?php if( !empty($_SESSION['stage']) ){ echo $_SESSION['stage']; } ?>"></p>
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
				   <p>出演者：<input type="text" name="player_impression_[]" class = "text" value="<?php if( !empty($_SESSION['player_impression_[]']) ){ echo $_SESSION['player_impression_[]']; } ?>"> 
				      出演者に対するコメント：<input type="text" name="impression_player_[]" value="<?php if( !empty($_SESSION['impression_player_[]']) ){ echo $_SESSION['impression_player_[]']; } ?>"></p>
				   <button id="add-player" type="button">追加</button>
				   <p>好きな場面とその理由：<input type="text" name="impression_scene_[]" value="<?php if( !empty($_SESSION['impression_scene[]']) ){ echo $_SESSION['impression_scene_[]']; } ?>"></p>
	   			   <button id="add-scene" type="button">追加</button>
	   			   <p>最後に：<input type="text" name="impression_final" value="<?php if( !empty($_SESSION['impression_final']) ){ echo $_SESSION['impression_final']; } ?>"></p>
	   			   <p>関連のある公演：
	   			   <select name='rerated_performances_[]' value="<?php if( !empty($_SESSION['rerated_performances_[]']) ){ echo $_SESSION['rerated_performances_[]']; } ?>">
                         <?php // optionタグを出力
                             echo $stages_array; ?>
                   </select></p>
                   <td ><button id="add" type="button">追加</button></td>
                   <p>画像：<div id="view_1"></div>
                            <input type="file" id = "image_1" name="picture_[]" accept="image/*" value="<?php if( !empty($_SESSION['picture_[]']) ){ echo $_SESSION['picture_[]']; } ?>"></p>
                   <td ><button id="add-picture" type="button">追加</button></td>
				   <input type="submit" name="btn_confirm" value="確認する">
	            </form>
	<?php endif; ?>    
</body>
</html>
