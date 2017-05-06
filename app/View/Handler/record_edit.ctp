<style>
		 table { border-collapse:separate; border-top: 1px solid black; }
        td, th {
            margin:0;
            border:1px solid black; 
            border-top-width:0px; 
            white-space:nowrap;
			text-align:center;
        }
       .my_tble{ 
            overflow-x:scroll;  
            margin-left:8em; 
            overflow-y:visible;
			padding-bottom:5px;
        }
        .headcol {
			margin:0;
            border:1px solid black;
			background-color:#FFD700;
            border-top-width:1px; 
			padding:7px;
            position:absolute; 
            width:9em; 
            left:0;
            //top:auto; 
			border-top-width:1px; /*only relevant for first row*/
             /*compensate for top border*/
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
		  <h3 class="box-title">Record Edit</h3>
		</div>
		<!-- /.box-header -->
		<!-- form start -->
		<div class="box-body">
			<form method="get" id="form">
				<div class="col-sm-12">
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
				  <div class="form-group col-sm-4">
					<label>Date range:</label>
					
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text">
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text">
						</div>
						<!-- /input-group -->
						<span class="help-block">
						Select date range </span>
					
				  </div>
				  <div class="form-group col-sm-2">
				  <label></label>
					<button type="submit" name="find_record" id="record" class="btn btn-block btn-primary" style="margin-top: 5px;">Record</button>
					</div>
				</div>
			</form>
			<div class="col-sm-12">
				
				<div class="my_tble" id="mytbl">
					<table style="border-color:1px solid #E1C115;">	<?php
				
			@$village=$_GET['village_id'];
			@$from=base64_encode($_GET['from']);
			@$to=base64_encode($_GET['to']);
			?>
					<table style="border-color:1px solid #E1C115;">						
					<thead>
					
							<tr style="background-color:#FFD700;"><th rowspan="2" colspan="2" class="headcol">Status as </br>on Date</th><th rowspan="2">Date of commissioning</br> of plant</th><th rowspan="2">Name of District</th><th rowspan="2">Name of Village/ habitation</th><th rowspan="2">Poulation ( 2011 Census)</th><th rowspan="2">Nos of Household</th><th rowspan="2">Nos. of ATM </br>Card issued </th><th rowspan="2">Date of sample (lab testing)</th><th colspan="3">Raw water Quality (PPM)</th><th colspan="3">Treated water Quality (PPM)</th><th rowspan="2" >SIM Number</th><th colspan="2">Status as on </th><th rowspan="2">Status (operational/Non operational)</th><th rowspan="2">Reason for Non-Operational</th><th rowspan="2">Treated water TDS ppm</th><th rowspan="2">IFR m3/hr</th><th rowspan="2">PFR m3/hr</th><th rowspan="2">Recovery <br/>(PFR/IFR*100)</th><th rowspan="2">Operational Hrs in a day</th><th rowspan="2">Operational Hrs as on date</th><th rowspan="2">Cummulative volume dispensed</br> (m3 in a day)</th><th rowspan="2">Cummulative volume </br>(m3 as on date)</th><th colspan="2">% Penetration </th><th rowspan="2">Delete/Undo</th><th rowspan="2">Permanent Delete</th>
							</tr>
							<tr style="background-color:#FFD700;">
								<th></th><th >TDS</th><th >Fl</th><th >No3</th><th >TDS</th><th >Fl</th><th >No3</th><th >Date</th><th >Time</th><th>ATM card based </br>(ATM Card issued/Nos of Household x 100)</th><th>Volume based (Cummulative vol(m3 in a day)/<br/>Total nos of HH x 15 liter per day per HH X 100)</th>
							</tr>
						</thead>
						<tbody id="tble">
						<?php
						foreach(@$result_record as $data_record)
						{ 
						$find_village=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village1',$data_record['record']['village_id']), array());
						$find_village_all=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village_all',$data_record['record']['village_id']), array());
						$find_block=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_block1',$find_village_all[0]['village']['block_id']), array());
						$find_district=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_district',$find_block[0]['block']['district_id']), array());
						/*	
							$find_block=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_block1',$data_record['record']['block_id']), array());
							$find_district=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_district',$data_record['record']['district_id']), array());
							$find_village=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village1',$data_record['record']['village_id']), array());
							 $auto_id=$data_record['record']['id'];
							 $find_village_all=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village_all',$data_record['record']['village_id']), array());
						*/
							 
							?>
							<?php 
							$record_flag=$data_record['record']['record_flag']; 
							if($record_flag==1)
							{ 
							?>
							<tr style="background-color:#a0a0a0;" id="a<?php echo $auto_id; ?>">
							<?php } else { ?>
							<tr id="a<?php echo $auto_id; ?>">
							<?php } ?>
								
								<td class="headcol" style="background-color:#FFD700;" ><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['status_date']), array());?></td>
								
								<td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$find_village_all[0]['village']['commissioning']), array());?></td>
								<td><?php echo $find_district[0]['district']['district_name']; ?></td>
								<td><?php echo $find_village[0]['village']['village_name']; ?></td>
								<td><?php echo $find_village_all[0]['village']['population']; ?></td>
								<td><?php echo $no_houses=$find_village_all[0]['village']['no_houses']; ?></td>
								<td><a href="#" class="editable_text" field_name="atmcard_issues" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $atmcard=$data_record['record']['atmcard_issues']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="date_lab_testing" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="date" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['date_lab_testing']),array()); ?> </a></td>
								<td><a href="#" class="editable_text" field_name="rwq_tds" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['rwq_tds']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="rwq_fl" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['rwq_fl']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="rwq_no" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['rwq_no']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="twq_tds" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['twq_tds']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="twq_fl" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['twq_fl']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="twq_no" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['twq_no']; ?></a></td>
								<td><?php echo $find_village_all[0]['village']['sim_number']; ?></td>
								<td><a href="#" class="editable_text" field_name="status_date" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="date" data-viewformat="dd-mm-yyyy" data-pk="1"><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['status_date']),array()); ?></a></td>
								<td><a href="#" class="editable_text" field_name="status_time" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['status_time']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="status_plant" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $status= $data_record['record']['status_plant']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="reason_nonoperational" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['reason_nonoperational']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="treated_tds" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['treated_tds']; ?></a></td>
								<td><?php  if($status=='O'){ echo $ifr=800; } else { echo '-'; } ?></td>
								<td><a href="#" class="editable_text" field_name="pfr" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $pfr=$data_record['record']['pfr']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="recovery" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $recovery=$pfr/$ifr*100; ?></a></td>
								<td><a href="#" class="editable_text" field_name="operational_day" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['operational_day']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="operational_date" table_id="<?php echo $data_record['record']['id']; ?>" data-type="text" data-pk="1"><?php echo $data_record['record']['operational_date']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="dispense_day" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $cum_vol=$data_record['record']['dispense_day']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="dispense_date" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $data_record['record']['dispense_date']; ?></a></td>
								<td><a href="#" class="editable_text" field_name="penetration_atm" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $pen_atm=round((($atmcard/$no_houses)*100),2); ?></a></td>
								<td><a href="#" class="editable_text" field_name="penetration_volume" table_id="<?php echo $data_record['record']['id']; ?>"  data-type="text" data-pk="1"><?php echo $pen_vol=round(($cum_vol/$no_houses*15)*100,2); ?></a></td>
								<?php
								if($role==1){ ?>
								<?php
								if($record_flag==1)
								{
								?>
								<td style="width:10px;"><a class="btn undo" onclick="undo_record(<?php echo $auto_id;?>)" field_name="" table_id="<?php echo $data_record['record']['id']; ?>" ><i style="color:red;" class="fa fa-undo "></a></td>
								<td style="width:10px;"><a class="btn del" onclick="del_record(<?php echo $auto_id;?>)" field_name="" table_id="<?php echo $data_record['record']['id']; ?>" ><i style="color:red;" class="fa fa-trash-o "></a></td>
								<?php } else { ?>
								
								<td style="width:10px;"><a class="btn disable" onclick="delete_record(<?php echo $auto_id;?>)" field_name="" table_id="<?php echo $data_record['record']['id']; ?>" ><i style="color:red;" class="fa fa-close "></a></td>
								<?php } ?>
								<?php }else { } ?>
								
							</tr>
							
							<?php 
						}
						?>
						
						</tbody>
					</table>
				</div>
			</div>
			<div  class="col-sm-12">
				<div class="form-group col-sm-2">
				  <label></label>
					<a  name="del_all" id="del_all" onclick="del_all('<?php echo $village;?>','<?php echo $from; ?>','<?php echo $to;?>')" class="btn btn-block btn-primary" style="margin-top: 5px; display:none;">Delete All</a>
					</div>
				<div class="pull-left">
					<div style="margin-top: 20px;white-space: nowrap;font-weight: 600;">
					Showing &nbsp; <?= $this->Paginator->counter() ?></div>
					
				</div>
				<div class="pull-right" style="float:right;">
					<div class="paginator" style="float:right;">
						<ul class="pagination">
							
							<li><?= $this->Paginator->first(__('< First')) ?></li>
							<?= $this->Paginator->prev(__('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next')) ?>
							<li><?= $this->Paginator->last(__('> Last')) ?></li>
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
        $("#del_all").show();
    
	 $(".undo").click(function(){
        $(this).hide();
    });
	$(".disable").click(function(){
        $(this).hide();
    });

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
			var data_type=$(this).closest('td').find('a').attr('field_name');
			if(data_type=='date')
			{
				value = value.split("-").reverse().join("-");
			}
			m_data.append(field_name,value);
			
			var table_id=$(this).closest('td').find('a').attr('table_id');
			m_data.append('id',table_id);
			
			$.ajax({
			url: "<?php echo $this->webroot; ?>ajax_php_file?record_edit=1",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'json',
			success: function(data)   // A function to be called if request succeeds
			{
				alert(data);
			}	
			});
		}
		
		
	});
});


function delete_record(t)
{
	
	var aa=t;
	 $.ajax({
			url:"ajax_delete_record?con="+t+"", 
			async: false,
			success: function(data){
			$('#a'+t).css("background-color", "#a0a0a0");
			//$('#a'+t).hide();
			}
		});
            
}

function undo_record(t)
{
	
	var aa=t;
	 $.ajax({
			
			url:"ajax_undo_record?con="+t+"", 
			async: false,
			success: function(data){
			$('#a'+t).css("background-color", "#ffffff");
			//$('#a'+t).hide();
			}
		});
            
}

function del_record(t)
{
	
	var aa=t;
	 $.ajax({
			url:"ajax_del_record?con="+t+"", 
			async: false,
			success: function(data){
			$('#a'+t).hide();
			}
		});
            
}

function del_all(a,b,c)
{
	var v=a;
	var f=b;
	var t=c;
	
	 $.ajax({
			url:"ajax_delete_all?v="+v+"&f="+f+"&t="+t+"", 
			async: false,
			success: function(data){
			
			$('#tble').hide();
			$('#del_all').hide();
			}
		});
            
}
</script>
