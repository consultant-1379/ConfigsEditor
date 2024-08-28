<h1><?php echo h($variable['Variable']['name']); ?></h1>

<table>
    <tr><td>Id: <?php echo $variable['Variable']['id']; ?></td></tr>
    <tr><td>Label: <?php echo $variable['Variable']['label']; ?></td></tr>
    <tr><td>Field type: <?php echo $variable['Variable']['type']; ?></td></tr>
    <tr><td>Dropdown options:<?php echo $variable['Variable']['dropName']; ?></td></tr>
    <tr><td>Variable section: <?php echo $variable['Variable']['section']; ?></td></tr>
    <tr><td>Variable Dependencies: <?php echo $variable['Variable']['dependency']; ?></td></tr>
    <tr><td>OSS-RC Version: <?php echo $variable['Variable']['version']; ?></td></tr>
    <tr><td>Numeric: <?php echo $variable['Variable']['numeric']; ?></td></tr>
    <tr><td>IP Address Field: <?php echo $variable['Variable']['ipAddress']; ?></td></tr>
    <tr><td>IP Type: <?php echo $variable['Variable']['IPType']; ?></td></tr>
    <tr><td>Required: <?php echo $variable['Variable']['required']; ?></td></tr>
    <tr><td>Variable File Type: <?php echo $variable['Variable']['fileType']; ?></td></tr>
</table>
