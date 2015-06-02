<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author Chanthoeun
 */
class Groups extends Admin_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('group_model', 'group');
        
        $this->lang->load('group');
    }
    
    public function _remap($method, $params = array())
    {   
        $get_method = str_replace('-', '_', $method);
        
        if (method_exists($this, $get_method))
        {
            return call_user_func_array(array($this, $get_method), $params);
        }
        show_404();
    }
    
    /**
     * List all groups
     */
    public function index(){
        parent::check_login();
        $this->data['groups'] = $this->get_all();
        
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        
        // process template
        $this->data['title'] = $this->lang->line('index_group_heading');
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/plugins/dataTables.bootstrap.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/plugins/dataTables/jquery.dataTables.js', 
                                        'js/plugins/dataTables/dataTables.bootstrap.js',
                                        'js/sb-admin-2.js'
                                        );
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable();});';
        
        $layout_property['breadcrumb'] = array($this->lang->line('index_group_heading'));
        
        $layout_property['content']  = 'index';
        
        // menu
        $this->data['account_menu'] = TRUE; $this->data['group_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
    }
    
    /**
     * Create New
     */
    public function create()
    {
        parent::check_login();
        // Validation error
        $validation_errors = $this->session->flashdata('validation_errors');

        //set the flash data error message if there is one
        $this->data['message'] = ($validation_errors['errors'] ? $validation_errors['errors'] : $this->session->flashdata('message'));
        
        // display form
        $this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'class' => 'form-control',
            'placeholder' => 'Enter Group Name',
            'value' => (isset($validation_errors['post_data']['name']) ? $validation_errors['post_data']['name'] : NULL)
        );
        
        $this->data['desc'] = array(
            'name' => 'desc',
            'id'   => 'desc',
            'class'=> 'form-control',
            'placeholder' => 'Enter group description',
            'value'=> (isset($validation_errors['post_data']['des']) ? $validation_errors['post_data']['des'] : NULL)
        );
        
        // process template
        $title = $this->lang->line('form_group_create_heading');
        $this->data['title'] = $title;
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/sb-admin-2.js'
                                        );
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable();});';
        
        $layout_property['breadcrumb'] = array('groups' => $this->lang->line('index_group_heading'), $title);
        
        $layout_property['content']  = 'create';
        
        // menu
        $this->data['account_menu'] = TRUE; $this->data['group_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
    }
    
    /**
     * Save to database
     */
    public function store()
    {
        parent::check_login();       
        // set data for update
        $data = array(
            'name' => trim($this->input->post('name')),
            'description' => trim($this->input->post('desc'))
        );
        
        // insert to group table 
        if(($gid = $this->insert($data)) != FALSE)
        {
            // set log
            array_unshift($data, $gid);
            set_log('Create Group', $data);

            // set success message and redire to group list
            $this->session->set_flashdata('message', $this->lang->line('form_group_report_success'));
            redirect('groups', 'refress');
        }
        else
        {
            // if error redirect to get form 
            redirect_form_validation(validation_errors(), $this->input->post(), 'groups/create');
        }
    }
    
    /**
     * Edit
     * @param int $id
     */
    public function edit($id)
    {
        parent::check_login();
        if(!isset($id) || !is_numeric($id)){ redirect('groups', 'refresh'); }
        
        // get group information
        $group = $this->get($id);

        // check if group is admin redirect to group list
        if($group->name == 'admin')
        {
            // set message group admin can not edit
            $this->session->set_flashdata('message', $this->lang->line('is_admin'));
            redirect('groups', 'refresh');
        }

        // set hidden group id
        $this->data['group_id'] = array('group_id' => $group->id);

        // set log
        set_log('View for modify Group', $group);
        
        // Validation error
        $validation_errors = $this->session->flashdata('validation_errors');

        //set the flash data error message if there is one
        $this->data['message'] = ($validation_errors['errors'] ? $validation_errors['errors'] : $this->session->flashdata('message'));
        
        // display form
        $this->data['name'] = array(
            'name'  => 'name',
            'id'    => 'name',
            'class' => 'form-control',
            'placeholder' => 'Enter Group Name',
            'value' => (isset($validation_errors['post_data']['name']) ? $validation_errors['post_data']['name'] : $group->name)
        );
        
        $this->data['desc'] = array(
            'name' => 'desc',
            'id'   => 'desc',
            'class'=> 'form-control',
            'placeholder' => 'Enter group description',
            'value'=> (isset($validation_errors['post_data']['des']) ? $validation_errors['post_data']['des'] : $group->description)
        );
        
        // process template
        $title = $this->lang->line('form_group_edit_heading');
        $this->data['title'] = $title;
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/sb-admin-2.js'
                                        );
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable();});';
        
        $layout_property['breadcrumb'] = array('groups' => $this->lang->line('index_group_heading'), $title);
        
        $layout_property['content']  = 'edit';
        
        // menu
        $this->data['account_menu'] = TRUE; $this->data['group_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
        
    }
    
    /**
     * Update to database
     */
    public function modify()
    {
        parent::check_login();
        // get group id
        $id = trim($this->input->post('group_id'));
        
        // set data for update
        $data = array(
            'name' => trim($this->input->post('name')),
            'description' => trim($this->input->post('desc'))
        );
        
        // set rules for descriptio field
        $this->group->validate[0]['rules'] = 'trim|required|xss_clean';

        // update group table
        if($this->update($id, $data))
        {
            //set log
            array_unshift($data, $id);
            set_log('Modified Group', $data);

            // set success message
            $this->session->set_flashdata('message', $this->lang->line('form_group_report_success'));
            redirect('groups', 'refress');
        }
        else
        {
            // if error redirect to get form 
            redirect_form_validation(validation_errors(), $this->input->post(), 'groups/edit/'.$id);
        }
    }
    
    /** 
     * Delete from database
     * @param int $id
     */
    public function destroy($id)
    {
        parent::check_login();
        // get group information
        $group = $this->get($id);
        
        // check group admin can not delete
        if($group->name == 'admin'){
            $this->session->set_flashdata('message', $this->lang->line('admin_group_cannot_delete'));
            redirect('groups', 'refresh');
        }
        
        // delete group 
        if($this->delete($id))
        {
            // set log
            set_log('Delete Group', $group);
            $this->session->set_flashdata('message', $this->lang->line('del_group_report_success'));
            redirect('groups', 'refresh');
        }
        else // delete error
        {
            $this->session->set_flashdata('message', $this->lang->line('del_group_report_error'));
            redirect('groups', 'refresh');
        }
    }
    
    public function get($id, $array = FALSE)
    {
        if($array == TRUE){
            return $this->group->as_array()->get($id);
        }
        return $this->group->as_object()->get($id);
    }
    
    
    public function get_all()
    {
        return $this->group->get_all();
    }
    
    
    public function insert($data, $skip_validation = FALSE)
    {
        return $this->group->insert($data, $skip_validation);
    }
    
    public function update($id, $data, $skip_validation = FALSE)
    {
        return $this->group->update($id, $data, $skip_validation);
    }
    
    public function delete($id)
    {
        return $this->group->delete($id);
    }
    
}