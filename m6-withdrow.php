<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>退会画面</title>
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
         $flag = 0;
         
         if(empty($_GET)){
             header("Location:m6-login-form.php");
             exit();
         }else{ 
             $flag = 1;
         }
         
         /**
         * 確認する(btn_withdrow_confirm)押した後の処理
         */
        
         if($flag === 1 && isset($_POST['btn_withdrow_confirm'])){
             $flag = 2;
             if(empty($_POST)){
                 header("Location: m6-login-form.php");
                 exit();
             }else{
                 //POSTされたデータを変数に入れる
                 $email = isset($_POST['email']) ? $_POST['email'] : NULL;
                 $name = isset($_POST['username']) ? $_POST['username']:NULL;
                 $password = isset($_POST['password']) ? $_POST['password']:NULL;
                 
                 //セッションに登録
                 $_SESSION['email'] = $email;
                 $_SESSION['username'] = $name;
                 $_SESSION['password'] = $password;
                 
                 //メールアドレス入力判定
                 //アカウント入力判定
                 //パスワード入力判定
                 if($email === "" || $password === "" || $username === ""){
                     if($email === ""){
                         $errors['email'] = "メールアドレスが入力されていません";
                     }
                     if($password === ""){
                         $errors['password'] = "パスワードが入力されていません";
                     }
                     if($username === ""){
                         $errors['username'] = "ユーザー名が入力されていません";
                     }
                 }else{
                     $errors = array();
                 }
             }
         }
         
         /**
          * 退会する(btn_withdrow_submit)を押した後の処理
         */
         if($flag === 2 && isset($_POST['btn_withdrow_submit'])){
             $flag = 3;
            //ここでデータベースから削除する
            $email = $_SESSION['email'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            
            try{
                 // userテーブルから削除する
                 $sql_withdrow = "delete from user  WHERE email=:email AND username=:username AND password=:password";
                 $stmt_withdrow = $pdo -> prepare($sql_withdrow);
                 $stmt_withdrow -> bindValue(':email', $email, PDO::PARAM_STR);
                 $stmt_withdrow -> bindValue(':password', $password, PDO::PARAM_STR);
                 $stmt_withdrow -> execute();
             
                 //このユーザーテーブルを削除する
                 define('table_name', $username)
                 $sql_withdrow_username = "DROP TABLE table_name";
                 $stmt_withdrow_username = $pdo -> prepare($sql_withdrow_username);
                 $stmt_withdrow_username -> execute();
             
                 //データベースの接続切断
                 $stmt_withdrow = NULL;
                 $stmt_withdrow_username = NULL;
             
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
   <h1>退会なさるのですか…？ありがとうございました。</h1>
   
   <!-- page3 完了画面 -->
   <?php if($flag === 3 && isset($_POST['btn_withdrow_submit']) && count($errors) === 0): ?>
   　退会できました。
   　
   <!-- page2 確認画面 -->
   <?php elseif($flag === 2 && isset($_POST['btn_withdrow_confirm']) && count($errors) === 0): ?>
         <form action="" method="post">
             <p>本当に良いのですね？</p>
             
             <input type="submit" name="btn_withdrow_back" value="戻る">
             <input type="submit" name="btn_withdrow_submit" value="退会する">
         </form>
   <?php endif; ?>
   
     <!-- page1 確認画面 -->
         <?php if(count($errors) > 0):?>
             <?php 
             foreach($errors as $value){
                 echo "<p class='error'>".$value."</p>";
             }
             ?>
         <?php endif; ?>
             <?php if($flag === 1): ?>
                <form action="" method="post">
				   <p>メールアドレス：    <input type="text" name="email" ></p>
				   <p>ユーザー名：        <input type="text" name="name"></p>
				   <p>パスワード：        <input type="password" name="password"></p>
				   <input type="submit" name="btn_withdrow_confirm" value="退会する">
	            </form>
	         <?php endif; ?>
</body>
</html>
