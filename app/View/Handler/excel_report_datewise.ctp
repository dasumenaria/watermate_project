<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=Excel_report.xls");
header("Content-Type: application/force-download");
header("Cache-Control: post-check=0, pre-check=0", true);?>
			
			<div class="col-sm-12">
			<div class="box-body table-responsive no-padding"  id="report">
				<table class="table table-bordered" border="1">
					<thead>
						<tr>
						<th rowspan="2">Date of commissioning of plant</th><th rowspan="2">District</th><th rowspan="2">MLA Costituency</th><th rowspan="2">Block/Panchayat Samity</th><th rowspan="2">Gram Panchayat</th><th rowspan="2">Name of Village/ habitation</th><th rowspan="2">Poulation ( 2011 Census)</th><th rowspan="2">Nos of Household</th><th rowspan="2">Nos. of ATM Card issued </th><th rowspan="2">Date of sample (lab testing)</th><th colspan="3">Raw water Quality (PPM)</th><th colspan="3">Treated water Quality (PPM)</th><th rowspan="2">SIM Number</th><th colspan="2">Status as on </th><th rowspan="2">Status (operational/Non operational)</th><th rowspan="2">Reason for Non-Operational</th><th rowspan="2">Treated water TDS ppm</th><th rowspan="2">IFR m3/hr</th><th rowspan="2">PFR m3/hr</th><th rowspan="2">Recovery (in %)(23-24)/23*100)</th><th rowspan="2">Operational Hrs in a day</th><th rowspan="2">Operational Hrs as on date</th><th rowspan="2">Cummulative volume dispensed (m3 in a day)</th><th rowspan="2">Cummulative volume (m3 as on date)</th><th colspan="2">% Penetration </th>
						</tr>
						<tr>
							<th>TDS</th><th>Fl</th><th>No3</th><th>TDS</th><th>Fl</th><th>No3</th><th>Date</th><th>Time</th><th>ATM card based (9/8 x100)</th><th>Volume based (Col-29/Total nos of HH x 15 liter per day per HH X100)</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($result_record as $data_record)
					{
						?>
						<tr>
							<td><?php echo date('d-m-Y',strtotime($data_record['record']['date_commission'])); ?></td>
							<td><?php echo $result_district[0]['district']['district_name']; ?></td>
							<td><?php echo $data_record['record']['mla_costituency']; ?></td>
							<td><?php echo $result_block[0]['block']['block_name']; ?></td>
							<td><?php echo $data_record['record']['gram_panchayat']; ?></td>
							<td><?php echo $result_village[0]['village']['village_name']; ?></td>
							<td><?php echo $data_record['record']['population']; ?></td>
							<td><?php echo $data_record['record']['no_houses']; ?></td>
							<td><?php echo $data_record['record']['atmcard_issues']; ?></td>
							<td><?php echo date('d-m-Y',strtotime($data_record['record']['date_lab_testing'])); ?></td>
							<td><?php echo $data_record['record']['rwq_tds']; ?></td>
							<td><?php echo $data_record['record']['rwq_fl']; ?></td>
							<td><?php echo $data_record['record']['rwq_no']; ?></td>
							<td><?php echo $data_record['record']['twq_tds']; ?></td>
							<td><?php echo $data_record['record']['twq_fl']; ?></td>
							<td><?php echo $data_record['record']['twq_no']; ?></td>
							<td><?php echo $data_record['record']['sim_number']; ?></td>
							<td><?php echo date('d-m-Y',strtotime($data_record['record']['status_date'])); ?></td>
							<td><?php echo $data_record['record']['status_time']; ?></td>
							<td><?php echo $data_record['record']['status_plant']; ?></td>
							<td><?php echo $data_record['record']['reason_nonoperational']; ?></td>
							<td><?php echo $data_record['record']['treated_tds']; ?></td>
							<td><?php echo $data_record['record']['ifr']; ?></td>
							<td><?php echo $data_record['record']['pfr']; ?></td>
							<td><?php echo $data_record['record']['recovery']; ?></td>
							<td><?php echo $data_record['record']['operational_day']; ?></td>
							<td><?php echo date('d-m-Y',strtotime($data_record['record']['operational_date'])); ?></td>
							<td><?php echo $data_record['record']['dispense_day']; ?></td>
							<td><?php echo date('d-m-Y',strtotime($data_record['record']['dispense_date'])); ?></td>
							<td><?php echo $data_record['record']['penetration_atm']; ?></td>
							<td><?php echo $data_record['record']['penetration_volume']; ?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div>
			</div>
			