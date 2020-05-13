<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
include("sqlite_functions.php");

$df = new SQLITEDB();
$vid ="uuid:60fmho5c-0009-4fd0-9bee-6k09be20203a";
$va = $df ->VADataWHO($vid);
$va2 = json_decode($va);
$map = $df ->createMappingArray();
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


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
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table
$ht= '
<table  border="1" cellpadding="10">
	<tr>
		<td>Question</td>
		<td>Response</td>
	</tr>';
	
foreach ($va2[0] as $key => $value) {
	if(ltrim(rtrim($value))=='' | ltrim(rtrim($value))==' '){

	}else{
		$h = 10;
		$w=140;
		$w2=50;
		$rt = strtolower($key);

		if(array_key_exists($rt, $map)){
			/*$len = strlen($map[$rt]);
			$len2 = strlen(ltrim(rtrim($value)));
			$lines = $len/$w;
			$lines2 = $len2/$w2;*/
			//$pdf->Cell($w,$h,$map[$rt],1,0,"L"); 		
			//$pdf->Cell(50,$h,ltrim(rtrim($value)),1,1,"L");
		
			 /*if($lines>0.4){
			 	$pdf->MultiCell($w,$h,$map[$rt]." lines".$lines,1,"L");
				$xpos = $pdf->GetX();
				$ypos = $pdf->GetY(); 	
				$pdf->SetXY($xpos+$w, ($ypos-$h)-$h);
				$pdf->MultiCell($w2,2*$h,ltrim(rtrim($value)),1,"L"); 
			 }else{
	 			$pdf->MultiCell($w,$h,$map[$rt]." lines".$lines,1,"L");
				$xpos = $pdf->GetX();
				$ypos = $pdf->GetY(); 	
				$pdf->SetXY($xpos+$w, $ypos-$h);
				$pdf->MultiCell($w2,$h,ltrim(rtrim($value))." lin2 ".$lines2,1,"L");
			 	 
			 }*/
				
			//$pdf->Cell(50,$h,ltrim(rtrim($value)),1,1,"L");
			 $ht=$ht.'<tr>
				 <td height="40px" >'.$map[$rt].'</td>
				 <td>'.ltrim(rtrim($value)).'</td>
				 </tr>';			

		}else{
			//echo "not found".$rt; strlen($map[$rt])
		}
	} #end if blank
} #end for loop

$ht= $ht.'</table>';

$pdf->writeHTML($ht, true, false, true, $cell=false, '');
// create some HTML content
$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';

$html = '<h2>HTML TABLE:</h2>
<table border="1" cellspacing="3" cellpadding="4">
    <tr>
        <th>#</th>
        <th align="right">RIGHT align</th>
        <th align="left">LEFT align</th>
        <th>4A</th>
    </tr>
    <tr>
        <td>1</td>
        <td bgcolor="#cccccc" align="center" colspan="2">A1 ex<i>amp</i>le <a href="http://www.tcpdf.org">link</a> column span. One two tree four five six seven eight nine ten.<br />line after br<br /><small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal  bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla<ol><li>first<ol><li>sublist</li><li>sublist</li></ol></li><li>second</li></ol><small color="#FF0000" bgcolor="#FFFF00">small small small small small small small small small small small small small small small small small small small small</small></td>
        <td>4B</td>
    </tr>
    <tr>
        <td>'.$subtable.'</td>
        <td bgcolor="#0000FF" color="yellow" align="center">A2 € &euro; &#8364; &amp; è &egrave;<br/>A2 € &euro; &#8364; &amp; è &egrave;</td>
        <td bgcolor="#FFFF00" align="left"><font color="#FF0000">Red</font> Yellow BG</td>
        <td>4C</td>
    </tr>
    <tr>
        <td>1A</td>
        <td rowspan="2" colspan="2" bgcolor="#FFFFCC">2AA<br />2AB<br />2AC</td>
        <td bgcolor="#FF0000">4D</td>
    </tr>
    <tr>
        <td>1B</td>
        <td>4E</td>
    </tr>
    <tr>
        <td>1C</td>
        <td>2C</td>
        <td>3C</td>
        <td>4F</td>
    </tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
//$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+