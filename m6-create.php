<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>本登録画面</title>
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
         
         // 成功・エラーメッセージの初期化
         $errors = array();
         
         if(empty($_GET)){
             header("Location:m6-pre-create.php");
             exit();
         }else{ 
             $urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
	         
	         //メール入力判定
	         if ($urltoken === ''){
		        $errors['urltoken'] = "トークンがありません。";
	         }else{
	            $flag = 0;
	            $date = date('Y-m-d H:i:s',strtotime("- 24hours"));
	            //flagが0の未登録者 or 仮登録日から24時間以内
			    $sql_confirm = "SELECT email FROM pre_user WHERE urltoken=:urltoken AND (flag=:flag OR date<=:date)";
                $stmt_confirm = $pdo->prepare($sql_confirm);
			    $stmt_confirm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			    $stmt_confirm->bindValue(':flag', $flag, PDO::PARAM_INT);
			    $stmt_confirm->bindValue(':date', $date, PDO::PARAM_STR);
			    $stmt_confirm->execute();
			    $count_confirm = $stmt_confirm -> rowCount();
			 
		    	//24時間以内に仮登録され、本登録されていないトークンの場合
			    if($count_confirm == 1){
			         $sql_confirm = "SELECT * FROM pre_user WHERE urltoken=:urltoken AND (flag=:flag OR date<=:date)";
			         $stmt_confirm = $pdo -> prepare($sql_confirm);
			         $stmt_confirm -> bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			         $stmt_confirm -> bindValue(':flag', $flag, PDO::PARAM_INT);
			         $stmt_confirm -> bindValue(':date', $date, PDO::PARAM_STR);
			         $stmt_confirm -> execute();
				     $email_array = $stmt_confirm -> fetchAll();
				     foreach($email_array as $row){
				          $email = $row['email'];
				     }
				     $_SESSION['email'] = $email;
			    }else{
				     $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。";
		   	    }
		   	    
             }
         }
         
         /**
         * 確認する(btn_confirm)押した後の処理
         */
        
         if(isset($_POST['btn_confirm'])){
             if(empty($_POST)){
                 header("Location: m6-pre-create.php");
                 exit();
             }else{
                 //POSTされたデータを変数に入れる
                 $username = isset($_POST['username']) ? $_POST['username']:NULL;
                 $password = isset($_POST['password']) ? $_POST['password']:NULL;
                 $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password']:NULL;
                 
                 //セッションに登録
                 
                 
                 
                 //アカウント入力判定
                 //パスワード入力判定
                 if($username == "" || $password == "" || $confirm_password == ""){
                     if($username == ""){
                         $errors['username'] = "ユーザー名が入力されていません。";
                     }
                     if(($password === "") || ($confirm_password === "")){
                         if($password === ""){
                             $errors['password'] = "パスワードが入力されていません。";
                         }
                         if($confirm_password === ""){
                             $errors['confirm_password'] = "パスワード（確認）が入力されていません。";
                         }
                     }
                 }else{
                     if(!empty($errors['username'])){
                         unset($errors['username']);
                     }
                     if(!empty($errors['password'])){
                         unset($errors['password']);
                     }
                     if(!empty($errors['confirm_password'])){
                         unset($errors['confirm_password']);
                     }
                 }
                 if($username != ""){
                     $_SESSION['username'] = $username;
                 }
                 if(count($errors) === 0 && ($password != "") && ($confirm_password != "")){
                     if($password == $confirm_password){
                         $password_hide = str_repeat('*',strlen($password));
                         $_SESSION['password'] = $password;
                         $_SESSION['password_hide'] = $password_hide;
                     }else{
                             $errors['password_confirm'] = "パスワードが一致しません。";
                     }
                 }
             }
         }
         
         /**
          * 登録(btn_submit)を押した後の処理
         */
         if(isset($_POST['btn_submit'])){
             //パスワードのハッシュ化
             $password_hash = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
             $email = $_SESSION['email'];
             $username = $_SESSION['username'];
             
            //ここでデータベースに登録する
            try{
                 $newdate = date('Y-m-d H:i:s');
                 $newstatus = 1;
                 $sql_registerate = "INSERT INTO user (email, username, password, status, createddate, updateddate) VALUES(:email, :username, :password, :status, :createddate, :updateddate)";
                 $stmt_registerate = $pdo -> prepare($sql_registerate);
                 $stmt_registerate -> bindValue(':email', $email, PDO::PARAM_STR);
                 $stmt_registerate -> bindValue(':username', $username, PDO::PARAM_STR);
                 $stmt_registerate -> bindValue(':password', $password_hash, PDO::PARAM_STR);
                 $stmt_registerate -> bindValue(':status', $newstatus, PDO::PARAM_INT);
                 $stmt_registerate -> bindValue(':createddate', $newdate, PDO::PARAM_STR);
                 $stmt_registerate -> bindValue(':updateddate', $newdate, PDO::PARAM_STR);
                 $stmt_registerate -> execute();
             
                 //pre_userのflagを１にする（トークンの無効化）
                 $sql_pre = "UPDATE pre_user SET flag=1 WHERE email=:email";
                 $stmt_pre = $pdo -> prepare($sql_pre);
                 $stmt_pre -> bindValue('email', $email, PDO::PARAM_STR);
                 $stmt_pre -> execute();
             
                 //データベースの接続切断
                 $stmt_registerate = NULL;
                 $stmt_pre = NULL;
             
                 //セッション変数をすべて解除
                 $_SESSION = array();
             
                 //セッションクッキーの削除
                 if (isset($_COOKIE["PHPSESSID"])) {
				     setcookie("PHPSESSID", '', time() - 1800, '/');
		         }
		     
		         //セッションを破棄する
		         session_destroy();
		         
             }catch(PDOException $e){
                 //トランザクション取り消し
                 $pdo -> rollBack();
                 $errors['error'] = "もう一度やり直してください。";
                 print('Error:'.$e->getMessage());
             }
        }
    ?>
    
<body>
   <h1>ようこそ、本登録をお願いします。</h1>
   
   <!-- page3 完了画面 -->
   <?php if(isset($_POST['btn_submit']) && count($errors) == 0): ?>
   　本登録されました。
   　<p>ログインは<a href="m6-login-form.php">こちら</a></p>
   　
   <!-- page2 確認画面 -->
   <?php elseif(isset($_POST['btn_confirm']) && count($errors) == 0): ?>
         <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
             <p>メールアドレス: <?=htmlspecialchars($_SESSION['email'], ENT_QUOTES)?></p>
             <p>ユーザー名: <?=  $_SESSION['username'] ?></p>
             <p>パスワード: <?=$_SESSION['password_hide']?></p>
             
             <input type="submit" name="btn_back" value="戻る">
             <input type="hidden" name="token" value="<?=$_POST['token']?>">
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
    <?php elseif(!isset($errors['urltoken_timeover'])): ?>
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
				   <p>メールアドレス：    <?=htmlspecialchars($email, ENT_QUOTES, 'UTF-8')?></p>
				   <p>ユーザー名：        <input type="text" name="username" value="<?php if( !empty($_SESSION['username']) ){ echo $_SESSION['username']; } ?>"></p>
				   <p>パスワード：        <input type="password" name="password"></p>
				   <p>パスワード（確認）：<input type="password" name="confirm_password"></p>
	   			   <input type="hidden" name="token" value="<?=$token?>">
				   <input type="submit" name="btn_confirm" value="確認する">
	            </form>
	<?php endif; ?>
</body>
</html>
