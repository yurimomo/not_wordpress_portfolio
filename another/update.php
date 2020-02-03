<?php
session_start();

require(__DIR__.'../../../library/config.lib');
require(__DIR__. '../../../library/common.lib');

db_connect($link);

$ticket = md5(uniqid(rand(), true));
$_SESSION['ticket'] = $ticket;

update_todo($array);

mysqli_close($link);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF8">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js">
	</script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<link href="../css/todo.css" rel="stylesheet">


</head>
<body>

<div id="wrapper">
	<h2 class="update_h2">Update what to do</h2>

<div class="content">
<div class="table_wrapper">

	<form action="regist.php" method="post" class="update_form">
<?php

	echo 
	"<table border='1'>
	<tr><th>todo</th><td>
	<input type='text' name='todo' value='{$array['todo_list']}'></td></tr>
	<tr><th>memo</th><td><textarea name='memo' class='no-margin'>{$array['memo']}</textarea></td></tr>
	</table>";
?>
<input type="hidden" name="id" value="<?=$array['id'] ?>">
<input type="hidden" name="ticket" value="<?=$ticket ?>">
<input type="submit" value="更新" class="submit">
</form>

</div>
</div>
</div>
</body>
</html>