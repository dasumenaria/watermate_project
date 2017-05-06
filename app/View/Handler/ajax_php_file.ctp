<?php
if(@$reg_guest_type_ajax==1)
{
      $guest_type_name=$q[0];
			
			if($guest_type_name=='life time')
			{
				echo'<td><label>Wing Name </label></td>
                 <td>
                    <div class="form-group">
                    <input class="form-control input-small"   placeholder="Wing Name" name="wing_name" type="text">
                    </div>
                 </td><td><label>Flat No.</label></td>
                 <td>
                    <div class="form-group">
                    <input class="form-control input-small"   placeholder="Flat No." name="flat_no" type="text">
                    </div>
                 </td>
                <td><label>Floor</label></td>
             	  <td>
                    <div class="form-group">
                    <input class="form-control input-small" autofocus  placeholder="Floor" name="floor" type="text">
                    </div>
               	 </td>'; 
			}
			else
			{
			echo'<input name="wing_name" value="" type="hidden">
			<input name="flat_no" value="" type="hidden">
			<input name="floor" value="" type="hidden">';	
			}
			
		}
if(@$reg_type_select_ajax==1)
        {
$reg_type=$q[0];
			
			if($reg_type=='dependant')
			{
			echo'<table width="60%" id="myTable" style="margin-top:1%;height:auto; margin-left:10%;" border="0">
                    <tr>
                     <td width="40%">
                        <div class="form-group">
                        <input class="form-control input-medium"   placeholder="Name of Cardholder" name="cardholder1" type="text">
                        </div>
                     </td>
                    
                     <td width="40%">
                        <div class="form-group">
                        <input class="form-control input-medium"  placeholder="Name of Applicant" name="applicant1" type="text">
                        </div>
                     </td></tr>
					 <tr><td colspan="5" id="nxt_row"></td></tr>
					<tr><td colspan="2"><button type="button" onclick="registration_addrow();" id="add_btn" class="btn btn-xs btn-primary">Add Row</button></td></tr>
					 <input type="hidden" name="total_row" value="1" id="next_row"/>
                        <input type="hidden" name="exct_row" value="1" id="exct_row"/>
                   
                   
              </table>';	
			}
			else
			{
					echo '<input type="hidden" name="total_row" value="0" id="next_row"/>
                        <input type="hidden" name="exct_row" value="0" id="exct_row"/>';
			}
}
if(@$fetch_outlet_item_mapping==1)
{
   $outlet_id=$q[0];
   $master_item_type_id=$q[1];
   $tr=0;

   foreach($fetch_master_item as $data)
   {
     $tr++;
     $fetch_outlet_item_mapping=$this->requestAction(array('controller' => 'Dreamshapers', 'action' => 'outlet_item_mapping',$outlet_id,$master_item_type_id,$data['master_item']['id']), array());

				 if(sizeof($fetch_outlet_item_mapping)==1)
				{
					?>
                     <tr>
                     <td><input type="checkbox" name="check_<?php echo $tr; ?>" checked="checked" /></td>
                     <td>
                     <select class="form-control input-medium" name="master_item_id_<?php echo $tr; ?>">
                        <option value="<?php echo $data['master_item']['id'];?>"><?php echo $data['master_item']['item_name'];?></option>
                     </select>
                     </td>
                     <td><input type="text" class="form-control input-small" placeholder="Billing Rate" name="billing_rate_<?php echo $tr; ?>" value="<?php echo $fetch_outlet_item_mapping[0]['outlet_item_mapping']['billing_rate'];?>"></td>
                     <td><input type="text" class="form-control input-small" placeholder="Billing Room Rate" name="billing_room_rate_<?php echo $tr; ?>" value="<?php echo $fetch_outlet_item_mapping[0]['outlet_item_mapping']['billing_room_rate'];?>"></td>
                     <td><input type="text" class="form-control input-small" placeholder="Urgent Rate" name="urgent_rate_<?php echo $tr; ?>" value="<?php echo $fetch_outlet_item_mapping[0]['outlet_item_mapping']['urgent_rate'];?>"></td>
                     
                    </tr>
                    <?php
				}
				else
				{
					?>
                     <tr>
                     <td><input type="checkbox" name="check_<?php echo $tr; ?>"/></td>
                     <td>
                     <select class="form-control input-medium" name="master_item_id_<?php echo $tr; ?>">
                        <option value="<?php echo $data['master_item']['id'];?>"><?php echo $data['master_item']['item_name'];?></option>
                     </select>
                     </td>
                      <td><input type="text" class="form-control input-small" placeholder="Billing Rate" name="billing_rate_<?php echo $tr; ?>" value="<?php echo $data['master_item']['billing_rate'];?>"></td>
                     <td><input type="text" class="form-control input-small" placeholder="Billing Room Rate" name="billing_room_rate_<?php echo $tr; ?>" value="<?php echo $data['master_item']['billing_room_rate'];?>"></td>
                     <td><input type="text" class="form-control input-small" placeholder="Urgent Rate" name="urgent_rate_<?php echo $tr; ?>" value=""></td>
                     
                    </tr>
                    <?php
				}
			
			}
}

?>