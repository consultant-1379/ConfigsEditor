<?php

//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//

$_POST['dir'] = urldecode($_POST['dir']);
$_GET['type'] = urldecode($_GET['type']);

if ($_POST['dir'] == "/export/scripts/CLOUD/logs/web/" && file_exists($_POST['dir'])) {
    $files = scandir($_POST['dir'], 1);
    //natcasesort($files);
    //array_reverse($files);
    if (count($files) > 2) { /* The 2 accounts for . and .. */
        echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
        // All dirs
        foreach ($files as $file) {
            if (file_exists($_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($_POST['dir'] . $file)) {

                if (file_exists($_POST['dir'] . $file . "/." . $_GET['type'])) {
                    if ($_GET['type'] == "completed") {
                        if (filemtime($_POST['dir'] . $file) <= time() - 60 * 60 * 48) {
                            continue;
                        }
                    }
                    echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
                }
            }
        }
        echo "</ul>";
    }
}
?>