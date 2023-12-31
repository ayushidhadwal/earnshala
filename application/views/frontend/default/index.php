
<!DOCTYPE html>
<html lang="en">
<head>

	<?php if ($page_name == 'course_page'):
		$title = $this->crud_model->get_course_by_id($course_id)->row_array()?>
		<title><?php echo $title['title'].' | '.get_settings('system_name'); ?></title>
	<?php else: ?>
		<title><?php echo ucwords($page_title).' | '.get_settings('system_name'); ?></title>
	<?php endif; ?>


	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="author" content="<?php echo get_settings('author') ?>" />

	<?php
	$seo_pages = array('course_page');
	if (in_array($page_name, $seo_pages)):
		$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();?>
		<meta name="keywords" content="<?php echo $course_details['meta_keywords']; ?>"/>
		<meta name="description" content="<?php echo $course_details['meta_description']; ?>" />
	<?php else: ?>
		<meta name="keywords" content="<?php echo get_settings('website_keywords'); ?>"/>
		<meta name="description" content="<?php echo get_settings('website_description'); ?>" />
	<?php endif; ?>

	<!--Whatsapp-->
	<meta property="og:title" content="<?php echo get_settings('system_name'); ?>" />
	<meta property="og:url" content="<?php echo site_url(); ?>" />
	<meta property="og:description" content="<?php echo get_settings('website_description'); ?>">
	<meta property="og:image" content="<?= base_url("uploads/system/".get_frontend_settings('banner_image')); ?>">
	<meta property="og:type" content="website" />
	<!--Whatsapp-->

	<!-- <link name="favicon" type="image/x-icon" href="<?php echo base_url('uploads/system/'.get_frontend_settings('favicon')); ?>" rel="shortcut icon" /> -->
	<?php include 'includes_top.php';?>

	<style type="text/css">
		.search::placeholder{
			color:red;
		}
	</style>

</head>
<body class="gray-bg">
	<?php
	if ($this->session->userdata('user_login')) {
		include 'logged_in_header.php';
	}else {
		include 'logged_out_header.php';
	}

	if(get_frontend_settings('cookie_status') == 'active'):
    	include 'eu-cookie.php';
  	endif;
  	
  	if($page_name === null){
  		include $path;
  	}else{
		include $page_name.'.php';
	}
	include 'footer.php';
	include 'includes_bottom.php';
	include 'modal.php';
	include 'common_scripts.php';
	?>
    <script>
    	 $(document).mouseup(function(e)
        {
            var container = $(".dsu-toggle");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.css('display','none');
            }
        });
        $(function () {
            onResize()
            function onResize() {

                    const setNewHeight = $('.dsu-height').outerHeight(true)
                    const setbg = $('.dsu-use-offset').offset().left -5;

                    $('.dsu-bg-percentage').css({background: '#1339BE', width: setbg, height: setNewHeight})
            }
            $(window).resize(function () {
                onResize()
            });

        })

        $(function () {
            let loginToggle = $('.dsu-toggle')
            $('.dsu-hs').click(function () {

                loginToggle.toggle()
            })
        })


         $('.searchbtn').click(function(e){

        e.preventDefault()

        $('#search').prop('required',true)

        var search = $('#search').val()

        if(search !== '')
        {
            window.location.href = "<?= base_url('home/search')?>"+"?query="+search
        }
        else
        {
            $("#search").attr('placeholder',"Please fill this field").addClass('search')
           
            setTimeout(function(){ 
                $("#search").attr('placeholder',"Search for courses").removeClass('search')

            }, 3000);
        }
    })


         // manage language
         $(document).mouseup(function(e)
         {
             $('.ds-onclick-e').click(function (e) {
                 $('.ds-course-sub-menu').toggle()
             })
             var container = $(".ds-course-sub-menu");

             // if the target of the click isn't the container nor a descendant of the container
             if (!container.is(e.target) && container.has(e.target).length === 0)
             {
                 container.css('display','none');
             }
         });
    </script>
</body>
</html>
