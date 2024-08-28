	<h1>Groups</h1>
	<table id="groups_table" class="datatable">
	<thead>
	<tr>			
			<th>Group Name</th>
			<th>Group DN</th>
			<th>Group Members</th>
			<th>Config Directory</th>
			<th>Config Permission</th>			
                        <th>Media Directory</th>
                        <th>Media Permission</th>
			<th class="actions">Actions</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($groups as $group):
	?>
	<tr>		
		<td><?php echo $group['Group']['group_name']; ?></td>
		<td><?php 
                    $groupCN=ldap_explode_dn($group['Group']['group_dn'] , 1);
                    echo $groupCN[0]; ?></td>		
		<td><?php echo $group['Group']['group_members']; ?></td>		
		<td><?php echo $group['Group']['directory']; ?></td>
		<td><?php 
                    if($group['Group']['permission'] ==1)    
                    echo 'RW';
                    else echo 'RO'?>
                </td>		
                <td><?php echo $group['Group']['mdir']; ?></td>
		<td><?php 
                    if($group['Group']['mpermission'] ==1)    
                    echo 'RW';
                    else echo 'RO'?>
                </td>
		<td>
			<?php echo $this->Html->link('View', array('action' => 'view', $group['Group']['id'])); ?>
			    <?php echo $this->Html->link('Edit', array('action' => 'edit', $group['Group']['id'])); ?>
			    <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $group['Group']['id']), array('confirm'=>'Are you sure you want to delete that group?')); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
<div class="actions">
	<h3>Actions</h3>
	<ul>
		<li><?php echo $this->Html->link('New Group', array('action' => 'add')); ?></li>
		 <li><?php echo $this->Html->link('Sync Groups', array('action' => 'sync')); ?></li>
	</ul>
</div>

