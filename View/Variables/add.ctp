<?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', FALSE); ?>
<?php echo $this->Html->script('jquery-ui-1.8.22.custom.min', FALSE); ?>

<?php
$type = array('Text Field' => 'Text Field', 'Dropdown Menu' => 'Dropdown Menu', 'Text Area' => 'Text Area');
$depChoice = array('yes' => 'yes', 'no' => 'no');
$ipType = array('IPv4' => 'IPv4', 'IPv6' => 'IPv6');
?> 

<?php echo $this->Form->create('Variable'); ?>
<?php echo $this->Form->input('id'); ?>
<?php
$panes = array();
$filePanes = array();
$panes["New Section"] = "New Section";
$filePanes["New File Type"] = "New File Type";

foreach ($variables as $var) : {
        if ($var['Variable']['section'] != '') {
            if (in_array($var['Variable']['section'], $panes)) {
                
            } else {
                $se = $var['Variable']['section'];
                $panes[$se] = $se;
            }
        }

        if ($var['Variable']['fileType'] != '') {
            if (in_array($var['Variable']['fileType'], $filePanes)) {
                
            } else {
                $fp = $var['Variable']['fileType'];
                $filePanes[$fp] = $fp;
            }
        }
    }
endforeach;
?>

<h1>Add Post</h1>
<table>
    <tr>
        <td><?php echo $this->Form->label('Variable Name: ') ?></td>
        <td><?php echo $this->Form->input('name', array('label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td>
    </tr>	
    <tr>	
        <td><?php echo $this->Form->label('Taf property: ') ?></td>	
        <td><?php echo $this->Form->input('tafproperty', array('label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Human Readable Name: ') ?></td>
        <td><?php echo $this->Form->textarea('label', array('label' => '', 'style' => 'height: 50px; width: 150px;')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Tool tip: ') ?></td>
        <td><?php echo $this->Form->textarea('tooTip', array('label' => '', 'style' => 'height: 50px; width: 150px;')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Type of field: ') ?></td>
        <td><?php echo $this->Form->select('type', $type, array('class' => 'type', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr id="row1">
        <th>Please outline drop down options:</th>
        <th></th>
    </tr>
    <tr id="row2">
        <td><?php echo $this->Form->label('Name 1:'); ?></td>
        <td><?php echo $this->Form->input('inputName1', array('label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td> 
        <td><?php echo $this->Form->label('Value 1:'); ?></td>
        <td><?php echo $this->Form->input('inputValue1', array('label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td> 
    </tr>
    <tr  id="existingRow">
        <td><?php echo $this->Form->button('Add Option', array('class' => 'addButton', 'type' => 'button')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Is this field required: ') ?></td>
        <td><?php echo $this->Form->select('required', $depChoice, array('class' => 'required', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Is this a numeric field: ') ?></td>
        <td><?php echo $this->Form->select('numeric', $depChoice, array('class' => 'numeric', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Is this an IP Address field: ') ?></td>
        <td><?php echo $this->Form->select('ipAddress', $depChoice, array('class' => 'ipAddress', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr  id="ipRow">
        <td><?php echo $this->Form->label('IPv4 or IPv6: ') ?></td>
        <td><?php echo $this->Form->select('IPType', $ipType, array('class' => 'IPType', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Section the Variable falls under: ') ?></td>
        <td><?php echo $this->Form->select('section', $panes, array('class' => 'section', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr id="newSection">
        <td><?php echo $this->Form->label('Please enter name of the new Section: ') ?></td>
        <td><?php echo $this->Form->input('sectionInput', array('class' => 'sectionInput', 'label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td> 
    </tr>
    <tr>
        <td><?php echo $this->Form->label('File type the variable falls under: ') ?></td>
        <td><?php echo $this->Form->select('fileType', $filePanes, array('class' => 'fileType', 'style' => 'width: 100px', 'label' => '')); ?></td>
    </tr>
    <tr id="newFileType">
        <td><?php echo $this->Form->label('Please enter name of the new file type: ') ?></td>
        <td><?php echo $this->Form->input('fileInput', array('class' => 'fileInput', 'label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td> 
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Version of OSS: ') ?></td>
        <td><?php echo $this->Form->input('version', array('label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->label('Is there depenecies: ') ?></td>
        <td><?php echo $this->Form->select('dependency', $depChoice, array('class' => 'dep', 'style' => 'height: 20px;')); ?></td>
    </tr>
</table>

<div id="tablesDiv" style="width:802px;">
    <div style="float: left; border-right: #555555 2px solid; width: 400px;">
        <table id="leftTable">
            <th>First Dependencies</th>
            <th></th>
            <tr>
                <td><?php echo $this->Form->label('Dependency 1: ') ?></td>
                <td><?php echo $this->Form->input('inputBlade1', array('class' => 'inputBlade1', 'label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td>
            </tr>
            <tr id="addLeft">
                <td><?php echo $this->Form->button('Add Dependency', array('class' => 'addBladeField', 'type' => 'button')); ?></td>
                <td></td>
            </tr>
        </table>

    </div>
    <div style="width:400px; float: right;">
        <table id="rightTable" >
            <th>Second Dependencies</th>
            <th></th>
            <tr>
                <td><?php echo $this->Form->label('Dependency 1: ') ?></td>
                <td><?php echo $this->Form->input('inputVirtual1', array('class' => 'inputVirtual1', 'label' => '', 'style' => 'height: 10px; width: 150px;')); ?></td>
            </tr>
            <tr id="addRight">
                <td><?php echo $this->Form->button('Add Dependency', array('class' => 'addVirtualField', 'type' => 'button')); ?></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>

<div style="float: right; margin-right: 120px;"><?php echo $this->Form->button('Save Variable', array('class' => 'endButton', 'style' => 'width: 100px; height: 30px;')); ?></div>
<script>

    $('.type').change(function()
    {
        var selectedVal = $('.type option:selected').text();

        if (selectedVal == "Dropdown Menu")
        {
            $('.numeric').val('no');
            $('.ipAddress').val('no')
            $('.numeric').attr("disabled", "disabled");
            $('.ipAddress').attr("disabled", "disabled");
        }
        else
        {
            $('.numeric').val('');
            $('.ipAddress').val('')
            $('.numeric').removeAttr("disabled");
            $('.ipAddress').removeAttr("disabled");
        }

    });

    $('#newSection').hide();
    $('.section').change(function()
    {
        var selectedVal = $('.section option:selected').text();

        if (selectedVal == "New Section")
        {
            $('#newSection').show();
        }
        else
        {
            $('#newSection').hide();
        }
    });

    $('#newFileType').hide();
    $('.fileType').change(function()
    {
        var selectedVal = $('.fileType option:selected').text();

        if (selectedVal == "New File Type")
        {
            $('#newFileType').show();
        }
        else
        {
            $('#newFileType').hide();
        }
    });

    $('#row1').hide();
    $('#row2').hide();
    $('#existingRow').hide();
    $('#ipRow').hide();

    $('.ipAddress').change(function()
    {
        if ($('.ipAddress option:selected').text() == "yes")
        {
            $('#ipRow').show();
        }
        else
        {
            $('#ipRow').hide();
        }
    });

    $('.type').change(function()
    {
        if ($('.type option:selected').text() == "Dropdown Menu")
        {
            $('#row1').show();
            $('#row2').show();
            $('#existingRow').show();
        }
        else
        {
            $('#row1').hide();
            $('#row2').hide();
            $('#existingRow').hide();
        }
    });

    $('#leftTable').hide();
    $('#rightTable').hide();
    $('.inputBlade1').attr("disabled", "disabled");
    $('.inputVirtual1').attr("disabled", "disabled");

    $('.dep').change(function()
    {
        if ($('.dep option:selected').text() == "yes")
        {
            $('#leftTable').show();
            $('#rightTable').show();
            $('.inputBlade1').removeAttr("disabled");
            $('.inputVirtual1').removeAttr("disabled");
        }
        else
        {
            $('#leftTable').hide();
            $('#rightTable').hide();
            $('.inputBlade1').attr("disabled", "disabled");
            $('.inputVirtual1').attr("disabled", "disabled");
        }
    });

    var counter = 2;
    $('.addButton').click(function()
    {
        $('#existingRow').before($('<tr><td><label for="VariableOption">Name ' + counter + ':</label></td><td><input name="data[Variable][inputName' + counter + ']" style="height: 10px; width: 150px;" maxlength="30" type="text" id="VariableName"></td>\n\
                                        <td><label for="VariableOption">Value ' + counter + ':</label></td><td><input name="data[Variable][inputValue' + counter + ']" style="height: 10px; width: 150px;" maxlength="30" type="text" id="VariableValue"></td></tr>'));
        counter++;
    });

    var leftCounter = 2;
    $('.addBladeField').click(function()
    {
        $('#addLeft').before($('<tr><td><label for="VariableBladeDependcy1:">Dependcy ' + leftCounter + ': </label></td><td><input name="data[Variable][inputBlade' + leftCounter + ']" style="height: 10px; width: 150px;" maxlength="30" type="text" id="VariableName"></td></tr>'));
        leftCounter++;
    });

    var rightCounter = 2;
    $('.addVirtualField').click(function()
    {
        $('#addRight').before($('<tr><td><label for="VariableVirtualDependency1:">Dependency ' + rightCounter + ': </label></td><td><input name="data[Variable][inputVirtual' + rightCounter + ']" style="height: 10px; width: 150px;" maxlength="30" type="text" id="VariableName"></td></tr>'));
        rightCounter++;
    });

</script>