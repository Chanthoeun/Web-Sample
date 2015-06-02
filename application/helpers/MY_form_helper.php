<?php

/**
 * Validation Error String
 *
 * Returns all the errors associated with a form submission.  This is a helper
 * function for the form validation class.
 *
 * @access	public
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('validation_errors'))
{
	function validation_errors($prefix = '', $suffix = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}

		return $OBJ->error_string($prefix, $suffix);
	}
}

/**
 * Redirect form validation (when validate failed)
 * @param array $form_errors 
 * @param array $form_post_data
 * @param string $redirect_page
 */
if (! function_exists('redirect_form_validation')){
    
    function redirect_form_validation($form_errors, $form_post_data, $redirect_page){
       $CI =& get_instance();
       $CI->load->library('session');
       
       $validation_errors = array('errors' => $form_errors, 'post_data' => $form_post_data);

       $CI->session->set_flashdata('validation_errors', $validation_errors);

       redirect($redirect_page, 'refresh');
    }
} 

