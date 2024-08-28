<?php

#header('Content-Type: text/html');
#header("Cache-Control: no-cache, must-revalidate");
#header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$Shell_Command = "./getlogtail.sh " . $_GET['log'] . ' ' . $_GET['tail'];
#$log = htmlspecialchars(shell_exec($Shell_Command));
#$log = str_replace("\n", "<br>", $log);
$log = shell_exec($Shell_Command);
echo $log;
#echo $_GET['log'] . "_:_" . $log;
?>
