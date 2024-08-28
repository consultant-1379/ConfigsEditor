<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array(
			'Session',
                        'RequestHandler',
			'Auth' => array(
					'loginRedirect' => array('controller' => 'Variables', 'action' => 'index'),
					'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
					'authError' => "You don't have permission to access that page, please contact your team co-ordinator to give you access if required.",
					'authorize' => array('Controller'),
                                        'authenticate' => array(
                                           'Form',
                                           'Ldap' => array('userModel' => 'Ldap')
                                       )
                            )
	);
	
	public function isAuthorized($user) {
// 		if ($user['is_admin']) {
// 			return true;
// 		}
// 		return false;                              
                return true;
	}
	
	public function beforeFilter() {
		//$this->Auth->allow('index', 'view');
                //CakeLog::write('debug', 'Request Made ' + $this->Auth->loggedIn());                
                $user=$this->Auth->user();
                /*
                 * For every request,user details are refreshed from the database
                 * If there is performance impact,move the below logic to the Models[User and LdapUser]
                 */
                $groups = ClassRegistry::init('Group')->find('all');
                $permissions = '';
                $mpermissions = '';
                if ($user['is_admin']) {                                                           
                    foreach ($groups as $group) {                
                         $permissions[$group['Group']['directory']] = true;                    
                         $mpermissions[$group['Group']['mdir']] = true;
                    }                                            
                }
                else
                {                    
                    foreach ($groups as $group) {
                     if (strstr($group['Group']['group_members'], $user['username'])) {
                         //CakeLog::write('debug', 'PermissionTest '.$group['Group']['permission']);
                         if (!(isset($permissions[$group['Group']['directory']])))
                         {
                            $permissions[$group['Group']['directory']] = $group['Group']['permission'];
                         }
                         else if ($permissions[$group['Group']['directory']] != 1)
                         {
                             $permissions[$group['Group']['directory']] = $group['Group']['permission'];
                         }
                         
                         if (!(isset($mpermissions[$group['Group']['mdir']])))
                         {
                            $mpermissions[$group['Group']['mdir']] = $group['Group']['mpermission'];
                         }
                         else if ($mpermissions[$group['Group']['mdir']] != 1)
                         {
                             $mpermissions[$group['Group']['mdir']] = $group['Group']['mpermission'];
                         }
                     }
                    }
                }
                if(!$this->Auth->loggedIn())
                {
                    //$this->Session->setFlash('Session Expired', 'flash_bad');
                    $this->redirect($this->Auth->logout());
                }
                else if($permissions == '')
                {
                    $this->Session->setFlash('You do not have access to any directories', 'flash_bad');                    
                   // $this->redirect(array('controller' => 'user', 'action' => 'login'));
                    $this->redirect($this->Auth->logout());
                }
                
                $user['permissions'] = $permissions;
                $user['mpermissions'] = $mpermissions;
                $this->Auth->login($user);//update the user in the session,won't invoke authnticate.                
		$this->set('logged_in', $this->Auth->loggedIn());
		$this->set('current_user', $this->Auth->user());
	}
}
