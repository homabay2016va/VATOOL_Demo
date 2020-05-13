<?php


// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
include("sqlite_functions.php");

$df = new SQLITEDB();
//$vid ="uuid:60fcdf5c-03a9-4fd0-9bee-6f09be19943a";
$vid=$_GET['vid'];
$vid=pg_escape_string($vid);
//echo $vid;
$va = $df ->VADataWHO($vid);
$va2 = json_decode($va);
$map = $df ->createMappingArray();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
$pdf->SetHeaderData("icons/who.jpg", PDF_HEADER_LOGO_WIDTH, "WHO 2016 QUESTIONNAIRE Responses", "Powered by VATool");

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table
$ht= '
<table  border="1" cellpadding="10">
	<tr>
		<th colspan="2" style="text-align:center;"><img src="icons/who.jpg" width="" height="80px"/></th>
	</tr>
	<tr>
		<td><b>Question</b></td>
		<td><b>Response</b></td>
	</tr>';
	
foreach ($va2[0] as $key => $value) {
	if(ltrim(rtrim($value))=='' | ltrim(rtrim($value))==' '){

	}else{
		$h = 10;
		$w=140;
		$w2=50;
		$rt = strtolower($key);

		if(array_key_exists($rt, $map)){
			//$pdf->Cell(50,$h,ltrim(rtrim($value)),1,1,"L");
			 $ht=$ht.'<tr>
				 <td height="30px" >'.$map[$rt].'</td>
				 <td>'.ltrim(rtrim($value)).'</td>
				 </tr>';			

		}else{
			//echo "not found".$rt; strlen($map[$rt])
		}
	} #end if blank
} #end for loop

$ht= $ht.'</table>';

$pdf->writeHTML($ht, true, false, true, $cell=false, '');

// reset pointer to the last page
//$pdf->lastPage();

// ---------------------------------------------------------



//Close and output PDF document ,I,D,FD,f
$pdf->Output('vadata_'.str_replace(":", "-", $vid).'_.pdf', 'I');

//echo "<div class='alert alert-success alert-dismissible fade show'
					//		style='margin-top:5px;' id='message'>
				//			Downloaded successfuly!
						//	</div>";
	//echo "<script>
					//	$('#message').dialog({
					  //	modal:true,
					 // 	title:'Download status',
					//  	height:200,
					//  	width:400,										 
				     //   position: { my: 'center',
				     //   			at:'top'
				   // 				}
					//  });
				//</script>";

//exec("EXPLORER C:\\tcpdf\\");
//============================================================+
// END OF FILE
//============================================================+
?>