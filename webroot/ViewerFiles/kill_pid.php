<?php

$server = urldecode($_GET['server']);
$pid = urldecode($_GET['pid']);

$kill_part = "kill " . $pid .";while kill -0 ". $pid ."; do sleep 1;done";

if ($server == "atclctl4")
{
    $final_string = $kill_part;
} 
else
{
    $final_string = "ssh -l root -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null " . $server . " " . $kill_part;
}

$connection = ssh2_connect('atclctl4', 22);
ssh2_auth_password($connection, "root", "shroot12");
$stream = ssh2_exec($connection, $final_string);
stream_set_blocking($stream, true);

?>
