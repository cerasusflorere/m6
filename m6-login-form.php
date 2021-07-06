<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>ログイン画面</title>
 </head>
 <body>
   <h1>ようこそ、ログインしてください。</h1>
   <form  action="m6-login.php" method="post">
		 <p>ユーザー名：<input type="text" name="username"></p>
		 <p>パスワード：<input type="password" name="password"></p>
     <button type="submit">ログイン</button>
   </form>
   <br>
   <a href="m6-pre-create.php" target="_blank">初めての方はこちら</a><br>
   <a href="m6-foget-username-form.php" target="_blank">ユーザー名をお忘れの方はこちら</a><br>
   <a href="m6-forget-password-form.php" target"_blank">パスワードをお忘れの方はこちら</a>
</html>
