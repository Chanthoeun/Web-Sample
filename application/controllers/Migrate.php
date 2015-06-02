<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    
    public function __construct() {
        parent::__construct();
        $this->load->library('migration');
    }

    public function _remap($method, $params = array())
    {
        if(is_numeric($method))
        {
            array_unshift($params, $method);
            $method = 'get_index';
        }
        else
        {
            $method = str_replace('-', '_', $method);
        }
        if (method_exists($this, $method))
        {
                return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }

    public function index()
    {
        if ( ! $this->migration->current())
        {
            show_error($this->migration->error_string());
        }
        else
        {
            echo "Migration Successed!";
        }
    }
    
    public function get_index($version)
    {
        if ( ! $this->migration->version($version))
        {
            show_error($this->migration->error_string());
        }
        else
        {
            echo "Migration Successed!";
        }
    }
    
    public function last(){
        if ( ! $this->migration->latest())
        {
            show_error($this->migration->error_string());
        }
        else
        {
            echo "Migration Successed!";
        }
    }
}

/* End of file migration.php */
/* Location: ./application/controllers/migration.php */