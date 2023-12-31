<?php
$status_wise_courses = $this->crud_model->get_status_wise_courses();
?>
<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached bgcolorset" >
	<div class="leftbar-user">
		<a href="javascript: void(0);">
			<img src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="user-image" height="42" class="rounded-circle shadow-sm">
			<?php
			$admin_details = $this->user_model->get_all_user($this->session->userdata('user_id'))->row_array();
			?>
			<span class="leftbar-user-name"><?php echo $admin_details['first_name'].' '.$admin_details['last_name']; ?></span>
		</a>
	</div>
	<!--- Sidemenu -->
	<ul class="metismenu side-nav side-nav-light">

		<li class="side-nav-title side-nav-item"><?php echo get_phrase('navigation'); ?></li>

		<li class="side-nav-item <?php if ($page_name == 'dashboard')echo 'active';?>">
			<a href="<?php echo site_url('admin/dashboard'); ?>" class="side-nav-link">
				<i class="dripicons-view-apps"></i>
				<span><?php echo get_phrase('dashboard'); ?></span>
			</a>
		</li>

        <?php $permission_check = get_permission_status('category'); if ($permission_check) : ?>
            <li class="side-nav-item <?php if ($page_name == 'categories' || $page_name == 'category_add' || $page_name == 'category_edit' ): ?> active <?php endif; ?>">
                <a href="javascript: void(0);" class="side-nav-link <?php if ($page_name == 'categories' || $page_name == 'category_add' || $page_name == 'category_edit' ): ?> active <?php endif; ?>">
                    <i class="dripicons-network-1"></i>
                    <span> <?php echo get_phrase('categories'); ?> </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li class = "<?php if($page_name == 'categories' || $page_name == 'category_edit') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/categories'); ?>"><?php echo get_phrase('categories'); ?></a>
                    </li>

                    <li class = "<?php if($page_name == 'category_add') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/category_form/add_category'); ?>"><?php echo get_phrase('add_new_category'); ?></a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <?php $permission_check = get_permission_status('banner'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/banner'); ?>" class="side-nav-link <?php if ($page_name == 'banner')echo 'active';?>">
                    <i class="fa fa-images"></i>
                    <span>Banners</span>
                </a>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('course'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/courses'); ?>" class="side-nav-link <?php if ($page_name == 'courses' || $page_name == 'course_add' || $page_name == 'course_edit')echo 'active';?>">
                    <i class="dripicons-archive"></i>
                    <span><?php echo get_phrase('courses'); ?></span>
                </a>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('quiz'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/quiz_cat'); ?>" class="side-nav-link <?php if ($page_name == 'quiz_page' || $page_name == 'quiz_add_page' || $page_name == 'quiz_edit_page')echo 'active';?>">
                    <i class="dripicons-archive"></i>
                    <span><?php echo get_phrase('quiz'); ?></span>
                </a>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('forum'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/forum'); ?>" class="side-nav-link <?php if ($page_name == 'forum' )echo 'active';?>">
                    <i class="dripicons-user-group"></i>
                    <span><?php echo get_phrase('forum'); ?></span>
                </a>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('coupon'); if ($permission_check) : ?>
            <li class="side-nav-item <?php if ($page_name == 'admins' || $page_name == 'admin_add' || $page_name == 'admin_edit' || $page_name == 'admin_permission'): ?> active <?php endif; ?>">
                <a href="javascript: void(0);" class="side-nav-link <?php if ($page_name == 'admins' || $page_name == 'admin_add' || $page_name == 'admin_edit' || $page_name == 'admin_permission'): ?> active <?php endif; ?>">
                    <i class="mdi mdi-incognito"></i>
                    <span> <?php echo get_phrase('coupon'); ?>  </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li class = "<?php if($page_name == 'admins' || $page_name == 'admin_add' || $page_name == 'admin_edit' || $page_name == 'admin_permission') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/coupons'); ?>" class="<?php if ($page_name == 'admins' || $page_name == 'admin_edit' || $page_name == 'admin_permission') : ?> active <?php endif; ?>"><?php echo get_phrase('manage_coupons'); ?></a>
                    </li>
                    <li class = "<?php if ($page_name == 'admin_add') echo 'active'; ?>">   <a href="<?php echo site_url('admin/coupon_add'); ?>"><?php echo get_phrase('add_new_coupon'); ?></a>
                    </li>
                </ul>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('admin'); if ($permission_check) : ?>
            <li class="side-nav-item <?php if ($page_name == 'admins' || $page_name == 'admin_add' || $page_name == 'admin_edit' || $page_name == 'admin_permission'): ?> active <?php endif; ?>">
                <a href="javascript: void(0);" class="side-nav-link <?php if ($page_name == 'admins' || $page_name == 'admin_add' || $page_name == 'admin_edit' || $page_name == 'admin_permission'): ?> active <?php endif; ?>">
                    <i class="mdi mdi-incognito"></i>
                    <span> <?php echo get_phrase('admins'); ?> </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li class = "<?php if($page_name == 'admins' || $page_name == 'admin_add' || $page_name == 'admin_edit' || $page_name == 'admin_permission') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/admins'); ?>" class="<?php if ($page_name == 'admins' || $page_name == 'admin_edit' || $page_name == 'admin_permission') : ?> active <?php endif; ?>"><?php echo get_phrase('manage_admins'); ?></a>
                    </li>
                    <li class = "<?php if ($page_name == 'admin_add') echo 'active'; ?>">	<a href="<?php echo site_url('admin/admin_form/add_admin_form'); ?>"><?php echo get_phrase('add_new_admin'); ?></a>
                    </li>
                </ul>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('instructor'); if ($permission_check) : ?>
            <li class="side-nav-item <?php if ($page_name == 'instructors' || $page_name == 'instructor_add' || $page_name == 'instructor_edit'): ?> active <?php endif; ?>">
                <a href="javascript: void(0);" class="side-nav-link <?php if ($page_name == 'instructors' || $page_name == 'instructor_add' || $page_name == 'instructor_edit'): ?> active <?php endif; ?>">
                    <i class="mdi mdi-incognito"></i>
                    <span> <?php echo get_phrase('instructors'); ?> </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li class = "<?php if($page_name == 'instructors' || $page_name == 'instructor_add' || $page_name == 'instructor_edit') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/instructors'); ?>"><?php echo get_phrase('instructor_list'); ?></a>
                    </li>

                    <li class = "<?php if($page_name == 'instructor_payout') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/instructor_payout'); ?>">
                            <?php echo get_phrase('instructor_payout'); ?>
                        </a>
                    </li>

                    <li class = "<?php if($page_name == 'instructor_settings') echo 'active'; ?>">
                        <a href="<?php echo site_url('admin/instructor_settings'); ?>"><?php echo get_phrase('instructor_settings'); ?></a>
                    </li>
                </ul>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('student'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/users'); ?>" class="side-nav-link <?php if ($page_name == 'users' || $page_name == 'user_add' || $page_name == 'user_edit')echo 'active';?>">
                    <i class="dripicons-user-group"></i>
                    <span><?php echo get_phrase('students'); ?></span>
                </a>
            </li>
        <?php endif ?>


        <?php $permission_check = get_permission_status('live'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/live_class'); ?>" class="side-nav-link <?php if ($page_name == 'live_class' ) echo 'active';?>">
                    <i class="dripicons-user-group"></i>
                    <span><?php echo get_phrase('live_class'); ?></span>
                </a>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('revenue'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="javascript: void(0);" class="side-nav-link <?php if ($page_name == 'admin_revenue' || $page_name == 'instructor_revenue' || $page_name == 'invoice'): ?> active <?php endif; ?>">
                    <i class="dripicons-box"></i>
                    <span> <?php echo get_phrase('report'); ?> </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="side-nav-second-level" aria-expanded="false">
                    <li class = "<?php if($page_name == 'admin_revenue') echo 'active'; ?>" > <a href="<?php echo site_url('admin/admin_revenue'); ?>"><?php echo get_phrase('admin_revenue'); ?></a> </li>
                    <li class = "<?php if($page_name == 'admin_revenue_partial_course') echo 'active'; ?>" > <a href="<?php echo site_url('admin/admin_revenue_partial_course'); ?>"><?php echo get_phrase('partial_course_revenue'); ?></a> </li>
                    <?php if (get_settings('allow_instructor') == 1): ?>
                        <li class = "<?php if($page_name == 'instructor_revenue') echo 'active'; ?>" >
                            <a href="<?php echo site_url('admin/instructor_revenue'); ?>">
                                <?php echo get_phrase('instructor_revenue');?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class = "<?php if($page_name == 'courses_enrolled') echo 'active'; ?>" > <a href="<?php echo site_url('admin/courses_enrolled'); ?>"><?php echo get_phrase('courses'); ?></a> </li>
                </ul>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('incomplete_orders'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/uncomplete_orders/""/""'); ?>" class="side-nav-link <?php if ($page_name == 'uncomplete_orders' ) echo 'active';?>">
                    <i class="dripicons-user-group"></i>
                    <span><?php echo get_phrase('incomplete_orders'); ?></span>
                </a>
            </li>
        <?php endif ?>
        <?php $permission_check = get_permission_status('user_clicks'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/user_clicks'); ?>" class="side-nav-link <?php if ($page_name == 'user_clicks' )echo 'active';?>">
                    <i class="dripicons-user-group"></i>
                    <span><?php echo get_phrase('user_course_clicks'); ?></span>
                </a>
            </li>
        <?php endif ?>
        <?php $permission_check = get_permission_status('social_links'); if ($permission_check) : ?>
            <li class="side-nav-item">
                <a href="<?php echo site_url('admin/social_links'); ?>" class="side-nav-link <?php if ($page_name == 'social_links' )echo 'active';?>">
                    <i class="dripicons-user-group"></i>
                    <span><?php echo get_phrase('social_links'); ?></span>
                </a>
            </li>
        <?php endif ?>

        <?php $permission_check = get_permission_status('settings'); if ($permission_check) : ?>
            <li class="side-nav-item <?php if ($page_name == 'manage_profile')echo 'active';?>">
                <a href="<?php echo site_url(strtolower($this->session->userdata('role')).'/manage_profile'); ?>" class="side-nav-link">
                    <i class="dripicons-user"></i>
                    <span><?php echo get_phrase('manage_profile'); ?></span>
                </a>
            </li>
        <?php endif; ?>
	</ul>
</div>
