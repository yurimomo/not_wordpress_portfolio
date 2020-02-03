<?php
session_start();

require(__DIR__ .'../../library/config.lib');
require(__DIR__ .'../../library/common.lib');

db_connect($link);

regist_user($message);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="../../css/admin.css">
<link href="https://fonts.googleapis.com/css?family=Rouge+Script&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<title>管理者登録ページ</title>
</head>
<body>
<div class="container">
<div class="wrapper">
	<p style="color: red"><?php echo $message; ?></p>

<div class="regist">
	<h3>管理者登録</h3>
<form action="admin_regist.php" method="post">
	<label for="name2" class="name">ユーザーID</label>
	<input id="name2" name="user_id" required><br />
	<label for="password2" class="password">password</label>
	<input type="password" id="password2" name="password" required><br />
	<input type="submit" name="regist" class="login_submit" value="登録する">
</form>
<a href='admin_login.php' class='login_button'>ログインページ</a>
</div>
</div>
</div>

</body>
</html>