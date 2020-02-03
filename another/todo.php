<?php

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js">
	</script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>

<body>
<header>
	header
</header>

<div id="wrapper">
<div class="contents">
	<h2>what to do</h2>
<div class="table_wrapper">
<?php
// $xはwhileの外なのか$x++はwhile内なんだね
	$x = 1;//$x =0を設定するの忘れてた
while($array = mysqli_fetch_array($result, MYSQLI_BOTH)) {

	$result_array[$x] = $array;
	$today = date('Y/m/d H:i', strtotime($result_array[$x]['created_at']));
	echo 
	"<table border='1'>
	<tr><th>todo</th><td class='{$x}';>".$result_array[$x]['todo_list']."</td></tr>
	<tr><th>memo</th><td class='{$x}';>".$result_array[$x]['memo']."</td></tr>
	</table>";
	echo
"
<div class='both'>
<p class='today'>".$today."</p>
<div class='icon'>
	<a href='javascript:;' id='{$result_array[$x]['id']}'; onclick='delete_confirm(this);'><p class='icon'><i class='fas fa-trash-alt'></i></p></a>
	<a href='update.php?id={$result_array[$x]['id']}&value=update'><p class='icon'><i class='fas fa-eraser'></i></p></a>
	<a href='javascript:;' id='{$x}'; onclick='setLineThrough(this);'><p class='icon'><i class='far fa-check-square'></i></p></a>
</div></div>
";
$x++;

}
// divの中にtable作りtable内にicon入れた
?>

</div> 


<form action="regist.php" method="post" name="todo_form" onsubmit="return check_submit(this);">
<h5 class="inline memo">Add new to do</h5>
<!-- 生成したticketを隠しフィールドで渡す -->
<input type="hidden" name="ticket" value="<?=$ticket?>">
<input type="text" name="todo" class="input">
<br>
<h5 class='inline memo'>Add new memo</h5>
<textarea name="memo" class='inline'></textarea>
<input type="submit" value="登録">
</form>
</div>

<footer>
	aaa
</footer>

<div class="list-group">

</div>
</div>
<script>
function setLineThrough(todoId) {
	var todoid = todoId.id; //クリックされた数字
	var todos = document.getElementsByClassName(todoid);
	todos[0].classList.toggle('linethrough');
	todos[1].classList.toggle('linethrough');
	// console.log(todos);
}
function delete_confirm(todo) {
	var todoid = todo.id;
	target = confirm('削除してよろしいですか?');
	if(target == true) {
		window.location.href='delete.php?id='+todoid+'&value=delete';
	}else{
		return false;
}
}
function check_submit() {
	if(document.todo_form.todo.value == "") {
		alert('todoが入力されてません');
		if(!document.todo_form.memo.value == "") {
			todo_form.memo.value = "";
		}
		return false;
	}else{
		return true;
	}
}
</script>
</body>
</html>