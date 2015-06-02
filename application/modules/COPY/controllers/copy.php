<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of copy
 *
 * @author Chanthoeun
 */
class Copy extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('copy_model', 'copy');
        $this->lang->load('copy');
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
    
    // list all
    public function index()
    {
        
    }
    
    // create
    public function create()
    {
        
    }
    
    // save
    public function store()
    {
        
    }
    
    // edit
    public function edit($id)
    {
        
    }
    
    // update
    public function modify()
    {
        
    }
    
    // view
    public function view($id)
    {
        
    }
    
    // delete
    public function destroy($id)
    {
        
    }

    public function get($id, $array = FALSE)
    {
        if($array == TRUE){
            return $this->copy->as_array()->get($id);
        }
        return $this->copy->as_object()->get($id);
    }
    
    public function get_by($where, $array = FALSE)
    {
        if($array == TRUE){
            return $this->copy->as_array()->get_by($where);
        }
        return $this->copy->as_object()->get_by($where);
    }
    
    public function get_all($order_by = FALSE, $limit = FALSE, $offset = 0)
    {
        if($order_by != FALSE)
        {
            $this->order_by($order_by);
        }
        if($limit != FALSE)
        {
            $this->copy->limit($limit, $offset);
        }
        return $this->copy->get_all();
    }
    
    public function get_many_by($where, $order_by = FALSE, $limit = FALSE, $offset = 0)
    {
        if($order_by != FALSE)
        {
            $this->order_by($order_by);
        }
        if($limit != FALSE)
        {
            $this->copy->limit($limit, $offset);
        }
        return $this->copy->get_many_by($where);
    }
    
    public function insert($data, $skip_validation = FALSE)
    {
        return $this->copy->insert($data, $skip_validation);
    }
    
    public function insert_many($data, $skip_validation = FALSE)
    {
        return $this->copy->insert_many($data, $skip_validation);
    }
    
    public function update($id, $data, $skip_validation = FALSE)
    {
        return $this->copy->update($id, $data, $skip_validation);
    }
    
    public function delete($id)
    {
        return $this->copy->delete($id);
    }
    
    public function delete_by($where)
    {
        return $this->copy->delete_by($where);
    }
    
    public function count_all()
    {
        return $this->copy->count_all();
    }
    
    public function count_by($where)
    {
        return $this->copy->count_by($where);
    }
    
    public function dropdown($key, $value, $option_label = NULL, $where = NULL)
    {
        if($where != NULL){
            $this->db->where($where);
        }
        
        return $this->copy->dropdown($key, $value,$option_label);
    }
    
    public function order_by($criteria, $order = NULL)
    {
        $this->copy->order_by($criteria,$order);
    }
    
    public function get_next_order($field, $where = FALSE)
    {
        return $this->copy->get_next_order($field, $where);
    }
}