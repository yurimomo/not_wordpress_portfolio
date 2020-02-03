<?php
session_start();
require(__DIR__ .'../../library/config.lib');
require(__DIR__ .'../../library/common.lib');

db_connect($link);

get_login();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="./css/admin.css">
<link href="https://fonts.googleapis.com/css?family=Rouge+Script&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<title>管理者ログインページ</title>
</head>
<body>
<div class="container">
<div class="wrapper">
	<p style="color: red"><?php echo $message; ?></p>

<div class="kanri">
	<h3>管理者ログイン</h3>
<form action="admin_login.php" method="post">
	<label for="name1" class="name">ユーザーID</label>
	<input id="name1" name="user_id" required><br />
	<label for="password1" class="password">password</label>
	<input type="password1" id="password" name="password" required><br />
	<input type="submit" name="login" class="login_submit" value="ログイン">
</form>
</div>
</div>
</div>

</body>
</html>