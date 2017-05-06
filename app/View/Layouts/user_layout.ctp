<?php
$login_data=$this->requestAction(array('controller' => 'Handler', 'action' => 'authentication'), array());
?>
<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<meta charset="utf-8">
<title>Watermate</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="" name="description">
<meta content="" name="author">
<?php Configure::write('debug', 0); ?>
 
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css"/>
	<link rel="stylesheet"  href="<?php echo $this->webroot; ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
	<link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/plugins/jquery-validation/demo/css/screen.css">
	
	  <!-- iCheck for checkboxes and radio inputs -->
	   <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/plugins/iCheck/all.css">

  <!-- Font Awesome -->
    <link href="<?php echo $this->webroot; ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Ionicons -->
 <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">-->
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/plugins/select2/select2.min.css">
  <link href="<?php echo $this->webroot; ?>assets/plugins/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/dist/css/skins/_all-skins.min.css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico">
<style>

.self-table > tbody > tr > td, .self-table > tr > td
{
	border-top:none !important;
}

.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
 
    vertical-align:middle !important;
}


</style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      
        <div class="navbar-header">
           <a href="<?php echo $this->webroot; ?>index" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo $this->webroot; ?>images/project_logo/logo.jpg"  style="width:240px; height: 120px; margin-top:-30px; margin-left:-20px;"/></span>
    </a>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
           
           
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <span><?php echo $login_data[0]['user_login']['username']; ?></span>
				</a>
              <ul class="dropdown-menu">
                <!-- Menu Footer-->
               <li>
                  <a href="<?php echo $this->webroot; ?>login" class="btn btn-default btn-flat" style="background-color: #fff;">Log out</a>
              </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
    
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
		 <section class="content">
			<div class="row">
				<?php echo $this->fetch('content'); ?>
			</div>
		 </section>
	</div>
  <!-- /.content-wrapper -->

</div>
<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>



<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->webroot; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $this->webroot; ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>


<script src="<?php echo $this->webroot; ?>assets/plugins/jquery-validation/lib/jquery.js"></script>
<script src="<?php echo $this->webroot; ?>assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script src="<?php echo $this->webroot; ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $this->webroot; ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $this->webroot; ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $this->webroot; ?>assets/plugins/select2/select2.full.min.js"></script>


<script src="<?php echo $this->webroot; ?>assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo $this->webroot; ?>assets/plugins/iCheck/icheck.min.js"></script>

<!-- FastClick -->
<script src="<?php echo $this->webroot; ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->webroot; ?>assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->webroot; ?>assets/dist/js/demo.js"></script>
<script>
$('.select2').select2();
$('.date-picker').datepicker({
      autoclose: true
    });


 $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass: 'iradio_minimal-blue'
});

</script>

 $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass: 'iradio_minimal-blue'
});
</script>
   
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>