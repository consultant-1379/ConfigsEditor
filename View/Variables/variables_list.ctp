
<table>
    <tr>
        <td><h1 style="margin-left: 0%;">Database Variables</h1></td>
    </tr>
    <tr>
        <td><?php echo $this->Html->link('Add Variable', array('action' => 'add')); ?></td>
    </tr>
</table>

<table style="table-layout: fixed;">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Taf Property</th>
        <th>Label</th>
        <th style="word-wrap:break-word;" >Tool Tip</th>
        <th>Field Type</th>
        <th>Name For Value</th>
        <th>Value For Name</th>
        <th>Variable Section</th>
        <th style="word-wrap:break-word;">Variable Dependencies</th>
        <th>OSS-RC Version</th>
        <th style="word-wrap:break-word;" >Numeric</th>
        <th>IP Adress Field</th>
        <th>IP Type</th>
        <th style="word-wrap:break-word;">Required</th>
        <th>File Type</th>
        <th></th>
    </tr>
    <?php foreach ($variables as $var): ?>
    <tr>
        <td><?php echo $var['Variable']['id']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['name']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['tafproperty']; ?></td>	
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['label']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['toolTip']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['type']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['dropName']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['dropValue']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['section']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['dependency']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['version']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['numeric']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['ipAddress']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['IPType']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['required']; ?></td>
        <td style="word-wrap:break-word;"><?php echo $var['Variable']['fileType']; ?></td>
        <td>
            <?php echo $this->Html->link('View', array('action' => 'view', $var['Variable']['id'])); ?>
            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $var['Variable']['id']), array('confirm' => 'Are you sure?')); ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $var['Variable']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
