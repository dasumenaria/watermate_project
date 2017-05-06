					<table style="border-color:1px solid #E1C115;">
						<thead>
							<tr style="background-color:#FFD700;"  >
								<th class="headcol">Village Name</th>
								<th>Latitude</th><th>Longitude</th><th>Executive Engineer</th><th>Assistant Engineer</th><th>Junior Engineer</th><th>Operator</th><th>Customer Care No.</th><th>Land Allocation</th><th>Water Connection</th><th>Electrical Connection</th><th>Foundation</th><th>Flooring</th><th>Shelter Erection</th><th>Water Tank</th><th>Plant Installation</th><th>Commissioining</th><th>MLA Costituency</th><th>Gram Panchayat</th><th>Population</th><th>Nos of Household</th><th>SIM NUMBER</th><th>IFR</th>
							</tr>
						</thead>
						
						
						<tbody>
						
						
						<?php
						foreach($village as $village_data)
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
								<td><a href="#" class="editable_text" field_name="land_allocation" table_id="<?php echo $village_data['village']['id']; ?>"  data-type="date" data-format="yyyy-mm-dd" data-viewformat="dd-mm-yyyy" data-pk="1"><?php  if(!empty($village_data['village']['land_allocation'])){ echo date('d-m-Y',strtotime($village_data['village']['land_allocation'])); } ?></a></td>
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
