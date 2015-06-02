<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo lang('login_heading');?></h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open("auth/login", 'role="form"');?>
                        <fieldset>
                            <div class="form-group">
                                <?php echo form_input($identity);?>
                            </div>
                            <div class="form-group">
                                <?php echo form_input($password);?>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>Remember Me
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-lg btn-success btn-block"');?>
                        </fieldset>
                    <?php echo form_close();?>
                </div>
                <?php if($message != FALSE): ?>
                <div class="panel-footer">
                    
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo $message;?></strong>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>