<?php

class LdapUser extends AppModel {

    var $name = 'LdapUser';
    var $useTable = false;
    var $host = 'ldap-egad.internal.ericsson.com';
    var $port = 3268;
    var $baseDn = 'dc=ericsson,dc=se';
    var $user = 'ATVEGAD@ericsson.se';
    var $pass = 'GuWa3EpuBRUqAjAg';
    var $ds;

    function __construct() {
        parent::__construct();
        //if (!$this->ds = ldap_connect($this->host, $this->port))
        if (!$this->ds = ldap_connect($this->host, $this->port)) {
            die("Could not connect to LDAP server");
        }
        
        ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ds, LDAP_OPT_REFERRALS, 0);
        ldap_bind($this->ds, $this->user, $this->pass);
    }

    function __destruct() {
        ldap_close($this->ds);
    }

    function _findUser($uid, $password) {
        //echo "searching for . " . $uid;
        $result = $this->findAll('sAMAccountName', $uid, $this->baseDn);
        if (isset($result[0])) {

            if (!empty($password) && @ldap_bind($this->ds, $result[0]['dn'], $password)) {
                $permissions = '';
                //$this->getDN($this->ds, "IEAT-VM-PoC-Admin", $this->baseDn)
                //$search_group_dn="CN=IEAT-VM-PoC-Admin,OU=INACC,OU=Applications,DC=eemea,DC=ericsson,DC=se";
                //use the below logic if there is perfromance impact   
//                 $groups = ClassRegistry::init('Group')->find('all');
//                 foreach ($groups as $group) {
//                     if (strstr($group['Group']['group_members'], $result[0]['dn'])) {
//                         //CakeLog::write('debug', 'PermissionTest '.$group['Group']['permission']);
//                         if (!(isset($permissions[$group['Group']['directory']])))
//                         {
//                            $permissions[$group['Group']['directory']] = $group['Group']['permission'];
//                         }
//                         else if ($permissions[$group['Group']['directory']] != 1)
//                         {
//                             $permissions[$group['Group']['directory']] = $group['Group']['permission'];
//                         }
//                     }
//                }                
//                if($permissions == '')
//                    return false;
//                else
//                {
                    $object = array(
                        'login_type' => 'ldap',
                        'username' => $result[0]['cn'][0],
                        'firstname' => $result[0]['givenname'][0],
                        'email' => $result[0]['mail'][0],
                        'is_admin' => false
                        //'permissions' => $permissions
                    );
                    return $object;
//                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function findAll($attribute = 'uid', $value = '*', $baseDn = 'ou=People,dc=example,dc=com') {
        //$r = ldap_search($this->ds, $baseDn, $attribute . "=" . $value);
        $r = ldap_search($this->ds, $baseDn, "(" . $attribute . '=' . $value . ")");

        if ($r) {
            return ldap_get_entries($this->ds, $r);
        }
    }

    function checkGroupEx($ad, $userdn, $groupdn) {
        $attributes = array('memberof');
        $result = ldap_read($ad, $userdn, '(objectclass=*)', $attributes);
        if ($result === FALSE) {
            return FALSE;
        };
        $entries = ldap_get_entries($ad, $result);
        if ($entries['count'] <= 0) {
            return FALSE;
        };
        if (empty($entries[0]['memberof'])) {
            return FALSE;
        } else {
            for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
                if ($entries[0]['memberof'][$i] == $groupdn) {
                    return TRUE;
                } elseif ($this->checkGroupEx($ad, $entries[0]['memberof'][$i], $groupdn)) {
                    return TRUE;
                };
            };
        };
        return FALSE;
    }

    function get_members($group = FALSE, $inclusive = FALSE) {

        $keep = array(
            "distinguishedname"
        );
        // Begin building query
        if ($group)
            $query = "(&"; else
            $query = "";

        $query .= "(&(objectClass=user)(objectCategory=person))";

        // Filter by memberOf, if group is set
        if (is_array($group)) {
            // Looking for a members amongst multiple groups
            if ($inclusive) {
                // Inclusive - get users that are in any of the groups
                // Add OR operator
                $query .= "(|";
            } else {
                // Exclusive - only get users that are in all of the groups
                // Add AND operator
                $query .= "(&";
            }

            // Append each group
            foreach ($group as $g)
                $query .= "(memberof=$g,$this->baseDn)";

            $query .= ")";
        } elseif ($group) {
            // Just looking for membership of one group
            $query .= "(memberof=$group)";
        }

        // Close query
        if ($group)
            $query .= ")"; else
            $query .= "";

        // Uncomment to output queries onto page for debugging
        // Search AD
        $results = ldap_search($this->ds, $this->baseDn, $query);
        $entries = ldap_get_entries($this->ds, $results);

        // Remove first entry (it's always blank)
        array_shift($entries);

        $output = array(); // Declare the output array

        $i = 0; // Counter
        // Build output array
        foreach ($entries as $u) {
            foreach ($keep as $x) {
                // Check for attribute
                if (isset($u[$x][0]))
                    $attrval = $u[$x][0]; else
                    $attrval = NULL;

                // Append attribute to output array
                $userCN=ldap_explode_dn($attrval , 1);
                //$output[$i][$x] = $attrval;
                $output[$i][$x] = $userCN[0];
                //CakeLog::write('debug', 'LDAP $attrval '.$attrval.'$userCN[0] '.$userCN[0]);
            }
            $i++;
        }

        return $output;
    }

    function checkGroup($ad, $userdn, $groupdn) {
        $attributes = array('members');
        $result = ldap_read($ad, $userdn, "(&(objectCategory=user)(memberof={$groupdn}))", $attributes);
        if ($result === FALSE) {
            return FALSE;
        };
        $entries = ldap_get_entries($ad, $result);
        return ($entries['count'] > 0);
    }

    function getDN($ad, $samaccountname, $basedn) {
        $attributes = array('dn');
        $result = ldap_search($ad, $basedn, "(samaccountname={$samaccountname})", $attributes);
        if ($result === FALSE) {
            return '';
        }
        $entries = ldap_get_entries($ad, $result);
        if ($entries['count'] > 0) {
            return $entries[0]['dn'];
        } else {
            return '';
        };
    }

}

?>
