<?php     
    $this->layout='login';
    echo $this->Form->create();
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Session->flash(); 
    //echo $this->Form->button('Login', array('class' => 'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-button-text'));
    echo $this->Form->button('Login', array('class' => 'logButton'));
?>

<script>
    $(document).ready(function()
    {
        $('.logButton').button();
    });
</script>
