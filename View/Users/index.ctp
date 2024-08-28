
<table>
    <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Enabled</th>
        <th>Actions</th>
    </tr>
    
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['User']['username']; ?></td>
            <td>
                <?php echo $this->Html->link($user['User']['first_name']." ".$user['User']['surname'], array('controller' => 'users', 'action' => 'edit', $user['User']['id']));
                ?>
            </td>
            
            <td><?php echo $user['User']['email_address']; ?></td>
            <td><?php 
                    
            if($user['User']['is_enabled'] == 1){
                echo "Yes";                
                
            }else{
                echo "No";
            }
            ?>
            </td>

            <td>
                <?php 
                
                echo $this->Form->postLink('Delete', array('controller' => 'users', 'action' => 'delete', $user['User']['id']), array('confirm' => 'Are you sure?'));
                
                ?>
                
            
                
            </td>
        </tr>
    <?php endforeach; ?>
     
                    
        
</table>

<?php echo $this->Html->link('Add', array('controller' => 'users', 'action' => 'add'));?>