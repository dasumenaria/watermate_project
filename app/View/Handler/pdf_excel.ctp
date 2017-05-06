<?php
if($export_in=='excel')
{
	$file_name=date('d-m-Y');
	header("Content-Type: application/xls");
	header("Content-Disposition: attachment; filename=$file_name.xls");
	header("Content-Type: application/force-download");
	header("Cache-Control: post-check=0, pre-check=0", true);
	echo $export_data;
}
if($export_in=='pdf')
{
	App::import('Vendor','xtcpdf');  
	$tcpdf = new XTCPDF(); 
	$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans' 
	
	$tcpdf->SetAuthor("Ashish Bohara"); 
	$tcpdf->SetAutoPageBreak( true ); 
	//$tcpdf->setHeaderFont(array($textfont,'',40)); 
	$tcpdf->xheadercolor = array(255,255,255); 
	$tcpdf->xheadertext = ''; 
	$tcpdf->xfootertext = 'UCCI';
	
	// add a page (required with recent versions of tcpdf) 
	$tcpdf->AddPage(); 
	
	// Now you position and print your page content 
	// example:  
	$tcpdf->SetTextColor(0, 0, 0); 
	$tcpdf->SetFont($textfont,12); 
	$tcpdf->SetLineWidth(0.1);
	
	$tcpdf->writeHTML($export_data);
	
	echo $tcpdf->Output($file_name.'.pdf', 'D'); 
}


?>