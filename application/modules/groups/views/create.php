<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-users"></i> <?php echo $title; ?></h1>
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
                <?php echo lang('form_group_subheading'); ?>
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
                    <?php echo form_open("groups/store", 'role="form"');?>
                        <div class="form-group">
                            <?php echo lang('form_group_name_label', 'name');?> <br />
                            <?php echo form_input($name);?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('form_group_desc_label', 'desc');?> <br />
                            <?php echo form_textarea($desc);?>
                        </div>

                        <button type="submit" class="btn btn-primary"><?php echo lang('form_group_submit_btn') ?></button>
                        <a href="<?php echo site_url('groups'); ?>" class="btn btn-danger">Cancel</a>
                    <?php echo form_close();?>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


