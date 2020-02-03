<?php
session_start();

require(__DIR__.'../../library/config.lib');
require(__DIR__.'../../library/common.lib');

db_connect($link);

mail_to_customer();

$_SESSION = array();
session_destroy();
header("Location:thanks.php");

mysqli_close($link);

?>