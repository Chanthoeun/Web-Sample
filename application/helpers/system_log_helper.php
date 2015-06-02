<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!function_exists('set_log'))
{
    /**
     * Set Log
     * -----------------------------------------------------------
     * @param string $action
     * @param array $description
     */
    function set_log($action, $description = FALSE, $who = FALSE)
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->model('system_log/system_log_model', 'system_log');
        $data['who'] = $who == FALSE ?  $CI->session->userdata('username') : $who;
        $data['action'] = $action;
        $data['description'] = $description == FALSE ? NULL : implode(' | ', (array)$description);
        $CI->system_log->insert($data, TRUE);
    }
}