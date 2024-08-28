<?php
echo $this->Html->css('validationEngine.jquery', null, array('inline' => false));
echo $this->Html->css('jqueryFileTree/jqueryFileTree', null, array('inline' => false));
echo $this->Html->css('jquery-dattaya-maccordion', null, array('inline' => false));

//echo $this->Html->script('http://stevenlevithan.com/assets/misc/split.js');
echo $this->Html->script('jquery.validationEngine-en');
echo $this->Html->script('jquery.validationEngine');
echo $this->Html->script('jqueryFileTree');
echo $this->Html->script('jquery.dattaya.maccordion');
echo $this->Html->script('spin.min');

$fileType = array('media' => 'media', 'config' => 'config');
$blackList = array('dummy', 'VERSION_LABEL', 'INS_TYPE', 'DHCP_SERVER_IP', 'DHCP_SERVER_ROOT_PASS', 'INITIAL_INSTALL_MCS', 'OMSERVM_DEPL_TYPE', 'ESXI_VERSION', 'DHCP_SERVER');
$loadUrl = '';

$configType = '';
$selDefault = '';

if (isset($this->passedArgs["type"]))
{
    $configType = $this->passedArgs["type"] . '/';
    $selDefault = $this->passedArgs["type"];
}

if (isset($this->passedArgs["urlType"]))
{
    $loadUrl = str_replace('-', '/', $this->passedArgs["urlType"]);
}

$dir = dirname(APP) . '/' . basename(APP) . '/webroot/files/configs/' . $configType;
$directory = $current_user['permissions'];
$mdirectory = $current_user['mpermissions'];
$files = scandir($dir);
$directories = array();
$iterator = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
$iter = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iter as $it)
{
    if ($it->isDir())
    {
        array_push($directories, $it->getFileName());
    }
}

$edit = 0;
foreach ($directory as $key => $val)
{
    $edit = $directory[$key] | $edit;
}

$medit = 0;
foreach ($mdirectory as $key => $val)
{
    $medit = $mdirectory[$key] | $medit;
}

$readWriteConfig = array();
foreach ($directory as $key => $val)
{
    if ($val == '1')
    {
        $readWriteConfig[$key] = $val;
    }
}


$rwMedia = array();
foreach ($mdirectory as $key => $val)
{
    if ($val == '1')
    {
        array_push($rwMedia, $key);
    }
}

echo $this->Form->create('Variable', array('class' => 'Variable', 'name' => 'Variable'));
?>

<table>
    <tr>
        <td><label>Choose File Type: </label><?php echo $this->Form->select('Choose File Type', $fileType, array('name' => 'Choose_File_Type', 'id' => 'fileTypeSelect', 'default' => $selDefault)); ?></td>
        <td><label id="workingFile"> </label></td>
        <td><?php echo $this->Form->button('New', array('id' => 'newFileButton', 'type' => 'button', 'style' => 'font-size: 12px;')); ?></td>        
        <td><?php echo $this->Form->button('Open', array('id' => 'fileButton', 'type' => 'button', 'style' => 'font-size: 12px;')); ?> </td>
        <td><?php echo $this->Form->button('Save', array('id' => 'saveButton', 'type' => 'button', 'style' => 'font-size: 12px;')); ?></td>
        <td><?php echo $this->Form->button('Save As', array('id' => 'saveAsButton', 'type' => 'button', 'style' => 'font-size: 12px;')); ?></td>        
    </tr>
</table>

<?php
$checks = array();
$checkCounter = 0;

foreach ($variables as $var) :
    if ($configType == 'config/' && !in_array($var['Variable']['name'], $blackList))
    {
        if ($var['Variable']['name'] == 'BEHIND_GATEWAY')
        {
            $nameArray = explode(',', $var['Variable']['dropName']);
            $valueArray = explode(',', $var['Variable']['dropValue']);
            $corArray = array_combine($valueArray, $nameArray);
            ?>
            <table>
                <tr>
                    <td>
                        <label><?php echo $var['Variable']['label'] . ':' ?><?php echo $this->Form->select($var['Variable']['section'], $corArray, array('error' => $var['Variable']['dependency'], 'name' => $var['Variable']['name'], 'id' => $var['Variable']['name'], 'class' => array($var['Variable']['name'], 'validate[required]'))); ?></label>
                    </td>
                </tr>
            </table>
            <?php
        } else
        {
            if (!in_array($var['Variable']['section'], $checks))
            {
                $checks[$checkCounter] = $var['Variable']['section'];
                $checkCounter++;
            }
        }
    } else
    {
        if ($var['Variable']['name'] == 'DHCP_SERVER')
        {
            $nameArray = array();
            $valueArray = array();
            $nameArr = explode(',', $var['Variable']['dropName']);
            $valueArr = explode(',', $var['Variable']['dropValue']);
            
            for ($i = 0; $i < sizeof($nameArr); $i++)
            {
                if (array_key_exists($nameArr[$i], $mdirectory))
                {
                    array_push($nameArray, $nameArr[$i]);
                    array_push($valueArray, $valueArr[$i]);
                }
            }
            $corArray = array_combine($valueArray, $nameArray);
            ?>
            <table>
                <tr>
                    <td>
                        <label><?php echo $var['Variable']['label'] . ':' ?><?php echo $this->Form->select($var['Variable']['section'], $corArray, array('name' => $var['Variable']['name'], 'id' => $var['Variable']['name'], 'class' => array($var['Variable']['name'], 'validate[required]'))); ?></label>
                    </td>
                </tr>
            </table>
            <?php
        } else
        {
            if (!in_array($var['Variable']['section'], $checks))
            {
                $checks[$checkCounter] = $var['Variable']['section'];
                $checkCounter++;
            }
        }
    }
endforeach;
?>

<table><tr><td><label id="chooseLabel">Please choose the server variables you wish to edit:</label></td></tr>
    <tr><td><label style="color: #FF0000;">Make sure relevant checkboxes below are ticked otherwise the config file will only consist of the
                                               variables related to the ticked boxes because save function will overwrite the previous config file.</label></td><td></td></tr>
</table>

<div id="checkBoxDiv" style="float: left;">
    <table style="width: 200px;">
                <?php
                for ($i = 0; $i < count($checks); $i++)
                {
                    ?>
            <tr><td><label><?php echo $checks[$i]; ?></label></td>
                <td>
    <?php
    $noSpaces = str_replace(' ', '', $checks[$i]);
    if ($configType == "config/")
    {
        if ($i == 0)
        {
            echo $this->Form->checkbox($checks[$i], array('name' => $checks[$i], 'type' => 'checkbox', 'class' => array($checks[$i], 'check' . $noSpaces), 'id' => 'check' . $noSpaces, 'value' => 'on'));
        } else
        {
            echo $this->Form->checkbox($checks[$i], array('name' => $checks[$i], 'type' => 'checkbox', 'class' => array($checks[$i], 'check' . $noSpaces), 'id' => 'check' . $noSpaces, 'value' => $i));
        }
    } else
    {
        if ($i == 0)
        {
            echo $this->Form->checkbox($checks[$i], array('name' => $checks[$i], 'type' => 'checkbox', 'class' => array($checks[$i], 'check' . $noSpaces, 'validate[required]'), 'id' => 'check' . $noSpaces, 'value' => 'on', 'data-prompt-position' => 'bottomRight: 35,-35'));
        } else
        {
            echo $this->Form->checkbox($checks[$i], array('name' => $checks[$i], 'type' => 'checkbox', 'class' => array($checks[$i], 'check' . $noSpaces, 'validate[required]'), 'id' => 'check' . $noSpaces, 'value' => $i, 'data-prompt-position' => 'bottomRight: 35,-35'));
        }
    }
    ?>
                </td>
            </tr>
    <?php
}
?>
    </table>
</div>

<div id="main" style="float: left; margin-left: 20px; min-width: 400px; max-width: 600px;">
    <div id="accordion" style="width: auto 50px; min-width: 400px; float: left;">

                <?php
                $panes = array();
                $pCounter = 0;

                foreach ($variables as $var) :
                    {
                        if (!in_array($var['Variable']['section'], $panes))
                        {
                            $panes[$pCounter] = $var['Variable']['section'];
                            $pCounter++;
                        }
                    }
                endforeach;

                foreach ($panes as $pan) :
                    {
                        $spl = split(" ", $pan);
                        $res = implode('', $spl);

                        if ($res != "")
                        {
                            ?>
                    <h3 id="h3<?php echo $res ?>"><a href="#">Click to show <?php echo $pan ?></a></h3>
                    <div style="min-width: 400px;">
                        <table id="Table<?php echo $res ?>">
                                    <?php
                                    foreach ($variables as $var) :
                                        {
                                            if ($var['Variable']['section'] == $pan)
                                            {
                                                if ($var['Variable']['name'] == 'DHCP_SERVER')
                                                {
                                                    
                                                } else
                                                {
                                                    ?>
                                            <tr id="row<?php echo $var['Variable']['name'] ?>">
                                                <td style="max-width: 20x;"><?php
                            if ($var['Variable']['required'] == 'yes')
                            {
                                echo $var['Variable']['label'] . "<span style='color:#FF0000; font-weight:bold; font-size: medium;'>*</span>";
                            } else
                            {
                                echo $var['Variable']['label'];
                            }
                                                    ?></td>
                                                <td>
                                                    <?php
                                                    if ($var['Variable']['type'] == 'Text Field')
                                                    {
                                                        if ($var['Variable']['ipAddress'] == 'yes')
                                                        {
                                                            if ($var['Variable']['required'] == 'yes')
                                                            {
                                                                if ($var['Variable']['IPType'] == 'IPv4')
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required,custom[ipv4]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                } else if ($var['Variable']['IPType'] == 'Prefix')
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required,custom[ipPrefix]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                } else
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required,custom[ipv6]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                }
                                                            } else
                                                            {
                                                                if ($var['Variable']['IPType'] == 'IPv6')
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[custom[ipv6]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                } else if ($var['Variable']['IPType'] == 'Prefix')
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required,custom[ipPrefix]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                } else
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[custom[ipv4]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                }
                                                            }
                                                        } else
                                                        {
                                                            if ($var['Variable']['required'] == 'yes')
                                                            {
                                                                if ($var['Variable']['numeric'] == 'yes')
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required, custom[onlyNumberSp]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                } else
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                }
                                                            } else
                                                            {
                                                                if ($var['Variable']['numeric'] == 'yes')
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[custom[onlyNumberSp]]', $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                } else
                                                                {
                                                                    echo $this->Form->input($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 220px; height:10px;',
                                                                        'class' => array($var['Variable']['dependency'], $var['Variable']['name'], $res), 'data-prompt-position' => 'bottomLeft: -10,10', 'disabled' => true));
                                                                }
                                                            }
                                                        }
                                                    } else if ($var['Variable']['type'] == 'Dropdown Menu')
                                                    {
                                                        $nameArray = explode(',', $var['Variable']['dropName']);
                                                        $valueArray = explode(',', $var['Variable']['dropValue']);
                                                        $corArray = array_combine($valueArray, $nameArray);

                                                        if ($var['Variable']['required'] == 'yes')
                                                        {
                                                            echo $this->Form->select($var['Variable']['name'], $corArray, array('error' => $var['Variable']['dependency'], 'name' => $var['Variable']['name'], 'label' => '', 'style' => 'height:20px;',
                                                                'class' => array($var['Variable']['name'], 'validate[required]', $res), 'data-prompt-position' => 'bottomLeft: -10,0', 'disabled' => true));
                                                        }
                                                    } else if ($var['Variable']['type'] == 'Text Area')
                                                    {
                                                        if ($var['Variable']['required'] == 'yes')
                                                        {
                                                            echo $this->Form->textarea($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 150px; height:25px;',
                                                                'class' => array($var['Variable']['dependency'], $var['Variable']['name'], 'validate[required]', $res), 'data-prompt-position' => 'bottomLeft: -10,0', 'disabled' => true));
                                                        } else
                                                        {
                                                            echo $this->Form->textarea($var['Variable']['name'], array('name' => $var['Variable']['name'], 'label' => '', 'style' => 'width: 150px; height:25px;',
                                                                'class' => array($var['Variable']['dependency'], $var['Variable']['name']), 'data-prompt-position' => 'bottomLeft: -10,0', 'disabled' => true));
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td><div  style="margin-top: 15px;"><?php
                                                    if ($var['Variable']['toolTip'] != "")
                                                    {
                                                        echo $this->Html->image('/images/tooltip_icon.gif', array('id' => $var['Variable']['name'] . 'tip', 'title' => $var['Variable']['toolTip']));
                                                    }
                                                    ?></div></td>
                                            </tr>
                            <?php
                        }
                    }
                } endforeach;
            ?>  
                        </table>
                    </div>
            <?php
        }
    } endforeach;
?>
    </div>
</div>

<input type="hidden" id="hiddenPath" value="<?php echo $app_path = dirname(APP) . "/" . basename(APP); ?>" />
<input type="hidden" name="Variable[hiddenName]" id="hiddenName" value="" />
<input type="hidden" id="hiddenFile" value="" />
<script>
    //Declaration of globally used variables, popup dialogs and DOM element arrays
    var elementID = ['BEHIND_GATEWAY'];
    var $dial, $dialog, $dialogConfirm, $deleteConfirm = '';
    var formSelects = $('.Variable select');
    var formInputs = $('#accordion input, textarea');
    var formCheckBoxes = $('#checkBoxDiv input[type=checkbox]');
    var EniqEventsCheckBoxes = [];
    var EniqStatsCheckBoxes = [];
    var OSSCheckBoxes = [];
    var fromOpenDialog = "no";

    //This function is used to disable/enable the selects based on the BEHIND_GATEWAY select and the Server type (Blade/Virtual).
    function disableSelectInputs(selects)
    {
        //Iterate through the form selects
        jQuery.each(selects, function()
        {
            //Get the error attribute which stores the list of input fields who are dependant on blade or virtual/
            var temp = $("." + this.name).attr("error");
            
            //The first if is to stop getting errors of calling methods of type undefined.
            if (typeof temp == 'undefined')
            {
            }
            else if (temp != "")
            {
                //Theese next 2 lines of code split at a space to get differentiate the blade and virtual dependencies.
                var t = temp.split(" ");
                var blades = t[0].split(",");
                var virtuals = '';
                var behind = $('#BEHIND_GATEWAY option:selected').val();
                var selectVal = $('.' + this.name + ' option:selected').val();
                
                //Virtuals could be blank so have to check for null first.
                if (t[1] != null)
                {
                    virtuals = t[1].split(",");
                }

                //Check if the value of the select is blade or YES.
                if (selectVal == "blade" || selectVal == "YES")
                {
                    //Call to methods that will display or hide input fields explained below
                    displayBlock(blades);
                    displayNone(virtuals);
                }
                else if (selectVal == "virtual" || selectVal == "NO")
                {
                    //Check for the behind gateway value before displaying virtual input fields.
                    if (behind == "no")
                    {
                        displayBlock(virtuals);
                    }
                    else if (behind == "yes")
                    {
                        displayNone(virtuals);
                    }

                    displayNone(blades);
                }
                else
                {
                    displayNone(blades);
                    displayNone(virtuals);
                }
                
                //SFS Server type is a special case and only displays SFS Hostname is SFS Server type is virtual.
                if (this.name.indexOf("SFS_SERVER_TYPE") >= 0)
                {
                    if ($('.SFS_SERVER_TYPE').val() == "virtual")
                    {
                        $('.SFS_HOSTNAME').css('display', 'block');
                        $("#rowSFS_HOSTNAME").show();
                    }
                }
            }
        })
    }
    
    //Diasable all checkboxes for media files that are no valid e.g. if ENIQ stats is checked disable OSS-RC checkboxes and this also 
    //Removes the Validation errors from the checkboxes
    function checkTrue(arrayOne, arrayTwo)
    {
        //Need to set timeout otherwise this function was getting called too soon and wouldn't work.
        setTimeout(function()
        {
            jQuery.each(arrayOne, function()
            {
                $('#' + this).prop('disabled', true);
                $("." + this + "formError").remove();
            })

            jQuery.each(arrayTwo, function()
            {
                $('#' + this).prop('disabled', true);
                $("." + this + "formError").remove();
            })
        }, 500);
    }
    
    //Same as above function but does the opposite.
    function checkFalse(arrayOne, arrayTwo)
    {
        jQuery.each(arrayOne, function()
        {
            $('#' + this).prop('disabled', false);
            $("." + this + "formError").remove();
        })

        jQuery.each(arrayTwo, function()
        {
            $('#' + this).prop('disabled', false);
            $("." + this + "formError").remove();
        })
    }

    //This function is called to show/hide the jQuery accordions when the corresponding checkbox is checked.
    function toggleCheckBoxes()
    {
        $('#checkBoxDiv input[type=checkbox]').on('click', (function()
        {
            var temp = this.id.replace('check', '').replace(/ /g, '');
            //Check if the accordion is already showing.    
            if (!$('#h3' + temp).is(":visible"))
            {
                //Show the accordion
                $('#h3' + temp).show();
                //Make all the elements in the accordion not disabled.
                $("#Table" + temp).find('input,select,textarea').prop('disabled', false);
                
                //Call a function to disable the correct inputs based on the selects values in the accordion
                disableSelectInputs($("#Table" + temp).find('select'));
                
                //Show the table.
                $("#Table" + temp).show();
                
                //Make the Admin1 extra boot args variable blur to enable input fields to be showing based on the values.
                $('.ADM1_EXTRA_BOOTARGS').trigger('blur');
                
                //Checking if the filetype is media then call the CheckTrue or CheckFalse methods explained above.
                if ($('#fileTypeSelect').val() == 'media')
                {
                    if (this.name.indexOf('ENIQ Events') >= 0)
                    {
                        checkTrue(OSSCheckBoxes, EniqStatsCheckBoxes);
                    }
                    else if (this.name.indexOf('ENIQ Stats') >= 0)
                    {
                        checkTrue(OSSCheckBoxes, EniqEventsCheckBoxes);
                    }
                    else
                    {
                        checkTrue(EniqEventsCheckBoxes, EniqStatsCheckBoxes);
                    }
                }
            }
            else
            {
                //Opposite to the above if statement.
            
                if ($('#h3' + temp).hasClass('ui-state-active'))
                {
                    if (this.value == 'on')
                    {
                        $("#accordion").maccordion("option", "active", 0);
                    }
                    else
                    {
                        $("#accordion").maccordion("option", "active", this.value);
                    }
                }

                $('#h3' + temp).hide();

                var temp = this.id.replace('check', '').replace(/ /g, '');
                $("#Table" + temp).find('input,select,textarea').prop('disabled', true);
                $("#Table" + temp).hide();

                if ($('#fileTypeSelect').val() == 'media')
                {
                    if (this.name.indexOf('ENIQ Events') >= 0)
                    {
                        checkFalse(OSSCheckBoxes, EniqStatsCheckBoxes);
                    }
                    else if (this.name.indexOf('ENIQ Stats') >= 0)
                    {
                        checkFalse(OSSCheckBoxes, EniqEventsCheckBoxes);
                    }
                    else
                    {
                        var OSSCounter = 0;
                        var tempOSSArray = [];
                        
                        //Populate a temp array of all OSS-RC checkboxes that are checked to check below if all OSS-RC checkboxes
                        //are unchcked before displaying the ENIQ ones again.
                        jQuery.each(OSSCheckBoxes, function()
                        {
                            if ($('#' + this).prop("checked"))
                            {
                                OSSCounter++;
                                tempOSSArray.push(this);
                            }
                        })
                        
                        //Checking whether all OSS-RC checkboxes are unchcked before allowing ENIQ checkboxes to be enabled.
                        if (OSSCounter == 0 || OSSCounter == 1 && $('#' + tempOSSArray[tempOSSArray.length - 1]).prop("checked"))
                        {
                            checkFalse(EniqEventsCheckBoxes, EniqStatsCheckBoxes);
                        }
                    }
                }
            }
        }));
    }
    
    //This function is used to click checkboxes when loading in variables from a file.
    function clickCheckBoxes(checkArray, varName)
    {
        for (var i = 0; i < checkArray.length; i++)
        {
            var tempCheck = checkArray[i].id.replace(/\s+/g, '').split("check");
            if ($('.' + varName).hasClass(tempCheck[1]))
            {
                if (!$(checkArray[i]).prop("checked"))
                {
                    $(checkArray[i]).trigger("click");
                }
            }
        }
    }
    
    //This function is used when the page loads to display the correct buttons based on user privaleges.
    function loadOptions(configOption)
    {
        var configEditable = <?php echo json_encode($edit); ?>;
        var mediaEditable = <?php echo json_encode($medit); ?>;
        var isAdmin = <?php echo json_encode($current_user['is_admin']); ?>;


        if (configOption == "")
        {
            $('#saveAsButton, #saveButton, #newFileButton, #fileButton, #chooseLabel').css('display', 'none');
        }
        else if (isAdmin)
        {
            $('#saveAsButton, #saveButton, #newFileButton, #fileButton, #chooseLabel').css('display', 'block');
        }
        else if (configOption == "config" && configEditable == 0)
        {
            $('#fileButton, #chooseLabel').css('display', 'block');
            $('#saveAsButton, #saveButton, #newFileButton').css('display', 'none');
        }
        else if (configOption == "media")
        {
            $('#fileButton, #chooseLabel, #newFileButton').css('display', 'block');
            $('#saveAsButton, #saveButton').css('display', 'none');
        }
    }

    function loadFiles(loadURL)
    {
        var opts2 = {
            // web documentation at http://fgnass.github.com/spin.js/#?lines=13&length=4&width=2&radius=6&rotate=0&trail=60&speed=1.7
            lines: 13, // The number of lines to draw
            length: 4, // The length of each line
            width: 4, // The line thickness
            radius: 15, // The radius of the inner circle
            rotate: 0, // The rotation offset
            color: '#2E6E9E', // #rgb or #rrggbb
            speed: 1.7, // Rounds per second
            trail: 60, // Afterglow percentage
            shadow: false, // Whether to render a shadow
            hwaccel: false, // Whether to use hardware acceleration
            className: 'spinner', // The CSS class to assign to the spinner
            zIndex: 1, // The z-index (defaults to 2000000000)
            top: -18, // Top position relative to parent in px
            left: 60 // Left position relative to parent in px
        };

        var target = document.getElementById('spinDiv');
        var spinner = new Spinner(opts2).spin(target);

        var finalPath = loadURL.split('files/configs/');
        $('#hiddenName').val(finalPath[finalPath.length - 1]);

        $.ajax({
            url: "/files/configs/" + finalPath[finalPath.length - 1],
            type: 'GET',
            cache: false,
            dataType: 'html',
            timeout: 100000,
            success: function(data)
            {
                var subStr = data.split('\n');

                //Clears all inputs to make fresh page
                $('#accordion').find('input, select').val('');

                //Unchecks all checked checkboxes
                for (var i = 0; i < formCheckBoxes.length; i++)
                {
                    if ($(formCheckBoxes[i]).prop("checked"))
                    {
                        $(formCheckBoxes[i]).trigger("click");
                    }
                }

                //Iterates through each line in text file.
                for (var i = 0; i < subStr.length; i++)
                {
                    //Checks to make sure it's not a comment by looking for # symbol and checks to see if it has an = symbol to make sure its a variable.
                    if (subStr[i].indexOf('=') >= 0 && subStr[i].substr(0, 1) != '#')
                    {
                        //Makes sure its not of tye undefined otherwise no methods will work on undefined and will get error "Can't call method of undefined".
                        if (typeof subStr[i] == "undefined")
                        {
                        }
                        else
                        {
                            //variableName splits the line at the first occurance of the = symbol to get the variable name and variable value.
                            //varName and varValue removes all '/" characters for displaying on editor.
                            var variableName = subStr[i].split(/=(.*)/);
                            var varName = variableName[0].replace(/^\s\s*/, '');
                            var varValue = variableName[1].replace(/\'|"/g, '').replace(/^\s\s*/, '');

                            //Checks to see if the element is an input/textarea.
                            if ($('.' + varName).is('input,textarea'))
                            {
                                //Assigns the value to the element and triggers a blur event incase inputs have dependendant elements e.g. ADM1_EXTRA_BOOT_ARGS
                                $('.' + varName).val(varValue).trigger('blur');
                                clickCheckBoxes(formCheckBoxes, varName);
                            }
                            else
                            {
                                if (varValue == "blade" || varValue == "virtual")
                                {
                                    $('.' + varName).val(varValue).trigger('change');
                                    clickCheckBoxes(formCheckBoxes, varName);
                                }
                                else
                                {

                                    if (varName != "DHCP_SERVER")
                                    {
                                        $('.' + varName).val(varValue).trigger('change');
                                        clickCheckBoxes(formCheckBoxes, varName);
                                    }
                                    else
                                    {
                                        fromOpenDialog = "yes";
                                        $('.' + varName).val(varValue).trigger('change');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        });
    }
    
    //DisplayBlock displays all the input fields that are passed to it in an array.
    function displayBlock(array)
    {
        for (var i = 0; i < array.length; i++)
        {
            if (array[i] != "")
            {
                var id = $("." + array[i]).prop('id');
                $("." + id + "formError").remove();
                $('.' + array[i]).css('display', 'block').prop('disabled', false);
                $("#row" + array[i]).show();
            }
        }
    }
    
    //DisplayNone hides all the input fields that are passed to it in an array.
    function displayNone(array)
    {
        for (var i = 0; i < array.length; i++)
        {
            if (array[i] != "")
            {
                $('.' + array[i]).css('display', 'none').prop('disabled', true);
                $("#row" + array[i]).hide();
            }
        }
    }

    $('#fileTypeSelect').change(function()
    {
        var value = $(this).val();
        var url = encodeURI("/Variables/index/type:" + value);
        window.location = url;
    });

    $(document).ready(function()
    {   
        //When the DHCP_SERVER dropdown changes display/hide the save button based on their privaleges to write to that jumpstart server.
        $('#DHCP_SERVER').on('change', function()
        {
            readWriteFolders = [];
            readWriteFolders = <?php echo json_encode($rwMedia); ?>;
            if ($.inArray($('#DHCP_SERVER option:selected').text(), readWriteFolders) == -1)
                $('#saveAsButton, #saveButton').css('display', 'none');
            else
                $('#saveAsButton, #saveButton').css('display', 'block');

            if (fromOpenDialog != "yes")
            {
                $('#hiddenName').val('');
            }
            else
            {
                fromOpenDialog = "no";
            }
        })
    
        //Populate the checkbox arrays for ENIQ Events/Stats and OSS-RC.
        for (var i = 0; i < formCheckBoxes.length; i++)
        {
            if (formCheckBoxes[i].name.indexOf('ENIQ Events') >= 0)
            {
                EniqEventsCheckBoxes.push(formCheckBoxes[i].id);
            }
            else if (formCheckBoxes[i].name.indexOf('ENIQ Stats') >= 0)
            {
                EniqStatsCheckBoxes.push(formCheckBoxes[i].id);
            }
            else
            {
                OSSCheckBoxes.push(formCheckBoxes[i].id);
            }
        }

        var confType = <?php echo json_encode($configType); ?>;
        
        //Hardcoded input fields to display the NEDSS SMRS OSS ID, NEDSS Slave OSS ID, NEDSS Slave IPv6 ID
        if (confType == "config/")
        {
            $('#TableNEDSSVariables').append('<tr id="rowNEDSS_IPv4_WRAN"><td>Sample wran IPv4 SFS filesystem name:</td><td><input data-prompt-position="bottomLeft: -10,10" class="NEDSS_IPv4_WRAN validate[maxSize[25]]" id="ipv4Input" style="width: 220px; height:10px;" readonly></td><td><div style="margin-top: 0px;"><img src="/images/tooltip_icon.gif" id="ipv4Inputtip" title="This is the name of the filesystem that will be created on the sfs based on the SMRS Identifier and Slave Service names you gave. In total it must be 25 or less characters. Shorten the SMRS Identifier and Slave Service names as necessary." alt></div></td></tr>\n\
<tr id="rowNEDSS_IPv6_WRAN"><td>Sample wran IPv6 SFS filesystem name:</td><td><input data-prompt-position="bottomLeft: -10,10" class="NEDSS_IPv6_WRAN validate[maxSize[25]]" id="ipv6Input" style="width: 220px; height:10px;" readonly></td><td><div style="margin-top: 0px;"><img src="/images/tooltip_icon.gif" id="ipv4Inputtip" title="This is the name of the filesystem that will be created on the sfs based on the SMRS Identifier and Slave Service names you gave. In total it must be 25 or less characters. Shorten the SMRS Identifier and Slave Service names as necessary." alt></div></td></tr>\n\
<tr id="rowNEDSS_Common_WRAN"><td>Sample wran common SFS filesystem name:</td><td><input data-prompt-position="bottomLeft: -10,10" class="NEDSS_Common_WRAN validate[maxSize[25]]" id="commonInput" style="width: 220px; height:10px;" readonly></td><td><div style="margin-top: 0px;"><img src="/images/tooltip_icon.gif" id="ipv4Inputtip" title="This is the name of the filesystem that will be created on the sfs based on the SMRS Identifier and Slave Service names you gave. In total it must be 25 or less characters. Shorten the SMRS Identifier and Slave Service names as necessary." alt></div></td></tr>\n\
<tr id="rowNEDSS_Pool"><td>SMRS Pool Name:</td><td><input data-prompt-position="bottomLeft: -10,10" class="NEDSS_Pool" id="poolInput" style="width: 220px; height:10px;" readonly></td><td><div style="margin-top: 0px;"><img src="/images/tooltip_icon.gif" id="ipv4Inputtip" title="This is the name of the pool that’s expected to exist on the sfs. Its based on the SMRS Identifier you gave, followed by _SMRS." alt></div></td></tr>');

            $('#VariableNEDSSSMRSOSSID,#VariableNEDSSSLAVESERVID4,#VariableNEDSSSLAVESERVID6').keyup(function()
            {
                $('#ipv4Input').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS-wran_" + $('#VariableNEDSSSLAVESERVID4').val());
                $('#ipv6Input').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS-wran_" + $('#VariableNEDSSSLAVESERVID6').val());
                $('#commonInput').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS-wran_common");
                $('#poolInput').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS");
            });

            $('#VariableNEDSSSMRSOSSID,#VariableNEDSSSLAVESERVID4,#VariableNEDSSSLAVESERVID6').on('blur', function()
            {
                $('#ipv4Input').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS-wran_" + $('#VariableNEDSSSLAVESERVID4').val());
                $('#ipv6Input').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS-wran_" + $('#VariableNEDSSSLAVESERVID6').val());
                $('#commonInput').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS-wran_common");
                $('#poolInput').val($('#VariableNEDSSSMRSOSSID').val() + "_SMRS");
            });
        }

        $('.Variable').find("button").button();

        $('#eHeadRB a').on('click', function()
        {
            $(this).css('color: #000')
        })

        var loadURL = <?php echo json_encode($loadUrl); ?>;

        if (loadURL != '')
        {
            var tempFileName = loadURL.split("/");
            $('#workingFile').text("File you are working on: " + tempFileName[tempFileName.length - 1]);
            loadFiles(loadURL);
        }

        loadOptions($('#fileTypeSelect').val());

        $(".Variable").validationEngine({scroll: true});

        $("#accordion").maccordion({collapsible: true, active: false, heightStyle: false});

        var folderPath = <?php echo json_encode($configType); ?>;
        var padir = <?php echo json_encode($directory); ?>;
        var fp = folderPath.split('/');
        var nameInfo = '';
        
        //Defining the pop up dialog for confirmation.
        $dialogConfirm = $('<div id="dialogConfirm"></div>');

        $dialogConfirm.dialog({
            autoOpen: false,
            resizable: false,
            height: 180,
            modal: true,
            title: "Confirm Overwrite",
            open: function()
            {
                $('#dialogConfirm').html('<label>The file ' + nameInfo + ' already exists. If you would like to overwrite this file click Ok otherwise click cancel and rename the file.</label>');
            },
            buttons: {
                Ok: function()
                {
                    $('#workingFile').text('File you are working on: ' + nameInfo);
                    $('#hiddenName').val($('#hiddenName').val() + nameInfo);
                    $('#saveButton').trigger('click');
                    $dialog.dialog("close");
                    $(this).dialog("close");
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
        
        //Defining popup for Save Dialog.
        $dialog = $('<div id="saveDialog"></div>').html('Please choose the folder you wish to save the file in:');

        var dirN = '';
        $dialog.dialog(
                {
                    autoOpen: false,
                    modal: true,
                    buttons: {
                        Save: function()
                        {
                            if ($('#nFile').val() == "")
                            {
                                alert('You have not given the file a name.')
                            }
                            else if ($('#hiddenName').val() == "")
                            {

                            }
                            else
                            {
                                var textArray = [];

                                $.ajax({
                                    url: "/files/configs/" + dirN,
                                    type: 'GET',
                                    cache: false,
                                    dataType: 'html',
                                    timeout: 100000,
                                    success: function(data) {
                                        $(data).find("td > a").each(function()
                                        {
                                            textArray.push($(this).attr("href"));
                                        });

                                        var underScoreName = $('#nFile').val().replace(" ", "_");
                                        if (underScoreName.indexOf(".txt") >= 0)
                                        {
                                            if (jQuery.inArray(underScoreName, textArray) > -1)
                                            {
                                                nameInfo = underScoreName;
                                                $dialogConfirm.dialog("open");
                                            }
                                            else
                                            {
                                                $('#workingFile').text('File you are working on: ' + underScoreName + '.txt');
                                                $('#hiddenName').val($('#hiddenName').val() + underScoreName);
                                                $('#saveButton').trigger('click');
                                                $dialog.dialog("close");
                                            }
                                        }
                                        else
                                        {
                                            if (jQuery.inArray(underScoreName + '.txt', textArray) > -1)
                                            {
                                                nameInfo = underScoreName;
                                                $dialogConfirm.dialog("open");
                                            }
                                            else
                                            {
                                                $('#workingFile').text('File you are working on: ' + underScoreName + '.txt');
                                                $('#hiddenName').val($('#hiddenName').val() + underScoreName);
                                                $('#saveButton').trigger('click');
                                                $dialog.dialog("close");
                                            }
                                        }

                                    },
                                    error: function(xhr)
                                    {
                                        alert(xhr.status);
                                    }
                                });
                            }
                        },
                        Cancel: function()
                        {
                            $('#nFile').val("");
                            $(this).dialog("close");
                        }
                    },
                    show: "blind",
                    hide: "explode",
                    resizable: true,
                    minWidth: 500,
                    maxWidth: 800,
                    height: 400,
                    open: function()
                    {
                        var readWriteFolders = [];
                        if ($('#fileTypeSelect').val() == 'media')
                        {
                            var readWriteFold = {};
                            readWriteFold[$('#DHCP_SERVER option:selected').text()] = true;
                            readWriteFolders = readWriteFold;
                        }
                        else
                        {
                            readWriteFolders = <?php echo json_encode($readWriteConfig); ?>;
                        }
                        
                        //Defining fileTree.
                        $('#saveDialog').fileTree({
                            root: $('#hiddenPath').val() + '/webroot/files/configs/' + $('#fileTypeSelect').val() + '/',
                            pdir: readWriteFolders,
                            script: '/jqueryFolderTree.php',
                            expandSpeed: 20,
                            collapseSpeed: 20,
                            multiFolder: false
                        },
                        function(file) {
                        },
                                function(dire)
                                {
                                    var finalPath = dire.split('files/configs/');
                                    dirN = finalPath[finalPath.length - 1];
                                    $('#hiddenName').val(finalPath[finalPath.length - 1]);
                                });

                                $('#saveDialog').append('<label>Enter name of new file:<label><input id="nFile" style="width: 100px; height: 10px; margin-left: 20px;"></input><br><br>\n\
                                             <label>Please choose folder to save file:</label><br>');
                            }
                });
                
                //Defning Open file dialog
                $dial = $('<div id="di"></div>');

                var setFile = '';
                $dial.dialog(
                        {
                            autoOpen: false,
                            modal: true,
                            buttons: {
                                Open: function()
                                {
                                    $('#tree').empty();
                                    $('#di').html('<div id="spinDiv" style="margin-top: 120px; margin-left: 150px;"></div>\n\
                                  <div  style="margin-top: 175px; margin-left: 210px; "><label id="loadingLabel" style="color:#2E6E9E;">Loading...</label></div>')

                                    loadFiles(setFile);


                                    var tempFile = setFile.split('/');
                                    $('#workingFile').text('File you are working on: ' + tempFile[tempFile.length - 1]);
                                    $('#chosenFile').text('');
                                    $(this).dialog("close");
                                },
                                Delete: function()
                                {
                                    $deleteConfirm.dialog("open");
                                },
                                Cancel: function()
                                {
                                    $('#chosenFile').text('');
                                    $(this).dialog("close");
                                }},
                            show: "blind",
                            hide: "fade",
                            resizable: true,
                            minWidth: 500,
                            maxWidth: 800,
                            height: 400,
                            open: function()
                            {
                                $('#di').html('<label id="questLabel" style="font-family: Verdana, sans-serif; font-size: 11px;">Please Choose a ' + fp[0] + ' file:\n\
                   <br><br><div id="tree"></div>');
                                var mediaFolders = [];
                                if ($('#fileTypeSelect').val() == 'media')
                                {
                                    mediaFolders = <?php echo json_encode($mdirectory); ?>;
                                }
                                else
                                {
                                    mediaFolders = <?php echo json_encode($directory); ?>;
                                }

                                $(".ui-dialog-buttonpane span:contains('Delete')").parent().hide();
                                var configPath = $('#hiddenPath').val() + '/webroot/files/configs/' + $('#fileTypeSelect').val() + '/';
                                $('#tree').fileTree({
                                    root: configPath,
                                    pdir: mediaFolders,
                                    script: '/jqueryFileTree.php',
                                    expandSpeed: 20,
                                    collapseSpeed: 20,
                                    multiFolder: false
                                },
                                function(file)
                                {
                                    setFile = file;
                                    var tempFile = file.split('/');
                                    $('#chosenFile').text("File Name: " + tempFile[tempFile.length - 1]);

                                    for (var key in padir)
                                    {
                                        var fil = configPath + key + '/';
                                        if (file.substring(0, fil.length) === fil)
                                        {
                                            if (padir[key])
                                            {
                                                $(".ui-dialog-buttonpane span:contains('Delete')").parent().show();
                                            }
                                            else
                                            {
                                                $(".ui-dialog-buttonpane span:contains('Delete')").parent().hide();
                                            }
                                        }
                                    }
                                    if ($('#chosenFile').text() == '')
                                    {
                                        $(".ui-dialog-buttonpane:contains('Delete')").prepend('<label style="float: left; font-family: Verdana, sans-serif; font-size: 11px;" id="chosenFile"></label>');
                                        $('#chosenFile').text("File Name: " + tempFile[tempFile.length - 1]);
                                    }
                                    else
                                    {
                                        $('#chosenFile').text("File Name: " + tempFile[tempFile.length - 1]);
                                    }
                                },
                                        function(dire)
                                        {
                                            $(".ui-dialog-buttonpane span:contains('Delete')").parent().hide();
                                        }
                                        );
                                    }
                        });
                        
                        //Defining Delete Dialog
                        $deleteConfirm = $('<div id="deleteConfirm"></div>');

                        $deleteConfirm.dialog({
                            autoOpen: false,
                            resizable: false,
                            height: 180,
                            modal: true,
                            title: "Confirm Delete",
                            open: function()
                            {
                                if (setFile != "")
                                {
                                    var tempLabel = setFile.split('/');
                                    $('#deleteConfirm').html('<label>Are you sure you want to delete: ' + tempLabel[tempLabel.length - 1] + '.</label>');
                                }
                                else
                                {
                                    $('#deleteConfirm').html('<label>You have not chosen a file to delete.</label>');
                                }
                            },
                            buttons: {
                                Ok: function()
                                {
                                    if (setFile != "")
                                    {
                                        $.post('/deleteFile.php', 'val=' + setFile);
                                        $dial.dialog("close");
                                        $dial.dialog("open");
                                        $('#chosenFile').text('');
                                        $(this).dialog("close");
                                    }
                                    else
                                    {
                                        $(this).dialog("close");
                                    }
                                },
                                Cancel: function() {
                                    $(this).dialog("close");
                                }
                            }
                        });

                        jQuery.each($('#main').find("input,select,textarea"), function()
                        {
                            elementID.push(this.name);
                        })
                    });
                    
                    //This method is used to find out when any EXTRA_BOOTARGS input fields have changed
                    jQuery.each(formInputs, function()
                    {
                        if (this.name != "")
                        {
                            var temp = $('.' + this.name).attr("class");

                            $('.' + this.name).on('blur', function()
                            {
                                if (this.name.indexOf("EXTRA_BOOTARGS") >= 0)
                                {
                                    if (typeof temp == 'undefined')
                                    {
                                    }
                                    else if (temp == "" || temp == "_method" || temp == "query")
                                    {
                                    }
                                    else if (this.name.toLowerCase().indexOf("[") >= 0)
                                    {
                                    }
                                    else
                                    {
                                        var t = temp.split(" ");
                                        var inputNames = t[0].split(",");
                                        var inputText = $('.' + this.name).val();

                                        if (this.name == "ADM1_EXTRA_BOOTARGS")
                                        {
                                            if (inputText.indexOf("environ=test") < 0 && $('#VariableADM1IPV6PARAMETER').val() == "YES")
                                            {
                                                displayBlock(inputNames);
                                            }
                                            else if (inputText.indexOf("environ=test") < 0 && $('#VariableADM1IPV6PARAMETER').val() == "NO")
                                            {
                                                var tempArray = [];

                                                for (var i = 0; i < inputNames.length; i++)
                                                {
                                                    if (inputNames[i].indexOf("VIP_IPV6"))
                                                    {
                                                        tempArray.push(inputNames[i]);
                                                    }
                                                }
                                                displayBlock(tempArray);
                                            }
                                            else if (inputText.indexOf("environ=test") >= 0)
                                            {
                                                displayNone(inputNames);
                                            }
                                            else
                                            {
                                                displayBlock(inputNames);
                                            }
                                        }
                                        else
                                        {
                                            if (inputText.indexOf("environ=test") >= 0)
                                            {
                                                displayNone(inputNames);
                                            }
                                            else
                                            {
                                                displayBlock(inputNames);
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    });
                    
                    //This method is used when any of the form selects are changed it displays/hides input fields based on value of select.
                    jQuery.each(formSelects, function(i, val)
                    {
                        var temp = $("." + this.name).attr("error");

                        $('.' + this.name).on('change', function()
                        {
                            if (typeof temp == 'undefined')
                            {
                            }
                            else if (temp != "")
                            {
                                var t = temp.split(" ");
                                var blades = t[0].split(",");
                                var virtuals = '';
                                var behind = $('#BEHIND_GATEWAY option:selected').val();

                                if (t[1] != null)
                                {
                                    virtuals = t[1].split(",");
                                }

                                var selectVal = $('.' + this.name + ' option:selected').val();

                                if (this.name == 'BEHIND_GATEWAY')
                                {
                                    if (behind == "yes")
                                    {
                                        jQuery.each(formSelects, function()
                                        {
                                            if (this.name.indexOf("SERVER_TYPE") >= 0)
                                            {
                                                if ($('.' + this.name).val() == "virtual")
                                                {
                                                    $('.' + this.name).trigger('change');
                                                }
                                                else
                                                {
                                                    $('.' + this.name).val("");
                                                    $('.' + this.name).trigger('change');
                                                }
                                            }
                                        })
                                    }
                                    else if (behind == "no")
                                    {
                                        jQuery.each(formSelects, function()
                                        {
                                            if (this.name.indexOf("SERVER_TYPE") >= 0)
                                            {
                                                if ($('.' + this.name).val() != "")
                                                {
                                                    $('.' + this.name).trigger('change');
                                                }
                                                else
                                                {
                                                    $('.' + this.name).val("");
                                                    $('.' + this.name).trigger('change');
                                                }
                                            }
                                        })
                                    }
                                }

                                if (selectVal == "blade" || selectVal == "YES")
                                {
                                    displayBlock(blades);
                                    displayNone(virtuals);
                                }
                                else if (selectVal == "virtual" || selectVal == "NO")
                                {
                                    jQuery.each(virtuals, function()
                                    {
                                        if (behind == "no")
                                        {
                                            displayBlock(virtuals);
                                        }
                                        else if (behind == "yes")
                                        {
                                            displayNone(virtuals);
                                        }
                                    })

                                    displayNone(blades);
                                }
                                else
                                {
                                    displayNone(blades);
                                    displayNone(virtuals);
                                }

                                if (this.name == "ADM1_IPV6_PARAMETER")
                                {
                                    var inputNames = $('#VariableADM1EXTRABOOTARGS').attr("class").split(",");
                                    ;
                                    var inputText = $('#VariableADM1EXTRABOOTARGS').val();

                                    if (inputText.indexOf("environ=test") < 0 && $('#VariableADM1IPV6PARAMETER').val() == "YES")
                                    {
                                        displayBlock(inputNames);
                                    }
                                    else if (inputText.indexOf("environ=test") < 0 && $('#VariableADM1IPV6PARAMETER').val() == "NO")
                                    {
                                        var tempArray = [];

                                        for (var i = 0; i < inputNames.length; i++)
                                        {
                                            if (inputNames[i].indexOf("VIP_IPV6"))
                                            {
                                                tempArray.push(inputNames[i]);
                                            }
                                        }
                                        displayBlock(tempArray);
                                    }
                                    else if (inputText.indexOf("environ=test") >= 0)
                                    {
                                        displayNone(inputNames);
                                    }
                                    else
                                    {
                                        displayBlock(inputNames);
                                    }
                                }

                                if (this.name.indexOf("SFS_SERVER_TYPE") >= 0)
                                {
                                    if ($('.SFS_SERVER_TYPE').val() == "virtual")
                                    {
                                        $('.SFS_HOSTNAME').css('display', 'block').prop('disabled', false);
                                        $("#rowSFS_HOSTNAME").show();
                                    }
                                }
                            }
                        })
                    })
                    
                    //Hides all accordions on page load.
                    $("#accordion").find('h3').hide();
                    toggleCheckBoxes();
                    
                    //This is all the logic behind the save button.
                    $("#saveButton").click(function()
                    {
                        //This hiddenName input field holds the path to the config file in which we want to save if this is empty we 
                        //popup the save dialog box.
                        if ($('#hiddenName').val() == "")
                        {
                            $dialog.dialog("open");
                            return false;
                        }
                        else
                        {
                            var checksArray = [];
                            
                            //Iterating through all the checkboxes and drop all of their corresponding accordions so the validation engine
                            //can do it's checks it doesn't work on non dropped accordions.
                            jQuery.each(formCheckBoxes, function()
                            {
                                if ($(this).prop("checked"))
                                {
                                    if (this.value == 'on')
                                    {
                                        $("#accordion").maccordion("option", "active", 0);
                                    }
                                    else
                                    {
                                        $("#accordion").maccordion("option", "active", this.value);
                                    }
                                }
                            })
                            
                            //Call the form submit function so the form gets submitted and the validation engine gets called.
                            $('.Variable').submit();
                            
                            //Close any dialogs that are currently open.
                            $dialog.dialog("close");
                            $dialogConfirm.dialog("close");
                            $dial.dialog("close");
                            
                            //Get all elements on the form with errors on them.
                            var errorElements = $(".formError");
                            
                            //Iterate through elements with errors 
                            jQuery.each(errorElements, function()
                            {
                                var classNames = this.className.split(' ');
                                var elementID = classNames[0].split('formError');

                                jQuery.each($('#' + elementID[0]).prop('class').split(' '), function(i, val)
                                {
                                    if (val != "")
                                    {
                                        if (jQuery.inArray(val, checksArray) == -1)
                                        {
                                            checksArray.push(val);
                                        }
                                    }
                                })
                            })

                            setTimeout(function()
                            {
                                jQuery.each(formCheckBoxes, function()
                                {
                                    var minusCheck = this.id.split("check");
                                    var minusSpaces = minusCheck[1].replace(/ /g, '');
                                    if ($(this).prop("checked"))
                                    {
                                        if (jQuery.inArray(minusSpaces, checksArray) > -1)
                                        {
                                            if ($("#accordion").find('h3').filter(':contains(' + minusCheck[1] + ')').hasClass('ui-state-active'))
                                            {
                                                if (this.value == 'on')
                                                {
                                                    $("#accordion").maccordion("option", "active", 0);
                                                }
                                                else
                                                {
                                                    $("#accordion").maccordion("option", "active", this.value);
                                                }
                                            }
                                        }
                                        else
                                        {
                                            if (!$("#accordion").find('h3').filter(':contains(' + minusCheck[1] + ')').hasClass('ui-state-active'))
                                            {
                                                if (this.value == 'on')
                                                {
                                                    $("#accordion").maccordion("option", "active", 0);
                                                }
                                                else
                                                {
                                                    $("#accordion").maccordion("option", "active", this.value);
                                                }
                                            }
                                        }
                                    }
                                })
                            }, 500);
                        }
                    });

                    $('#newFileButton').click(function()
                    {
                        var accordions = $("#accordion").find('h3');

                        $("#accordion").maccordion("option", "active", accordions.length);
                        $('#workingFile').text('File you are working on: New File');
                        $('#hiddenName, #BEHIND_GATEWAY ').val('');

                        jQuery.each(formInputs, function()
                        {
                            $('#' + this.id).val('');
                        })

                        jQuery.each(formSelects, function()
                        {
                            if (this.id != "fileTypeSelect")
                            {
                                $('#' + this.id).val('');
                                $('#' + this.id).trigger('change');
                            }
                        })

                        jQuery.each(formCheckBoxes, function()
                        {
                            if ($(this).prop('checked'))
                            {
                                $(this).trigger('click');
                            }
                        })
                    });

                    $('#fileButton').click(function()
                    {
                        $dial.dialog('open');
                    });

                    $("#saveAsButton").click(function()
                    {
                        $dialog.dialog("open");
                    });
</script>
