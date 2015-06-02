<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author Administrator
 */
class Template {
    private $CI;
    
    public  $data              = array();
    private $layout            = ""; // layout folder
    private $asset_location    = ""; // Assets location
    private $site_name         = "";
    private $title_seperator   = ' | ';
    private $title             = "";
    private $header            = "";
    private $no_header         = FALSE;
    private $sidebar           = "";
    private $no_sidebar        = FALSE;
    private $sidebar_items     = array();
    private $content           = "";
    private $content_items     = array();
    private $footer            = "";
    private $no_footer         = FALSE;
    private $_css              = array();
    private $_custom_css       = array();
    private $_js               = array();
    private $_js_optional      = array();
    private $_script           = array();
    private $_meta             = array();
    private $_jquery           = array();
    private $_breadcrumb       = array();
    private $home_breadcrumb   = "";
    private $_style_path       = "";
    
    

    public function __construct($config = array()) {
        $this->CI =& get_instance(); 
        $this->CI->load->helper('url');
        $this->CI->load->helper('html');
        
        $this->home_breadcrumb = site_url();
        
        if(!empty($config)){
            $this->initialize($config);
        }
    }
    
    /**
     * Initailize configuration 
     * -------------------------------------------------------------------------
     * @param type array $config
     */
    public function initialize($config = array()){
        $defaults = array(
            'layout'            => "",
            'asset_location'    => "",
            'site_name'         => "",
            'title'             => "",
            'title_seperator'   => ' | ',
            'no_header'         => FALSE,
            'no_sidebar'        => FALSE,
            'no_footer'         => FALSE,
            'home_breadcrumb'   => ""
            
        );
        
        foreach ($defaults as $key => $val){
            if(isset($config[$key])){
                $method = 'set_'.$key;
                if(method_exists($this, $method)){
                    $this->$method($config[$key]);
                }else{
                    $this->$key = $config[$key];
                }
            }else{
                $this->$key = $val;
            }
        }
        
    }
    
    /**
     * View Site name
     * ------------------------------------------------------------------------
     * @return string
     */
    public function print_site_name(){
        return $this->site_name;
    }

    /**
     * Set data
     * ------------------------------------------------------------------------
     * @param array $data
     */
    public function set_data($data){
        $this->data = $data;
        
        // set title
        if(isset($this->data['title']))
        {
            $this->set_title($this->data['title']);
        }
        
        // set title seperator
        if(isset($this->data['title_seperator']))
        {
            $this->set_title_seperator($this->data['title_seperator']);
        }
        
        // set asset locaiton
        if(isset($this->data['asset_location']))
        {
            $this->set_asset_location($this->data['asset_location']);
        }
    }


    /**
     * Set page title
     * ------------------------------------------------------------------------
     * @param string $title
     */
    public function set_title($title){
        $this->title = $title;
    }
    
    /*
     * Print title to browser
     * ------------------------------------------------------------------------
     * @return String
     */
    public function print_title(){
        if($this->title == FALSE)
        {
            $site_title = $this->site_name;
        }
        else
        {
            $site_title = $this->title.$this->title_seperator.$this->site_name;
        }
        return $site_title;
    }


    /**
     * Set seperator symbol
     * ------------------------------------------------------------------------
     * @param string $title_seperator
     */
    public function set_title_seperator($title_seperator){
        $this->title_seperator = $title_seperator;
    }
    
    public function print_title_seperator(){
        return $this->title_seperator;
    }


    /**
     * Set Layout
     * ------------------------------------------------------------------------
     * @param string $layout
     */
    public function set_layout($layout){
        $this->layout = $layout;
        $style = explode('/', $this->layout);
        $this->_style_path = count($style) == 1 ? $style[0] : $style[1];
    }
    
    
    /**
     * Set header page
     * ------------------------------------------------------------------------
     * @param string $header
     * @param array $data
     */
    public function set_header($header){
        $this->header = $header;
    }
    
    public function print_header(){
        if(empty($this->header)){
            $view = $this->CI->load->view($this->layout.'/'.'header', $this->data, TRUE);
        }else{
            $view = $this->CI->load->view($this->header, $this->data, TRUE);            
        }
        return $view;
    }
    
    /**
     * Set Sidebar
     * ------------------------------------------------------------------------
     * @param string(html_file) $view
     * @param array $data
     */
    public function set_sidebar($sidebar){
        $this->sidebar = $sidebar;
    }
    
    public function print_sidebar(){
        if(empty($this->sidebar)){
            $view = $this->CI->load->view($this->layout.'/'.'sidebar', $this->data, TRUE);
        }else{
            $view = $this->CI->load->view($this->sidebar, $this->data, TRUE);
        }       
        return $view;
    }
    
    /**
     * Set Content
     * ------------------------------------------------------------------------
     * @param string(html_file) $view
     * @param array $data
     */
    public function set_content($content){
        $this->content = $content;
    }
    
    public function print_content(){
        if(empty($this->content)){
            $view = $this->CI->load->view($this->layout.'/'.'index', $this->data, TRUE);
        }else{
            $view = $this->CI->load->view($this->content, $this->data, TRUE);
        }
        return $view;
    }
    
    /**
     * Set Footer
     * ------------------------------------------------------------------------
     * @param string(html_file) $view
     * @param array $data
     */
    public function set_footer($footer){
        $this->footer = $footer;
    }
    
    public function print_footer(){
        if(empty($this->footer)){
            $view = $this->CI->load->view($this->layout.'/'.'footer', $this->data, TRUE);
        }else{
            $view = $this->CI->load->view($this->footer, $this->data, TRUE);
        }
        return $view;
    }

    /**
     * Get Image
     * ------------------------------------------------------------------------
     * @param string $file_name is image name 
     * @param string $path if false set to current path
     * @param boolen $thumb view in thumbnial album
     * @return image 
     */
    public function get_image($file_name,$path = FALSE, $thumb = FALSE){
        $img = '';
        if($path == FALSE){
            $img = ($thumb == FALSE ? base_url($this->asset_location.'/'.$this->_style_path.'/img/'.$file_name) : base_url($this->asset_location.'/'.$this->_style_path.'/img/'.$thumb.'/'.$file_name));
        }else{
            $img = ($thumb == FALSE ? base_url($path.'/'.$file_name) : base_url($path.'/'.$thumb.'/'.$file_name));
        }
        return $img;
    }

    /**
     * Set Asset Location
     * ------------------------------------------------------------------------
     * @param string $asset_location
     */
    public function set_asset_location($asset_location){
        $this->asset_location = $asset_location;
    }

    /**
     * add plug-in in slibar layout
     * ------------------------------------------------------------------------
     * @param string $view it html file
     * @param array $data
     */
    public function add_sidebar_items($view){
        $this->sidebar_items[] = $this->CI->load->view($view, $this->data, TRUE);
        return $this;
    }
    
    /**
     * Print HTML code to browser
     * ------------------------------------------------------------------------
     * @return HTML
     */
    public function print_sidebar_items(){
        $final_item = '';
        foreach ($this->sidebar_items as $item){
            $final_item .= $item;
        }
        return $final_item;
    }
    
    /**
     * Add content to content layout
     * ------------------------------------------------------------------------
     * @param string $view it html file
     * @param array $data
     */
    public function add_content_items($view){
        $this->content_items[] = $this->CI->load->view($view, $this->data, TRUE);
        return $this;
    }
    
    /**
     * Print content to content layout
     * ------------------------------------------------------------------------
     * @return html
     */
    public function print_content_items(){
        $final_item = '';
        foreach ($this->content_items as $item){
            $final_item .= $item;
        }
        return $final_item;
    }
    
    /**
     * Add css file
     * ------------------------------------------------------------------------
     * @param string $css file name
     * @param boolen $pre_base_url True or False
     * @return css
     */
    public function add_css($css, $pre_base_url = TRUE){
        if($pre_base_url){
            $this->_css[] = base_url($this->asset_location.'/'.$this->_style_path.'/'.$css);
        }else{
            $this->_css[] = $css;
        }
        return $this;
    }
    
    /**
     * Print and generate css tag
     * ------------------------------------------------------------------------
     * @return css
     */
    public function print_css(){
        $final_css = '';
        foreach ($this->_css as $css){
            $final_css .= link_tag($css, 'stylesheet', 'text/css');
        }
        return $final_css;
    }
    
    /**
     * Add css script
     * ------------------------------------------------------------------------
     * @param string $css_code stylesheet code
     * @return script
     */
    public function add_custom_css($css_code){
        $this->_custom_css[] = $css_code;
        return $this;
    }
    
    /**
     * Print css script to html head
     * ------------------------------------------------------------------------
     * @return css_script
     */
    public function print_custom_css(){
        if(empty($this->_custom_css)){ return NULL;}
        
        $final_custom_css = '<style>';
        foreach ($this->_custom_css as $custom_css){
            $final_custom_css .= $custom_css;
        }
        $final_custom_css .= '</style>';
        return $final_custom_css;
    }
    
    /**
     * Add javascript file
     * ------------------------------------------------------------------------
     * @param string $js javascript file
     * @param boolen $pre_base_url True or False
     * @return \javascript
     */
    public function add_js($js, $pre_base_url=TRUE){
        if($pre_base_url){
            $this->_js[] = base_url($this->asset_location.'/'.$this->_style_path.'/'.$js);
        }else{
            $this->_js[] = $js;
        }
        return $this;
    }
    
    /**
     * Print and generate javascript tag
     * ------------------------------------------------------------------------
     * @return string
     */
    public function print_js(){
        $final_js = '';
        foreach ($this->_js as $js){
            $final_js .= '<script src="'.$js.'" ></script>';
        }
        return $final_js;
    }
    
    /**
     * Add javascript file outside template folder
     * ------------------------------------------------------------------------
     * @param string $js javascription file
     * @param string $path
     * @return \javascript
     */
    public function add_js_optional($js,$path = FALSE){
        if($path != FALSE){
            $this->_js_optional[] = base_url($path.'/'.$js);
        }else{
            $this->_js_optional[] = $js;
        }
        return $this;
    }
    
    /**
     * Print and generate javascript file 
     * ------------------------------------------------------------------------
     * @return string
     */
    public function print_js_optional(){
        $final_js = '';
        foreach ($this->_js_optional as $js){
            $final_js .= '<script src="'.$js.'" ></script>';
        }
        return $final_js;
    }

    /**
     * Add javascript code
     * ------------------------------------------------------------------------
     * @param string $script
     * @return \string
     */
    public function add_script($script){
        $this->_script[] = $script;
        return $this;
    }
    
    /**
     * Print javascript script
     * ------------------------------------------------------------------------
     * @return string
     */
    public function print_script(){
        if(empty($this->_script)){ return NULL; }
        
        $final_script = '<script type="text/javascript">';
        foreach ($this->_script as $script){
            $final_script .= $script;
        }
        $final_script .= '</script>';
        return $final_script;
    }

    /**
     * Add jquery code 
     * ------------------------------------------------------------------------
     * @param string $jquery
     * @return \string
     */
    public function add_jquery($jquery){
        $this->_jquery[] = $jquery;
        return $this;
    }
    
    /**
     * Print jquery code
     * ------------------------------------------------------------------------
     * @return string
     */
    public function print_jquery(){
        if(empty($this->_jquery)){ return NULL; }
        
        $final_jquery = '<script type="text/javascript">'
                        . '$(function() {';
        foreach ($this->_jquery as $jquery){
            $final_jquery .= $jquery;
        }
        $final_jquery .= '})'
                        . '</script>';
        return $final_jquery;
    }

    /**
     * Add meta data
     * ------------------------------------------------------------------------
     * @param array $meta
     * @return \meta
     */
    public function add_meta($meta = array()){
        $this->_meta = $meta;
        return $this;
    }
    
    /**
     * Print Meta data to browser
     * ------------------------------------------------------------------------
     * @return meta_tag
     */
    public function print_meta(){
        return meta($this->_meta);
    }

    /**
     * Set home breadcrumb
     * ------------------------------------------------------------------------
     * @param string $breadcrumb example homepage
     */
    public function set_home_breadcrumb($breadcrumb){
        $this->home_breadcrumb = site_url($breadcrumb);
    }
    
    public function print_home_breadcrumb()
    {
        return $this->home_breadcrumb;
    }

    /**
     * Add breadcrumb link and title with array key and value (key is url_link, value is title)
     * ------------------------------------------------------------------------
     * @param array $breadcrumb (url_link, title) example array('home' => 'Home','about-us'=>'About Us')
     */
    public function add_breadcrumb($breadcrumb){
        
        $this->_breadcrumb = $breadcrumb;
    }
    
    /**
     * Print Breadcrumb to Browser
     * ------------------------------------------------------------------------
     * @param string $start_tag example <div class="breadcrumbs fixed" id="breadcrumbs">
     * @param string $end_tag example </div>
     * @param string $home_icon example <i class="icon-home home-icon"></i>
     * @param string $divider example <span class="divider"><i class="icon-angle-right arrow-icon"></i></span> or NULL
     * @param string $active example active
     * @return string
     */
    public function print_breadcrumb($start_tag='<ol class="breadcrumb">', $end_tag='</ol>',$home_icon='<i class="fa fa-home fa-fw"></i>', $active='active'){
        $final_breadcrumb = $start_tag;
        //home breadcrumb
        $home = $home_icon == '<i class="fa fa-home fa-fw"></i>' ? $home_icon.' Home' : $home_icon;
        $final_breadcrumb .= '<li>'.anchor($this->home_breadcrumb, $home).'</li>';
        
        //breadcrumb items
        
        $last_breadcrumb = end($this->_breadcrumb);
        
        foreach ($this->_breadcrumb as $url => $title){
            if($title != $last_breadcrumb){
                $final_breadcrumb .= '<li>'.anchor(site_url($url),$title).'</li>';
            }
        }
        $final_breadcrumb .= '<li class="'.$active.'">'.$last_breadcrumb.'</li>';
        $final_breadcrumb .= $end_tag;
        return $final_breadcrumb;
    }
    

    /**
     * Clear all style
     * ------------------------------------------------------------------------
     */
    public function clear(){
        $this->_css         = array();
        $this->_js          = array();
        $this->_custom_css  = array();
        $this->_js_optional = array();
        $this->_script      = array();
        $this->_meta        = array();
        $this->_jquery      = array(); 
        $this->data         = array();
    }
    
    /**
     * Generate template
     * ------------------------------------------------------------------------
     * @param string $layout layout name 
     */
    public function build($layout = 'default'){
        if($layout == 'one_col')
        {
            $this->data['content']    = $this->print_content();
        }
        else
        {
            $this->data['header']     = $this->no_header == FALSE ? $this->print_header() : '';
            $this->data['sidebar']    = $this->no_sidebar == FALSE ? $this->print_sidebar() : '';
            $this->data['content']    = $this->print_content();
            $this->data['footer']     = $this->no_footer == FALSE ? $this->print_footer() : '';
        }
        $this->CI->load->view($this->layout.'/layouts/'.$layout,$this->data);
    }
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */