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

if ($_POST['dir'] == "/export/scripts/CLOUD/logs/web/" && file_exists($_POST['dir']))
{
    if (endsWith($_POST['dir'], '/web/'))
    {
        $fils = array_keys($_POST['pdir']);
        $files = array();
        foreach ($fils as $fil)
        {
            $sfiles = scandir($_POST['dir'] . $fil . '/', 1);
            foreach ($sfiles as $sfil)
            {
                if ($sfil != '.' && $sfil != '..')
                    array_push($files, $fil . '/' . $sfil);
            }
            //$files=array_merge($files,$sfiles);                    
        }
    }
    else
    {
        $files = scandir($_POST['dir'], 1);
    }
    //natcasesort($files);
    //array_reverse($files);
    //if (count($files) > 2) { /* The 2 accounts for . and .. */
    echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
    // All dirs
    foreach ($files as $file)
    {
        //echo $file ;                        
        if (file_exists($_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($_POST['dir'] . $file))
        {
            if (file_exists($_POST['dir'] . $file . "/." . $_GET['type']))
            {
                //echo $_GET['type'];    
                if ($_GET['type'] == "completed")
                {
                    if ($_GET['date'] != '0')
                    {
                        if (filemtime($_POST['dir'] . $file) <= time() - $_GET['date'])
                        {
                            continue;
                        }
                    }
                }
                echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
            }
        }
    }
    echo "</ul>";
    //}
}

function endsWith($haystack, $needle, $case = true)
{
    if ($case)
    {
        return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
    }
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
}

?>
