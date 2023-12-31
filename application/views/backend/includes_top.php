<?php include 'includes/favicon.php'; ?>
<!-- third party css -->
<link href="<?php echo base_url('assets/backend/css/vendor/jquery-jvectormap-1.2.2.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/dataTables.bootstrap4.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/responsive.bootstrap4.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/buttons.bootstrap4.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/select.bootstrap4.css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/summernote-bs4.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/fullcalendar.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/vendor/dropzone.css'); ?>" rel="stylesheet" type="text/css" />
<!-- third party css end -->
<!-- App css -->
<link href="<?php echo base_url('assets/backend/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url('assets/backend/css/main.css') ?>" rel="stylesheet" type="text/css" />

<!-- font awesome 5 -->
<link href="<?php echo base_url('assets/backend/css/fontawesome-all.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/backend/css/font-awesome-icon-picker/fontawesome-iconpicker.min.css') ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/dsu.css'; ?>">

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="<?php echo base_url('assets/backend/js/jquery-3.3.1.min.js'); ?>" charset="utf-8"></script>
<script src="<?php echo site_url('assets/backend/js/onDomChange.js');?>"></script>

<style>
	.bgcolorset{
		background-color: #203548 !important;
	}

	.bgcolorsetyellow{
		background-color: #DB9508 !important;
	}

	button {
		background-color: #203548 !important;
	}

	button[type=submit],input[type=submit]{
		background-color: #DB9508 !important;	
		border: #DB9508 !important;	
	}

	div.note-btn-group button {
		background-color: #edeff1 !important;
	}

	li.active a{
	background-color: #203548 !important;	
	}

	li a.active{
	background-color: #203548 !important;	
	}

	li.previous  a, li.next  a{
	background-color: #DB9508 !important;	
	border: #DB9508 !important;	
	}

	li.paginate_button:not(.active) a{
	background-color: #edeff1 !important;
	border: #edeff1 !important;	
	}

	ul.metismenu li a.side-nav-link:hover,ul.metismenu li a.side-nav-link.active {
		color: #DB9508 !important;	
		border: #DB9508 !important;	
	}

	li.select2-results__option{
		background-color: white !important;	
	}

	li.select2-results__option:hover {
	   background-color: #203548 !important;	
	}

    a.btn-outline-primary:hover {
    	background-color: #203548 !important;		
    }

    li.nav-item a.active span {
    	color: white;
    }

    div.modal button.close { 
    	background-color: white !important;
    }

    div#basicwizard button.btn-outline-secondary {
    	color: #DB9508 !important;	
    }

</style>
