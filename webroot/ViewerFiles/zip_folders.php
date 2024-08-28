<?php
$filename = $_GET['fileDir'];

$fileName2 = explode('/', $filename);
$zipname = $fileName2[count($fileName2) - 1];


header('Content-Type: text/plain');
header('Content-disposition: attachment; filename='.$zipname);
readfile($filename);

//$text = file_get_contents($file);
//$fileName = explode('/', $path);
//$zipname = $fileName[count($fileName) - 2];
//
//$zip = new ZipArchive;
//$handle = opendir($path);//

////Check whether Zip can be opened
//if ($zip->open($zipname, ZIPARCHIVE::CREATE) !== TRUE) {
//    die("Could not open archive");
//}
//
////Add all files to an array
//while ($file = readdir($handle)) 
//{
//    $zip->addFile($path . $file, $file) or die("Can't add file");
//}
//
//closedir($handle);
//$zip->close();

//Send zip folder 
?>