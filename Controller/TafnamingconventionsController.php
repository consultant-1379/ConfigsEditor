<?php

App::uses('AppController', 'Controller');

/**
 * Tafnamingconventions Controller
 *
 * @property Tafnamingconvention $Tafnamingconvention
 */
class TafnamingconventionsController extends AppController {

    public function beforeFilter() {
        $this->Auth->allow('tafnamingconventions', 'readfile', 'readfile_json');
    }

    public function readfile_internal() {

        //get the url
        $urlpath = $this->here;
        //splits the url by :
        $explodeurl = explode(":", $urlpath);
        $myarray = array();
        //loops through each file
        foreach ($explodeurl as $file) {
            if ($file != "/Tafnamingconventions/readfile/file" && $file != "/Tafnamingconventions/readfile_json/file") {
		$file = str_replace('/.json','',$file);
		if ($file == "OUTSIDE_GATEWAY")
                {
                        $myarray['OUTSIDE_GATEWAY'] = true;
                        continue;
                }
                $document = file_get_contents($file);
                
                $lines = explode("\n", $document);
                //loops through file and adds all vars to $myarray
                foreach ($lines as $line) {
                    $exploded_line = explode("=", $line, 2);
                    if (isset($exploded_line[0]) && isset($exploded_line[1])) {
			$right = $exploded_line[1];
			$trimmedright = trim($right, '"');
			$trimmedright = trim($trimmedright, "'");
			$myarray[$exploded_line[0]] = $trimmedright;
                    }
                }
            }
        }
	return $myarray;
    }
    public function readfile() {
	$myarray = $this->readfile_internal();
	$outputarray = array();

	//loop through each element in myarray and check them against the varailble in the db
        $this->loadModel("Variable");
        $dbarray = $this->Variable->find('all', array('fields' => array('name', 'tafproperty')));

	 //loops through my array that contains key values pairs of ossrc variables and values
        foreach ($myarray as $left => $right) {
            //assigns the taf property comparison variable with its ossrc variable
            foreach ($dbarray as $dbentry) {
                $cite = $dbentry['Variable']['name'];
                $taf = $dbentry['Variable']['tafproperty'];
                if ($left == $cite && $taf != NULL) {
                    $trimmedright = trim($right, '"');
                    $trimmedright = trim($trimmedright, "'");
                    //$output = $taf . "=" . $trimmedright;
                    $output_array[$taf] = $trimmedright;
                }
            }
        }

	//add everything to output array and call wit in the view file
	$this->set('output_array', $output_array);
    }

    public function readfile_json () {
	$this->autoRender = false;

	// Read in the file, into a name value pair array
	$myarray = $this->readfile_internal();

	// Setup the object we will later output as json
	$obj = array();

	// Define an array containing some meta data specific to ossrc, that we use later to populate our $obj variable (which gets turned to json)
	$config_file_mappings = array (
		array (
			'key' => 'GATEWAY',
			'type' => 'gateway',
			'needs_root_user' => true
		),
		array (
			'key' => "ADM1",
			'type' => 'rc',
			'needs_root_user' => true,
			'forwarded_port' => 2205,
			'users' => array (
	                        array (
	                                'username' => 'nmsadm',
	                                'passmapping' => 'ADM1_NMSADM_PASS',
	                                'type' => 'oper'
	                        ),
                            array (
                                    'username' => 'suser1',
                                    'passmapping' => 'SUSER1_PASS',
                                    'type' => 'sys_adm'
                            )
	                )
		),
		array (
                        'key' => "NSS",
                        'type' => 'http',
                        'needs_root_user' => true,
                        'forwarded_port' => 2205,
                        'extra_ports' => array (
                            'internal' => array (
                                'http' => '50503'
                            ),
                            'external' => array (
                                'http' => '50503'
                            )
                        ),
                        'users' => array (
                                array (
                                        'username' => 'nmsadm',
                                        'passmapping' => 'ADM1_NMSADM_PASS',
                                        'type' => 'oper'
                                ),
                                array (
                                        'username' => 'suser1',
                                        'passmapping' => 'SUSER1_PASS',
                                        'type' => 'sys_adm'
                                )
                        )
                ),
		array (
			'key' => "NETSIM",
			'type' => 'netsim',
			'needs_root_user' => true,
			'forwarded_port' => 2202,
			'users' => array (
	                        array (
	                                'username' => 'netsim',
	                                'passmapping' => 'NETSIM_USER_PASS',
	                                'type' => 'custom'
	                        )
	                )
		),
		array (
			'key' => "UAS1",
			'type' => 'uas',
			'needs_root_user' => true,
			'forwarded_port' => 2206,
                'users' => array (
                        array (
                                'username' => 'nmsadm',
                                'passmapping' => 'ADM1_NMSADM_PASS',
                                'type' => 'oper'
                        ),
                        array (
                                    'username' => 'suser1',
                                    'passmapping' => 'SUSER1_PASS',
                                    'type' => 'sys_adm'
                        )
                )
		),
		array (
			'key' => "OMSAS",
			'type' => 'omsas',
			'needs_root_user' => true,
			'forwarded_port' => 2203,
			'users' => array (
	                        array (
	                                'usernamemapping' => 'CAASADM_USER',
	                                'passmapping' => 'CAASADM_PASS',
	                                'type' => 'custom'
	                        ),
				array (
	                                'username' => 'neuser',
	                                'passmapping' => 'NEUSER_PASS',
	                                'type' => 'custom'
	                        ),
				array (
	                                'username' => 'scsuser',
	                                'passmapping' => 'SCSUSER_PASS',
	                                'type' => 'custom'
	                        )
	                )
		),
		array (
			'key' => "OMSERVM",
			'type' => 'omsrvm',
			'needs_root_user' => true,
			'forwarded_port' => 2204
		),
		array (
			'key' => "OMSERVS",
			'type' => 'omsrvs',
			'needs_root_user' => true,
			'forwarded_port' => 2207
		),
		array (
			'key' => "NEDSS",
			'type' => 'nedss',
			'needs_root_user' => true,
			'forwarded_port' => 2208
		),
		array (
			'key' => "EBAS",
			'type' => 'ebas',
			'needs_root_user' => true,
			'forwarded_port' => 2209,
			'users' => array (
	                        array (
	                                'username' => 'nmsadm',
	                                'passmapping' => 'ADM1_NMSADM_PASS',
	                                'type' => 'oper'
	                        )
	                )
		),
		array (
			'key' => "SFS",
			'type' => 'sfs',
			'users' => array (
				array (
					'username' => 'master',
					'passmapping' => 'NASMASPWW',
					'type' => 'custom'
				),
				array (
					'username' => 'support',
					'passmapping' => 'NASSUPPWW',
					'type' => 'custom'
				)
			)
		),
		array (
			'key' => "TDLIN",
			'type' => 'unknown',
			'needs_root_user' => false
		),
		array (
			'key' => "PEER1",
			'type' => 'peer',
			'needs_root_user' => true,
			'forwarded_port' => 2247,
			'users' => array (
	                        array (
	                                'username' => 'nmsadm',
	                                'passmapping' => 'ADM1_NMSADM_PASS',
	                                'type' => 'oper'
	                        )
	                )
		)
	);

	// Special case to map GATEWAY IP ADDR to internal IP
	if (isset($myarray['BEHIND_GATEWAY']) && $myarray['BEHIND_GATEWAY'] == "yes")
	{
		if (isset($myarray['OUTSIDE_GATEWAY']) && $myarray['OUTSIDE_GATEWAY'] == "yes")
		{
			$port_forwarding=true;
		}
		else
		{
			$port_forwarding=false;
		}
		$myarray['GATEWAY_HOSTNAME']='gateway';
		$myarray['GATEWAY_IP_ADDR']='192.168.0.1';

		$myarray['TDLIN_HOSTNAME']='tdlin';
		$myarray['TDLIN_IP_ADDR']='192.168.0.86';
	}

	// Special case to map SFS IP ADDR to NASC
	if (isset($myarray['NASC']))
        {
                $myarray['SFS_IP_ADDR']=$myarray['NASC'];
        }

	foreach ($config_file_mappings as $host)
	{
		if (isset($myarray[$host['key'] . "_HOSTNAME"]) && $myarray[$host['key'] . "_HOSTNAME"] != "")
		{
			// Hostname
			$hostname = $myarray[$host['key']. "_HOSTNAME"];

			// IP Address
			$ip = "not set";
			if (isset($myarray[$host['key'] . "_IP_ADDR"]))
			{
				$ip=$myarray[$host['key'] . "_IP_ADDR"];
			}

			// Type
			$type = $host['type'];

			// Users
			$users = array ();

			// Handle root user / pass
			// If the user needs a root user and doesn't have the pass specified, set it to default of shroot
			if (!isset($myarray[$host['key'] . "_ROOT_PASS"]) && isset($host['needs_root_user']) && $host['needs_root_user'])
			{
				$myarray[$host['key'] . "_ROOT_PASS"]="shroot";
			}
			if (isset($myarray[$host['key'] . "_ROOT_PASS"]))
			{
				array_push($users, array (
					'username' => 'root',
					'password' => $myarray[$host['key'] . "_ROOT_PASS"],
					'type' => 'admin'
				));
			}

			// Handle defined users in array above
			if (isset($host['users']))
			{
				foreach ($host['users'] as $user)
				{
					if (isset($user['usernamemapping']))
					{
						$username=$myarray[$user['usernamemapping']];
					}
					else
					{
						$username=$user['username'];
					}
                    if (isset($myarray[$user['passmapping']]))
                    {
                        $password = $myarray[$user['passmapping']];
                    } else {
                        $password = 'notsetinconfigfile';
                    }
					array_push($users, array (
						'username' => $username,
						'password' => $password,
						'type' =>  $user['type']
					));
				}
			}

			// Ports
			$ports = array();
			if ($port_forwarding && isset($host['forwarded_port']))
			{
				$ports['ssh'] = $host['forwarded_port'];
			}
			else
			{
				$ports['ssh'] = 22;
			}
            if (isset($host['extra_ports']))
            {
                if ($port_forwarding)
                {
                    $port_type = 'external';
                } else {
                    $port_type = 'internal';
                }
                foreach($host['extra_ports'][$port_type] as $key => $value)
                {
                    $ports[$key] = $value;
                }
            }

			array_push($obj, array (
				'hostname' => $hostname,
				'ip' => $ip,
				'type' => $type,
				'users' => $users,
				'ports' => $ports
			));
		}
	}
	echo (json_encode($obj));
    }
}
