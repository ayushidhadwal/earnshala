<div class="user-dashboard-menu">
    <ul>
        <li class="<?= ($this->uri->segment(3) === "user_profile")?'active':'' ?>"><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo site_phrase('profile'); ?></a></li>
        <?php if(!$userd->social_login){ ?>
        <li class="<?= ($this->uri->segment(3) === "user_credentials")?'active':'' ?>"><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo site_phrase('account'); ?></a></li>
    <?php } ?>
        <li class="<?= ($this->uri->segment(3) === "user_photo")?'active':'' ?>"><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo site_phrase('photo'); ?></a></li>
          <?php if($this->session->userdata('is_instructor')): ?>
            <li><a href="<?php echo site_url('user'); ?>">Instructor</a></li>
            <li class="<?= ($this->uri->segment(2) === "live-class-time")?'active':'' ?>"><a href="<?= base_url('instructor/live-class-time')?>">Live Course Time</a></li>
            <li class="<?= ($this->uri->segment(1) === "live-class-time-list")?'active':'' ?>"><a href="<?= base_url('instructor/live-class-time-list')?>">Live Course Time List</a></li>
        <?php endif; ?>
    </ul>
</div>