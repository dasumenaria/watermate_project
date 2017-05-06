<style>
.w3-btn-floating {
    -webkit-transition: background-color .3s,color .15s,box-shadow .3s,opacity 0.3s;
    transition: background-color .3s,color .15s,box-shadow .3s,opacity 0.3s;
}
.w3-btn-floating {
    width: 40px;
    height: 40px;
    line-height: 40px;
}
.w3-btn-floating, .w3-btn-floating-large {
    display: inline-block;
    text-align: center;
    color: #fff;
    background-color:#000;
    position: relative;
    overflow: hidden;
    z-index: 1;
    padding: 0;
    border-radius: 50%;
    cursor: pointer;
    font-size: 24px;
}
.w3-content,.mySlides
{
	width:100%;
	height: 400px;
	margin:auto;
}
 #map {
        width: 100%;
        height: 400px;
     }
</style>
 

<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title"><?php echo $village_name; ?></h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
		<div class="col-md-12">
		<div class="col-md-6">
		<div class="w3-content" style="max-width:800px;position:relative">
			<?php
			foreach($images as $data_image)
			{
				?>
				<img class="mySlides" src="<?php echo $data_image; ?>" style="width:100%">
				<?php
			}
			?>
			
			<a class="w3-btn-floating" style="position:absolute;top:45%;left:0" onclick="plusDivs(-1)">&#10094;</a>
			<a class="w3-btn-floating" style="position:absolute;top:45%;right:0" onclick="plusDivs(1)">&#10095;</a>
		</div>
		</div>
		<div class="col-md-6">
		<div id="map"></div>
		</div>
		</div>
		<form method="get" id="form">
			<input type="hidden" name="village_id" value="<?php echo $village_id; ?>" />
			<div class="col-sm-12">
			<div class="box-body table-responsive no-padding"  id="report" style="margin-top:10px;">
				<table class="table table-bordered" border="1" style="border-color:1px solid #E1C115;">
						
							<tr style="background-color:#FFD700;">
								<th>Village</th><th>Latitude</th><th>Longitude</th><th>Executive Engineer</th><th>Assistant Engineer</th><th>Junior Engineer</th><th>Operator</th><th>Customer Care No.</th><th>Land Allocation</th>
								</tr>
								<tr>
									<?php
									foreach($result_village as $village_data)
									{
										$latitude=$village_data['village']['latitude'];
										$longitude=$village_data['village']['longitude'];
										$village_name=$village_data['village']['village_name'];
										?>
										<td><?php echo $village_name; ?></td>
										<td><?php echo $latitude; ?></td>
										<td><?php echo $longitude; ?></td>
										<td><?php echo $village_data['village']['executive_engineer']; ?></td>
										<td><?php echo $village_data['village']['assistant_engineer']; ?></td>
										<td><?php echo $village_data['village']['junior_engineer']; ?></td>
										<td><?php echo $village_data['village']['operator']; ?></td>
										<td><?php echo $village_data['village']['customer_care_no']; ?></td>
										<td><?php echo  $village_data['village']['land_allocation']; ?></td>
										<?php
									}
									?>
								</tr>
								<tr style="background-color:#FFD700;">
								<th>Water Connection</th><th>Electrical Connection</th><th>Foundation</th><th>Flooring</th><th>Shelter Erection</th><th>Water Tank</th><th>Plant Installation</th><th>Commissioining</th><th></th>
								</tr>
							<?php
									foreach($result_village as $village_data)
									{
										?>
										<td><?php if($village_data['village']['water_connection']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['water_connection'])); } ?></td>
										<td><?php if($village_data['village']['electrical_connection']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['electrical_connection'])); } ?></td>
										<td><?php if($village_data['village']['foundation']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['foundation'])); } ?></td>
										<td><?php if($village_data['village']['flooring']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['flooring'])); } ?></td>
										<td><?php if($village_data['village']['shelter_erection']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['shelter_erection'])); } ?></td>
										<td><?php if($village_data['village']['water_tank']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['water_tank'])); } ?></td>
										<td><?php if($village_data['village']['plant_installation']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['plant_installation'])); } ?></td>
										<td><?php if($village_data['village']['commissioning']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['commissioning'])); } ?></td>
										<th></th>
										
										<?php
									}
									?>
						
						
						
						
				</table>
			</div>
			<div>
			<div class="col-sm-12">
			 <div class="form-group col-sm-4">
					<label>Date range:</label>
						<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
							<input class="form-control" name="from" type="text">
							<span class="input-group-addon" style="background-color:e5e5e5 !important;">
							To </span>
							<input class="form-control" name="to" type="text">
						</div>
						<span class="help-block">
						Select date range </span>
					<!-- /.input group -->
				  </div>
				
			  <div class="form-group col-sm-2">
			  <label></label>
				<button type="submit" name="find_record" class="btn btn-block btn-primary" formaction="record">Record</button>
				</div>
			</div>
			
		</form>
  </div>
  <!-- /.box -->
          
</div>
<?php

?>
<script>
      function initMap() {
        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
            center: {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>},
            zoom: 14
        });
      }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBi9JcS52KiZiERTS9Kd8GyJx106T866Yw&callback=initMap">
    </script>

<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

<script> 
$(document).ready(function() { 

	$('.applyBtn').on('click',function() {
		var daterangepicker_start=$('input[name="daterangepicker_start"]').val();
		var daterangepicker_end=$('input[name="daterangepicker_end"]').val();
		
		var village_id='<?php if(!empty($village_id)){ echo $village_id; } ?>';
		$.ajax({
		url: "ajax_php_file?search_report=1&daterangepicker_start="+daterangepicker_start+"&daterangepicker_end="+daterangepicker_end+"&village_id="+village_id,
		type: "POST",         
		success: function(data)
		{
			$("#find_data").html(data);
		}
		});
		
	});
	
	
});
var slideIndex = 1;
showDivs(slideIndex);
function showDivs(n) {
	
    var i;
    var x = document.getElementsByClassName("mySlides");
    if (n > x.length) {slideIndex = 1}
    if (n < 1) {slideIndex = x.length} ;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[slideIndex-1].style.display = "block";
}
$(function() {
	setInterval( "showDivs(slideIndex += 1)", 5000 );
} );
function plusDivs(n) {
	
    showDivs(slideIndex += n);
} 

</script>