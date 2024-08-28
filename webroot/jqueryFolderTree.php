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
//echo "kart ".$_POST['dir'];
if (file_exists($root . $_POST['dir']))
{   
	if(endsWith($_POST['dir'],'/config/') || endsWith($_POST['dir'],'/media/') )
	{
		$files =array();                
		$dirs =array_keys($_POST['pdir']);
                foreach ($dirs as $dir) {                                        
                    if($_POST['pdir'][$dir]=='true')
                    {
                        array_push($files, $dir);
                    }
                }                
	}
	else 
	{	
		$files = scandir($root . $_POST['dir']);
	}
	//echo $files;
    natcasesort($files);
    //if (count($files) > 2)
    //{ /* The 2 accounts for . and .. */
        echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
        // All dirs
        foreach ($files as $file)
        {        	
        	if (file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file ))
            {
            	
                echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
            }
        }
        echo "</ul>";
    //}
}

function endsWith($haystack,$needle,$case=true) {
	if($case){
		return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
	}
	return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}

?>