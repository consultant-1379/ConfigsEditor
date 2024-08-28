<style type="text/css">

    .clearfix:after {
        content: ".";
        display: block;
        height: 0;
        clear: both;
        visibility: hidden;
    }

    .clearfix {display: inline-block;}  /* for IE/Mac */

</style><!-- main stylesheet ends, CC with new stylesheet below... -->

<!--[if IE]>
<style type="text/css">
  .clearfix {
    zoom: 1;     /* triggers hasLayout */
    display: block;     /* resets display for IE/Win */
    }  /* Only IE can see inside the conditional comment
    and read this CSS rule. Don't ever use a normal HTML
    comment inside the CC or it will close prematurely. */
</style>
<![endif]-->
<script type="text/javascript">var directory = <?php echo json_encode($current_user['permissions']); ?>;</script>
<?php
echo $this->Html->css('jqueryFileTree/jqueryFileTree', null, array('inline' => false));
echo $this->Html->script('jqueryFileTree');
echo $this->Html->script('Viewer/viewer');
echo $this->Html->css('viewer', null, array('inline' => false));
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$timeArray = array('3600' => '1 Hour', '7200' => '2 hours', '10800' => '3 hours', '14400' => '4 hours', '28800' => '8 hours', '43200' => '12 hours'
    , '86400' => '24 hours', '172800' => '48 hours', '604800' => '1 week', '2419200' => '4 weeks', '0' => 'All');
?>

<div id="tree_container" style="min-width:850px;">
    <h2>Select a running or completed log directory</h2>

    <table>
        <tr style="width:100%">
            <td>
                <div class="tree_holder">
                    <table><tr><td><h3>Running</h3></td></tr></table>
                    <div id="running_log_file_tree" >

                    </div>
                </div>
            </td> 
            <td>
                <div class="tree_holder">
                    <table>
                        <tr>
                            <td><h3>Recently Completed</h3></td>
                            <td><label>Logs from: </label></td>
                            <td><?php echo $this->Form->select('dateSelector', $timeArray, array('empty' => false, 'id' => 'dateSelector', 'label' => '',)); ?></td>
                        </tr>
                    </table>
                    <div id="completed_log_file_tree" >

                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div style="float:left;min-width:100px;" id="selected_dir_info">

    </div>
    <div id="selected_dir" style="display:none;"></div>
    <div class="tree_holder">
        <div id="sub_tree">
        </div>
    </div>

    <br>
    <div style="float:left;min-width:600px;" id="selected_file_info"></div>
    <div id="selected_file" style="display:none;"></div>
    <div id="buttonDiv" style="margin-top: 10px;float:left;min-width:600px;" >
        <button class="clearfix" id="stop_button">Stop</button>
        <button class="clearfix" id="download_button">Download</button>
    </div>

    <div id="log_contents" style="overflow:scroll;padding:10px;width:850px;height:500px;" class="body_foreground body_background" >
    </div>
</div>
