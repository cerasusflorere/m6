<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>本登録画面</title>
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
	            $nowdate = date('YYYY-MM-DD HH:MM:SS');
	            //flagが0の未登録者 or 仮登録日から24時間以内
			    $sql_confirm = "SELECT email FROM pre_user WHERE urltoken=(:urltoken) AND flag = 0 AND date > now() - interval 24 hour";
                            $stmt_confirm = $pdo->prepare($sql_confirm);
			    $stmt_confirm->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			    $stmt_confirm->execute();
			    $count_confirm = $stmt_confirm -> rowCount();
			 
		    	//24時間以内に仮登録され、本登録されていないトークンの場合
			    if($count_confirm ==　1){
				     $email_array = $stmt_confirm -> fetch();
				     $email = $email_array["email"];
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
                 $name = isset($_POST['username']) ? $_POST['username']:NULL;
                 $password = isset($_POST['password']) ? $_POST['password']:NULL;
                 $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm']:NULL;
                 
                 //セッションに登録
                 $_SESSION['username'] = $name;
                 $_SESSION['password'] = $password;
                 
                 //アカウント入力判定
                 //パスワード入力判定
                 if($password != $password_confirm){
                     $errors['password_confirm'] = "パスワードが一致しません。";
                 }
                 
                 if(count($errors) == 0 && ($password === "" || $username === "")){
                     if($password === ""){
                         $errors['password'] = "パスワードが入力されていません。";
                     }else{
                         $passward_hide = str_repeat('*',strlen($passward)); 
                     }
                     if($username === ""){
                         $errors['username'] = "ユーザー名が入力されていません。";
                     }
                 }else{
                     $errors = array();
                 }
             }
         }
         
         /**
          * 登録(btn_submit)を押した後の処理
         */
         if(isset($_POST['btn_submit'])){
             //パスワードのハッシュ化
             $password_hash = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
         
            //ここでデータベースに登録する
            try{
                 $newdate = date('Y-m-d H:i:s');
                 $newstatus = 1;
                 $sql_registerate = "INSERT INTO user (username, password, status, createddate, updateddate)";
                 $stmt_registerate = $pdo -> prepare($sql_registerate);
                 $stmt_registerate -> bindValue(':email', $_SESSION['email'], PDO::PARAM_STR);
                 $stmt_registerate -> bindValue(':username', $_SESSION['username'], PDO::PARAM_STR);
                 $stmt_registerate -> bindValue(':password', $password_harsh, PDO::PARAM_STR);
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
             <?php if(!isset($errors['urltoken_timeover'])): ?>
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?urltoken=<?php print $urltoken; ?>" method="post">
				   <p>メールアドレス：    <?=htmlspecialchars($email, ENT_QUOTES, 'UTF-8')?></p>
				   <p>ユーザー名：        <input type="text" name="name" value="<?php if( !empty($_SESSION['name']) ){ echo $_SESSION['name']; } ?>"></p>
				   <p>パスワード：        <input type="password" name="password"></p>
				   <p>パスワード（確認）：<input type="password" name="confirm_password"></p>
	   			   <input type="hidden" name="token" value="<?=$token?>">
				   <input type="submit" name="btn_confirm" value="確認する">
	            </form>
	         <?php endif; ?>
</body>
</html>
