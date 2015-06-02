<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a <?php echo isset($dashboad_menu) ? 'class="active"' : ''; ?> href="<?php echo home_url(); ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li <?php echo isset($account_menu) ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-user fa-fw"></i> Account<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php echo isset($user_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('auth'); ?>"><i class="fa fa-user"></i> Users</a>
                    </li>
                    
                    <li>
                        <a <?php echo isset($group_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('groups'); ?>"><i class="fa fa-users"></i> Group</a>
                    </li>
                    
                    <li>
                        <a <?php echo isset($member_type_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('member_type'); ?>"><i class="fa fa-users"></i> Member Types</a>
                    </li>
                    
                    <li <?php echo isset($membership_group_menu) ? 'class="active"' : ''; ?>>
                        <a href="#"><i class="fa fa-user fa-fw"></i> Memberships <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a <?php echo isset($company_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('memberships'); ?>"><i class="fa fa-user"></i> Companies</a>
                            </li>
                            <li>
                                <a <?php echo isset($personal_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('memberships/personal'); ?>"><i class="fa fa-user"></i> Personals</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li <?php echo isset($setting_menu) ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-cog fa-fw"></i> Setting<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php echo isset($location_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('locations'); ?>"><i class="fa fa-map-marker fa-fw"></i> Locations</a>
                    </li>
                    <li>
                        <a <?php echo isset($category_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('categories'); ?>"><i class="fa fa-list fa-fw"></i> Categories</a>
                    </li>
                    <li>
                        <a <?php echo isset($duration_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('duration'); ?>"><i class="fa fa-calendar fa-fw"></i> Duration</a>
                    </li>
                    <li>
                        <a <?php echo isset($billing_system_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('billing_system'); ?>"><i class="fa fa-money fa-fw"></i> Billing System</a>
                    </li>
                    <li>
                        <a <?php echo isset($system_log_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('system_log'); ?>"><i class="fa fa-wrench"></i> System Logs</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li <?php echo isset($article_group_menu) ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-book fa-fw"></i> Articles<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li <?php echo isset($article_menu) ? 'class="active"' : ''; ?>>
                        <a href="#"><i class="fa fa-book fa-fw"></i> Articles <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a <?php echo isset($create_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('articles/create'); ?>"><i class="fa fa-book"></i> Create</a>
                            </li>
                            <li>
                                <a <?php echo isset($recently_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('articles'); ?>"><i class="fa fa-book"></i> Recently Posted</a>
                            </li>
                            <li>
                                <a <?php echo isset($search_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('articles/search'); ?>"><i class="fa fa-search"></i> Search</a>
                            </li>
                            <li>
                                <a <?php echo isset($filter_type_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('articles/filter-by_type'); ?>"><i class="fa fa-filter"></i> Filter by Article Type</a>
                            </li>
                            <li>
                                <a <?php echo isset($filter_category_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('articles/filter-by-category'); ?>"><i class="fa fa-filter"></i> Filter by Category</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a <?php echo isset($article_type_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('article_types'); ?>"><i class="fa fa-list fa-fw"></i> Article Types</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li <?php echo isset($classify_group_menu) ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Classifieds<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php echo isset($classify_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('classifieds'); ?>"><i class="fa fa-shopping-cart fa-fw"></i> Classifieds</a>
                    </li>
                    <li>
                        <a <?php echo isset($product_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('classifieds/products'); ?>"><i class="fa fa-shopping-cart fa-fw"></i> Products</a>
                    </li>
                    <li>
                        <a <?php echo isset($real_estate_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('classifieds/real-estates'); ?>"><i class="fa fa-building fa-fw"></i> Real Estates</a>
                    </li>
                    <li>
                        <a <?php echo isset($classify_search_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('classifieds/search'); ?>"><i class="fa fa-search fa-fw"></i> Search</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            
            <li <?php echo isset($advertising_group_menu) ? 'class="active"' : ''; ?>>
                <a href="#"><i class="fa fa-rss fa-fw"></i> Advertising<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a <?php echo isset($advertising_create_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising/get-form'); ?>"><i class="fa fa-rss fa-fw"></i> Create Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($advertising_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising'); ?>"><i class="fa fa-rss fa-fw"></i> Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($advertising_expired_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising/expired'); ?>"><i class="fa fa-rss fa-fw"></i> Expired Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($advertising_will_expire_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising/will-expire'); ?>"><i class="fa fa-rss fa-fw"></i> Will Expire Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($advertising_paid_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising/paid'); ?>"><i class="fa fa-rss fa-fw"></i> Paid Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($advertising_unpaid_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising/unpaid'); ?>"><i class="fa fa-rss fa-fw"></i> Unpaid Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($advertising_deactivated_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('advertising/deactivated'); ?>"><i class="fa fa-rss fa-fw"></i> Deactivated Advertising</a>
                    </li>
                    <li>
                        <a <?php echo isset($page_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('page'); ?>"><i class="fa fa-copy fa-fw"></i> Page</a>
                    </li>
                    <li>
                        <a <?php echo isset($layout_menu) ? 'class="active"' : ''; ?> href="<?php echo site_url('layout'); ?>"><i class="fa fa-file fa-fw"></i> Layout</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="<?php echo site_url(); ?>" target="_blank"><i class="fa fa-eye"></i> Visit Site</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->