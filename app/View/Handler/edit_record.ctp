
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title">Search</h3>
	  <div class="pull-right box-tools">
	 
	  </div>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
	<form>
		<div class="col-sm-12">
			<div class="form-group col-sm-3">
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
	
			 <div class="form-group col-sm-3">
					<label>Status Date range:</label>
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
			  <div class="form-group  col-sm-3">
					<label>Lab Testing Date</label>
					
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="date_lab_testing" type="text">
						
						</div>
						<!-- /input-group -->
						<span class="help-block">
						Select date </span>
					 </div>	 
				  <div class="form-group col-sm-2">
				  <label></label>
					<button type="submit" name="find_record" class="btn btn-block btn-primary" formaction="fetch_record"  style="margin-top: 5px;">Record</button>
					</div>
				</div>
			</form>
		</div>
		
	
  </div>
  <!-- /.box -->
          
</div>
<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>






