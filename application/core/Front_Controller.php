<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Front_Controller
 *
 * @author chanthoeun
 */
class Front_Controller extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('template', array('layout' => 'home_page', 'asset_location' => 'assets', 'site_name' => 'ទស្សនាវដ្តីកសិកម្ម')); 
    }
}