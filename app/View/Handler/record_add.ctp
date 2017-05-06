<style>
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 1px solid #E1C115;
}
.rotate {

/* Safari */
-webkit-transform: rotate(-90deg);
}
th,td
{
text-align: center;
}
</style>

<div class="col-md-12">
  <!-- Horizontal Form -->
	<div class="box box-primary">
		<div class="box-header with-border">
		  <h3 class="box-title">Record Add</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<div class="box-body">
			<form method="get" id="form">
				<div class="col-sm-12">
				<div class="form-group col-sm-3">
				<label class="control-label">Village</label>
				<select class="form-control select2 search" name="village_id" data-placeholder="Select Village" required>
					<option />
					<?php
					foreach($village as $village_data)
					{
						echo '<option value="'.$village_data['village']['id'].'">'.$village_data['village']['village_name'].'</option>';
					}
					?>
				</select>
			 </div>
				  <div class="form-group  col-sm-3">
					<label>Status Date range:</label>
					
						<div class="input-group input-medium date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text" required>
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text">
						</div>
						<!-- /input-group -->
						<span class="help-block">
						Select date range </span>
					 </div>
					<div class="form-group col-sm-3">
					<label class="control-label">No of ATM Issued</label>
					<select class="form-control select2 search" name="atmcard_issues" data-placeholder="Select Village" required><option>Select ATM Range</option>
					<option value="1">10 - 25</option>
					<option value="2">26 - 50</option>
					<option value="3">51 - 75</option>
					<option value="4">76 - 125</option>
					<option value="5">126 - 175</option>
					<option value="6">176 - 225</option>
					</select>
				</div> 

				  <div class="form-group  col-sm-3">
					<label>Lab Testing Date</label>
					
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="date_lab_testing" type="text" required>
						
						</div>
						<!-- /input-group -->
						<span class="help-block">
						Select date </span>
					 </div>
			</div>	
			
				<div class="col-sm-12">
			
				<div class="form-group col-sm-3">
				<label class="control-label">Raw Water TDS</label>
					<input class="form-control" name="rwq_tds" type="text">
				</div>
				<div class="form-group  col-sm-3">
				<label>Raw Water fl</label>
					<input class="form-control" name="rwq_fl" type="text">
				</div>
				<div class="form-group  col-sm-3">
				<label>Raw Water NO3</label>
					<input class="form-control" name="rwq_no" type="text">
				</div>
				</div>
				<div class="col-sm-12">
			
				<div class="form-group col-sm-3">
				<label class="control-label">Treated Water TDS</label>
					<input class="form-control" name="twq_tds" type="text">
				</div>
				<div class="form-group  col-sm-3">
				<label>Treated Water fl</label>
					<input class="form-control" name="twq_fl" type="text">
				</div>
				<div class="form-group  col-sm-3">
				<label>Treated Water NO3</label>
					<input class="form-control" name="twq_no" type="text">
				</div>
					 </div>
				  <div class="form-group col-sm-2">
				  <label></label>
					<button type="submit" name="add_record" id="record" class="btn btn-block btn-primary" style="margin-top: 5px;margin-left: 300px;">ADD RECORD</button>
					</div>
				</div>
			</form>
			
		</div>
	</div>
</div>

