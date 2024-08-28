<?php echo $this->Form->create('Group');?>
<table>
    <tr>
        <td style="width:150px">           
            <label id="label">Group Name:</label>
        </td>
        <td>
           <?php echo $this->Form->input('group_name',array('class' => 'txtfield','label' => false)); ?>     
            <p>Eg: IEAT-IM-EE_DEFT_LTE-RW</p>
        </td>
    </tr>
    <tr>
        <td style="width:150px">            
            <label id="label">Group DN:</label>
        </td>
        <td>
           <?php echo $this->Form->input('group_dn',array('class' => 'txtfield','label' => false)); ?>   
           <p>Eg: CN=IEAT-IM-EE_DEFT_LTE-RW,OU=INACC,OU=Applications,DC=eemea,DC=ericsson,DC=se</p>
        </td>
    </tr>
    <tr>
        <td style="width:150px">            
            <label id="label">Group Members:</label>
        </td>
        <td>
           <?php echo $this->Form->input('group_members',array('class' => 'txtfield','style' => 'height: 80px;','label' => false)); ?>   
           <p>Eg: ekarran(in new line)<br>Note:This will be overwritten by running Sync Groups</p>
        </td>
    </tr>
    <tr>
        <td style="width:150px">            
            <label id="label">Config Directory:</label>            
        </td>
        <td>
           <?php echo $this->Form->input('directory',array('class' => 'txtfield','label' => false)); ?>    
            <p>Eg: EE_DEFT_LTE<br>Note: the directory should be existing in the server</p>            
        </td>
    </tr>
    <tr>
        <td style="width:150px">            
            <label id="label">Config Write Permission:</label>
        </td>
        <td>
           <?php echo $this->Form->input('permission',array('class' => 'txtfield','label' => false)); ?> 
            <p>Eg: Check for RW permission</p>
        </td>
    </tr>
    <tr>
        <td style="width:150px">            
            <label id="label">Media Directory:</label>            
        </td>
        <td>
           <?php echo $this->Form->input('mdir',array('class' => 'txtfield','label' => false)); ?>    
            <p>Eg: atjumpx1<br>Note: the directory should be existing in the server</p>            
        </td>
    </tr>
    <tr>
        <td style="width:150px">            
            <label id="label">Media Write Permission:</label>
        </td>
        <td>
           <?php echo $this->Form->input('mpermission',array('class' => 'txtfield','label' => false)); ?> 
            <p>Eg: Check for RW permission</p>
        </td>
    </tr>
</table>
<?php echo $this->Form->button('Submit', array('class' => 'submitButton')); ?>

<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('List Groups', array('action' => 'index'));?></li>
	</ul>
</div>
<style>
    p 
    {
        color:brown;
        font-family: arial,verdana,sans-serif,clean;
        font-size: 80%;
        margin-bottom: 5px;
    }
    
    form div
    {
         margin-bottom: 1px;
    }
    
    #label 
    {
        padding-left:10px;
        padding-right:10px;
        padding-top: 4px;
        padding-bottom:2px;
        margin-top: 15px;
        margin-bottom: 8px
    }
    .txtfield 
    {
        min-width: 300px;        
        padding-left:10px;
        padding-right:10px;
        padding-top: 2px;
        padding-bottom:2px;
        margin-top: 3px;
        margin-bottom: 1px;   
        font-family: arial,verdana,sans-serif,clean;
        font-size: 110%;                        
        height: 20px;
        color : black;
    }
    
</style>
<script>
    $(document).ready(function()
    {
        $('.submitButton').button();
    });
</script>