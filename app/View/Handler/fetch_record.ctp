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
	  <h3 class="box-title">Search</h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
	<form method="get">
		<div class="col-sm-12">
		 <input type="hidden" name="from" value="<?php echo $from; ?>" />
		 <input type="hidden" name="to" value="<?php echo $to; ?>" />
		 <input type="hidden" name="village_id" value="<?php echo $village_id; ?>" />
		 <input type="hidden" name="date_lab_testing" value="<?php echo $date_lab_testing; ?>" />
			<button type="submit" class="btn btn-large btn-primary pull-right print" name="edit_record" value="edit" formaction="edit_data"  style="margin-right: 5px;"><i class="fa fa-edit"></i> Edit</button>
		</div>
	</form>
	<div class="col-sm-12">
		<div class="box-body table-responsive no-padding" id="report">
		<table class="" border="1" style="border-color:1px solid #E1C115;width:3000px;">
			<thead>
				<tr style="background-color:#FFD700;">
					<th rowspan="2">Status as on Date</th><th rowspan="2">Date of Commissioning<br/>of Plant</th><th rowspan="2">District</th><th rowspan="2">MLA Costituency</th><th rowspan="2">Block/Panchayat Samity</th><th rowspan="2">Gram Panchayat</th><th rowspan="2">Name of Village/ Habitation</th><th rowspan="2">Population<br/>(2011 Census)</th><th rowspan="2">Nos. of Household</th><th rowspan="2">Nos. of ATM<br/>Card Issued </th><th rowspan="2">Date of Sample<br/>(Lab Testing)</th><th colspan="3">Raw Water Quality (PPM)</th><th colspan="3">Treated Water Quality (PPM)</th><th rowspan="2">SIM Number</th><th colspan="2" style="width: 168px;">Status as on </th><th rowspan="2">Status (Operational<br/>/Non-operational)</th><th rowspan="2">Reason for Non-operational</th><th rowspan="2">Treated Water TDS (PPM)</th><th rowspan="2">IFR m3/hr</th><th rowspan="2">PFR m3/hr</th><th rowspan="2">Recovery<br/>(PFR/IFR*100)</th><th rowspan="2">Operational Hrs <br/>in a day</th><th rowspan="2">Operational Hrs <br/>as on Date</th><th rowspan="2">Cummulative Volume<br/> Dispensed<br/> (m3 in a day)</th><th rowspan="2">Cummulative Volume<br/>(m3 as on date)</th><th colspan="2">% Penetration </th>
				</tr>
				<tr style="background-color:#FFD700;">
					<th>TDS</th><th>Fl</th><th>No3</th><th>TDS</th><th>Fl</th><th>No3</th><th>Date</th><th>Time</th><th>ATM card based (ATM Card issued/Nos of Household x 100)</th><th>Volume based (Cummulative volume dispensed (m3 in a day)/Total nos of HH x 15 liter per day per HH X100)</th>
				</tr>
			</thead>
			<tbody>
		
<?php
foreach($records as $data_record)
{
			$find_village=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village1',$data_record['record']['village_id']), array());
			$find_village_all=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village_all',$data_record['record']['village_id']), array());
			
			$village_name=$find_village[0]['village']['village_name'];
			
			$find_block=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_block1',$find_village_all[0]['village']['block_id']), array());
			
			$find_district=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_district',$find_block[0]['block']['district_id']), array());
			
				?>
				<tr>
					
					<td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['status_date']), array());?></td>
					<td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$find_village_all[0]['village']['commissioning']), array());?></td>
					<td><?php echo $find_district[0]['district']['district_name']; ?></td>
					<td><?php echo $find_village_all[0]['village']['mla_costituency']; ?></td>
					<td><?php echo $find_block[0]['block']['block_name']; ?></td>
					<td><?php echo $find_village_all[0]['village']['gram_panchayat']; ?></td>
					<td><?php echo $village_name; ?></td>
					<td><?php echo $find_village_all[0]['village']['population']; ?></td>
					<td><?php echo $no_houses=$find_village_all[0]['village']['no_houses']; ?></td>
					<td><?php echo $atmcard=$data_record['record']['atmcard_issues']; ?></td>
					<td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['date_lab_testing']), array());?></td>
					<td><?php echo $data_record['record']['rwq_tds']; ?></td>
					<td><?php echo $data_record['record']['rwq_fl']; ?></td>
					<td><?php echo $data_record['record']['rwq_no']; ?></td>
					<td><?php echo $data_record['record']['twq_tds']; ?></td>
					<td><?php echo $data_record['record']['twq_fl']; ?></td>
					<td><?php echo $data_record['record']['twq_no']; ?></td>
					<td><?php echo $find_village_all[0]['village']['sim_number']; ?></td>
					<td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['status_date']), array());?></td>
					<td><?php echo $data_record['record']['status_time']; ?></td>
					<td><?php echo $status=$data_record['record']['status_plant']; ?></td>
					<td><?php echo $data_record['record']['reason_nonoperational']; ?></td>
					<td><?php echo $data_record['record']['treated_tds']; ?></td>
					<td><?php  if($status=='O'){ echo $ifr=800; } else { echo '-'; } ?></td>
					<td><?php echo $pfr=$data_record['record']['pfr']; ?></td>
					<td><?php echo $recovery=$pfr/$ifr*100; ?></td>
					<td><?php echo $data_record['record']['operational_day']; ?></td>
					<td><?php echo $data_record['record']['operational_date']; ?></td>
					<td><?php echo $cum_vol=$data_record['record']['dispense_day']; ?></td>
					<td><?php echo $data_record['record']['dispense_date']; ?></td>
					<td><?php echo $pen_atm=round((($atmcard/$no_houses)*100),2); ?></td>
				    <td><?php echo $pen_vol=round(($cum_vol/$no_houses*15)*100,2); ?></td>
				</tr>
				<?php
							
}
?>

			</tbody>
		</table>
	
	</div>
</div>
			<div  class="col-sm-12">
				<div class="pull-left">
					<div style="margin-top: 20px;white-space: nowrap;font-weight: 600;">
					Showing &nbsp; <?= $this->Paginator->counter(); ?></div>
					
				</div>
				<div class="pull-right" style="float:right;">
					<div class="paginator" style="float:right;">
						<ul class="pagination">
							
							<li><?= $this->Paginator->first(__('First')) ?></li>
							<?= $this->Paginator->prev(__('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next')) ?>
							<li><?= $this->Paginator->last(__('Last')) ?></li>
						</ul>
						
					</div>
				</div>
			</div>
</div>
</div>
</div>