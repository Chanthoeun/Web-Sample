<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('upload_image'))
{

    function upload_file($field, $type, $filename, $category = NULL, $amz = FALSE)
    {
        $CI =& get_instance();
        $CI->load->library('upload_lib', array('amz' => $amz));
        $CI->load->helper('string');

        // clear config
        $CI->upload_lib->clear();

        // set config
        $CI->upload_lib->set_field($field);
        $CI->upload_lib->set_upload_type($type);
        if(mulit_array($_FILES[$field]) == TRUE)
        {
            foreach ($_FILES[$field]['name'] as $name)
            {
                $arr = explode('.', $name);
                $ext = strtolower(array_pop($arr));
                $newfilename[] = $filename.'-'.random_string('alnum', 10).'.'.$ext;
            }
            $CI->upload_lib->set_file_name($newfilename, $category);
            $uploaded = $CI->upload_lib->multi_upload();
            if($uploaded == FALSE)
            {
                return FALSE;
            }
            else
            {
                return $uploaded;
            }
        }
        else
        {
            $arr = explode('.', $_FILES[$field]['name']);
            $ext = strtolower(array_pop($arr));
            $newfilename = $filename.'-'.random_string('alnum', 10).'.'.$ext;
            $CI->upload_lib->set_file_name($newfilename, $category);
            $uploaded = $CI->upload_lib->upload();
            if($uploaded == FALSE)
            {
                return FALSE;
            }
            else
            {
                return $uploaded;
            }
        }
    }
}


if(! function_exists('print_upload_error'))
{
    function print_upload_error()
    {
        $CI =& get_instance();
        return $CI->upload_lib->print_error();
    }
}

if(!function_exists('check_empty_field'))
{

    function check_empty_field($field)
    {
        if(mulit_array($_FILES[$field]) == TRUE)
        {
            foreach ($_FILES[$field]['name'] as $field_element)
            {
                if($field_element == FALSE)
                {
                    return FALSE;
                }
            }
        }
        else
        {
            if($_FILES[$field]['name'] == FALSE)
            {
                return FALSE;
            }
        }
        return TRUE;
    }
}

if(! function_exists('delete_uploaded_file'))
{

    function delete_uploaded_file($file)
    {
        $CI =& get_instance();
        $CI->load->library('upload_lib');

        $CI->upload_lib->delete_file($file);
    }
}

if(! function_exists('get_uploaded_file'))
{

    function get_uploaded_file($file)
    {
        $CI =& get_instance();
        $CI->load->library('upload_lib');

        return $CI->upload_lib->get_file($file);
    }
}

if(!function_exists('image_thumb'))
{
    /**
     * Get Image on the fly
     * ------------------------------------------------------------
     * @param string $image_path
     * @param int $height
     * @param int $width
     * @param string $alt
     * @return string image
     */
    function image_thumb($image_path, $height, $width, $attribute)
    {
        $CI =& get_instance();
        $CI->load->helper('html');

        $path = pathinfo($image_path);

        // Path to image thumbnail
        $image_thumb = $path['dirname'] . '/' . $path['filename'] . "_" . $height . '_' . $width . "." . $path['extension'];

        if(file_exists($image_thumb))
        {
            list($original_width, $original_height, $file_type, $attr) = getimagesize($image_thumb);
        }
        else
        {
            // LOAD LIBRARY
            $CI->load->library( 'image_lib' );

            $CI->image_lib->clear();

            // CONFIGURE IMAGE LIBRARY
            $config['image_library']    = 'gd2';
            $config['source_image']     = $image_path;
            $config['new_image']        = $image_thumb;
            $config['maintain_ratio']   = TRUE;
            $config['width']            = $width;
            $config['height']           = $height;
            $CI->image_lib->initialize( $config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();

            // get our image attributes
            list($original_width, $original_height, $file_type, $attr) = getimagesize($image_thumb);

//            // set our cropping limits.
//            $crop_x = ($original_width / 2) - ($width / 2);
//            $crop_y = ($original_height / 2) - ($height / 2);
//
//            // initialize our configuration for cropping
//            $config['source_image'] = $image_thumb;
//            $config['new_image'] = $image_thumb;
//            $config['x_axis'] = $crop_x;
//            $config['y_axis'] = $crop_y;
//            $config['maintain_ratio'] = FALSE;
//
//            $CI->image_lib->initialize($config);
//            $CI->image_lib->crop();
//            $CI->image_lib->clear();
        }

        $img_property = array(
            'src' => base_url($image_thumb),
            'width' => $original_width,
            'height' => $original_height
        );

        $all_property = array_merge($img_property, $attribute);

        return img($all_property);
    }
}