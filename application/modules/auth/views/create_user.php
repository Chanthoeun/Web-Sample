<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title; ?></h1>
    </div>
    <!-- /.col-lg-12 -->
    <div class="col-lg-12">
        <?php echo view_breadcrumb(); ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo lang('create_user_subheading'); ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if($message != FALSE){ ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $message;?></strong>
                </div>
                <?php } ?>
                <div class="col-lg-4">
                    <?php echo form_open("auth/create_user", 'role="form"');?>
                        <div class="form-group">
                            <?php echo lang('create_user_username_label', 'username');?> <br />
                            <?php echo form_input($username);?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_email_label', 'email');?> <br />
                            <?php echo form_input($email);?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_password_label', 'password');?> <br />
                            <?php echo form_input($password);?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                            <?php echo form_input($password_confirm);?>
                        </div>

                        <button type="submit" class="btn btn-primary"><?php echo lang('create_user_submit_btn') ?></button>
                        <a href="<?php echo site_url('auth'); ?>" class="btn btn-danger">Cancel</a>
                    <?php echo form_close();?>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


