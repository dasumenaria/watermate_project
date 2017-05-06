<!DOCTYPE html>
<html lang="en">
<head>
<title>Watermate</title>
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
echo $this->fetch('meta');
 Configure::write('debug', 0);
 ?>

    <!-- Custom Fonts -->
    <link href="<?php echo $this->webroot; ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $this->webroot; ?>assets/plugins/iCheck/square/blue.css">
	</style>
<?php
//$this->requestAction(array('controller' => 'Nonmovinginventory', 'action' => 'ajax_function'), array());
?>
</head>
<body class="hold-transition login-page" >
<!-- --------------------------------start  menu  header--------------------------------------------- -->
<?php    
?>
<!-- --------------------------------end  menu  header--------------------------------------------- -->
<!-- Here's where I want my views to be displayed-->
<?php echo $this->fetch('content'); ?>
 <!-- --------------------------------start  footer menu--------------------------------------------- -->


    <!-- Custom Theme JavaScript -->
    <script src="<?php echo $this->webroot; ?>assets/dist/js/sb-admin-2.js"></script>
	<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->webroot; ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $this->webroot; ?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '10%' // optional
    });
  });
</script>
</body>
</html>


