<style>
		 table { border-collapse:separate; border-top: 3px solid grey; }
        td, th {
            margin:0;
            border:1px solid black; 
            border-top-width:0px; 
            white-space:nowrap;
			padding:3px;
        }
       .tble{ 
            
            overflow-x:scroll;  
            margin-left:12em; 
            overflow-y:visible;
            padding-bottom:5px;
        }
        .headcol {
            position:absolute; 
            width:13em; 
            left:0;
            top:auto; 
            border-top-width:3px; /*only relevant for first row*/
            margin-top:-3px; /*compensate for top border*/
        }
</style>

<style>

.rotate {

/* Safari */
-webkit-transform: rotate(-90deg);
}
</style>

<div class="col-md-12">
  <!-- Horizontal Form -->
	<div class="box box-primary">
		<div class="box-header with-border">
		<div class="form-group col-sm-4">
		  <h3 class="box-title">Village Edit</h3>
		 </div>
		<div class="form-group col-sm-4">
				<label class="control-label">Village</label>
				<select class="form-control select2 search" name="village_id" id="village_id" data-placeholder="Select Village">
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
		<!-- /.box-header -->
		<!-- form start -->
		<div class="box-body">
		
			<div class="col-sm-12">
				<div class="tble" id="mytbl">
					<table style="border-color:1px solid #E1C115;">
						<thead>
							<tr style="background-color:#FFD700;"  >
								<th class="headcol">Village Name</th>
								<th>Latitude</th><th>Longitude</th><th>Executive Engineer</th><th>Assistant Engineer</th><th>Junior Engineer</th><th>Operator</th><th>Customer Care No.</th><th>Land Allocation</th><th>Water Connection</th><th>Electrical Connection</th><th>Foundation</th><th>Flooring</th><th>Shelter Erection</th><th>Water Tank</th><th>Plant Installation</th><th>Commissioining</th><th>MLA Costituency</th><th>Gram Panchayat</th><th>Population</th><th>Nos of Household</th><th>SIM NUMBER</th>
							</tr>
						</thead>
						
						
						<tbody>
						
						<?php
						foreach($result_village as $village_data)
						{
							?>
							<tr>
								<td style="background-color:#FFD700;" class="headcol" ><?php echo $village_data['village']['village_name'] ;?></td>
								<td><a href="#" class="editable_text" field_name="latitude" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['latitude']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="longitude" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['longitude']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="executive_engineer" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['executive_engineer']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="assistant_engineer" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['assistant_engineer']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="junior_engineer" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['junior_engineer']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="operator" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['operator']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="customer_care_no" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['customer_care_no']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="land_allocation" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php  echo $village_data['village']['land_allocation']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="water_connection" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['water_connection'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="electrical_connection" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['electrical_connection'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="foundation" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['foundation'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="flooring" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['flooring'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="shelter_erection" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['shelter_erection'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="water_tank" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['water_tank'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="plant_installation" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['plant_installation'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="commissioning" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo date('d-m-Y',strtotime($village_data['village']['commissioning'])); ?></a></td>
								<td><a href="#" class="editable_text" field_name="mla_costituency" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['mla_costituency']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="gram_panchayat" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['gram_panchayat']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="population" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo$village_data['village']['population']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="no_houses" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['no_houses']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="sim_number" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="text" data-pk="1"><?php echo $village_data['village']['sim_number']; ?></a></td>
								
							</tr>
							<?php
						}
						?>
						
						</tbody>
						
					</table>
				
			</div>
			<div  class="col-sm-12">
				<div class="pull-left">
					<div style="margin-top: 20px;white-space: nowrap;font-weight: 600;">
					Showing &nbsp; <?= $this->Paginator->counter(); ?></div>
					
				</div>
				<div class="pull-right" style="float:right;">
					<div class="paginator" style="float:right;">
						<ul class="pagination">
							<?= $this->Paginator->prev(__('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next')) ?>
						</ul>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>

$(document).ready(function() { 
	//global settings
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.inputclass = 'form-control input-small';
	$('.editable_text').editable();
	$(document).on('click', '.editable-submit', function(e)
	{
		var m_data = new FormData();
		var class_name=$(this).closest('td').find('a.editable_text').length;
		
		if(class_name>0)
		{
			var field_name=$(this).closest('td').find('a').attr('field_name');
			var value=$(this).closest('form').find('input.form-control').val();
			var data_type=$(this).closest('td').find('a').attr('data-type');
			if(data_type=='date')
			{
				value = value.split("-").reverse().join("-");
			}
			//alert(value	);
			m_data.append(field_name,value);
			var table_id=$(this).closest('td').find('a').attr('table_id');
			
			m_data.append('id',table_id);
			//alert(m_data);
			$.ajax({
			url: "<?php echo $this->webroot; ?>ajax_php_file?village_edit_ajax=1",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			//dataType:'json',
			success: function(data)   // A function to be called if request succeeds
			{
				//alert(data);
			}	
			});
		}
	});
	
});
</script>
  <script type="text/javascript">
$(document).ready(function()
{
	$('#village_id').on('change', function(){
		
		var village_id = $(this).val();
		if(village_id>0){
		$.ajax({
			url: "<?php echo $this->webroot; ?>village_search_ajax?q="+village_id,
			type: "POST",
			success: function(data)
				{
					$('#mytbl').html(data);
					$.fn.editable.defaults.mode = 'inline';
					$.fn.editable.defaults.inputclass = 'form-control input-small';
					$('.editable_text').editable();
				}
			});
		}
		
	});
});
</script>
