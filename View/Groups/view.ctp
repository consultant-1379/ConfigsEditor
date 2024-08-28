<div class="groups view">
<h2>Group</h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Id</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Name</dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                        <?php echo $group['Group']['group_name']; ?>
                        &nbsp;
                </dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Group DN</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['group_dn']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Group Members</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['group_members']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Config directory</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['directory']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Config permission</dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>>                        
                    <?php 
                        if($group['Group']['permission'] ==1)    
                        echo 'RW';
                        else echo 'RO'?>
                        &nbsp;
                </dd>	
                <dt<?php if ($i % 2 == 0) echo $class;?>>Media directory</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['mdir']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Media permission</dt>
                <dd<?php if ($i++ % 2 == 0) echo $class;?>>                        
                    <?php 
                        if($group['Group']['mpermission'] ==1)    
                        echo 'RW';
                        else echo 'RO'?>                    
                        &nbsp;
                </dd>
	</dl>
</div>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		    <li><?php echo $this->Html->link('Edit Group', array('action' => 'edit', $group['Group']['id'])); ?> </li>
		    <li><?php echo $this->Form->postLink('Delete Group', array('action' => 'delete', $group['Group']['id']), array('confirm'=>'Are you sure you want to delete that group?')); ?> </li>
		<li><?php echo $this->Html->link('List Groups', array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link('New Group', array('action' => 'add')); ?> </li>
	</ul>
</div>

