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
		  <h3 class="box-title">Record Edit</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<div class="box-body">
			<form method="get" id="form">
				<div class="col-sm-12">
				<div class="form-group col-sm-3">
				<label class="control-label">Village</label>
				<?php 
				
			$find_village=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village1',$village_id), array());
			$village_name=$find_village[0]['village']['village_name'];
			
				?>
				<select class="form-control select2 search" name="village_id" data-placeholder="Select Village">
				<?php
					echo '<option value="'.$village_id.'" selected>'.$village_name.'</option>';
					
					?>
				</select>
			 </div>
				  <div class="form-group  col-sm-3">
					<label>Status Date range:</label>
					
						<div class="input-group input-medium date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text" value="<?php echo $strt_date; ?>" >
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text" value="<?php echo $end_date; ?>">
						</div>
						<!-- /input-group -->
						<span class="help-block">
						Select date range </span>
					 </div>
					<div class="form-group col-sm-3">
					<label class="control-label">No of ATM Issued</label>
					<select class="form-control select2 search" name="atmcard_issues" data-placeholder="Select Village">
					<option value="1" <?php if($op_val==1){echo 'selected';} ?> >10 - 25</option>
					<option value="2" <?php if($op_val==2){echo 'selected';} ?> >26 - 50</option>
					<option value="3" <?php if($op_val==3){echo 'selected';} ?> >51 - 75</option>
					<option value="4" <?php if($op_val==4){echo 'selected';} ?> >76 - 125</option>
					<option value="5" <?php if($op_val==5){echo 'selected';} ?> >126 - 175</option>
					<option value="6" <?php if($op_val==6){echo 'selected';} ?>>176 - 225</option>
					</select>
				</div> 

				  <div class="form-group  col-sm-3">
					<label>Lab Testing Date</label>
					
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="date_lab_testing" type="text" value="<?php echo $lab_test; ?>" >
						
						</div>
						<!-- /input-group -->
						<span class="help-block">
						Select date </span>
					 </div>
			</div>	
			
				<div class="col-sm-12">
			
				<div class="form-group col-sm-3">
				<label class="control-label">Raw Water TDS</label>
					<input class="form-control" name="rwq_tds" type="text" value="<?php echo $r_tds; ?>">
				</div>
				<div class="form-group  col-sm-3">
				<label>Raw Water fl</label>
					<input class="form-control" name="rwq_fl" type="text" value="<?php echo $r_fl; ?>">
				</div>
				<div class="form-group  col-sm-3">
				<label>Raw Water NO3</label>
					<input class="form-control" name="rwq_no" type="text" value="<?php echo $r_no; ?>">
				</div>
				</div>
				<div class="col-sm-12">
			
				<div class="form-group col-sm-3">
				<label class="control-label">Treated Water TDS</label>
					<input class="form-control" name="twq_tds" type="text" value="<?php echo $t_tds; ?>">
				</div>
				<div class="form-group  col-sm-3">
				<label>Treated Water fl</label>
					<input class="form-control" name="twq_fl" type="text" value="<?php echo $t_fl; ?>">
				</div>
				<div class="form-group  col-sm-3">
				<label>Treated Water NO3</label>
					<input class="form-control" name="twq_no" type="text" value="<?php echo $t_no; ?>">
				</div>
					 </div>
				  <div class="form-group col-sm-2">
				  <label></label>
					<button type="submit" name="edit_record1" id="record" class="btn btn-block btn-primary" style="margin-top: 5px;margin-left: 300px;">EDIT RECORD</button>
					</div>
				</div>
			</form>
			
		</div>
	</div>
</div>

