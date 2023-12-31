<?php $social_links = json_decode($user_details['social_links'], true); ?>
<?php include "profile_menus.php"; ?>

<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                        <div class="user-box">
                             <?php $userd = $this->user_model->getUserd($this->session->userdata('user_id'));
                                    if($userd->social_login)
                                    {
                                        if(!empty($userd->image))
                                        {
                                            $image = $this->user_model->get_user_image_url($this->session->userdata('user_id'));
                                        }
                                        else
                                        {
                                            $image = $userd->profile_picture;
                                        }
                                    }

                                        ?>
                            <img src="<?php echo $image; ?>" alt="" class="img-fluid">
                            <div class="name">
                                <div class="name"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></div>
                            </div>
                        </div>
                        <?php include 'include_sidebar.php'; ?>
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo site_phrase('profile'); ?></div>
                            <div class="subtitle"><?php echo site_phrase('add_information_about_yourself_to_share_on_your_profile'); ?>.</div>
                        </div>
                        <form action="<?php echo site_url('home/update_profile/update_basics'); ?>" method="post">
                            <div class="content-box">
                                <div class="basic-group d-none">
                                    <div class="form-group">
                                        <label for="FristName"><?php echo site_phrase('basics'); ?>:</label>
                                        <input type="text" class="form-control" name = "first_name" id="FristName" placeholder="<?php echo site_phrase('first_name'); ?>" value="<?php echo $user_details['first_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name = "last_name" placeholder="<?php echo site_phrase('last_name'); ?>" value="<?php echo $user_details['last_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control" name = "phone" placeholder="Phone Number" value="<?php echo $user_details['phone']; ?>">
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-6">
                                            <label>Country</label>
                                            <select class="form-control" name="country" id="country">
                                                <option value="">---Select Country---</option>
                                                <?php foreach($countries as $key => $cnt): ?>
                                                    <option value="<?= $cnt->countries_id ?>" <?= ($cnt->countries_id == $user_details['country'])?"selected":"" ?>><?= $cnt->countries_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                             <label>City</label>
                                             <select name="city" id="state" class="form-control">
                                                 <option value="">---Select City---</option>
                                             </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Biography"><?php echo site_phrase('biography'); ?>:</label>
                                        <textarea class="form-control author-biography-editor" name = "biography" id="Biography"><?php echo $user_details['biography']; ?></textarea>
                                    </div>
                                </div>

                                <div class="link-group">
                                  <?php if($this->session->userdata('is_instructor')): ?>
                                  <div class="form-group">

                                    <label>Skills:</label>
                                             <select name="skills" id="skills" class="form-control">
                                                <option value="">---Select Skills---</option>
                                              <?php foreach($categories as $key => $cat): ?>
                                                <option value="<?= $cat->id ?>" <?= ($user_details['skills'] == $cat->id)?"selected":"" ?>><?= $cat->name ?></option>
                                              <?php endforeach; ?>

                                             </select>
                                            <!--  <input type="text" name="selskills" value="<?= json_decode($user_details['instructor_skills'])?>"> -->

                                  </div>

                                  <div class="form-group" id="selectsubcategory">

                                  </div>
                                <?php endif; ?>



                                    <!-- <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "twitter_link" placeholder="<?php echo site_phrase('twitter_link'); ?>" value="<?php echo $social_links['twitter']; ?>">
                                        <small class="form-text text-muted"><?php echo site_phrase('add_your_twitter_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "facebook_link" placeholder="<?php echo site_phrase('facebook_link'); ?>" value="<?php echo $social_links['facebook']; ?>">
                                        <small class="form-text text-muted"><?php echo site_phrase('add_your_facebook_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "linkedin_link" placeholder="<?php echo site_phrase('linkedin_link'); ?>" value="<?php echo $social_links['linkedin']; ?>">
                                        <small class="form-text text-muted"><?php echo site_phrase('add_your_linkedin_link'); ?>.</small>
                                    </div> -->
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn"><?= site_phrase('save'); ?></button>
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

            countrySelect("<?= $user_details['country']?>","<?= $user_details['city']?>")




            skillsSelect("<?= $user_details['skills']?>","<?= $user_details['instructor_skills'] ?>")
            // alert("<?= $user_details['skills']?>")
            // countrySelect(10)
        })

        function countrySelect(cntid,city)
        {

            if(cntid)
            {
                $.ajax({

          type       : 'GET',
          url        : '<?php echo base_url() ?>fetch-cities/'+cntid,
          dataType   : 'JSON',
           beforeSend: function() {
          $('#state').html('');
      },
          success    : function(result) {

            // console.log(result)


              var select = ''
              if(result.length > 0)
              {


                  select += '<option value="">---Select City---</option>';
                  $.each(result, function(result, val) {

                      select += `<option value="${val['id']}" ${(val['id'] == city)?"selected":""}>${val['city_name']}</option>`;
                  });

                $('#state').html(select);

              }

          },error: function(jqXHR, exception) {
              console.log(jqXHR.responseText);
              console.log('bye');
          }
      })
            }

        }

        function skillsSelect(category, skillArr)
        {

          if(category != '')
          {
            let arra = skillArr.split("-");


              $.ajax({

                  type       : 'POST',
                  url        : '<?php echo site_url() ?>get-sub-child-by-category-id',
                  dataType   : 'JSON',
                  data       : {'cat': category},
                  success    : function(result) {

                          console.log(arra);

                           var select = '';
                          if(result.status == 100)
                          {
                              select += `<label>Sub-category:</label>
                                            <select name="subcat[]" id="subcat" multiple rows="7" class="form-control">
                                            ${result.data.map(val =>
                                            `<option value="${val.id}" ${arra.find(a =>
                                          +a === +val.id
                                        ) ? 'selected' : ""}>${val.name} - ${val.subcat}</option>`
                                              )}
                                            `;

                                    $('#selectsubcategory').html(select);

                          }

                          else if(result.status == 200)
                          {
                              select += ` <label>Sub-category:</label>
                                            <select name="subcat[]" id="subcat" multiple rows="7" class="form-control">`;
                                    $.each(result.data, function(result, val) {

                                        select += `<option value="${val.id}" }>${val.name}</option>`;

                                    });

                                    $('#selectsubcategory').html(select);

                          }
                          else
                          {

                          }




                  },error: function(jqXHR, exception) {
                      console.log(jqXHR.responseText);
                      console.log('bye');
                  }
              })
          }


        }


        $('#country').on('change',function(e){

            e.preventDefault()
            var country = $('#country').val()

            $.ajax({

          type       : 'GET',
          url        : '<?php echo base_url() ?>fetch-cities/'+country,
          dataType   : 'JSON',
           beforeSend: function() {
          $('#state').html('');
      },
          success    : function(result) {

            // console.log(result)

              var select = ''
              if(result.length > 0)
              {

                  select += '<option value="">---Select City---</option>';
                  $.each(result, function(result, val) {

                      select += '<option value="'+val['id']+'">'+val['city_name']+'</option>';
                  });

                $('#state').html(select);

              }

          },error: function(jqXHR, exception) {
              console.log(jqXHR.responseText);
              console.log('bye');
          }
      })
        })

        $('#skills').on('change', function(e){

            var cat = $(this).val();


            $.ajax({

                type       : 'POST',
                url        : '<?php echo site_url() ?>get-sub-child-by-category-id',
                dataType   : 'JSON',
                data       : {'cat': cat},
                success    : function(result) {

                         var select = '';
                        if(result.status == 100)
                        {
                            select += ` <label>Sub-category:</label>
                                          <select name="subcat[]" id="subcat" multiple rows="7" class="form-control">`;
                                  $.each(result.data, function(result, val) {

                                      select += `<option value="${val.id}" }>${val.name} - ${val.subcat}</option>`;

                                  });

                                  $('#selectsubcategory').html(select);

                        }

                        else if(result.status == 200)
                        {
                            select += ` <label>Sub-category:</label>
                                          <select name="subcat[]" id="subcat" multiple rows="7" class="form-control">`;
                                  $.each(result.data, function(result, val) {

                                      select += `<option value="${val.id}" }>${val.name}</option>`;

                                  });

                                  $('#selectsubcategory').html(select);

                        }
                        else
                        {

                        }




                },error: function(jqXHR, exception) {
                    console.log(jqXHR.responseText);
                    console.log('bye');
                }
            })



        })
</script>
