<?php
session_start();

require(__DIR__. '../../../library/config.lib');
require(__DIR__. '../../../library/common.lib');

db_connect($link);


//ワンタイムチケットを生成する
$ticket = md5(uniqid(rand(), true));
// 生成したチケットをセッション変数に保存する
$_SESSION['ticket'] = $ticket;

//get todo data
get_todo($result);

$cnt = mysqli_num_rows($result);
// to do

// ===========for calender================================
$ym = isset($_GET['ym']) ? $_GET['ym'] : date('Ym');
$timeStamp = strtotime($ym);
if($timeStamp === false) {
	$timeStamp = time();
} 

$year = date("Y",$timeStamp);
// $month = date("Y-m",$timeStamp); //$ymと同じこと
$today = mktime(0,0,0,date("m"),date("j"),date("Y"));
$firstday = date('w', strtotime("first day of this month", $timeStamp)); 

$lastday = date('w',strtotime("last day of this month", $timeStamp));

$days = date('t', mktime(0,0,0,date("m",$timeStamp)+1,0,date("Y",$timeStamp)));//30

// 翌月、来月リンク用=============
$lastmonth = date('Y-m', mktime(0,0,0,date("m",$timeStamp)-1,1,date("Y",$timeStamp)));
$nextmonth = date('Y-m', mktime(0,0,0,date("m",$timeStamp)+1,1,date("Y", $timeStamp)));
// =====================calender============================

?>

<!DOCTYPE html>
<html lang="ja">
<head>
		<meta charset="UTF8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js">
	</script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<link href="../css/todo.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
<div class="contents">

<table class="calender" border="1" style="border-collapse:collapse;">
<thead>
<tr>
<th><a href="?ym=<?php echo $lastmonth; ?>">&laquo;</a></th>
<!-- 今月 -->
<th colspan="5"><?php echo date("Y",$timeStamp)."-".date("m",$timeStamp); ?></th>
<!--  -->
<th><a href="?ym=<?php echo $nextmonth; ?>">&raquo;</a></th>
</tr>
</thead>

<th>日</th>
<th>月</th>
<th>火</th>
<th>水</th>
<th>木</th>
<th>金</th>
<th>土</th>



<?php
// 1日が日曜でなければtr入れる
if($firstday != 0) {
	echo "<tr>";
}
// 最初のtdを埋める
for($w = 0; $w < $firstday; $w++) {
	echo "<td></td>";
}
// 30日分のループを回す
for($i = 1; $i <= $days; $i++) {
$tday = mktime(0,0,0,date("m",$timeStamp),$i,$year);

$weeks = date('w',mktime(0,0,0,date("m",$timeStamp),$i,$year));
	if($weeks == 0){
	echo "<tr>";
	}
	if($weeks == 6){
		echo "<td class='sat'>".$i."</td>";
	}elseif($weeks == 0){
		echo "<td class='sun'>".$i."</td>";
	}elseif($today == $tday) {
		echo "<td class='daytoday'>".$i."</td>";
	}else{
	echo "<td>".$i."</td>";
	}
	if($weeks == 6) {
	echo "</tr>";
	}
}
// 30まで回しました！それから最後のtdを入れる
if($lastday != 6) {
	for($j = 1; $j < 7- $lastday; $j++) {
		echo "<td></td>";
	}
}
?>

</table>

</div><!--contents-->

<!--==================== todo ==================-->
<div class="contents">
	<h2>what to do</h2>
	<?php 
	if($cnt == 0) {
		echo "todo listはありません。";
	}
	?>
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
<p class="inline memo">Add new to do</p>
<!-- 生成したticketを隠しフィールドで渡す -->
<input type="hidden" name="ticket" value="<?=$ticket?>">
<input type="text" name="todo" class="input">
<br>
<p class='inline memo'>Add new memo</p>
<textarea name="memo" class='inline'></textarea>
<input type="submit" value="登録" class="submit">
</form>
</div>

<footer>
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



</div><!--wrapper-->
</body>
</html>