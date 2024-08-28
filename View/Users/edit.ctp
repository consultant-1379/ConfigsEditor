<h1>Edit User</h1>
<?php
echo $this->Form->create('User', array('action' => 'edit'));
echo $this->Form->input('first_name');
echo $this->Form->input('surname');
echo $this->Form->input('signum');
echo $this->Form->input('email_address', array('type' => 'email'));
echo $this->Form->input('local_password', array('type' => 'password'));
echo $this->Form->end('Edit User');
?>
