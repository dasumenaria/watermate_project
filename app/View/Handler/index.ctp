<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title">Upload the CSV Format</h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form class="form-horizontal cmxform" id="registratiomForm" method="post"  enctype="multipart/form-data">
	<div class="col-md-12">
	 <div class="box-body col-md-6">
		<div class="form-group">
		  <label class="col-sm-2 control-label">File input</label>
		  <input type="file"  name='filename'>
		 </div>
		 <button type="submit" name="csv_submit" class="btn btn-success"><i class="fa fa-plus"></i> Submit</button>
		
	</div>
	 <div class="box-body col-md-6">
		<div class="form-group">
			<a class="btn btn-primary" href="<?php echo $this->webroot; ?>files/watermate.csv" download><i class="fa fa-download"></i> Download Sample File </a>
		</div>
	</div>
	</div>
	  <!-- /.box-body -->
	  <div class="box-footer">
		</div>
	  <!-- /.box-footer -->
	</form>
	
  </div>
  <!-- /.box -->
         
           
             
</div>
<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>

$(document).ready(function() { 

	$('input[name="member_type_id"]').on('change',function() {
		var member_type_id=$(this).val();
		if(member_type_id==1)
		{
			$('select[name="turn_over_id"]').removeAttr('disabled');
		}
		else
		{
			$('select[name="turn_over_id"]').attr('disabled','disabled');
		}
	});
	// validate the comment form when it is submitted
	// validate signup form on keyup and submit
	$("#registratiomForm").validate({
		rules: {
			company_organisation: {
				required: true
			},
			member_name: {
				required: true
			},
			alternate_nominee: {
				required: true
			},
			address: {
				required: true
			},
			end_products_item_dealing_in: {
				required: true
			},
			office_telephone: {
				required: true
			},
			residential_telephone: {
				required: true
			},
			fax: {
				required: true
			},
			email: {
				required: true
			},
			mobile_no: {
				required: true
			},
			grade: {
				required: true
			},
			category: {
				required: true
			},
			classification: {
				required: true
			},
			year_of_joining: {
				required: true
			},
			member_type_id: {
				required: true
			},
			turn_over_id: {
				required: true
			},
			email: {
				required: true,
				email: true
			}
			
		},
		messages: {
			member_name: {
				required: "Please enter a username"
			},
			email: "Please enter a valid email address",
			member_type_id: {
					required: "Please select a member type"
				}
		}
	});

});
</script>
       