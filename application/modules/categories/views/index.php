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
                <?php echo lang('index_cagetory_subheading'); ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if($message != FALSE){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $message;?></strong>
                </div>
                <?php } ?>
                <?php if($categories != FALSE){ ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo lang('index_cagetory_id_th'); ?></th>
                                <th><?php echo lang('index_cagetory_caption_th');?></th>
                                <th><?php echo lang('index_cagetory_slug_th');?></th>
                                <th><?php echo lang('index_cagetory_parent_th');?></th>
                                <th class="text-center"><?php echo lang('index_cagetory_type_th');?></th>
                                <th class="text-center"><?php echo lang('index_cagetory_display_th');?></th>
                                <th class="text-center"><?php echo lang('index_cagetory_status_th');?></th>
                                <th class="text-center"><?php echo lang('index_cagetory_image_th');?></th>
                                <th class="text-center"><?php echo lang('index_cagetory_order_th');?></th>
                                <th class="col-lg-2 text-center"><?php echo lang('index_cagetory_action_th');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category):?>
                            <tr>
                                <td class="text-center"><?php echo $category->id;?></td>
                                <td><?php echo anchor('categories/sub-category/'.$category->id, $category->caption, 'title= "View sub categories"');?></td>
                                <td><?php echo $category->slug;?></td>
                                <td><?php echo $category->p_caption;?></td>
                                <td class="text-center"><?php echo $category->type == 1 ? 'Product' : '';?></td>
                                <td class="text-center"><?php echo $category->display == 1 ? '<i class="fa fa-check text-success"></i> <span class="text-success">Home</span>' : '';?></td>
                                <td class="text-center"><?php echo $category->status == 1 ? anchor('categories/deactivate/'.$category->id, '<i class="fa fa-check fa-lg text-success"> Activated</i>', 'onClick="return confirm(\'Would you like to deactivate this category?\'"') : anchor('categories/activate/'.$category->id, '<i class="fa fa-times fa-lg text-danger"> Deactivated</i>', 'onClick="return confirm(\'Would you like to activate this category?\'"');?></td>
                                <td class="text-center">
                                    <?php 
                                        if($category->photo == FALSE)
                                        {
                                            echo 'None';
                                        }
                                        else
                                        {
                                            $image = get_uploaded_file($category->photo, './assets/uploaded');
                                            echo anchor(base_url($image), 'View Image', 'class="color-box"');
                                        }
                                    ?>
                                </td>
                                <td class="text-center"><?php echo $category->order;?></td>
                                <td class="text-center"><?php echo link_edit("categories/edit/".$category->id, 'Edit', array('title' => 'Edit Category'));?> | <?php echo link_delete('categories/destroy/'.$category->id, 'Delete', 'Would you like to delete this category?'); ?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ ?>
                <div class="alert alert-info">No Records in database!</div>
                <?php } ?>
                <p><?php echo link_add('categories/create', lang('index_cagetory_create_link'), array('class' => 'btn btn-primary'));?></p>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>