<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of log
 *
 * @author Chanthoeun
 */
class System_log extends Admin_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('system_log_model', 'system_log');
        
        $this->lang->load('system_log');
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
    
    public function index()
    {   
        parent::check_login();
        
        $this->data['logs']= $this->get_all(array('created_at' => 'desc'));
        
        // message
        $this->data['message'] = $this->session->flashdata('message');
        
        $this->data['title'] = $this->lang->line('log_index_heading_label');
        
        // style
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
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable({"aaSorting": [[5, "desc"]]});});';
        
        $layout_property['breadcrumb'] = array($this->lang->line('log_index_heading_label'));
        
        $layout_property['content']  = 'index';
        
        // menu
        $this->data['setting_menu'] = TRUE; $this->data['system_log_group_menu'] = TRUE; $this->data['system_log_menu'] = TRUE;
        generate_template($this->data, $layout_property);
    }
    
    public function filter()
    {
        parent::check_login();
        
        $this->form_validation->set_rules('users', $this->lang->line('log_filter_user_validation_label'), 'trim|xss_clean');
        $this->form_validation->set_rules('types', $this->lang->line('log_filter_type_validation_label'), 'trim|xss_clean');
        $this->form_validation->set_rules('create_date', $this->lang->line('log_filter_date_validation_label'), 'trim|xss_clean');
        if($this->form_validation->run() === TRUE)
        {
            $username = $this->input->post('users');
            $action_type = $this->input->post('types');
            $create_date = $this->input->post('create_date');
            
            $where = FALSE; $like = FALSE;
            
            if($username != FALSE && $action_type == FALSE && $create_date == FALSE)
            {
                $where = array('who' => $username);
            }
            else if($username == FALSE && $action_type != FALSE && $create_date == FALSE)
            {
                $where = array('action' => $action_type);
            }
            else if($username == FALSE && $action_type == FALSE && $create_date != FALSE)
            {
                $like = array('FROM_UNIXTIME(created_at, \'%Y-%m-%d\')' => $create_date);
            }
            else if($username != FALSE && $action_type != FALSE && $create_date == FALSE)
            {
                $where = array('who' => $username,'action' => $action_type);
            }
            else if($username != FALSE && $action_type == FALSE && $create_date != FALSE)
            {
                $where = array('who' => $username);
                $like = array('FROM_UNIXTIME(created_at, \'%Y-%m-%d\')' => $create_date);
            }
            else if($username == FALSE && $action_type != FALSE && $create_date != FALSE)
            {
                $where = array('action' => $action_type);
                $like = array('FROM_UNIXTIME(created_at, \'%Y-%m-%d\')' => $create_date);
            }
            else if($username != FALSE && $action_type != FALSE && $create_date != FALSE)
            {
                $where = array('who' => $username, 'action' => $action_type);
                $like = array('FROM_UNIXTIME(created_at, \'%Y-%m-%d\')' => $create_date);
            }
            
            if($where != FALSE)
            {
                $this->data['logs']= $this->get_many_by($where, array('created_at' => 'desc'), $like);
            }
            else
            {
                $this->data['logs']= $this->get_all(array('created_at' => 'desc'), $like);
            }
            
        }
        
        // message
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        
        // display form
        $users = $this->ion_auth->users(1)->result();
        $user_options = array('' => '--- Select User ---');
        foreach ($users as $user){
            $user_options[$user->username] = $user->username;
        }
        $this->data['users'] = form_dropdown('users',$user_options, set_value('users'), 'class="form-control" id="users"');
        
        $types = $this->system_log->get_type();
        $type_options = array('' => '--- Select Type ---');
        foreach ($types as $type)
        {
            $type_options[$type->action] = $type->action;
        }
        $this->data['types'] = form_dropdown('types', $type_options, set_value('types'), 'class="form-control" id="types"');
        
        $this->data['create_date'] = array(
            'name'  => 'create_date',
            'id'    => 'create_date',
            'class' => 'form-control',
            'placeholder' => 'Select Date',
            'data-date-format'  => 'yyyy-mm-dd',
            'data-date' => date('Y-m-d'),
            'value' => set_value('create_date')
        );
        
        $this->data['title'] = $this->lang->line('log_filter_heading');
        
        // style
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/plugins/dataTables.bootstrap.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css',
                                        'css/datepicker.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/plugins/dataTables/jquery.dataTables.js', 
                                        'js/plugins/dataTables/dataTables.bootstrap.js',
                                        'js/sb-admin-2.js',
                                        'js/bootstrap-datepicker.min.js'
                                        );
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable({"aaSorting": [[5, "desc"]]});}); $(\'#create_date\').datepicker();';
       
        $layout_property['breadcrumb'] = array($this->lang->line('log_filter_heading'));
        
        $layout_property['content']  = 'filter';
        
        // menu
        $this->data['setting_menu'] = TRUE; $this->data['system_log_group_menu'] = TRUE; $this->data['filter_log_menu'] = TRUE;
        generate_template($this->data, $layout_property);
    }

    public function filter_by_user($username)
    {
        parent::check_login();
        
        $this->data['logs']= $this->get_many_by(array('who'=>$username), array('created_at' => 'desc'));
        
        // message
        $this->data['message'] = $this->session->flashdata('message');
        
        $this->data['title'] = $this->lang->line('log_index_heading_label');
        
        // style
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
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable({"aaSorting": [[5, "desc"]]});});';
        
        $layout_property['breadcrumb'] = array($this->lang->line('log_index_heading_label'));
        
        $layout_property['content']  = 'index';
        
        // menu
        $this->data['setting_menu'] = TRUE; $this->data['system_log_menu'] = TRUE;
        generate_template($this->data, $layout_property);
    }
    
    public function del($id){
        parent::check_login();
        // get log
        $get_log = $this->get($id);
        
        if($this->delete($id))
        {
            set_log('deleted', $get_log);
            $this->session->set_flashdata('message', $this->lang->line('del_success_label'));
        }  
        else 
        {
            set_log('delete Error', $get_log);
            $this->session->set_flashdata('message', $this->lang->line('del_error_label'));
        }
        
        redirect(site_url('system_log', 'refresh'));
    }

    public function get($id)
    {
        return $this->system_log->as_object()->get($id);
    }
    
    public function get_by($where)
    {
        return $this->system_log->as_object()->get_by($where);
    }
    
    public function get_all($order_by = FALSE, $like = FALSE)
    {
        if($order_by != FALSE)
        {
            $this->order_by($order_by);
        }
        
        if($like != FALSE)
        {
            $this->system_log->like($like);
        }
        return $this->system_log->get_all();
    }
    
    public function get_many_by($where, $order_by = FALSE, $like = FALSE)
    {
        if($order_by != FALSE)
        {
            $this->order_by($order_by);
        }
        
        if($like != FALSE)
        {
            $this->system_log->like($like);
        }
        
        return $this->system_log->get_many_by($where);
    }
    
    public function insert($data, $skip_validation = FALSE)
    {
        return $this->system_log->insert($data, $skip_validation);
    }
    
    public function insert_many($data, $skip_validation = FALSE)
    {
        return $this->system_log->insert_many($data, $skip_validation);
    }
    
    public function update($id, $data, $skip_validation = FALSE)
    {
        return $this->system_log->update($id, $data, $skip_validation);
    }
    
    public function delete($id)
    {
        return $this->system_log->delete($id);
    }
    
    public function delete_by($where)
    {
        return $this->system_log->delete_by($where);
    }
    
    public function count_all()
    {
        return $this->system_log->count_all();
    }
    
    public function count_by($where)
    {
        return $this->system_log->count_by($where);
    }
    
    public function dropdown($key, $value, $option_label = NULL, $where = NULL)
    {
        if($where != NULL){
            $this->db->where($where);
        }
        
        return $this->system_log->dropdown($key, $value,$option_label);
    }
    
    public function order_by($criteria, $order = NULL){
        $this->system_log->order_by($criteria,$order);
    }
}