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
	<div class="box-header with-border" align="center">
	  <h1 class="box-title">Report</h1>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
	<form method="get">
		<div class="col-sm-12" align="right">
		 <input type="hidden" name="from" value="<?php echo $from; ?>" />
		 <input type="hidden" name="to" value="<?php echo $to; ?>" />
		 
		<button type="submit" class="btn btn-sm btn-primary pull-right print" name="complete_data" value="Watermate" formaction="complete_excel_website"  style="margin-right: 5px;"><i class="fa fa-download"></i>Download Excel</button>
		</div>
	</form>
	<div class="col-sm-12">
		<div class="box-body table-responsive no-padding" id="report">
		<table class="" border="1" style="border-color:1px solid #E1C115;width:100%;">
			<thead>
				<tr style="background-color:#FFD700;">
                	<th rowspan="2">S.No.</th>
                     <th rowspan="2">District</th>
                    <th rowspan="2">MLA Costituency</th>
                    <th rowspan="2">Block/Panchayat Samity</th>
                    <th rowspan="2">Gram Panchayat</th>
                    <th rowspan="2">Name of Village/ Habitation</th>
                    <th rowspan="2">Population<br/>(2011 Census)</th>
                    <th rowspan="2">Output Capacity of RO plant    in LPH</th>
                    <th rowspan="2">Nos. of Household</th>
                     <th rowspan="2">Date of Sample<br/>(Lab Testing)</th>
                    <th colspan="3">Raw Water Quality (PPM)</th>
                    <th colspan="3">Treated Water Quality (PPM)</th>
                    <th rowspan="2">Date of Commissioning<br/>of Plant</th>
                     <th colspan="3" style="width: 168px;">Preasent status of Q&M </th>
                      
				</tr>
				<tr style="background-color:#FFD700;">
					<th>TDS</th>
                    <th>Fl</th>
                    <th>No3</th>
                    <th>TDS</th>
                    <th>Fl</th>
                    <th>No3</th>
                    <th>Date of Report</th>
                    <th>whether oprational (Yes/No)</th>
                    <th>If no, reasons of being non oprational</th>
				</tr>
			</thead>
			<tbody>
		
<?php
$i=0;
foreach($village_records as $data_record)
{$i++;
			$find_village=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village1',$data_record['record']['village_id']), array());
			$find_village_all=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_village_all',$data_record['record']['village_id']), array());
			
			$village_name=$find_village[0]['village']['village_name'];
			
			$find_block=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_block1',$find_village_all[0]['village']['block_id']), array());
			
			$find_district=$this->requestAction(array('controller' => 'Handler', 'action' => 'find_district',$find_block[0]['block']['district_id']), array());
			if($find_village_all[0]['village']['commissioning'] != '0000-00-00' ){
				?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $find_district[0]['district']['district_name']; ?></td>
                <td><?php echo $find_village_all[0]['village']['mla_costituency']; ?></td>
                <td><?php echo $find_block[0]['block']['block_name']; ?></td>
                <td><?php echo $find_village_all[0]['village']['gram_panchayat']; ?></td>
                <td><?php echo $village_name; ?></td>
                <td><?php echo $find_village_all[0]['village']['population']; ?></td>
                <td>500</td>
                <td><?php echo $data_record['record']['atmcard_issues']; ?></td>
                <td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['date_lab_testing']), array());?></td>
                <td><?php echo $data_record['record']['rwq_tds']; ?></td>
                <td><?php echo $data_record['record']['rwq_fl']; ?></td>
                <td><?php echo $data_record['record']['rwq_no']; ?></td>
                <td><?php echo $data_record['record']['twq_tds']; ?></td>
                <td><?php echo $data_record['record']['twq_fl']; ?></td>
                <td><?php echo $data_record['record']['twq_no']; ?></td>
                <td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$find_village_all[0]['village']['commissioning']), array());?></td>
                <td><?php echo @$this->requestAction(array('controller' => 'Handler', 'action' => 'dateforview',$data_record['record']['status_date']), array());?></td>
                <td><?php echo $status=$data_record['record']['status_plant']; ?></td>
                <td><?php echo $data_record['record']['reason_nonoperational']; ?></td>
 			</tr>
				<?php
			}
							
}
?>

			</tbody>
		</table>
	
	</div>
</div>
			 
</div>
</div>
</div>