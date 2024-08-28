<h1>Add User</h1>
<?php
echo $this->Form->create('User');
echo $this->Form->input('first_name');
echo $this->Form->input('surname');
echo $this->Form->input('email_address');
echo $this->Form->input('username');
echo $this->Form->input('password', array('type' => 'password' ));
echo $this->Form->input('password_confirmation', array('type' => 'password' ));
echo $this->Form->end('Add User');
?>