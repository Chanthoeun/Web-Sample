<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Chanthoeun
 */
class Control extends Admin_Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        parent::check_login(); 
        
        $this->data['title'] = 'Administror Control Panel';
        $this->data['page_title'] = 'Dashboard';
        
        // message
        $this->data['message'] = $this->session->flashdata('message');
        
        $layout_property['css']     = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE, 
                                            'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css' => FALSE,
                                            'css/plugins/metisMenu/metisMenu.min.css',
                                            'css/sb-admin-2.css',
                                            'font-awesome-4.1.0/css/font-awesome.min.css'
                                      );
        $layout_property['js']      = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                            'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'=> FALSE,
                                            'js/plugins/metisMenu/metisMenu.min.js',
                                            'js/sb-admin-2.js'
                                      );
        $layout_property['content'] = 'index';
        
        // active menu 
        $this->data['dashboad_menu'] = TRUE;
        generate_template($this->data, $layout_property);
    }
}