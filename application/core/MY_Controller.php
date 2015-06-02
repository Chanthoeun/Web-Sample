<?php (defined('BASEPATH')) OR exit('No direct script access allowed');


class MY_Controller extends MX_Controller {
    
    /**
     * Public Variables
     */
    public $data = array();
    
    function __construct() {
        parent::__construct();        
        // load model
        $this->load->model('auth/ion_auth_model');
        
        // load library
        $this->load->library('ion_auth');
        
        // monitoring system
        $this->output->enable_profiler(ENVIRONMENT=='development');
    }
    
}