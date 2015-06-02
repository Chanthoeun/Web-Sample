<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if( ! function_exists('set_btn')){
    /**
     * Generate Button
     * 
     * @param string $name
     * @param string $type type of button 'submit, button, reset'
     * @param string $caption the title of button
     * @param string $icon
     * @param string $class
     * @param string $js javascript 
     * @return type
     */
    function set_btn($name, $type='button', $caption='Button', $class=NULL, $js=NULL){
        $CI =& get_instance();
        $CI->load->helper('form');
        $data = array(
            'name'  => $name,
            'id'    => $name,
            'type'  => $type,
            'class' => $class
        );
        
        return form_button($data,$caption,$js);
    }
}

if( ! function_exists('set_link')){
    /**
     * Set Link
     * 
     * @param url $uri
     * @param string $title
     * @param array $attributes
     * @param string $icon
     * @return link
     */
    function set_link($uri, $title, $attributes = FALSE, $icon = FALSE){
        return anchor(trim($uri), $icon == FALSE ? $title : $icon.' '.$title, $attributes);
    }
}

if ( ! function_exists('link_add')){
    /**
     * link add
     * 
     * @param url $uri
     * @param string $label
     * @param array $attr
     * @return link
     */
    function link_add($uri, $label = 'Add', $attr = FALSE, $icon = '<i class="fa fa-plus fa-fw"></i>'){
        return anchor(trim($uri), $icon.' '.$label, $attr == FALSE ? array('title' => 'Add') : $attr);
    }
}

if ( ! function_exists('link_edit')){
    /**
     * link Edit
     * 
     * @param url $uri
     * @param string $label
     * @param array $attr
     * @return link
     */
    function link_edit($uri, $label = FALSE, $attr = FALSE, $icon = '<i class="fa fa-pencil fa-fw text-success"></i>'){
        return anchor(trim($uri), $label == FALSE ? $icon : $icon.' '. $label, $attr == FALSE ? array('title' => 'Edit') : $attr);
    }
}

if ( ! function_exists('link_delete')){
    /**
     * link delete
     * 
     * @param url $uri
     * @param string $label
     * @param string $tooltip
     * @param string $messages
     * @return link
     */
    function link_delete($uri, $label = FALSE, $tooltip = 'Delete', $message = 'You are about to delete a record. This cannot be undone. Are you sure?', $target='_self', $icon = '<i class="fa fa-trash-o fa-fw text-danger"></i>')
    {
        return anchor(trim($uri), $label == FALSE ? $icon : $icon.' '.$label, array('title' => $tooltip, 'target' => $target, 'onclick' => "return confirm('".$message."')"));
    }
}

if( ! function_exists('link_preview')){
    /**
     * link Preview
     * 
     * @param url $uri
     * @param string $label
     * @param array $attr
     * @return link
     */
    function link_preview($uri, $label = FALSE, $attr = FALSE, $icon = '<i class="fa fa-search fa-fw"></i>'){
        return anchor(trim($uri), $label == FALSE ? $icon : $icon.' '.$label, $attr == FALSE ? array('title' => 'Preview') : $attr);
    }
}

if( ! function_exists('popup_link_preview')){
    /**
     * link popup link preview
     * 
     * @param url $uri
     * @param string $label
     * @param array $attr
     * @return link
     */
    function popup_link_preview($uri, $label = FALSE, $attr = FALSE, $icon = '<i class="fa fa-search fa-fw"></i>'){
        return anchor_popup($uri, $label == FALSE ? $icon : $icon.' '.$label, $attr == FALSE ? array('title' => 'Popup Preview') : $attr);
    }
}


if (!function_exists('dump')) {
    /**
    * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
    * @author Joost van Veen
    * @version 1.0
    */
    function dump ($var, $label = 'Dump', $echo = TRUE){
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        // Output
        if ($echo == TRUE) {
            echo $output;
        }else {
            return $output;
        }
    }
}
 
 
if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}


if ( ! function_exists('random_password')){
    /**
    * Generate a random password. 
    * 
    * get_random_password() will return a random password with length 6-8 of lowercase letters only.
    *
    * @access    public
    * @param    $chars_min the minimum length of password (optional, default 6)
    * @param    $chars_max the maximum length of password (optional, default 8)
    * @param    $use_upper_case boolean use upper case for letters, means stronger password (optional, default false)
    * @param    $include_numbers boolean include numbers, means stronger password (optional, default false)
    * @param    $include_special_chars include special characters, means stronger password (optional, default false)
    *
    * @return    string containing a random password 
    */    
    function random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false){
        $length = rand($chars_min, $chars_max);
        $selection = 'aeuoyibcdfghjklmnpqrstvwxz';
        if($include_numbers) {
            $selection .= "1234567890";
        }
        if($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }
                
        $password = "";
        for($i=0; $i<$length; $i++) {
            $current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
            $password .=  $current_letter;
        }                
        
        return $password;
    }
}


if(!function_exists('random_filename')){
    /**
    * Random File Name
    * 
    * @param string $str description is original file name
    * @param string $file_ext description file extension
    * @return new file name
    */
    function random_filename($filename,$file_ext){
        return md5($filename + rand()*100).$file_ext;
    }
}


if(!function_exists('send_email')){
    /**
    * Send Email 
    * 
    * @param string $from description email address of sender
    * @param string $name description name of sender
    * @param string $to description email address of reciever
    * @param string $subject description title of email
    * @param string $body description email message
    * @param file $attach description file attach
    * @param string $cc description email address want to send with cc option
    * @return boolean TRUE if mail send succesfully
    */
    function send_email($from, $name, $to, $subject, $body, $attach = FALSE, $cc = FALSE) {
        $CI =& get_instance();
        $CI->load->library('email');
        
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';
        $config['wordwrap'] = TRUE;

        $CI->email->initialize($config);
        
        $CI->email->clear();
        
        $CI->email->set_newline("\r\n");
        $CI->email->from($from, $name); // change it to yours
        $CI->email->to($to); // change it to yours
        if ($cc == TRUE) {
            $CI->email->cc($cc);
        }
        $CI->email->subject($subject);
        if ($attach == TRUE) {
            $CI->email->attach($attach);
        }
        $CI->email->message($body);
        if ($CI->email->send()) {
            return TRUE;
        } else {
            return show_error($CI->email->print_debugger());
        }
    }
}



if(!function_exists('get_csrf_nonce')){
    /**
    * get csrf security
    * 
    * @return csrf key and value
    */
    function get_csrf_nonce(){
        $CI =& get_instance();
        $CI->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $CI->session->set_flashdata('csrfkey', $key);
        $CI->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }
}



if(!function_exists('valid_csrf_nonce')){
    /**
    * Check CSRF security
    * 
    * @return boolean
    */
    function valid_csrf_nonce(){
        $CI =& get_instance();
        if ($CI->input->post($CI->session->flashdata('csrfkey')) !== FALSE &&
            $CI->input->post($CI->session->flashdata('csrfkey')) == $CI->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}



if(!function_exists('get_num_from_string')){
    /**
    * Get Number from string
    * 
    * @param string $str
    * @return int number
    */
    function get_num_from_string($str){
        return preg_replace('/[^0-9]/', '', $str);
    }
}

if(!function_exists('remain_months')){
    /**
     * Remain months
     * 
     * @param date $end
     * @param date $start
     * @return int remain month
     */
    function remain_months($end, $start = NULL){
        $start_date = $start == NULL ? strtotime(date('Y-m-d')) : strtotime($start);
        $end_date = strtotime($end);
        
        $start_year = date('Y',$start_date);
        $end_year = date('Y',$end_date);
        
        $start_month = date('m',$start_date);
        $end_month = date('m',$end_date);
        
        $remain_month = (($end_year - $start_year) * 12) + ($end_month - $start_month);
        return $remain_month;
    }
}


if(!function_exists('get_pagination')){
    /**
     * Get pagination 
     * 
     * @param type $url
     * @param type $total_rows
     * @param type $per_page
     * @param type $num_links
     * @param type $uri_segment
     * @return type
     */
    function get_pagination($url,$total_rows,$per_page=30, $num_links=2, $uri_segment = 3){
        $CI =& get_instance();
        
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '<i class="fa fa-step-backward"></i> First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last <i class="fa fa-step-forward"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next <i class="fa fa-arrow-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-arrow-left"></i> Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $config['base_url'] = base_url($url);
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['uri_segment'] = $uri_segment;
        $CI->load->library('pagination', $config);
        
        $config['v_pagination'] = $CI->pagination->create_links();
        return $config;
    }
}

if(!function_exists('get_google_map'))
{
    /**
     * Get google map
     * -------------------------------------------------
     * @param array $config
     * @param array $markers
     * @return map
     */
    function get_google_map($config, $markers = FALSE)
    {
        $CI =& get_instance();
        // Google configuration
        $CI->load->library('Googlemaps', $config);

        // add marker
        if($markers != FALSE) // marker is not blank
        {
            if(mulit_array($markers) == TRUE)
            {
                // loop add marker
                foreach ($markers as $marker)
                {
                    $CI->googlemaps->add_marker($marker);
                }
            }
            else
            {
                $CI->googlemaps->add_marker($markers);
            }
        }
        else // if marker is blank 
        {
            // add marker in center of map
            $marker = array();
            $CI->googlemaps->add_marker($marker);
        }
        // reture map with marker
        return $CI->googlemaps->create_map();
    }
}

if(!function_exists('multi_array'))
{
    /**
     * Check multiple array
     * --------------------------------------------------------
     * @param array $array
     * @return boolean
     */
    function mulit_array($array)
    {
        foreach ($array as $value)
        {
            if(is_array($value))
            {
                return TRUE;
            }
        }
        return FALSE;
    }
}

if(!function_exists('valid_url'))
{
    /**
     * Check valid url
     * ------------------------------------------------
     * @param string $url
     * @return boolean
     */
    function valid_url($url)
    {
        if(!filter_var($url, FILTER_VALIDATE_URL))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}

if(!function_exists('generate_captcha_image'))
{
    /**
    * Generate Captcha
    * --------------------------------------------
    * @param string $url url
    * @param string $path path to captcha folder
    */
    function generate_captcha_image($url, $path = './captcha/')
    {
        $CI =& get_instance();
        $CI->load->helper('captcha');
        $vals = array(
            'img_path' => $path,
            'img_url' => $url.'/captcha/'
        );
        
        $cap = create_captcha($vals);

        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $CI->input->ip_address(),
            'word' => $cap['word']
            );

        $query = $CI->db->insert_string('captcha', $data);
        $CI->db->query($query);

        return $cap['image'];
    }
}

if(!function_exists('check_captcha'))
{
    /**
    * Check Captcha
    * -------------------------------------------
    * @param string $captch captcha form input
    * @return boolen check if valid captcha
    */
    function check_captcha($captcha)
    {
        $CI =& get_instance();
        
        $expiration = time()-7200; // Two hour limit
        $CI->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);

        // Then see if a captcha exists:
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($captcha, $CI->input->ip_address(), $expiration);
        $query = $CI->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0)
        {
            return FALSE;
        }
        return TRUE;
    }
}

if(!function_exists('product_hit'))
{
    function product_hit($id)
    {
        $CI =& get_instance();
        $CI->load->model('products/product_model', 'product');
        $product = $CI->product->get_by($id);
        
        // product is not valid
        if($product == FALSE)
        {
            return FALSE;
        }
        
        $last_hit = (int) $product->view;
        $current_hit = $last_hit + 1;
        
        // update hit
        if($CI->product->update($id, array('view' => $current_hit), TRUE))
        {
            return TRUE;
        }
        return FALSE;
    }
}

// check primary classified picture
if(!function_exists('check_primary_classified_picture'))
{
    function check_primary_classified_picture($cid)
    {
        $CI =& get_instance();
        $CI->load->model('classified_medias/classified_media_model', 'classified_media');
        $classified_media = $CI->classified_media->count_by(array('classified_id' => $cid, 'set' => 1));
        if($classified_media == FALSE)
        {
            return FALSE;
        }
        else 
        {
            if($classified_media > 0)
            {
                return TRUE;
            }
        }
        return FALSE;
    }
}

//array insert to array
if(!function_exists('array_insert'))
{
    function array_insert($array, $insert, $position)
    {
        settype($array, "array");
        settype($insert, "array");
        settype($position, "int");

        //if pos is start, just merge them
        if($position==0) {
            $array = array_merge($insert, $array);
        } else {
            //split into head and tail, then merge head+inserted bit+tail
            $head = array_slice($array, 0, $position);
            $tail = array_slice($array, $position);
            $array = array_merge($head, $insert, $tail);
        }
        return $array;
    }
}

// get information from IP Address
if(!function_exists('ip_info'))
{
    /**
     * 
     * @param string $ip
     */
    function ip_info($ip)
    {
        return json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    }
}

/* End of file general_helper.php */
/* Location: ./application/helpers/general_helper.php */