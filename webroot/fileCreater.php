<?php
//App::uses('File', 'Utility');

$data = $_POST['data'];


echo "Direcotry: " . $data['dir'] . "\n";
echo "Filename: " . $data['filename'] . "\n";
echo "Variables: " . $data['data'] . "\n";
$name = $data['filename'];

//$file = fopen("files/configs/web_configs/$name.txt", "w+");
//$fh = fopen("/opt/bitnami/apache2/htdocs/app/webroot/files/configs/$name", "w") or die("can't open file");
//$stringData = split(' ', $data['data']);
//foreach($stringData as $str)
//{
//fwrite($fh, $str);
//}
//
//fclose($fh);

/* $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
  $input=file_get_contents('php://input', 1000000);
  $values=$json->decode($input); */

//$Shell_Command = $HOME."/scripts/save_preset.sh " . escapeshellarg($values['dir']) . " " . escapeshellarg($values['filename']) . " " . escapeshellarg($values['data']);
//$output = shell_exec($Shell_Command);
?>