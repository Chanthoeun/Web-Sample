<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->lang->load('auth');

    }
    
    public function _remap($method, $params = array())
    {   
        $get_method = str_replace('-', '_', $method);
        
        if (method_exists($this, $get_method))
        {
            return call_user_func_array(array($this, $get_method), $params);
        }
        show_404();
    }

    //redirect if needed, otherwise display the user list
    function index()
    {
        parent::check_login();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        //list the users
        $this->data['users'] = $this->ion_auth->users(1)->result();
        foreach ($this->data['users'] as $k => $user)
        {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }
        
        // process template
        $this->data['title'] = $this->lang->line('index_heading');
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/plugins/dataTables.bootstrap.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/plugins/dataTables/jquery.dataTables.js', 
                                        'js/plugins/dataTables/dataTables.bootstrap.js',
                                        'js/sb-admin-2.js'
                                        );
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable();});';
        
        $layout_property['breadcrumb'] = array($this->lang->line('index_heading'));
        
        $layout_property['content']  = 'index';
        
        // menu
        $this->data['account_menu'] = TRUE; $this->data['user_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
    }
    
    // Member
    public function member()
    {
        parent::check_login();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        //list the users
        $this->data['users'] = $this->ion_auth->users(2)->result();
        foreach ($this->data['users'] as $k => $user)
        {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }
        
        // process template
        $this->data['title'] = $this->lang->line('index_heading');
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/plugins/dataTables.bootstrap.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/plugins/dataTables/jquery.dataTables.js', 
                                        'js/plugins/dataTables/dataTables.bootstrap.js',
                                        'js/sb-admin-2.js'
                                        );
        $layout_property['script']  = '$(document).ready(function() {$(\'#dataTables-example\').dataTable();});';
        
        $layout_property['breadcrumb'] = array($this->lang->line('index_heading'));
        
        $layout_property['content']  = 'member';
        
        // menu
        $this->data['account_menu'] = TRUE; $this->data['member_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
    }
    
    //log the user in
    function login(){
        // auto login if remember login user
        if($this->ion_auth->login_remembered_user() == TRUE)
        {
            // log activities
            set_log('Log In');

            //redirect them back to the home page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            if($this->ion_auth->is_admin()){
                redirect('control', 'refresh');
            }else{
                if($this->ion_auth->in_group(2))
                {
                    redirect('memberships/member', 'refresh');
                }
            }
        }
        
        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === TRUE){
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){  
                // log activities
                set_log('Log In');
                
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                if($this->ion_auth->is_admin()){
                    redirect('control', 'refresh');
                }
                else
                {
                    redirect('memberships/member', 'refresh');
                }
            }else{
                //redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }else{
            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                    'id' => 'identity',
                    'type' => 'text',
                    'autocomplete'  => 'off',
                    'class' => 'form-control',
                    'placeholder'   => 'Email Address',
                    'value' => set_value('identity'),
            );
            $this->data['password'] = array('name' => 'password',
                    'id' => 'password',
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder'   => 'Password',
            );


            // process template
            $this->data['title'] = 'Login';
            $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                            'css/sb-admin-2.css'
                                        );
            $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                            'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                            'js/sb-admin-2.js'
                                        );
            $layout_property['content']     = 'login';
            $layout_property['template']    = 'one_col';
            
            generate_template($this->data, $layout_property);
        }
    }

    //log the user out
    function logout()
    {
        $this->data['title'] = "Logout";
        
        // log activities
        set_log('Log Out');
        //log the user out
        if($this->ion_auth->is_admin())
        {
            $this->ion_auth->logout(FALSE);
        }
        else
        {
            $this->ion_auth->logout(FALSE);
        }
        
        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect(site_url(), 'refresh');
    }
    
    function delete_auto_login()
    {
        if(! $this->ion_auth->logged_in())
        {
            redirect('home/login', 'refresh');
        }
        
        if (get_cookie('identity'))
        {
            delete_cookie('identity');
        }
        if (get_cookie('remember_code'))
        {
            delete_cookie('remember_code');
        }
        
        //redirect them back to the home page
        $this->session->set_flashdata('message', 'Auto login was disabled!');
        if($this->ion_auth->is_admin()){
            redirect('control', 'refresh');
        }else{
            if($this->ion_auth->in_group(2))
            {
                redirect('company_member', 'refresh');
            }
            else if($this->ion_auth->in_group(3))
            {
                redirect('personal_member', 'refresh');
            }
            else if($this->ion_auth->in_group(4))
            {
                redirect('expert_member', 'refresh');
            }
        }
    }

    //change password
    function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
        {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                    'name' => 'old',
                    'id'   => 'old',
                    'type' => 'password',
            );
            $this->data['new_password'] = array(
                    'name' => 'new',
                    'id'   => 'new',
                    'type' => 'password',
                    'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id'   => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                    'name'  => 'user_id',
                    'id'    => 'user_id',
                    'type'  => 'hidden',
                    'value' => $user->id,
            );

            //render
            //$this->_render_page('auth/change_password', $this->data);
            $this->template->set_title('Change Password');
            $this->template->set_content('change_password', $this->data);
            $this->template->build('one_col');
        }
        else
        {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                    //if the password was successfully changed
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    $this->logout();
            }
            else
            {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('auth/change_password', 'refresh');
            }
        }
    }

    //forgot password
    function forgot_password()
    {
        $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');
        if ($this->form_validation->run() == false){
            //setup the input
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'class' => 'span12',
                'placeholder' => 'Email'
            );

            if ( $this->config->item('identity', 'ion_auth') == 'username' ){
                $this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
            }else{
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            //$this->_render_page('auth/forgot_password', $this->data);
            // process template
            $this->template->set_title('Forgot Password');
            $this->template->set_content('forgot_password', $this->data);
            $this->template->build('one_col');
        }else{
            // get identity for that email
            $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
            if(empty($identity)) {
                $this->ion_auth->set_message('forgot_password_email_not_found');
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/forgot_password", 'refresh');
            }
                //run the forgotten password method to email an activation code to the user
                $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

                if ($forgotten)
                {
                    //if there were no errors
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
                }
                else
                {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect("auth/forgot_password", 'refresh');
                }
            }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL)
    {
        if (!$code)
        {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user)
        {
            //if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false)
            {
                //display the form

                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                        'name' => 'new',
                        'id'   => 'new',
                'type' => 'password',
                        'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->data['new_password_confirm'] = array(
                        'name' => 'new_confirm',
                        'id'   => 'new_confirm',
                        'type' => 'password',
                        'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->data['user_id'] = array(
                        'name'  => 'user_id',
                        'id'    => 'user_id',
                        'type'  => 'hidden',
                        'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                //render
                $this->template->set_title('Set Passowrd');
                $this->template->set_content('reset_password', $this->data);
                $this->template->build('one_col');
            }
            else
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
                {

                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                }
                else
                {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change)
                    {
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->logout();
                    }
                    else
                    {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        }
        else
        {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //activate the user
    function activate($id, $code=false)
    {
        if ($code !== false)
        {
            $activation = $this->ion_auth->activate($id, $code);
        }
        else if ($this->ion_auth->is_admin())
        {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation)
        {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL){
        parent::check_login();

        $id = $this->config->item('use_mongodb', 'ion_auth') ? (string) $id : (int) $id;

        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE)
        {
            $user = $this->ion_auth->user($id)->row();
            $this->data['user'] = $user;
            
            if($user->username == 'administrator')
            {
                $this->session->set_flashdata('message', $this->lang->line('not_deactivate_administrator_label'));
                redirect('auth', 'refresh');
            }

            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            
            // process template
            $this->data['title'] = $this->lang->line('deactivate_heading');
            $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                            'css/plugins/metisMenu/metisMenu.min.css',
                                            'css/sb-admin-2.css',
                                            'font-awesome-4.1.0/css/font-awesome.min.css'
                                            );
            $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                            'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                            'js/plugins/metisMenu/metisMenu.min.js',
                                            'js/sb-admin-2.js'
                                            );

            $layout_property['breadcrumb'] = array('auth' => $this->lang->line('index_heading'), $this->lang->line('deactivate_heading'));

            $layout_property['content']  = 'deactivate_user';

            // menu
            $this->data['account_menu'] = TRUE; $this->data['user_menu'] = TRUE;
            generate_template($this->data, $layout_property); 
        }
        else
        {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes')
            {
                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
                {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    //create a new user
    function create_user()
    {
        parent::check_login();        
        //validate form input
        $this->form_validation->set_rules('username', $this->lang->line('create_user_validation_username_label'), 'trim|required|is_unique[users.username]|xss_clean', array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[users.email]|xss_clean', array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'trim|required');


        if ($this->form_validation->run() == TRUE)
        {
            $username = strtolower(trim($this->input->post('username')));
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'active'    => 1,
            );
            if ($this->ion_auth->register($username, $password, $email, $additional_data,array(1))){
                // set log
                set_log('Create User', array($username,$email,$password,'Admin',1));

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        }
        
        //display the create user form
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['username'] = array(
            'name'  => 'username',
            'id'    => 'username',
            'type'  => 'text',
            'class' => 'form-control',
            'autocomplete' => 'off',
            'value' => $this->form_validation->set_value('username'),
        );
        $this->data['email'] = array(
            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'email',
            'class' => 'form-control',
            'autocomplete' => 'off',
            'value' => $this->form_validation->set_value('email'),
        );
        $pword = random_password(8, 8, FALSE, TRUE);
        $this->data['password'] = array(
            'name'  => 'password',
            'id'    => 'password',
            'type'  => 'text',
            'class' => 'form-control',
            'autocomplete' => 'off',
            'value' => $this->form_validation->set_value('password', $pword),
        );
        $this->data['password_confirm'] = array(
            'name'  => 'password_confirm',
            'id'    => 'password_confirm',
            'type'  => 'text',
            'class' => 'form-control',
            'autocomplete' => 'off',
            'value' => $this->form_validation->set_value('password_confirm', $pword),
        );

        // process template
        $this->data['title'] = $this->lang->line('create_user_heading');
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/sb-admin-2.js'
                                        );

        $layout_property['breadcrumb'] = array('auth' => $this->lang->line('index_heading'), $this->lang->line('create_user_heading'));

        $layout_property['content']  = 'create_user';

        // menu
        $this->data['account_menu'] = TRUE; $this->data['user_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
    }

    //edit a user
    function edit_user($id)
    {
        parent::check_login();

        $user = $this->ion_auth->user($id)->row();
        $user_groups = $this->ion_auth->get_users_groups($user->id)->row();
               
        //validate form input
        if($user->username != 'administrator')
        {
            $this->form_validation->set_rules('username', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        }
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required|valid_email|xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            if($user->username != 'administrator')
            {
                $data['username'] = $this->input->post('username');
            }
            
            $data['email'] = $this->input->post('email');
            
            //update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $this->input->post('password');
            }

            if ($this->form_validation->run() === TRUE)
            {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");
                
                // set log
                array_unshift($data, $user->id);
                set_log('Updated User', $data);
                
                if($user_groups->id == 1)
                {
                    redirect("auth", 'refresh');
                }
                else if($user_groups->id == 2)
                {
                    redirect("auth/member", 'refresh');
                }
            }
        }

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;
        if($user->username != 'administrator')
        {
            $this->data['username'] = array(
                    'name'  => 'username',
                    'id'    => 'username',
                    'type'  => 'text',
                    'class' => 'form-control',
                    'autocomplete' => 'off',
                    'value' => $this->form_validation->set_value('username', $user->username),
            );
        }
        $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'email',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'value' => $this->form_validation->set_value('email', $user->email),
        );

        $this->data['password'] = array(
                'name' => 'password',
                'id'   => 'password',
                'type' => 'password',
                'autocomplete' => 'off',
                'class' => 'form-control',
        );
        $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id'   => 'password_confirm',
                'type' => 'password',
                'autocomplete' => 'off',
                'class' => 'form-control',
        );

        // set log before update
        set_log('View Update User', $user);
        
        // process template
        $this->data['title'] = $this->lang->line('edit_user_heading');
        $layout_property['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' => FALSE,
                                        'css/plugins/metisMenu/metisMenu.min.css',
                                        'css/sb-admin-2.css',
                                        'font-awesome-4.1.0/css/font-awesome.min.css'
                                        );
        $layout_property['js']  = array('https://code.jquery.com/jquery-1.11.1.min.js' => FALSE,
                                        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' => FALSE,
                                        'js/plugins/metisMenu/metisMenu.min.js',
                                        'js/sb-admin-2.js'
                                        );

        $layout_property['breadcrumb'] = array('auth' => $this->lang->line('index_heading'), $this->lang->line('edit_user_heading'));

        $layout_property['content']  = 'edit_user';

        // menu
        $this->data['account_menu'] = TRUE; $this->data['user_menu'] = TRUE;
        generate_template($this->data, $layout_property); 
    }

    // Delete user
    function del_user($id, $redirect = FALSE){
        parent::check_login();
        
        $user = $this->ion_auth->user($id)->row();
        if($user->username == 'administrator')
        {
            $this->session->set_flashdata('message', $this->lang->line('not_del_user_administrator_label'));
            redirect('auth', 'refresh');
        }
        
        $delete_user = $this->ion_auth->delete_user($id);

        if(!$delete_user){
            // set log
            set_log('Delete User', $user);
            
            if($redirect == FALSE)
            {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('auth','refresh');
            }
        }else{
            if($redirect == FALSE)
            {
                $this->session->set_flashdata('message', $this->lang->line('del_user_successed'));
                redirect('auth','refresh');
            }
        }
    }

}
