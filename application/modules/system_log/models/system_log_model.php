<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log_model
 *
 * @author Chanthoeun
 */
class System_log_model extends MY_Model {
    public $_table = 'log';
    public $protected_attributes = array( 'id');
    
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
    
    
    public function get_type()
    {
        $this->db->distinct();
        $this->db->select('action');
        return parent::get_all();
    }
    
    public function get_all()
    {
        $this->db->select($this->_table.'.*', FALSE);
        return parent::get_all();
    }
    
    public function like($like)
    {
        $this->db->like($like);
    }
}
