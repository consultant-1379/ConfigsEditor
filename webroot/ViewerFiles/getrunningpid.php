<?php

#header('Content-Type: text/html');
#header("Cache-Control: no-cache, must-revalidate");
#header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$Shell_Command = "./getrunningpid.sh " . $_GET['dir'];
#$log = htmlspecialchars(shell_exec($Shell_Command));
#$log = str_replace("\n", "<br>", $log);
$pid = shell_exec($Shell_Command);
echo $pid;
#echo $_GET['log'] . "_:_" . $log;
?>
