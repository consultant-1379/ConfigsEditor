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
        echo $this->Html->css('jquery-custome-theme/jquery-ui-1.9.0.custom');
        echo $this->Html->css('ericsson');
        echo $this->Html->css('ericsson.cake');
        echo $this->fetch('css');

        echo $this->fetch('meta');

        // Javascript
        //echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', FALSE);
        echo $this->fetch('script');
        echo $this->Html->script('jquery-1.8.3.min');
        echo $this->Html->script('jquery-ui-1.9.2.custom.min');

        echo $scripts_for_layout;

        //echo $this->Js->writeBuffer(array('cache' => TRUE));

        if (!isset($page_for_layout))
        {
            $page_for_layout = "";
        }
        
        ?>
    </head>
    <style>
        .errormsg {
            margin: .5em 0 0;
            display: block;
            color: #DD4B39;
            line-height: 17px;
        }   
    </style>
    <body class="ePageType1">
        <div class="eOuterWrapper">
            <div id="eHead" class="eInnerWrapper eGB">
                <div class="eWrapContainer eGB">	
                    <div id="eHeadNavigation">
                        <div id ="eEricsson_CookieConsent_PlaceHolder" class="eCookieConsentDialog">
                        </div>
                        <p class="eLogoContainer">
                            <a id="eHeaderLogo" title="Ericsson Home" href="/"><span class="eHide">Ericsson</span></a>
                        </p>	
                        <div id="eHeadRT">
                        </div>
                        <div id="eHeadRB">
                            <ul id="eGlobalMenu">
                                <li id="eMenu0" class="eMenuLi eHasMenu">
                                    <a id="eMenu0Link" class="eMenuLink" style="<?php
        if ($page_for_layout == "ConfigEditor")
        {
            echo "color: #333333";
        }
        ?>"href="/Variables/">Configs Editor<span></span></a>
                                </li>
                                <li id="eMenu1" class="eMenuLi eHasMenu">
                                    <a id="eMenu1Link" class="eMenuLink" style="<?php
                                       if ($page_for_layout == "InstallPage")
                                       {
                                           echo "color: #333333";
                                       }
        ?>"href="/Installs/">Start Installs<span></span></a>
                                </li>
                                <li id="eMenu1" class="eMenuLi eHasMenu">
                                    <a id="eMenu1Link" class="eMenuLink" style="<?php
                                       if ($page_for_layout == "ViewerPage")
                                       {
                                           echo "color: #333333";
                                       }
        ?>"href="/Viewer/">Monitor Installs<span></span></a>
                                </li>
                                <li id="eMenu4" class="eMenuLi eHasMenu">
                                    <a id="eMenu4Link" class="eMenuLink " target="_blank" href="http://jira-oss.lmera.ericsson.se/browse/CIP">Support<span></span></a>
                                </li>		
                                <?php
                                if ($logged_in)
                                {
                                    ?>				                        
                                    <li id="eMenu5" class="eMenuLi eHasMenu">
                                        <a id="eMenu1Link" class="eMenuLinkLast" href="/Users/logout">
                                            LOGOUT (<?php echo $current_user['username'] ?>)<span></span></a>
                                    </li>             
<?php } ?>
                            </ul>		
                        </div>
                    </div>
                </div>
            </div>
            <div id="eMain" class="eInnerWrapper">
                <div  class="eWrapContainer">
                    <div class="eColGroup">

                        <?php
                        if ($current_user['is_admin'])
                        {
                            ?>
                            <div id="eLeftMenu" class="eCol3w25">
                                <h2><a href="">Install Manager</a></h2>                      
                                <ul class="eInnerMenu">
                                    <li><a style="<?php if ($page_for_layout == "Groups")
                            {
                                echo "color: #333333";
                            } ?>" href="/Groups/">Groups</a></li></ul>                          
                                <ul class="eInnerMenu">
                                    <li><a style="<?php if ($page_for_layout == "Variables")
                            {
                                echo "color: #333333";
                            } ?>" href="/Variables/variablesList">Variables</a></li></ul>                                                        
                            </div>
                                <?php } ?>

                        <div id="eCenterCol50" class="eCol3w50m">
                            <div class="eBoxContent">
                                <?php echo $this->Session->flash(); ?>
                            </div>
                            <div>
                                <?php
                                if (strpos($_SERVER['HTTP_USER_AGENT'], '(compatible; MSIE ') !== FALSE)
                                {
                                    echo "<h1 style='color: #FF0000;'>Sorry this application does not work in Internet Explorer. <br> Please use either Google Chrome or Mozilla Firefox. <br>
                          Thank you.<h1>";
                                } else
                                {

                                    echo $content_for_layout;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>
