<?php

class Variable extends AppModel
{ 
    var $name = 'Variable';
    //var $useTable = false;
    
    var $validate = array (
        
        'DHCP_SERVER_IP' => array(
            'rule' => 'notEmpty',
            'message' => 'This field cannot be left blank')
        
        );
}

?>
