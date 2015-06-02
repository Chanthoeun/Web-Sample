<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-user"></i> <?php echo $title; ?></h1>
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
                <?php echo lang('index_subheading'); ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php if($message != FALSE){ ?>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong><?php echo $message;?></strong>
                </div>
                <?php } ?>
                <?php if($users != FALSE){ ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th><?php echo lang('index_username_th');?></th>
                                <th><?php echo lang('index_email_th');?></th>
                                <th><?php echo lang('index_groups_th');?></th>
                                <th><?php echo lang('index_status_th');?></th>
                                <th class="col-lg-2 text-center"><?php echo lang('index_action_th');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user):?>
                            <tr>
                                <td class="text-center"><?php echo $user->id;?></td>
                                <td><?php echo $user->username;?></td>
                                <td><?php echo $user->email;?></td>
                                <td>
                                    <?php foreach ($user->groups as $group):?>
                                        <?php 
                                            echo anchor("group/get-form/".$group->id, $group->name);
                                        ?><br />
                                    <?php endforeach?>
                                </td>
                                <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                                <td class="text-center"><?php echo link_edit("auth/edit-user/".$user->id, 'Edit');?> <?php if($user->username != 'administrator'){ echo ' | '.link_delete('auth/del-user/'.$user->id, 'Delete'); } ?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ ?>
                <div class="alert alert-info">No Records in database!</div>
                <?php } ?>
                <p><?php echo link_add('auth/create-user', lang('index_create_user_link'), array('class' => 'btn btn-primary'));?> | <?php echo link_add('groups/get-form', lang('index_create_group_link'), array('class' => 'btn btn-success'));?></p>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>