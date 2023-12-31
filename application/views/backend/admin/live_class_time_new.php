<style type="text/css">
    .field-icon {
      float: right;
      margin-left: -25px;
      margin-top: -25px;
      position: relative;
      z-index: 2;
      padding-right: 15px;
    }
</style>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title">Add Live Class Time</h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo site_phrase('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo site_phrase('wishlists'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo site_phrase('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo site_phrase('purchase_history'); ?></a></li>
                    <li class="active"><a href=""><?php echo site_phrase('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                         <?php 
                         $userd = $this->user_model->getUserd($this->session->userdata('user_id')); 

                                    // if($userd->social_login)
                                    // {
                                       

                                    //     if(!empty($userd->image))
                                    //     {
                                            
                                    //         $image = $this->user_model->get_user_image_url($this->session->userdata('user_id'));
                                    //     }
                                    //     else
                                    //     {

                                    //         $image = $userd->profile_picture;
                                    //     }
                                    // }
                                        ?>
                        <div class="user-box">
                            <img src="<?php //echo $image; ?>" alt="" class="img-fluid">
                            <div class="name"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></div>
                        </div>
                        <?php // include 'include_sidebar.php'; ?>
                        
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title">Add Live Class Time</div>
                            <!-- <div class="subtitle"><?php echo site_phrase('edit_your_account_settings'); ?>.</div> -->
                        </div>
                        <form class="add-live-class-time" method="post">
                            <div class="errorMsg">
                                
                            </div>
                            <div class="content-box">
                                
                                <div class="form-group">
                                    <label>Date *</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Select Time Schedule *</label>
                                    <select class="form-control" name="time[]" required="" multiple="">
                                        <?php foreach($time as $key => $t): ?>
                                            <option value="<?= $t->time_id ?>"><?= date('h:i a',strtotime($t->time_start)) ?> - <?= date('h:i a',strtotime($t->time_end)) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- <div class="form-group row">
                                    
                                    <div class="col-md-6">
                                         <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                         <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" required>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label>Category *</label>
                                    <select class="form-control" name="parent_category" id="category" required="">
                                        <option>---Select Category---</option>
                                        <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat->id?>"><?= $cat->name?></option>

                                        <?php endforeach; ?>

                                    </select>
                                </div>

                                <div class="form-group" id="subcategory">
                                    <label>Sub Category *</label>
                                    <select class="form-control" name="subcategory" id="selsubcategory" required="">
                                        <option>---Select Sub-category---</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn">
                                    <?php echo site_phrase('save'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){

        $('#category').on('change', function(e){

            var cat = $(this).val();

            $.ajax({

                type       : 'POST',
                url        : '<?php echo site_url() ?>get-sub-child-by-category-id',
                dataType   : 'JSON',
                data       : {'cat': cat},
                beforeSend : function(){

                    $('#selsubcategory').html(`<option value="">---Select Sub-category---</option>`)
                },
                success    : function(result) {

                         var select = '';
                        if(result.status == 100)
                        { 
                            select += ` <label>Sub-category:</label>
                                          <select name="subcategory" id="subcat" class="form-control">
                                          <option value="">---Select Sub-category---</option>`;
                                  $.each(result.data, function(result, val) {

                                      select += `<option value="${val.id}" }>${val.name} - ${val.subcat}</option>`;

                                  });

                                  $('#subcategory').html(select);

                        }

                        else if(result.status == 200)
                        { 
                            select += ` <label>Sub-category:</label>
                                          <select name="subcategory" id="subcat" class="form-control">
                                          <option value="">---Select Sub-category---</option>`;
                                  $.each(result.data, function(result, val) {

                                      select += `<option value="${val.id}" }>${val.name}</option>`;

                                  });

                                  $('#subcategory').html(select);

                        }
                        else
                        {

                        }

                }, error: function(jqXHR, exception) {
                    console.log(jqXHR.responseText);
                    console.log('bye');
                }
            })
             
        })

        $('.add-live-class-time').on('submit', function(e){

            e.preventDefault()

            let fd = new FormData(this)

            $.ajax({
                type        : "POST",
                url         : "<?php echo site_url(); ?>instructor/add-live-class-time",
                dataType    : 'json',
                data        : fd,
                processData : false,
                contentType : false,
                success     : function(result) {

                         if(result.status)
                         {
                            window.location.reload()
                         }
                         else
                         {
                            $('.errorMsg').html(`<div class="alert alert-danger">${result.msg}</div>`)

                            setTimeout(function(){ $('.errorMsg').html(''); }, 5000);
                         }

                },error: function(jqXHR, exception) {
                    console.log(jqXHR.responseText);
                    console.log('bye');
                }

            })
        })
    })
</script>
