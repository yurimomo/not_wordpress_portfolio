<?php
session_start();
require(__DIR__ .'../../library/config.lib');
require(__DIR__ .'../../library/common.lib');


if(!isset($_SESSION["USER"])) {
	header("Location: admin_login.php");
	exit;
}

if(isset($_REQUEST['logout'])) {
	$_SESSION = "";
	session_destroy();

	header("Location: admin_login.php");
	exit;
}

db_connect($link);

get_all_mail($cnt_mail); 

get_ten_list_mail($page, $cnt, $page_sum, $result);

// pagenation用
$range = 3;

mysqli_close($link);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="./css/admin.css">
<link href="https://fonts.googleapis.com/css?family=Rouge+Script&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<title>管理者ページ</title>
</head>
<body>

<div class="container">
	<div class="wrapper">
	<h3 class="kanri1">管理ページ</h3>
		<p class="kanri2">
			<form action="admin_page.php" action="post" class="pageform"><input type="submit" name="logout" value="ログアウトする" class="submit">
			</form>
		</p>
	</div>
<?php
$x = 1;
while($array = mysqli_fetch_array($result, MYSQLI_BOTH)) {
	$result_array[$x] = $array;
	$x++;
}
?>

<table border="1">
	<?php 
	echo "<tr><th>id</th><th class='kokyaku_name'>お名前</th><th class='email'>メールアドレス</th><th>お問い合わせ内容</th><th class='contact_time'>問い合わせ時間</th></tr>";

	for($i = 1; $i <= $cnt; $i++) {
		echo "<tr><td>".
		$result_array[$i]['ID']."</td><td>".
		$result_array[$i]['name']."</td><td class='email'>".
		$result_array[$i]['email']."</td><td>".
		$result_array[$i]['text']."</td><td>".
		$result_array[$i]['contact_day']."</td>
		</tr>";
	}
?>
</table>
<div class='page_nation_box'>
<!-- page nation  -->

<!-- 前へ -->
<?php if($page > 1) : ?>
	<a class='page_back' href="admin_page.php?p=<?php echo ($page - 1); ?>">前へ</a>
<?php endif; ?>

<!-- 前に3ページ表示 -->
<?php for($i = $range; $i > 0; $i--) : ?>
<?php if ($page - $i < 1) continue; ?>
<a  class='page_nation' href="admin_page.php?p=<?php echo ($page - $i); ?>">
	<?php echo ($page - $i); ?></a>
<?php endfor; ?>


<!-- 今のページにcurrent css -->

<?php
for($i = 1; $i <= $page_sum; $i++) {
	if($page == $i) {
 	echo "<a href='admin_page.php?p={$i}' class='page_nation page_current'>{$i}</a>";
 }
}
?>

<!-- 後ろに3ページ表示 -->

<?php for($i = 1; $i <= $range; $i++) : ?>
	<?php if($page + $i > $page_sum) break; ?>
	<a class='page_nation' href="admin_page.php?p=<?php echo ($page + $i); ?>">
		<?php echo ($page + $i); ?>
	</a>
<?php endfor; ?>

<!-- 次へ -->
<?php if($page < $page_sum) : ?>
	<a class='page_ahead' href="admin_page.php?p=<?php echo ($page + 1); ?>">次へ</a>
<?php endif; ?>

</div>
</div>
</body>
</html>