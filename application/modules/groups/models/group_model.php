<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of group_model
 *
 * @author Chanthoeun
 */
class Group_model extends MY_Model {
    public $_table = 'groups';
    public $protected_attributes = array( 'id');
    
    public $before_create = array( 'created_at', 'updated_at' );
    public $before_update = array( 'updated_at' );
    
    public $validate = array(
        array(
            'field' => 'name',
            'label' => 'lang:form_group_validation_name_label',
            'rules' => 'trim|required|is_unique[groups.name]|xss_clean',
            array(
                'is_unique' => 'This %s already exists.'
            )
        ),
        array(
            'field' => 'description',
            'label' => 'lang:form_group_validation_desc_label',
            'rules' => 'trim|required|xss_clean'
        )
    );
}
