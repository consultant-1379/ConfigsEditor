<?php

App::uses('File', 'Utility');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

class InstallsController extends AppController
{

    public function index()
    {
        $this->set('page_for_layout', 'InstallPage');
        if ($this->request->is('post'))
        {
            
        }
    }

    public function fileWriter()
    {
        $this->autoRender = false;
        $data = $_POST['data'];
        $dir = dirname(APP) . '/' . basename(APP) . '/webroot/files/configs';
        
        $variables = $data['data'];
        $config = $data['config'];
        $config2 = str_replace($dir, '/export/scripts/CLOUD/configs', $config);
                
        $media = $data['media'];
        $media2 = str_replace($dir, '/export/scripts/CLOUD/configs', $media);
        
        $gateway = $data['gateway'];
        $name = explode(' ', $data['filename']);
        $name2 = $name[0] . $name[1];
        
        $sdir = $data['sdir'];

        $file = new File("files/configs/web_configs/" . $name2 . ".txt", true, 777);
        $file->write("");

        foreach ($variables as $key => $val)
        {
            $file->append("$key=\"$val\"\n", $force = false);
        }
        $file->close();
        
        $connection = ssh2_connect('atclctl4', 22);
        ssh2_auth_password($connection, "root", "shroot12");
        
        if($gateway != "")
        {
            $stream = ssh2_exec($connection, "/export/scripts/CLOUD/bin/master.sh -c " . $config2 . ":" . $media2 . ":/export/scripts/CLOUD/configs/web_configs/" . $name2 . ".txt -g " . $gateway . "  -l /export/scripts/CLOUD/logs/web/".$sdir."/ -f rollout_config > /dev/null 2> /dev/null &");
        }
        else
        {
            $stream = ssh2_exec($connection, "/export/scripts/CLOUD/bin/master.sh -c " . $config2 . ":" . $media2 . ":/export/scripts/CLOUD/configs/web_configs/" . $name2 . ".txt -l /export/scripts/CLOUD/logs/web/".$sdir."/ -f rollout_config > /dev/null 2> /dev/null &");
        }

        stream_set_blocking($stream, true);
    }
}
?>
