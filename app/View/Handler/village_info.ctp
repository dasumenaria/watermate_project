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
fieldset {
	padding: 13px !important;
    margin: 5px !important;
	border: 2px !important;
}
</style>
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title">Village Informetion</h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
	 
    <div class="box-body table-responsive no-padding"  id="report" style="margin-top:5px;">
    <div class="col-md-12" align="right">
    	<div style="width:30%">
   	 	<!--<input type="text" class="form-control " id="search" placeholder="Type to search">---------->
        </div>
    </div>
    <div class="col-md-12" id="#table">
   <?php
   foreach($village_record as $village_data)
	{
		?>
        <fieldset>
        <legend style="width:20% !important"> <label class="control-label"> &nbsp; <?php echo $village_data['village']['village_name'] ?> &nbsp;</label></legend>
        
    <table class="table table-bordered" border="1" style="border-color:1px solid #E1C115; margin-top:0px">
    <tr style="background-color:#FFD700;">
        <th>Village Name</th><th>Latitude</th><th>Longitude</th><th>Executive Engineer</th><th>Assistant Engineer</th><th>Junior Engineer</th><th>Operator</th><th>Customer Care No.</th><th>Land Allocation</th>
        </tr>
    	<tr>
		<?php
        
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
        
    </tr>
	<tr style="background-color:rgba(255, 215, 0, 0.54);">
	<th>Water Connection</th><th>Electrical Connection</th><th>Foundation</th><th>Flooring</th><th>Shelter Erection</th><th>Water Tank</th><th>Plant Installation</th><th>Commissioining</th> <th></th>
	</tr>
    <tr>
        <td><?php if($village_data['village']['water_connection']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['water_connection'])); } ?></td>
        <td><?php if($village_data['village']['electrical_connection']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['electrical_connection'])); } ?></td>
        <td><?php if($village_data['village']['foundation']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['foundation'])); } ?></td>
        <td><?php if($village_data['village']['flooring']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['flooring'])); } ?></td>
        <td><?php if($village_data['village']['shelter_erection']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['shelter_erection'])); } ?></td>
        <td><?php if($village_data['village']['water_tank']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['water_tank'])); } ?></td>
        <td><?php if($village_data['village']['plant_installation']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['plant_installation'])); } ?></td>
        <td><?php if($village_data['village']['commissioning']!='0000-00-00') { echo date('d-m-Y', strtotime($village_data['village']['commissioning'])); } ?></td>
        <th></th>
	</tr>
    </table>
    </fieldset>									
	<?php
    }
    ?>					
	</div>					
						
						
				
			</div>
	</div>
</div>
</div>
<script src="<?php echo $this->webroot; ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script>
var $rows = $('.table');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
    
    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>

