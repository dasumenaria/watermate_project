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
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- BEGIN HEADER -->
 <div id="wrapper">
<header class="main-header no-print">
    <!-- Logo -->
    <a href="<?php echo $this->webroot; ?>index" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo $this->webroot; ?>images/project_logo/logo.jpg"  style="width:240px; height: 120px; margin-top:-30px; margin-left:-20px;"/></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
     
	  <a href="#" class="hidden-lg hidden-md hidden-sm sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            
              <span><?php echo $login_data[0]['user_login']['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li>
                  <a href="<?php echo $this->webroot; ?>login" class="btn btn-default btn-flat" style="background-color: #fff;">Log out</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar no-print">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
	
	
        <!-- Navigation -->
        
			<ul class="sidebar-menu">
			<li class="">
            	<a href="http://amritjalpariyojana.com/" rel="tab" target="blank"> <i class="fa fa-globe"></i><span class="title"> Website</span></a>
            </li>
			<?php
			  $fetch_user_right=$this->requestAction(array('controller' => 'Handler', 'action' => 'user_rights'), array());
			 foreach($fetch_user_right as $data)
			 {  
				 $user_right1=$data['user_right']['module_id'];
			 }
			 
			 $user_right=explode(',', $user_right1);
			 
			 
			 $fetch_menu=$this->requestAction(array('controller' => 'Handler', 'action' => 'menu'), array());
			 $main_menu_arr[]='';
			 $page_name=$this->params['action'];
			 foreach($fetch_menu as $data)
			 {
				if(in_array($data['module']['id'], $user_right))
				{
					if(empty($data['module']['main_menu']) && empty($data['module']['sub_menu']))
					{
						 ?>
						<li class="<?php if($page_name==$data['module']['page_name_url']){ echo 'active'; } ?>">
						<a href="<?php echo $this->webroot; ?><?php echo $data['module']['page_name_url']; ?>" <?php if($data['module']['page_name_url']=='logout'){ }else{ ?>rel='tab' <?php } ?>> <i class="<?php echo $data['module']['icon_class_name']; ?>"></i><span class="title"> <?php echo $data['module']['name']; ?></span><?php if($page_name==$data['module']['page_name_url']){ ?> <span class="selected"></span> <?php } ?></a>
						</li>
						<?php 
					}
					else
					{
						if(!in_array($data['module']['main_menu'], $main_menu_arr))
						{
							$main_menu_arr[]=$data['module']['main_menu'];
							$fetch_menu_submenu=$this->requestAction(array('controller' => 'Handler', 'action' => 'menu_submenu',$data['module']['main_menu']), array()); 
							foreach($fetch_menu_submenu as $data_value1)
							{ 	
								if($data_value1['module']['page_name_url'] == $page_name)
								{
									$class_active='active';
									$arrow_open='open';
									$class_selected='selected';
								}
							}
							
							?>
							<li class="treeview<?php  echo @$class_active; ?> ">
								<a href="javascript:;">
								<i class="<?php echo $data['module']['main_menu_icon']; ?>"></i>
								<span><?php echo $data['module']['main_menu']; ?></span>
								<span class="<?php  echo @$class_selected; ?>"></span>
								<span class="pull-right-container">
								  <i class="fa fa-angle-left pull-right"></i>
								</span>
								</a>
								<ul class="treeview-menu">
								<?php
								$class_active='';
								$arrow_open='';
								$class_selected='';
								 
								foreach($fetch_menu_submenu as $data_value)
								{
									if(!empty($data_value['module']['sub_menu']))
									{
									$fetch_submenu=$this->requestAction(array('controller' => 'Handler', 'action' => 'submenu',$data_value['module']['sub_menu']), array());
									if(!in_array($data_value['module']['sub_menu'], $main_menu_arr))
									{
										$main_menu_arr[]=$data_value['module']['sub_menu'];
										$main_menu_arr_my[]=$data_value['module']['sub_menu'];
										$sub_id=0;
										foreach($fetch_submenu as $data_value1)
										{
											$sub_id[]=$data_value1['module']['page_name_url'];
											
											if($data_value1['module']['page_name_url'] == $page_name)
											{
												$class_active='active';
												$arrow_open='open';
												$class_selected='selected';
											}
											 
										}
										$x=0;
								foreach($fetch_submenu as $data_submenu)
								{$x++;
										if(in_array($data_submenu['module']['id'], $user_right) && $x==1)
										{  
										?>
										<li class="treeview <?php  echo @$class_active; ?>">
										<a href=javascript:;> 
										<i class="<?php echo $data_value['module']['sub_menu_icon']; ?>"></i>
										<span><?php echo $data_value['module']['sub_menu']; ?></span>
										<span class="<?php  echo @$class_selected; ?>"></span>
										<span class="pull-right-container">
										  <i class="fa fa-angle-left pull-right"></i>
										</span>
										</a>
										<ul  class="treeview-menu">
										<?php
										foreach($fetch_submenu as $data_submenu)
										{
											if((in_array($data_submenu['module']['id'], $user_right))&& (!in_array($data_submenu['module']['name'], $main_menu_arr)))
											{
												$main_menu_arr[]=$data_submenu['module']['name'];
											 ?>
											<li class="<?php if($page_name==$data_submenu['module']['page_name_url']){ echo ' active'; } ?>">
												<a href="<?php echo $this->webroot; ?><?php echo $data_submenu['module']['page_name_url']; ?>" rel='tab'> <i class="<?php echo $data_submenu['module']['icon_class_name']; ?>"></i><span class="title"><?php echo $data_submenu['module']['name']; ?></span></a>
											</li>
											<?php
											}
										}
										$class_active='';
										$arrow_open='';
										$class_selected='';
										?>
										</ul>
									</li>
							
								<?php
									 }
									}
									}
									}
									else
									{
										if((in_array($data_value['module']['id'], $user_right)) && (!in_array($data_value['module']['name'], $main_menu_arr)))
										{
											$main_menu_arr[]=$data_value['module']['name'];
										 ?>
												<li class="<?php if($page_name==$data_value['module']['page_name_url']){ echo ' active'; } ?>">
													<a href="<?php echo $this->webroot; ?><?php echo $data_value['module']['page_name_url']; ?>" rel='tab'> <i class="<?php echo $data_value['module']['icon_class_name']; ?>"></i><span class="title"><?php echo $data_value['module']['name']; ?></span></a>
												</li>
												<?php
										}
										
									}
								}
								?>
									</ul>	
							</li>
							<?php
							$class_active='';
							$arrow_open='';
							$class_selected='';
						}
					}
					
				}
			}
			?>
			</ul>
	     </section>
	</aside>
	<div class="content-wrapper">
		 <section class="content">
			<div class="row">
				<?php echo $this->fetch('content'); ?>
			</div>
		 </section>
	</div>
 </div>
 
	<!-- END PAGE CONTENT -->
<!-- END PAGE CONTAINER -->

<!-- BEGIN FOOTER -->
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
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
   
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>