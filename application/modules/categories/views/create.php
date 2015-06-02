<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-list"></i> <?php echo $title; ?></h1>
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
                <?php echo lang('form_cagetory_subheading'); ?>
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
                    <?php echo form_open_multipart("categories/store", 'role="form"');?>
                        <div class="form-group">
                            <?php echo lang('form_cagetory_parent_label', 'parent');?> <br />
                            
                            <?php echo $parent;?>
                        </div>
                    
                        <div class="form-group">
                            <?php echo lang('form_cagetory_caption_label', 'caption');?> <br />
                            <?php echo form_input($caption);?>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <?php echo form_checkbox($type).' '.  lang('form_cagetory_type_label');?> 
                            </label>
                        </div>
                    
                        <div class="checkbox">
                            <label>
                                <?php echo form_checkbox($display).' '.  lang('form_cagetory_display_label');?> 
                            </label>
                        </div>
                    
                        <div class="form-group">
                            <?php echo lang('form_cagetory_image_label', 'image');?> <br />
                            <?php echo form_upload($photo);?>
                        </div>
                      
                        <button type="submit" class="btn btn-primary"><?php echo lang('form_cagetory_submit_btn') ?></button>
                        <a href="<?php echo site_url('categories'); ?>" class="btn btn-danger">Cancel</a>
                    <?php echo form_close();?>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


