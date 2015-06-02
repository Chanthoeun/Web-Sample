<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('generate_template')){
    /**
     * Generate template
     * 
     * @param array $data
     * @param array $layout_property
     * @param string $layout
     * @param array $meta
     * @param boolen $clear_style
     */
    function generate_template($data, $layout_property, $layout = FALSE, $meta = FALSE,  $clear_style = TRUE){
        $CI =& get_instance();
        
        // clear template style
        if($clear_style === TRUE)
        { 
            $CI->template->clear();
        }
        
        // set data
        $CI->template->set_data($data);
        
        // set template layout
        if($layout != FALSE)
        {
            $CI->template->set_layout($layout);
        }
        
        
        // set home breadcrumb
        if(isset($layout_property['home_breadcrumb']) && !empty($layout_property['home_breadcrumb']))
        { 
            $CI->template->set_home_breadcrumb($layout_property['home_breadcrumb']); 
        }
        
        // set breadcrumb
        if(isset($layout_property['breadcrumb']) && !empty($layout_property['breadcrumb']))
        { 
            $CI->template->add_breadcrumb($layout_property['breadcrumb']); 
        }
        
        //META data
        if($meta !=  FALSE)
        { 
            $CI->template->add_meta($meta); 
        }
        
        // add css file
        if(isset($layout_property['css']) && !empty($layout_property['css']))
        {
            generate_css($layout_property['css']);
        }
        
        // add js file
        if(isset($layout_property['js']) && !empty($layout_property['js']))
        {
            generate_js($layout_property['js']);
        }
        
        // add javascript
        if(isset($layout_property['script']) && !empty($layout_property['script']))
        {
            generate_script($layout_property['script']);
        }
        
        // add js optional file
        if(isset($layout_property['optional_js']) && !empty($layout_property['optional_js']))
        {
            $CI->template->add_js_optional($layout_property['optional_js']);
        }
        
        // set layout item
        if(isset($layout_property['header']))
        {
            $CI->template->set_header($layout_property['header']);
        }
        
        if(isset($layout_property['sidebar']))
        {
            $CI->template->set_sidebar($layout_property['sidebar']);
        }
        
        if(isset($layout_property['content']))
        {
            $CI->template->set_content($layout_property['content']);
        }
        
        if(isset($layout_property['footer']))
        {
            $CI->template->set_footer($layout_property['footer']);
        }
        
        // build template
        if(isset($layout_property['template']))
        {
            $CI->template->build($layout_property['template']);
        }  else {
            $CI->template->build();
        }
    }
}

if(! function_exists('generate_css')){
    /**
     * Generate css is stylesheet file is store in template folder
     * 
     * @param array|value $css
     */
    function generate_css($css){
        $CI =& get_instance();
        if(is_array($css)){
            foreach ($css as $key => $value){
                if(is_numeric($key)){
                    
                    // link from local machine
                    $CI->template->add_css($value);
                }else{
                    // link from internet
                    $CI->template->add_css($key, $value);
                }
            }
        }else{
            $CI->template->add_css($css);
        }
    }
}

if(!function_exists('generate_custom_css')){
    /**
     * Generate css script
     * 
     * @param string $custom_css
     */
    function generate_custom_css($custom_css){
        $CI =& get_instance();
        if(is_array($custom_css)){
            foreach ($custom_css as $css_script){
                $CI->template->add_custom_css($css_script);
            }
        }else{
            $CI->template->add_custom_css($custom_css);
        }
    }
}

if(! function_exists('generate_js')){
    /**
     * Generate Js is javascription file is store in template folder
     * 
     * @param array|value $js
     */
    function generate_js($js){
        $CI =& get_instance();
        if(is_array($js)){
            foreach ($js as $key => $value){
                if(is_numeric($key)){
                    // link from local machine
                    $CI->template->add_js($value);
                }else{
                    // link from internet
                    $CI->template->add_js($key, $value);
                }
            }
        }else{
            //link from local machine
            $CI->template->add_js($js);
        }
    }
}

if(! function_exists('generate_script')){
    /**
     * Generate javascript
     * 
     * @param string $script
     */
    function generate_script($script){
        $CI =& get_instance();
        if(is_array($script)){
            foreach ($script as $value){
                $CI->template->add_script($value);
            }
        }else{
            $CI->template->add_script($script);
        }
    }
}

if(!function_exists('generate_js_optional')){
    /**
     * Generate Option Javascript is javascript file store outside template folder
     * 
     * @param array|value $js_optional array or value
     */
    function generate_js_optional($js_optional){
        $CI =& get_instance();
        if(is_array($js_optional)){
            foreach ($js_optional as $path => $js){
                if(is_numeric($path)){
                    // link from internet
                    $CI->template->add_js_optional($js);
                }else{
                    // link form local machine
                    $CI->template->add_js_optional($js, $path);
                }
            }
        }else{
            // link from internet
            $CI->template->add_js_optional($js_optional);
        }
    }
}

if(!function_exists('view_breadcrumb')){
    
    function view_breadcrumb($start_tag='<ol class="breadcrumb">', $end_tag='</ol>',$home_icon='<i class="fa fa-home fa-fw"></i>', $active='active'){
        $CI =& get_instance();
        return $CI->template->print_breadcrumb($start_tag, $end_tag, $home_icon, $active);
    }
}

if(!function_exists('home_url')){
    // view home url
    function home_url(){
        $CI =& get_instance();
        return $CI->template->print_home_breadcrumb();
    }
}

if(!function_exists('site_name'))
{
    // view website name
    function site_name(){
        $CI =& get_instance();
        return $CI->template->print_site_name();
    }
}

if(!function_exists('title_seperator'))
{
    // view title seperator
    function title_seperator(){
        $CI =& get_instance();
        return $CI->template->print_title_seperator();
    }
}

if(! function_exists('get_image'))
{
    function get_image($image, $path = FALSE, $thumb = FALSE)
    {
        $CI =& get_instance();
        return $CI->template->get_image($image, $path, $thumb);
    }
}
/* End of file template_helper.php */
/* Location: ./application/helpers/template_helper.php */