<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout . " - Install Manager"; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
	// CSS
	echo $this->Html->css("jquery-custome-theme/jquery-ui-1.9.0.custom.min");        
        echo $this->Html->css('login');
        echo $this->Html->css('ericsson.cake');
        echo $this->fetch('css');
        echo $this->fetch('meta');
	// Javascript        
	echo $this->Html->script('jquery-1.8.2.min');
	echo $this->Html->script('jquery-ui-1.9.0.custom.min');        
        echo $this->fetch('script');
        //echo $this->Js->writeBuffer(array('cache' => TRUE));
        ?>
    </head>
    <body>        
        <div id="Main borderline" >
            <div class="header borderline">	
                <img class="logo" src="/images/elogo.png" alt="Ericsson"></img>                    
            </div>
        </div>
        <div id="Content">
            <div id="leftContent">                
                <div class="prodHead">
                    <h1>Install Manager</h1>
                    <h2>Installation made easier</h2>
                </div>                
                <p>Installation is now automated with Install Manager. Install Manager supports the following features that helps you to avoid mistakes and install with ease</p>                                            
                <ul class="features">
                    <li>
                        <img src="/images/login/Edit.png"></img>
                        <p class="title">Configs Editor</p>
                        <p>Used to create and edit config files used for installation</p>
                    </li>
                    <li>
                        <img src="/images/login/Install.png"></img>
                        <p class="title">Start Installs</p>
                        <p>Used to select a config file and start the installation</p>
                    </li>
                    <li>
                        <img src="/images/login/Viewer.png"></img>
                        <p class="title">Monitor Installs</p>
                        <p>Used to monitor the progress of Installation</p>
                    </li>
                </ul>
            </div>   
            <div id="rightContent">                                                    
                <div id="login" class="loginBox  ui-corner-all">
                    <?php echo $content_for_layout ?>                       
                </div>
            </div>
        </div>        
    </body>
</html>
