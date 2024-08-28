<?php
echo $this->Html->css('jqueryFileTree/jqueryFileTree', null, array('inline' => false));
echo $this->Html->css('validationEngine.jquery', null, array('inline' => false));

echo $this->Html->script('jqueryFileTree');
echo $this->Html->script('jquery.validationEngine-en');
echo $this->Html->script('jquery.validationEngine');

$checksDir = dirname(APP) . '/' . basename(APP) . '/webroot/files/configs/web_configs/';
$mediaDir = dirname(APP) . '/' . basename(APP) . '/webroot/files/configs/media/';
$configDir = dirname(APP) . '/' . basename(APP) . '/webroot/files/configs/config/';
$dir = dirname(APP) . '/' . basename(APP) . '/webroot/files/configs';
$directory = $current_user['permissions'];
$mdirectory = $current_user['mpermissions'];

$date = date('m_d_Y h_i_s');

echo $this->Form->create('Install', array('class' => 'Install', 'name' => 'Install'));

//Array of checkboxes
$checkboxArray = array('Initial install admin 1' => 'INITIAL_INSTALL_ADM1', 'Initial install admin 1 part 1' => 'INITIAL_INSTALL_ADM1_PART1', 'Initial install admin 1 part 2' => 'INITIAL_INSTALL_ADM1_PART2',
    'Initial install admin 2' => 'INITIAL_INSTALL_ADM2', 'Initial install admin 2 part 1' => 'INITIAL_INSTALL_ADM2_PART1', 'Initial install admin 2 part 2' => 'INITIAL_INSTALL_ADM2_PART2',
    'Initial install OMSAS' => 'INITIAL_INSTALL_OMSAS', 'Initial install OMSAS part 1' => 'INITIAL_INSTALL_OMSAS_PART1', 'Initial install OMSAS part 2' => 'INITIAL_INSTALL_OMSAS_PART2',
    'Initial install OMSERVM' => 'INITIAL_INSTALL_OMSERVM', 'Initial install OMSERVM part 1' => 'INITIAL_INSTALL_OMSERVM_PART1', 'Initial install OMSERVM part 2' => 'INITIAL_INSTALL_OMSERVM_PART2',
    'Initial install OMSERVS' => 'INITIAL_INSTALL_OMSERVS', 'Initial install OMSERVS part 1' => 'INITIAL_INSTALL_OMSERVS_PART1', 'Initial install OMSERVS part 2' => 'INITIAL_INSTALL_OMSERVS_PART2',
    'Initial install UAS1' => 'INITIAL_INSTALL_UAS1', 'Initial install UAS1 part 1' => 'INITIAL_INSTALL_UAS1_PART1', 'Initial install UAS1 part 2' => 'INITIAL_INSTALL_UAS1_PART2',
    'Initial install PEER1' => 'INITIAL_INSTALL_PEER1', 'Initial install PEER1 part 1' => 'INITIAL_INSTALL_PEER1_PART1', 'Initial install PEER1 part 2' => 'INITIAL_INSTALL_PEER1_PART2',
    'Initial install NEDSS' => 'INITIAL_INSTALL_NEDSS', 'Initial install NEDSS part 1' => 'INITIAL_INSTALL_NEDSS_PART1', 'Initial install NEDSS part 2' => 'INITIAL_INSTALL_NEDSS_PART2',
    'Initial install EBAS' => 'INITIAL_INSTALL_EBAS', 'Initial install EBAS part 1' => 'INITIAL_INSTALL_EBAS_PART1', 'Initial install EBAS part 2' => 'INITIAL_INSTALL_EBAS_PART2',
    'Initial install ENIQE' => 'INITIAL_INSTALL_ENIQE', 'Initial install ENIQE part 1' => 'INITIAL_INSTALL_ENIQE_PART1', 'Initial install ENIQE part 2' => 'INITIAL_INSTALL_ENIQE_PART2',
    'Initial install ENIQS' => 'INITIAL_INSTALL_ENIQS', 'Initial install ENIQS part 1' => 'INITIAL_INSTALL_ENIQS_PART1', 'Initial install ENIQS part 2' => 'INITIAL_INSTALL_ENIQS_PART2',
    'Initial install SONVIS' => 'INITIAL_INSTALL_SON_VIS', 'Initial install SONVIS part 1' => 'INITIAL_INSTALL_SON_VIS_PART1', 'Initial install SONVIS part 2' => 'INITIAL_INSTALL_SON_VIS_PART2',
    'Post install admin 1' => 'POST_INSTALL_ADM1', 'Post install admin 2' => 'POST_INSTALL_ADM2', 'Post install OMSAS' => 'POST_INSTALL_OMSAS',
    'Post install OMSERVM' => 'POST_INSTALL_OMSERVM', 'Post install OMSERVS' => 'POST_INSTALL_OMSERVS', 'Post install UAS1' => 'POST_INSTALL_UAS1',
    'Post install PEER1' => 'POST_INSTALL_PEER1', 'Post install NEDSS' => 'POST_INSTALL_NEDSS', 'Post install EBAS' => 'POST_INSTALL_EBAS');
?>
<table>
    <tr>
        <td><label>Please choose media file:</label></td>
        <td><?php
            echo $this->Form->input('Mediainput', array('label' => '', 'id' => 'MediaInput', 'style' => 'width: 200px', 'class' => 'validate[required]', 'data-prompt-position' => 'topRight: 35, 0', 'readonly' => true));
            echo $this->Form->button('Browse Media', array('type' => 'button', 'id' => 'MediaButton', 'style' => 'font-size: 12px;'));
            echo $this->Form->button('Edit', array('type' => 'button', 'id' => 'MediaEdit', 'style' => 'font-size: 12px;'));
            ?>
        </td>
    </tr> 
    <tr>
        <td><?php echo $this->Form->label('Please choose config file: '); ?></td>
        <td>
            <?php
            echo $this->Form->input('Configinput', array('label' => '', 'id' => 'ConfigInput', 'style' => 'width: 200px', 'class' => 'validate[required]', 'data-prompt-position' => 'topRight: 35, 0', 'readonly' => true));
            echo $this->Form->button('Browse Configs', array('type' => 'button', 'id' => 'ConfigButton', 'style' => 'font-size: 12px;'));
            echo $this->Form->button('Edit', array('type' => 'button', 'id' => 'ConfigEdit', 'style' => 'font-size: 12px;'));
            ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Enter gateway: '); ?></td>
        <td><?php echo $this->Form->input('gateway', array('label' => '', 'id' => 'gateway')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->button('Check All', array('type' => 'button', 'id' => 'CheckAllButton', 'style' => 'font-size: 12px;')); ?></td><td></td>
    </tr>
</table>
<table id="checkBoxTable">
    <?php
    foreach ($checkboxArray as $key => $value) : {
            if (!strpos($key, 'part') !== false) {
                if (strpos($key, 'Post') !== false) {
                    ?>
                    <tr style="max-width: 210px;">
                        <td  style="width: 200px; max-width: 200px;"><label style="max-width: 200px;"><?php echo $key; ?></label></td>
                        <td style="width: 10px;"><?php echo $this->Form->checkbox($value, array('type' => 'checkbox', 'id' => $value)) ?></td>
                        <td></td>
                        <td></td>
                    </tr>    
                    <?php
                } else {
                    ?>
                    <tr style="max-width: 210px;">
                        <td  style="width: 200px; max-width: 200px;"><label style="max-width: 200px;"><?php echo $key; ?></label></td>
                        <td style="width: 10px;"><?php echo $this->Form->checkbox($value, array('type' => 'checkbox', 'id' => $value)) ?></td>
                        <td><label id="<?php echo $value ?>_PART1_LABEL" style="margin-left: 50px;"></label></td>
                        <td><div id="<?php echo $value ?>_DIV"><input type="checkbox" name=""  id="<?php echo $value ?>_PART1" value="1"></div></td>
                    </tr>
                    <tr id="row<?php echo $value; ?>"><td></td><td></td>
                        <td><label id="<?php echo $value ?>_PART2_LABEL" style="margin-left: 50px;"></label></td>
                        <td><input type="checkbox" name=""  id="<?php echo $value ?>_PART2" value="1"></td>
                    </tr>
                    <?php
                }
            }
        }
    endforeach;
    ?>
    <tr>
        <td>
            <?php echo $this->Form->button('Start', array('type' => 'submit', 'id' => 'startButton'))?>
        </td>
    </tr>
</table>

<script>
    var $dialog = '';
    var $dial = '';
    var inputs = $('#checkBoxTable').find(':checkbox');
    var media_file = '';
    var config_file = '';

    $(document).ready(function()
    {
        $('.Install').validationEngine('attach', {
            onValidationComplete: function(form, status)
            {
                if (status == true)
                {
                    var checkArray = {};

                    jQuery.each(inputs, function()
                    {
                        if ($('#' + this.id).attr("checked"))
                        {
                            checkArray[this.id] = "yes";
                        }
                        else
                        {
                            checkArray[this.id] = "no";
                        }
                    })

                    var padir = <?php echo json_encode($directory); ?>;
                    var configPath = <?php echo json_encode($configDir); ?>;
                    var filepath = config_file;
                    var sdir = '';

                    for (var key in padir) {
                        //alert(key + ' => ' + padir[key]);
                        fil = configPath + key + '/';
                        if (filepath.substring(0, fil.length) === fil)
                        {
                            sdir = key;
                        }
                    }

                    var save_data = {
                        "dir": <?php echo json_encode($mediaDir); ?>,
                        "filename": <?php echo json_encode($date); ?>,
                        "data": checkArray,
                        "media": media_file,
                        "config": config_file,
                        "gateway": $('#gateway').val(),
                        "sdir": sdir
                    };

                    $.ajax({
                        url: '/Installs/fileWriter',
                        type: 'POST',
                        data: {data: save_data},
                        success: function(data1)
                        {
                            alert("Started please go to the viewer page to view install progress." + data1);
                        },
                        error: function(xhr)
                        {
                            alert("Error: " + xhr.statusText);
                        }
                    })

                }
            }
        })
        $('.Install').find('button').button();
        var mediaPath = <?php echo json_encode($mediaDir); ?>;
        var configPath = <?php echo json_encode($configDir); ?>;
        var checkBoxes = <?php echo json_encode($checkboxArray); ?>;

        jQuery.each(checkBoxes, function(key, value)
        {
            $('#' + value + '_LABEL').text(key);

            if (key.indexOf("part") >= 0)
            {
                $('#' + value).prop("name", "data[Install][" + value + "]")
            }
        })

        $dialog = $('<div id="MediaDialog"></div>');

        $dialog.dialog(
                {
                    autoOpen: false,
                    modal: true,
                    buttons: {Ok: function()
                        {
                            $(this).dialog("close");
                        }},
                    show: "blind",
                    hide: "explode",
                    resizable: true,
                    minWidth: 500,
                    maxWidth: 800,
                    height: 400,
                    open: function()
                    {
                        var padir = <?php echo json_encode($mdirectory); ?>;
                        $('#MediaDialog').html('<label style="font-family: Verdana, sans-serif; font-size: 11px;" id="chosenFile">File Name:</label>\n\
                                    <br><br> <label style="font-family: Verdana, sans-serif; font-size: 11px;">Please Choose a Media file:\n\
                                    <div id="tree1"></div>');

                        $('#tree1').fileTree({
                            root: mediaPath,
                            pdir: padir,
                            script: '/jqueryFileTree.php',
                            expandSpeed: 20,
                            collapseSpeed: 20,
                            multiFolder: false
                        },
                        function(file)
                        {
                            var tempFile1 = file.split('/');
                            $('#chosenFile').text("File Name: " + tempFile1[tempFile1.length - 1]);
                            $('#MediaInput').val(file.replace(<?php echo json_encode($dir); ?>, ''));
                            media_file = file;

                            for (var key in padir) {
                                //alert(key + ' => ' + padir[key]);
                                fil = mediaPath + key + '/';
                                if (file.substring(0, fil.length) === fil)
                                {
                                    if (padir[key])
                                        $('#MediaEdit').css('visibility', 'visible');
                                    else
                                        $('#MediaEdit').css('visibility', 'hidden');
                                }
                            }
                        },
                                function(dire)
                                {
                                }
                        )
                    }
                });

        $dial = $('<div id="ConfigDialog"></div>');

        $dial.dialog(
                {
                    autoOpen: false,
                    modal: true,
                    buttons: {Ok: function()
                        {
                            $(this).dialog("close");
                        }},
                    show: "blind",
                    hide: "explode",
                    resizable: true,
                    minWidth: 500,
                    maxWidth: 800,
                    height: 400,
                    open: function()
                    {
                        var padir = <?php echo json_encode($directory); ?>;

                        $('#ConfigDialog').html('<label style="font-family: Verdana, sans-serif; font-size: 11px;" id="chosenFile2">File Name:</label>\n\
                                    <br><br> <label style="font-family: Verdana, sans-serif; font-size: 11px;">Please Choose a Config file:\n\
                                    <div id="tree2"></div>');
                        $('#tree2').fileTree({
                            root: configPath,
                            pdir: padir,
                            script: '/jqueryFileTree.php',
                            expandSpeed: 20,
                            collapseSpeed: 20,
                            multiFolder: false
                        },
                        function(file)
                        {
                            var tempFile = file.split('/');
                            $('#chosenFile2').text("File Name: " + tempFile[tempFile.length - 1]);
                            config_file = file;
                            $('#ConfigInput').val(file.replace(<?php echo json_encode($dir); ?>, ''));
                            for (var key in padir) {
                                fil = configPath + key + '/';
                                if (file.substring(0, fil.length) === fil)
                                {
                                    if (padir[key])
                                        $('#ConfigEdit').css('visibility', 'visible');
                                    else
                                        $('#ConfigEdit').css('visibility', 'hidden');
                                }
                            }
                        },
                                function(dire)
                                {
                                }
                        )
                    }
                });

        jQuery.each(inputs, function()
        {
            $('#' + this.id + '_PART1_LABEL').hide();
            $('#' + this.id + '_DIV').hide();
            $('#row' + this.id).hide();
        });

        jQuery.each(inputs, function()
        {
            $('#' + this.id).on('click', function()
            {
                if ($('#row' + this.id).is(":visible"))
                {
                    $('#' + this.id + '_PART1_LABEL').hide();
                    $('#' + this.id + '_DIV').hide();
                    $('#row' + this.id).hide();
                    $('#' + this.id + '_PART1').attr('checked', false);
                    $('#' + this.id + '_PART2').attr('checked', false);
                }
                else
                {
                    $('#' + this.id + '_PART1_LABEL').show();
                    $('#' + this.id + '_DIV').show();
                    $('#row' + this.id).show();
                    $('#' + this.id + '_PART1').attr('checked', true);
                    $('#' + this.id + '_PART2').attr('checked', true);
                }
            })
        });
    });

    $('#CheckAllButton').click(function()
    {
        var label = $('#CheckAllButton').button("option", "label");

        if (label == "Check All")
        {
            $('#CheckAllButton').button("option", "label", "Uncheck All");
            jQuery.each(inputs, function()
            {
                $('#' + this.id + '_PART1_LABEL').show();
                $('#' + this.id + '_DIV').show();
                $('#row' + this.id).show();
                $('#' + this.id).attr('checked', true);
                $('#' + this.id + '_PART1').attr('checked', true);
                $('#' + this.id + '_PART2').attr('checked', true);
            })
        }
        else
        {
            $('#CheckAllButton').button("option", "label", "Check All");
            jQuery.each(inputs, function()
            {
                $('#' + this.id + '_PART1_LABEL').hide();
                $('#' + this.id + '_DIV').hide();
                $('#row' + this.id).hide();
                $('#' + this.id).attr('checked', false);
                $('#' + this.id + '_PART1').attr('checked', false);
                $('#' + this.id + '_PART2').attr('checked', false);
            })
        }

    });

    $('#MediaEdit').click(function()
    {
        var value = $('#MediaInput').val();
        var v = value.replace(/ |\//g, "-");
        var url = encodeURI("/variables/index/type:media/urlType:" + v);
        window.open(url);
    });
    $('#ConfigEdit').click(function()
    {
        var value = $('#ConfigInput').val();
        var v = value.replace(/ |\//g, "-");
        var url = encodeURI("/variables/index/type:config/urlType:" + v);
        window.open(url);
    });

    $('#MediaButton').click(function()
    {
        $dialog.dialog('open');
    });

    $('#ConfigButton').click(function()
    {
        $dial.dialog('open');
    });
</script>
