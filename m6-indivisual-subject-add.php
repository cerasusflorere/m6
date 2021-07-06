<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>追加ページ</title>
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
         $stages_array = array();

         if(empty($_GET)){
             header("Location:m6-login-form.php");
             exit();
         else{
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
         }
     ?>

<body>     
     <h1>楽しかった公演の記録をどうぞ！</h1>
   <!-- page3 完了画面 -->
   <?php if(isset($_POST['btn_submit']) && count($errors) === 0): ?>
   　本登録されました。
   　<p>ログインは<a href="m6-login-form.php">こちら</a></p>
   　
   <!-- page2 確認画面 -->
   <?php elseif(isset($_POST['btn_confirm']) && count($errors) === 0): ?>
         <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
             <p>メールアドレス: <?=htmlspecialchars($_SESSION['email'], ENT_QUOTES)?></p>
             <p>ユーザー名: <?=htmlspecialchars($username, ENT_QUOTES)?></p>
             <p>パスワード: <?=$password_hide?></p>
             
             <input type="submit" name="btn_back" value="戻る">
             <input type="hidden" name="token" value="<?=$_POST['token']?>">
             <input type="submit" name="btn_submit" value="登録する">
         </form>
   <?php endif; ?>
   
     <!-- page1 登録画面 -->
         <?php if(count($errors) > 0):?>
             <?php 
             foreach($errors as $value){
                 echo "<p class='error'>".$value."</p>";
             }
             ?>
         <?php endif; ?>
             
                <form action="" method="post">
				   <p>公演名：    <input type="text" name="performance" value="<?php if( !empty($_SESSION['peformance']) ){ echo $_SESSION['peformance']; } ?>"></p>
				   <p>観劇日：        <input type="date" name="date" value="2021-07-04"></p>
				   <p>開演時刻：   <input type="time" name="time" value="13:00"></p>
				   <p>観劇した劇場：        <input type="text" name="stage"></p>
				   <p>主催：<input type="text" name="organizer"></p>
				   <p>演出：<input type="text" name="director"></p>
				   <p>作家：<input type="text" name="author"></p>
				   <p>公演期間：<input type="date" name="firstdate">
				                <input type="date" name="finaldate"></p>
				   <p>出演者：<input type="text" name="players"></p>
				   <p>あらすじ：<input type="text" name="scenario"></p>
				   <p>全体について思うこと：<input type="text" name="impression_all"></p>
				   <p>出演者：<input type="text" name="player_impression_1"> 出演者に対するコメント：<input type="text" name="impression_player_1"></p>
				   <td ><button id="add" type="button">追加</button></td>
				   <p>好きな場面とその理由：<input type="text" name="impression_scene_1"></p>
	   			   <td ><button id="add" type="button">追加</button></td>
	   			   <p>最後に：<input type="text" name="impression_final"></p>
	   			   <p>関連のある公演：
	   			   <select name='rerated_performances_1'>
                         <?php // ③optionタグを出力
                             echo $stages_array; ?>
                   </select></p>
                   <td ><button id="add" type="button">追加</button></td>
                   <p>画像：<input type="file" name="picture_1"></p>
                   <td ><button id="add" type="button">追加</button></td>
	   			   <input type="hidden" name="token" value="<?=$token?>">
				   <input type="submit" name="btn_confirm" value="確認する">
	            </form>
	         
</body>
</html>
