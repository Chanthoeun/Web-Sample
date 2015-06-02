<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Upload_lib
 *
 * @author Chanthoeun
 */
class Upload_lib {
    //put your code here
    public $CI;
    
    private $field = NULL;
    private $file_type = NULL;
    private $upload_type = NULL;
    private $path = NULL;
    private $file_name = array();
    private $quality = 100;
    private $max_size = 0;
    private $upload_error = NULL;
    private $uploded_info = array();
    
    // Amazon S3
    private $amz = FALSE;
    private $amz_path = '';
    private $amz_bucket = '';


    public function __construct($config = array()) 
    {
        $this->CI =& get_instance();
        $this->CI->load->library('upload');
        $this->CI->load->library('image_lib');
        $this->CI->load->config('upload');
        
        //load helper
        $this->CI->load->helper('url');
        
        // set upload path
        $this->path = $this->CI->config->item('upload_path');
        
        if(!empty($config))
        {
            $this->initialize($config);
        }
    }
    
    public function initialize($config = array())
    {
        $defaults = array(
            'quality'   => 100,
            'max_size'  => 0,
            'amz'       => FALSE,
            'amz_path'  => "",
            'amz_bucket'=> ""
        );
        foreach ($defaults as $key => $val)
        {
            if(isset($config[$key]))
            {
                $method = 'set_'.$key;
                if(method_exists($this, $method))
                {
                    $this->$method($config[$key]);
                }
                else
                {
                    $this->$key = $config[$key];
                }
            }
            else
            {
                $this->$key = $val;
            }
        }
    }
    
    function set_amz($amz)
    {
        $this->amz = $amz;
    }

    function set_amz_path($path)
    {
        $this->amz_path = $path;
    }
    
    function set_amz_bucket($bucket)
    {
        $this->amz_bucket = $bucket;
    }
    
    
    public function set_field($field)
    {
        $this->field = $field;
    }
    
    public function set_upload_type($upload_type = NULL)
    {
        if($upload_type == 'image')
        {
            $this->file_type = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif';
        }
        else if($upload_type == 'document')
        {
            $this->file_type = 'pdf|doc|docx|xls|xlsx|zip|tar|tgz';
        }
        else if($upload_type == 'audio')
        {
            $this->file_type = 'mid|midi|mpga|mp3|ram|rpm|wav';
        }
        else
        {
            $this->file_type = 'jpg|png|gif|bmp|jpeg|jpe|tiff|tif|doc|docx|xls|xlsx|pdf|zip|tar|tgz|mid|midi|mpga|mp3|ram|rpm|wav';
        }
        
        $this->upload_type = $upload_type;
    }
    
    
    public function clear()
    {
        $this->field        = NULL;
        $this->file_type    = NULL;
        $this->upload_type  = NULL;
        $this->file_name    = array();
        $this->quality      = 100;
        $this->max_size     = 0;
        $this->upload_error = NULL;
        $this->uploded_info = array();
    }


    public function set_file_name($file_name, $category = NULL)
    {
        if(is_array($file_name))
        {
            foreach ($file_name as $name)
            {
                $name = (string) url_title($name, '-', TRUE);
                $this->file_name[] = $category == NULL ? $name : $category.'-'.$name;
            }
        }
        else
        {
            $file_name = (string) url_title($file_name, '-', TRUE);
            $this->file_name = $category == NULL ? $file_name : $category.'-'.$file_name;
        }
    } 

    /**
     * Upload file 
     * --------------------------------------------------------------------------------------------------------------------------------------------------------
     * @param boolean $rename if true it will rename to new name;
     * @param int $resize this option work with image. if it's not false it will set width to image Example $resize = 120 it will set width of image to 120 px.
     * @param boolean $thumb if it true it will create folder thumb and create new image insite folder thumb and set width of image to resize value
     * @return string if upload success or array if not success
     */
    public function upload($rename = TRUE)
    {
        // set upload information to null
        $this->uploded_info = NULL;
        
        $config = array(
            'upload_path'   => $this->upload_type == NULL ? $this->path : $this->path.'/'.$this->upload_type,
            'allowed_types' => $this->file_type,
            'quality'       => $this->quality,
            'max_size'      => $this->max_size,
            'remove_spaces' => TRUE
        );
        
        if($rename == TRUE)
        {
            $config['file_name'] = url_title($this->file_name, '-', TRUE);
        }
        
        $this->CI->upload->initialize($config);
        
        if ( ! $this->CI->upload->do_upload($this->field))
        {
            $this->upload_error = $this->CI->upload->display_errors();
            return FALSE;
        }
        else
        {
            // upload information
            $this->uploded_info = $this->CI->upload->data();
            
            // upload to amazon service
            if($this->amz == TRUE)
            {
                $this->amazon_upload($this->uploded_info['full_path'],  $this->uploded_info['file_name']);
            }
            return $this->uploded_info['file_name'];
        }
    }
    
    
    public function multi_upload($rename = TRUE)
    {
        
        // set upload information to null
        $this->uploded_info = NULL;
        //set upload 
        $config = array(
            'upload_path'   => $this->upload_type == NULL ? $this->path : $this->path.'/'.$this->upload_type,
            'allowed_types' => $this->file_type,
            'quality'       => $this->quality,
            'max_size'      => $this->max_size,
            'remove_spaces' => TRUE
        );
        
        if($rename == TRUE)
        {
            $config['file_name'] = $this->file_name;
        }
        
        $this->CI->upload->initialize($config);
        
        if ( ! $this->CI->upload->do_multi_upload($this->field))
        {
            $this->upload_error = $this->CI->upload->display_errors();
            return FALSE;
        }
        else
        {            
            $this->uploded_info = $this->CI->upload->get_multi_upload_data();
            foreach ($this->uploded_info as $info)
            {
                $file_name[] = $info['file_name'];
                // upload to amazon service
                if($this->amz == TRUE)
                {
                    $this->amazon_upload($info['full_path'],  $info['file_name']);
                }
            }
            return $file_name;
        }
    }
    
    public function print_error()
    {
        return $this->upload_error;
    }
    
    public function amazon_upload($file, $name)
    {
        $this->CI->load->library('s3');
        $input = $this->CI->s3->inputFile($file);
        if($this->CI->s3->putObject($input,$this->amz_bucket,$name))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function delete_file($file)
    {
        $image = array('jpg', 'png', 'gif', 'bmp', 'jpeg', 'jpe', 'tiff', 'tif');
        $document = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'zip', 'tar', 'tgz');
        $audio = array('mid', 'midi', 'mpga', 'mp3', 'ram', 'rpm', 'wav');
        
        $arr = explode('.', $file);
        $filename = strtolower(array_shift($arr));
        $file_ext = strtolower(array_pop($arr));
        
        if(in_array($file_ext, $image))
        {
            foreach (glob("{$this->path}/image/{$filename}*.*") as $fn)
            {
                unlink($fn);
            }
        }
        else if(in_array($file_ext, $document))
        {
            foreach (glob("{$this->path}/document/{$filename}*.*") as $fn)
            {
                unlink($fn);
            }
        }
        else if(in_array($file_ext, $audio))
        {
            foreach (glob("{$this->path}/audio/{$filename}*.*") as $fn)
            {
                unlink($fn);
            }
        }
        else
        {
            foreach (glob("{$this->path}/{$filename}*.*") as $fn)
            {
                unlink($fn);
            }
        }
        
        // delete from amazon service
        if($this->amz == TRUE)
        {
            $this->CI->load->library('s3');
            $this->CI->s3->deleteObject($this->amz_bucket,$file);
        }
    }
    
    public function get_file($file)
    {
        $image = array('jpg', 'png', 'gif', 'bmp', 'jpeg', 'jpe', 'tiff', 'tif');
        $document = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'zip', 'tar', 'tgz');
        $audio = array('mid', 'midi', 'mpga', 'mp3', 'ram', 'rpm', 'wav');
        $arr = explode('.', $file);
        $file_ext = strtolower(array_pop($arr));
        
        if(in_array($file_ext, $image))
        {
            if(file_exists($this->path.'/image/'.$file))
            {
                return $this->path.'/image/'.$file;
            }
            else
            {
                return file_exists($this->path.'/'.$file) ? $this->path.'/'.$file : FALSE ;
            }
        }
        else if(in_array($file_ext, $document))
        {
            if(file_exists($this->path.'/document/'.$file))
            {
                return $this->path.'/document/'.$file;
            }
            else
            {
                return file_exists($this->path.'/'.$file) ? $this->path.'/'.$file : FALSE;
            }
        }
        else if(in_array($file_ext, $audio))
        {
            if(file_exists($this->path.'/audio/'.$file))
            {
                return $this->path.'/audio/'.$file;
            }
            else
            {
                return file_exists($this->path.'/'.$file) ? $this->path.'/'.$file : FALSE;
            }
        }
        
        // delete from amazon service
        if($this->amz == TRUE)
        {
            return $this->amz_path.$file;
        }
    }
}
