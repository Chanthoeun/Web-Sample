<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-filter"></i> <?php echo $title; ?></h1>
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
                <?php echo lang('log_index_subheading_label'); ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if($message != FALSE){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $message;?></strong>
                </div>
                <?php } ?>
                
                <?php echo form_open(current_url(), 'role="form"'); ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php echo lang('log_filter_user_label', 'users');?> <br />
                            <?php echo $users;?>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php echo lang('log_filter_type_label', 'types');?> <br />
                            <?php echo $types;?>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php echo lang('log_filter_date_label', 'create_date');?> <br />
                            <?php echo form_input($create_date);?>
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw fa-lg"></i> <?php echo lang('log_filter_filter_btn') ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                
                <?php if(isset($logs) && $logs != FALSE){ ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="col-lg-1 hidden-xs"><?php echo lang('log_index_id_th'); ?></th>
                                <th><?php echo lang('log_index_who_th'); ?></th>
                                <th class="hidden-xs"><?php echo lang('log_index_description_th'); ?></th>
                                <th><?php echo lang('log_index_user_action_th'); ?></th>
                                <th><?php echo lang('log_index_created_at_th'); ?></th>
                                <th class="col-lg-1"><?php echo lang('log_index_action_th'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="hidden-xs"><?php echo $log->id; ?></td>
                                <td><?php echo $log->who; ?></td>
                                <td class="hidden-xs"><?php echo $log->description; ?></td>
                                <td class="center"><?php echo $log->action; ?></td>
                                <td class="center"><?php echo date('Y-m-d H:s:i A', $log->created_at); ?></td>
                                <td class="center"><?php echo link_delete('system_log/del/'.$log->id, 'Delete', 'Delete Log', 'Do you want to delete this log?'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ ?>
                <div class="alert alert-info">No Records in database!</div>
                <?php } ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>