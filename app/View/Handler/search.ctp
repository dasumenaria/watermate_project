
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title">Search</h3>
	  <div class="pull-right box-tools">
	  <form method="get">
	  <input type="hidden" id="excel_input" name="district" value="all_district" />
		<button type="submit" formaction="complete_excel" value="Watermate" name="complete_data" class="btn btn-info btn-sm">
		  <i class="fa fa-file-excel-o"></i> RO Plant Status Summary</button>
		 </form>
	  </div>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
		<div class="col-sm-12">
			<div class="form-group col-sm-4">
				<label class="control-label">District</label>
				<select class="form-control select2 search" name="district_id" data-placeholder="Select District">
					<option />
					<?php
					foreach($district as $district_data)
					{
						echo '<option value="'.$district_data['district']['id'].'">'.$district_data['district']['district_name'].'</option>';
					}
					?>
				</select>
			 </div>
			 <div class="form-group col-sm-4">
				<label class="control-label">Block</label>
				<select class="form-control select2 search" name="block_id" data-placeholder="Select Block">
					<option />
					<?php
					foreach($block as $block_data)
					{
						echo '<option value="'.$block_data['block']['id'].'">'.$block_data['block']['block_name'].'</option>';
					}
					?>
				</select>
			 </div>
			 <div class="form-group col-sm-4">
				<label class="control-label">Village</label>
				<select class="form-control select2 search" name="village_id" data-placeholder="Select Village">
					<option />
					<?php
					foreach($village as $village_data)
					{
						echo '<option value="'.$village_data['village']['id'].'">'.$village_data['village']['village_name'].'</option>';
					}
					?>
				</select>
			 </div>
		 </div>
		 <div id="find_data">
			 <div class="row">
				<?php
				foreach($district as $data)
				{
					$all_district[]=$data['district']['id'];
					$target_dir = "images_post/district/".$data['district']['id'];
					$images = glob($target_dir.'/*');
					?>
					
					<div class="col-lg-3 col-xs-6">
					  <!-- small box -->
					  <a  class="search_data" block_id="" district_id="<?php echo $data['district']['id']; ?>" style="cursor:pointer;">
					  <div class="small-box bg-aqua" style="border:1px solid aqua;">
						 <img style="width:100%; height:150px; overflow:hidden;" src="<?php echo $images[0]; ?>"/>
						
						<div class="small-box-footer" style=" color:#fff; font-weight:700; text-transform: uppercase;">
							<?php echo $data['district']['district_name']; ?>
						</div>
					  </div>
					  </a>
					</div>
					
					<?php
				}
				$all_district_data=implode(',',$all_district);
				?>
				
			</div>
			<form method="get" id="form">
				<input type="hidden" name="district" value="all_district" />
				<div class="col-sm-12">
				  <div class="form-group col-sm-4">
					<label>Date range:</label>
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text">
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text">
						</div>
						<span class="help-block">
						Select date range </span>
					<!-- /.input group -->
				  </div>
				 
				  <div class="form-group col-sm-2">
				  <label></label>
					<button type="submit" name="find_record" class="btn btn-block btn-primary" formaction="record"  style="margin-top: 5px;">Record</button>
					</div>
				</div>
			</form>
		</div>
		
	
  </div>
  <!-- /.box -->
          
</div>
<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>


$(document).ready(function() { 
/*
var dateToday = new Date();
var dates = $("#from, #to").datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
    minDate: dateToday,
    onSelect: function(selectedDate) {
        var option = this.id == "from" ? "minDate" : "maxDate",
            instance = $(this).data("datepicker"),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
});*/
var returnLocation = document.location.href;
returnLocation = returnLocation.replace('http://localhost','');
	$(window).on('popstate', function() {
	
		var returnLocation = document.location.href;
		returnLocation = returnLocation.replace('http://localhost','');
		if (('localStorage' in window) && window['localStorage'] !== null) {
			pageurl="<?php echo $this->here; ?>";
			if(returnLocation=="<?php echo $this->here; ?>?block=block")
			{
				$("#find_data").html(localStorage.getItem('block'));
			}
			else if(returnLocation=="<?php echo $this->here; ?>?village=village")
			{
				$("#find_data").html(localStorage.getItem('village'));
			}
			else
			{
				$("#find_data").html(localStorage.getItem('district'));
			}
		}
    });
	
	if (('localStorage' in window) && window['localStorage'] !== null) { 
		var form = $("#find_data").html();
		localStorage.setItem('district', form);
	}
	$('.search').on('change',function() { 
		var district_id=$('select[name="district_id"] option:selected').val();
		var block_id=$('select[name="block_id"] option:selected').val();
		var village_id=$('select[name="village_id"] option:selected').val();
		var returnLocation = document.location.href;
		
		returnLocation = returnLocation.replace('http://localhost','');
		
		if(returnLocation=="<?php echo $this->here; ?>?block=block")
		{
			pageurl="<?php echo $this->here; ?>?village=village";
		}
		else if("<?php echo $this->here; ?>"=="/watermate/search")
		{
			pageurl="<?php echo $this->here; ?>?block=block";
		}
		window.history.pushState({path:pageurl},'',pageurl);
		$.ajax({
		url: "ajax_php_file?search=1&district_id="+district_id+"&block_id="+block_id+"&village_id="+village_id,
		type: "POST",         
		success: function(data)
		{
			$("#find_data").html(data);
			
            $( ".datepicker" ).datepicker();
			if(returnLocation=="<?php echo $this->here; ?>?block=block")
			{
				localStorage.setItem('village', data);
			}
			else if("<?php echo $this->here; ?>"=="/watermate/search")
			{
				localStorage.setItem('block', data);
			}
			
		}
		});
	});

	$(document).on('click', '.search_data', function(e)
	{
		var block_id=$(this).attr('block_id');
		var district_id=$(this).attr('district_id');
		
		if(district_id != '')
		{
			$("#excel_input").attr('name','district_id');
			$("#excel_input").val(district_id);
		}
		else if(block_id != '')
		{
			$("#excel_input").attr('name','block_id');
			$("#excel_input").val(block_id);
		}
		var returnLocation = document.location.href;
		
		returnLocation = returnLocation.replace('http://localhost','');
		
		if(returnLocation=="<?php echo $this->here; ?>?block=block")
		{
			pageurl="<?php echo $this->here; ?>?village=village";
		}
		else if("<?php echo $this->here; ?>"=="/watermate/search")
		{
			pageurl="<?php echo $this->here; ?>?block=block";
		}
		window.history.pushState({path:pageurl},'',pageurl);
		$.ajax({
		url: "ajax_php_file?search=1&district_id="+district_id+"&block_id="+block_id,
		type: "POST",         
		success: function(data)
		{	
			$('.date-picker').datepicker();
			$("#find_data").html(data);
			
			if(returnLocation=="<?php echo $this->here; ?>?block=block")
			{
				localStorage.setItem('village', data);
			}
			else if("<?php echo $this->here; ?>"=="/watermate/search")
			{
				localStorage.setItem('block', data);
			}
		}
		});
	});
	
	
});
</script>
