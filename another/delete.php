<?php

require(__DIR__. '../../../library/config.lib');
require(__DIR__. '../../../library/common.lib');

db_connect($link);

delete_todo($sql);

mysqli_query($link, $sql) or die("delete error:".mysqli_error($link));

header('Location:calender.php');

mysqli_close($link);

?>

