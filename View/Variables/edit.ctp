<h1>Edit Variable</h1>
<?php 
$type = array('Text Field' => 'Text Field', 'Dropdown Menu' => 'Dropdown Menu', 'Text Area' => 'Text Area'); 
$depChoice = array('yes' => 'yes', 'no' => 'no'); 
$ipType = array('IPv4' => 'IPv4', 'IPv6' => 'IPv6');
?> 
<?php echo $this->Form->create('Variable'); ?>

<table>
    <tr><td><label>Name: </label></td><td><?php echo $this->Form->input('name', array('label' => '')); ?></td></tr>
    <tr><td><label>TAF Property: </label></td><td><?php echo $this->Form->input('tafproperty', array
    ('label' => '')); ?></td></tr>
    <tr><td><label>Human Readable Name: </label></td><td><?php echo $this->Form->textarea('label', array('label' => '', 'rows' => '3', 'style' => 'width: 150px;')); ?></td></tr>
    <tr><td><label>Field Type: </label></td><td><?php echo $this->Form->select('type', $type, array('label' => '')); ?></td></tr>
    <tr><td><label>Dropdown Options: </label></td><td><label>Names: </label><?php echo $this->Form->input('dropName', array('label' => '')); ?><label>Values: </label><?php echo $this->Form->input('dropValue', array('label' => '')); ?></td></tr>
    <tr><td><label>Variable Section: </label></td><td><?php echo $this->Form->input('section', array('label' => '')); ?></td></tr>
    <tr><td><label>Variable Dependencies: </label></td><td><?php echo $this->Form->textarea('dependency', array('label' => '', 'style' => 'width: 150px; height: 50px;' )); ?></td></tr>
    <tr><td><label>OSS-RC version: </label></td><td><?php echo $this->Form->input('version', array('label' => '')); ?></td></tr>
    <tr><td><label>Numeric: </label></td><td><?php echo $this->Form->select('numeric', $depChoice, array('label' => '')); ?></td></tr>
    <tr><td><label>IP Address Field: </label></td><td><?php echo $this->Form->select('ipAddress', $depChoice, array('label' => '')); ?></td></tr>
    <tr><td><label>IP Type: </label></td><td><?php echo $this->Form->select('IPType', $ipType, array('label' => '')); ?></td></tr>
    <tr><td><label>Required: </label></td><td><?php echo $this->Form->select('required', $depChoice, array('label' => '')); ?></td></tr>
    <tr><td><label>File type: </label></td><td><?php echo $this->Form->input('fileType', array('label' => '')); ?></td></tr>
    <tr><td><?php echo $this->Form->end('Save Variable'); ?></td></tr>
</table>
