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
              <h3 class="box-title">Booking Status</h3>
            </div>
		</div>
      <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Name </th>
                  <th>Mobile No</th>
                  <th>Trip No </th>
                  <th>Travel From </th>
                  <th>Travel To </th>
                  <th>Date of Travel </th>
                  <th>Type </th>
                  <th style="width: 40px">Booking Status</th>
				  <th style="text-align:center">Action</th>
                </tr>
                <?php
				$i=0;
				foreach($result_booking as $booking){
					$i++;
					if($booking['bookingtrip']['status']==1){ $status_view='<span class="badge bg-yellow">Under Process</span>'; }
					if($booking['bookingtrip']['status']==2){ $status_view= '<span class="badge bg-green">Admin Booking</span>'; }
					if($booking['bookingtrip']['status']==3){ $status_view= '<span class="badge bg-blue">User Booking</span>'; }
					if($booking['bookingtrip']['status']==4){ $status_view= '<span class="badge bg-red">Rejected</span>'; }
					if($booking['bookingtrip']['status']==5){ $status_view= '<span class="badge bg-red">User Cancelled</span>'; }
					$login_data=$this->requestAction(array('controller' => 'Handler', 'action' => 'loginDataFetch',$booking['bookingtrip']['user_id']), array());
				?>
                <tr>
                  <td><?php echo $i; ?></td>
				  
                  <td><?php echo $login_data[0]['user_login']['username'];?></td>
                  <td><?php echo $login_data[0]['user_login']['mobile_no'];?></td>
                  <td><?php echo $booking['bookingtrip']['trip_id'];?></td>
                  <td><?php echo $booking['bookingtrip']['travel_from'];?></td>
                  <td><?php echo $booking['bookingtrip']['travel_to'];?></td>
                  <td><?php echo $booking['bookingtrip']['date_of_travel'];?></td>
                  <td><?php echo $booking['bookingtrip']['type'];?></td>
                  <td><?php echo $status_view; ?></td>
				  <td>
					 
						<div class="btn-group">
						  <button type="button" class="btn btn-default">Action</button>
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
							<li><a data-toggle="modal" href="#reject<?php echo $booking['bookingtrip']['id']; ?>">Reject</a></li><li class="divider"></li>
							<li><a data-toggle="modal" href="#user_book<?php echo $booking['bookingtrip']['id']; ?>">User Book</a></li><li class="divider"></li>
							<li><a data-toggle="modal"  href="#admin_book<?php echo $booking['bookingtrip']['id']; ?>">Book Ticket</a></li> 
 						  </ul>
						</div>
				  </td>
                </tr>
				<div class="modal fade" id="reject<?php echo $booking['bookingtrip']['id']; ?>" tabindex="-1" role="basic" aria-hidden="true" >
					<div class="modal-dialog">
 						<div class="modal-content">
							<form method="POST">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title"><strong>Do you want to reject this booking </strong></h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
									  <label>Reason for Rejection</label>
									  <textarea class="form-control" rows="3" name="reason"></textarea>
									</div>
								</div>
								<input type="hidden" name="update_id" value="<?php echo $booking['bookingtrip']['id']; ?>">
								<input type="hidden" name="user_id" value="<?php echo $booking['bookingtrip']['user_id']; ?>">
								<div class="modal-footer">
									<button type="button" class="btn default" data-dismiss="modal">Close</button>
									<button type="submit" name="reject_booking" class="btn btn-danger">Reject</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="user_book<?php echo $booking['bookingtrip']['id']; ?>" tabindex="-1" role="basic" aria-hidden="true" >
					<div class="modal-dialog">
						 
						<div class="modal-content">
							<form method="POST">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title"><strong>Do you want to process </strong></h4>
								</div>
								<input type="hidden" name="update_id" value="<?php echo $booking['bookingtrip']['id']; ?>">
								<input type="hidden" name="user_id" value="<?php echo $booking['bookingtrip']['user_id']; ?>">
								<div class="modal-footer">
									<button type="button" class="btn default" data-dismiss="modal">Close</button>
									<button type="submit" name="user_booking" class="btn btn-primary">User Book</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal fade" id="admin_book<?php echo $booking['bookingtrip']['id']; ?>" tabindex="-1" role="basic" aria-hidden="true" >
					<div class="modal-dialog">
 						<div class="modal-content">
							<form method="POST" enctype="multipart/form-data">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title"><strong>Do you want to book ticket </strong></h4>
								</div>
								<div class="modal-body">
									<div class="form-group">
									  <label>Upload Ticket</label>
									  <input type="file" name="ticket" id="exampleInputFile">
									</div>
								</div>
								<input type="hidden" name="update_id" value="<?php echo $booking['bookingtrip']['id']; ?>">
								<input type="hidden" name="trip_id" value="<?php echo $booking['bookingtrip']['trip_id']; ?>">
								<input type="hidden" name="user_id" value="<?php echo $booking['bookingtrip']['user_id']; ?>">
								<div class="modal-footer">
									<button type="button" class="btn default" data-dismiss="modal">Close</button>
									<button type="submit" name="ticket_booking" class="btn btn-danger">Book Ticket</button>
								</div>
							</form>
						</div>
					</div>
				</div>
              <?php }?> 

			  
              </tbody>
              </table>  
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
