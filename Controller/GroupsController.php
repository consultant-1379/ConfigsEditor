<?php

class GroupsController extends AppController {

    public $name = 'Groups';

    public function beforeFilter() {
        //parent::beforeFilter();
        $this->Auth->allow("sync"); 
        if($this->Auth->loggedIn())
        {
            $this->set('logged_in', true);
            $this->set('current_user', $this->Auth->user());
        }
        else
        {
            $this->set('logged_in', false);            
        }
        $this->set('page_for_layout', 'Groups');
    }

    public function isAuthorized($user) {
        if ($user['is_admin']) {
            return true;
        }
        return false;
    }

    public function index() {
        $this->set('page_for_layout', 'Groups');
        $this->Group->recursive = 0;
        $this->set('groups', $this->Group->find('all'));
    }

    public function sync() {
        $this->set('page_for_layout', 'SyncGroups');
        $groups = $this->Group->find('all');

        foreach ($groups as $group) {
//            echo $group['Group']['group_dn'];
//            echo "</br>";
            $members = ClassRegistry::init('LdapUser')->get_members($group['Group']['group_dn']);
            $member_string = "";
            foreach ($members as $member) {
                $member_string = $member_string . $member['distinguishedname'] . "\n";                
            }            
            $group['Group']['group_members'] = $member_string;
            $this->Group->save($group);
        }
        $this->Session->setFlash('The group members have been synced','flash_good');
        $this->redirect(array('action' => 'index'));
    }

    public function view($id = null) {
        $this->set('page_for_layout', 'ViewGroups');
        $this->Group->id = $id;

        if (!$this->Group->exists()) {
            throw new NotFoundException('Invalid group');
        }

        if (!$id) {
            $this->Session->setFlash('Invalid group', 'flash_bad');
            $this->redirect(array('action' => 'index'));
        }
        $this->set('group', $this->Group->read());
    }

    public function add() {
        $this->set('page_for_layout', 'AddGroups');
        if ($this->request->is('post')) {
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash('The group '.$this->request->data['Group']['group_name'] .' has been saved', 'flash_good');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The group could not be saved. Please, try again.', 'flash_bad');
            }
        }
    }

    public function edit($id = null) {
        $this->set('page_for_layout', 'EditGroups');
        $this->Group->id = $id;

        if (!$this->Group->exists()) {
            throw new NotFoundException('Invalid group');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash('The group '.$this->request->data['Group']['group_name'] .' has been saved', 'flash_good');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The group could not be saved. Please, try again.', 'flash_bad');
            }
        } else {
            $this->request->data = $this->Group->read();
        }
    }

    public function delete($id = null) {
        $this->set('page_for_layout', 'DeleteGroups');
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if (!$id) {
            $this->Session->setFlash('Invalid id for group', 'flash_bad');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Group->delete($id)) {
            $this->Session->setFlash('Group deleted', 'flash_good');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Group was not deleted', 'flash_bad');
        $this->redirect(array('action' => 'index'));
    }

}
?>

