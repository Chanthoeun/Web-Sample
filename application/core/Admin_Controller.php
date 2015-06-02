<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin_Controller
 *
 * @author chanthoeun
 */
class Admin_Controller extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template', array('layout' => 'backend', 'asset_location' => 'assets', 'site_name' => 'Agriculture Today', 'no_footer' =>TRUE));
        $this->load->library('form_validation');
        $this->load->helper('upload');
    }
    
    public function check_login(){
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('message', 'You are not log in.');
            redirect(site_url('auth/login'), 'refresh');
        }
        else
        {
            if(!$this->ion_auth->is_admin())
            {
                $this->session->set_flashdata('message', 'You must be an administrator to view this page.');
                
                //log the user out
                $this->ion_auth->logout();
                redirect(site_url('auth/login'), 'refresh');
            }
            // set home breadcrumb
            $this->template->set_home_breadcrumb('control');
            return TRUE;
        }
    }
    
    public function check_member_login(){
        if (!$this->ion_auth->logged_in()){
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect(site_url('login'), 'refresh');
        }else{
            $user_id = $this->session->userdata('user_id');
            if($this->ion_auth->in_group(2))
            {
                $this->template->set_home_breadcrumb('memberships/member');
                return Modules::run('memberships/get_with_user', array('u.id' => $user_id, 'c.type' => 1));
            }
            else
            {
                $this->session->set_flashdata('message', 'You account is not correct!');
                //log the user out
                $this->ion_auth->logout();
                redirect(site_url('login'), 'refresh');
            }
        }
    }
}