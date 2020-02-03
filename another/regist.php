<?php
session_start();

require(__DIR__. '../../../library/config.lib');
require(__DIR__. '../../../library/common.lib');

db_connect($link);


$ticket = isset($_POST['ticket']) ? $_POST['ticket'] :'';
$save   = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';
$_SESSION = array();
session_destroy();


if ($ticket === '') {
    die('不正なアクセスです');
}

if ($ticket === $save) {

 $todo = h($_POST['todo']);
 $memo = h($_POST['memo']);
}

// やっとできたこのコード。idあったらセット、なければ空
$id = isset($_POST['id']) ? $_POST['id'] : '';

// $idがあったらupdate

if(!$id == '') {
	if($stmt = mysqli_prepare($link, "UPDATE todo SET todo_list = ?, memo = ? WHERE id = ?")){
	mysqli_stmt_bind_param($stmt, "ssi",$todo,$memo,$id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}
// $idなかったらinsert
}else {
	if($stmt = mysqli_prepare($link, "INSERT INTO todo (todo_list, memo) VALUES (?,?)")) {
	mysqli_stmt_bind_param($stmt, "ss", $todo, $memo);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);}
}


// mysqli_query($link, $stmt);
header("Location:calender.php");

mysqli_close($link);


?>
