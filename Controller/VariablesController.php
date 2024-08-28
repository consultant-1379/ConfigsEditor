<?php

App::uses('File', 'Utility');

class VariablesController extends AppController
{
    public $helpers = array('Html', 'Form');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('page_for_layout', 'Variables');
    }
        
    public function index()
    {
        $this->set('page_for_layout', 'ConfigEditor');

        if (!empty($this->passedArgs["type"]))
        {
            $this->set('variables', $this->Variable->find('all', array('conditions' => array('fileType' => $this->passedArgs['type']))));
        } else
        {
            $this->set('variables', $this->Variable->find('all', array('conditions' => array('fileType' => ''))));
        }

        if ($this->request->is('post'))
        {
            if (!empty($this->request->data))
            {
                $query = $this->Variable->query("SELECT section FROM variables;");
                $blackList = array('Choose_File_Type', 'hiddenPath');
                
                foreach ($query as $q)
                {
                    if ($q['variables']['section'] != '')
                    {
                        if (!in_array($q['variables']['section'], $blackList))
                        {
                            $tempValue = str_replace(' ' , '_', $q['variables']['section']);
                            array_push($blackList, $tempValue);
                        }
                    }
                }

                $name = $this->request->data['Variable']['hiddenName'];
                $value = $this->request->data;
                
                $ext = pathinfo($name, PATHINFO_EXTENSION);

                if ($ext == "txt")
                {
                    $file = new File("files/configs/$name");
                    $file->delete();
                    $file = new File("files/configs/$name", true, 777);
                    $file->write("");

                    foreach ($value as $key => $v)
                    {
                        if ("$key" != "Variable" && "$v" != "")
                        {
                            if (in_array($key, $blackList))
                            {
                                
                            }
                            else
                            {
                                $file->append("$key='$v'\n", $force = false);
                            }
                        }
                    }
                } else
                {
                    $file = new File("files/configs/$name");
                    $file->delete();
                    $file = new File("files/configs/$name.txt", true, 777);
                    $file->write("");

                    foreach ($value as $key => $v)
                    {
                        if ("$key" != "Variable" && "$v" != "")
                        {
                            if (in_array($key, $blackList))
                            {
                                
                            }
                            else
                            {
                                $file->append("$key='$v'\n", $force = false);
                            }
                        }
                    }
                }
                $file->close();
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function add()
    {
        $this->set('page_for_layout', 'Add');
        $this->set('variables', $this->Variable->find('all'));

        if ($this->request->is('post'))
        {
            $arr = $this->request->data['Variable'];

            $nameResult = '';
            $valueResult = '';
            $blades = '';
            $virtuals = '';

            foreach ($arr as $key => $value)
            {
                if (substr($key, 0, 9) == "inputName")
                {
                    if ($value != "")
                    {
                        $nameResult = "$nameResult,$value";
                    }
                }
                if (substr($key, 0, 10) == "inputValue")
                {
                    if ($value != "")
                    {
                        $valueResult = "$valueResult,$value";
                    }
                } else if (substr($key, 0, 10) == "inputBlade")
                {
                    if ($value == "")
                    {
                        $blades = "nNoBlades";
                    } else
                    {
                        $blades = "$blades,$value";
                    }
                } else if (substr($key, 0, 12) == "inputVirtual")
                {
                    if ($value == "")
                    {
                        
                    } else
                    {
                        $virtuals = "$virtuals,$value";
                    }
                }
            }

            $comma = substr($virtuals, 1);
            $fin = "$blades $comma";

            $a = array();
            $a['dropName'] = substr($nameResult, 1);

            pr($valueResult);
            $a2 = array();
            $a2['dropValue'] = substr($valueResult, 1);

            $b = array();
            $b['dependency'] = substr($fin, 1);

            $sect = $this->request->data['Variable']['sectionInput'];
            $sect2 = $this->request->data['Variable']['section'];

            $fil = $this->request->data['Variable']['fileInput'];
            $fil2 = $this->request->data['Variable']['fileType'];

            $c = array();
            $c['section'] = $sect;

            $d = array();
            $d['fileType'] = $fil;

            if ($this->Variable->save($this->request->data))
            {
                $this->Variable->save($a);
                $this->Variable->save($a2);
                $this->Variable->save($b);
                if ($sect2 == "New Section")
                {
                    $this->Variable->save($c);
                }

                if ($fil2 == "New File Type")
                {
                    $this->Variable->save($d);
                }
                
                $this->redirect(array('action' => 'variablesList'));
            } else
            {
                $this->Session->setFlash('Unable to add your post. ');
            }
        }
        
    }

    public function variablesList()
    {
        $this->set('page_for_layout', 'VariablesList');
        $this->set('variables', $this->Variable->find('all'));
    }

    public function view($id = null)
    {
        $this->set('page_for_layout', 'View');
        $this->Variable->id = $id;
        $this->set('variable', $this->Variable->read());
    }

    public function delete($id = null)
    {
        $this->set('page_for_layout', 'Delete');
        if ($this->request->is('get'))
        {
            throw new MethodNotAllowedException();
        }

        if ($this->Variable->delete($id))
        {
            $this->redirect(array('action' => 'variablesList'));
        }
    }

    public function edit($id)
    {
        $this->set('page_for_layout', 'Edit');
        $this->Variable->id = $id;
        $this->set('variable', $this->Variable->read());

        if ($this->request->is('get'))
        {
            $this->request->data = $this->Variable->read();
        } else
        {
            if ($this->Variable->save($this->request->data))
            {
                $this->redirect(array('action' => 'variablesList'));
            } else
            {
                $this->Session->setFlash('Unable to update your post.');
            }
        }
    }

}
?>

