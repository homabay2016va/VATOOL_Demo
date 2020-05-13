<?php
include("header.php");
?>

<style type="text/css">

	.content{
		width: 100%;
	}
	#ana_leftnav{
		width: 17vw;
	    min-width: 150px;
	    max-width: 20vw;
	    background-color:white;
	    border-right: inset 1px;
	    padding-top:40px ; 
	    float: left;
	    height: 200vh;
	    align-items: stretch;
	}


.midcontent{
		width: 50vw;
	}

	ul.pagination li{
	margin-left: ;
	border: solid 1px #ddd;
	width: auto;
	text-align: center;
	padding-left: 10px;
	padding-right: 10px;
	
}
ul.pagination {
	width: 300px;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
  justify-content: flex-start;
}

tr,td {
	font-size: 12px;
}

div.dataTables_wrapper div.dataTables_filter {
    margin-left: 20vw;
}


.summaryTable{
	width: 300px;
}

</style>

 <script type="text/javascript">
	$(document).ready(function() { 
		//$('#viewint').DataTable({
		//	"pagingType": "simple_numbers" 
		//}); 

		$('#intsumTbl').DataTable({
			"pagingType": "simple_numbers" 
		}); 

		$('#cusumTbl').DataTable({
			"pagingType": "simple_numbers" 
		}); 

	});
	</script>
<body >
	<?php 
	include("connection.php");
	include("sqlite_functions.php");
	$df = new SQLITEDB();

	$Years = $df->csmfYear();
	$yr = $Years['year'];
	//var_dump($yr);
	$Years2 = $df->VASubmissionYear();
	$yr2 = $Years2['year'];
	//$Years = $df->VASubmissionYear();
	//$vaforms = $df->countForms();
	//$adult = $vaforms['adult'];
	//$child = $vaforms['child'];
	//$neonate = $vaforms['neonate'];
	//$totalforms = $vaforms['vacnt'];


?>
<div class="container-fluid">			
			<?php include("navheader.php"); ?>
		<!-- left nav menu-->
		<script type="text/javascript">
			//add class active for active link of current page
			document.querySelector('.active').classList.remove('active');
			document.querySelector('.vaanalytics').classList.add('active');
		</script>
		<div class="content" >
			<?php //include("navleft.php"); ?>
			<div id="ana_leftnav">						
				<nav class="" id="leftnavlist">
					<form action="#midcontent" method="POST">
					<ul>
						<li>
							<b>Data</b>
							<ul>
								<li>
									<select class="form-control" name="dtype" style="width: 200px; margin-left: 20px; font-size: 12px;" id="csmf_list">
										<option>VA SUMMARY By Year</option>
										<option>VA SUMMARY BY SEX</option>
										<option>VA SUMMARY BY AGE GROUP</option>
									</select>
								</li>
							</ul>
						</li>
						
						<li>	
											
								<b style="font-size: 20px;" class="text-danger"><i>Period</i></b>
							<ul style="margin-top: 8px;">
								<li id="csmf"><b>Year of death</b>
									<select class="form-control" name="year" style="width: 120px; margin-left: 30px;" id="year">
											<?php
											 foreach($yr as $y) {
											 	 echo "<option>".$y."</option>";
											 }
									 	    ?>
									</select>
								</li>
								
							</ul>
							<ul style="margin-top: 8px;">
								<li><input type="submit" name="search" value="Search" class="btn btn-success">
								</li>
							</ul>

						</li>
					</ul>	
				</form>	
				<hr></hr>	
				<form action="#midcontent" method="POST">
					<ul>
						<li>
							<b>Submission Data</b>
							<ul>
								<li>
									<select class="form-control" name="dtype2" style="width: 200px; margin-left: 20px; font-size: 12px;" id="csmf_list2">
										<option >VA SUBMISSION</option>
									</select>
								</li>
							</ul>
						</li>
						
						<li>							
								<b style="font-size: 20px;" class="text-danger"><i>Period</i></b>
							<ul style="margin-top: 8px;">
								<li id="csmf"><b>Year</b>
									<select class="form-control" name="year2" style="width: 120px; margin-left: 30px;" id="year2">
											<?php
											 foreach($yr2 as $y) {
											 	 echo "<option>".$y."</option>";
											 }
									 	    ?>
									</select>
								</li>
								
							</ul>
							<ul style="margin-top: 8px;">
								<li><input type="submit" name="search2" value="View" class="btn btn-success">
								</li>
							</ul>

						</li>
					</ul>	
				</form>		    	     		   
				</nav>
			 </div>
			 <div class="midcontent">
			 	<?php
			 		if(isset($_POST['dtype'])){

			 		
			 	?>
				<script type="text/javascript">
					document.getElementById('csmf_list').value='<?php echo $_POST['dtype']; ?>'
					document.getElementById('year').value='<?php echo $_POST['year']; ?>'
				</script>
				<?php
					}
				?>
					<div class="row">
						<div id="vaPlots" style=""></div>
							<div class="col-sm-7" id="vagraph" style="float: left; ">
							  	<div id="vagraphPlot" style=""></div>							  		 
							</div>
				
			       </div>
			       <div class="row">
						<div id="vaPlots" style=""></div>
							<div class="col-sm-7" id="vagraph" style="float: left; ">
							  	<div id="vagraphPlot_bar" style=""></div>							  		 
							</div>
				
			       </div>
			        <?php
				if(isset($_POST['search'])){
					$year = $_POST['year'];
					$vaforms = $df->countFormsYear($year);
					//var_dump($vaforms);
					$adult = $vaforms['adult'];
					$child = $vaforms['child'];
					$neonate = $vaforms['neonate'];
					$totalforms = $vaforms['vacnt'];

					?>
					<!--<div class="row" style="margin-bottom:30px;">
				    <div class="col-sm" id="quicksummary">	
				   	<span class="txtsummary"><b>Adult forms</b></span>
				    <p><i><?php //echo $adult." (".(int)(($adult/$totalforms)*100)."%)";?></i></p>
					    <div class="progress">
						  <div class="progress-bar" role="progressbar" style="width:<?php //echo (int)(($adult/$totalforms)*100);?>%" aria-valuenow="25" 
						  aria-valuemin="0" aria-valuemax="100"
						  title="<?php //echo (int)(($adult/$totalforms)*100);?>"></div>
						</div>		      
				    </div>

				    <div class="col-sm" id="quicksummary">
				      <span class="txtsummary"><b>Child forms</b></span>
				      <p><i><?php// echo $child." (".(int)(($child/$totalforms)*100)."%)";?></i></p>
					    <div class="progress">
						  <div class="progress-bar" role="progressbar" style="width:<?php //echo (int)(($child/$totalforms)*100);?>%;
						   background:#993300;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
						  title="<?php //echo (int)(($child/$totalforms)*100);?>"></div>
						</div>
						
				    </div>
				    <div class="col-sm" id="quicksummary">
				       <span class="txtsummary"><b>Neonate forms</b></span>
				       <p><i><?php //echo $neonate." (".(int)(($neonate/$totalforms)*100)."%)";?></i></p>
					    <div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: <?php //echo (int)(($neonate/$totalforms)*100);?>%; 
						  background:#006600;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
						   title="<?php //echo (int)(($neonate/$totalforms)*100);?>"></div>
						</div>
				    </div>

				    <div class="col-sm" id="quicksummary">
				     <span class="txtsummary"><b>Total</b></span>
				     <p><i><?php //echo $totalforms;?></i></p>
					    
				    </div>
				 </div> --> <!-- END OF ROW 1-->
					<?php

					if($_POST['dtype']=='VA SUMMARY BY SEX'){
						$mr = $df->MontlyReportSex($year);
						$mnths = $mr['months'];
						$mcnt = $mr['mcounts'];
						$fcnt = $mr['fcounts'];
						$mtot=array_sum($mcnt);
						$ftot=array_sum($fcnt);
						$sumcnt = $mtot+$ftot;

						?>
						<script type="text/javascript">
							var males = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($mcnt);?>,
									type: 'bar',
									name:'Males'
								  };

							var females = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($fcnt);?>,
									type: 'bar',
									name:'Females'
								  };

							var sexdata = [males, females];

							var layout = {
								barmode: 'stack',
								title: <?php echo $year;?>+' '+<?php echo json_encode($_POST['dtype']); ?>,
						 			height: 500,
									 width: 900,
									 margin:{
											l:20
										}
								};

						 	var config={
						 		displayModeBar:true,
						 		displaylogo:false,
						 		showSendToCloud:false
						 	};

						 	Plotly.newPlot("vagraphPlot",sexdata,layout,config);

						 </script>
						 <table class="table-bordered summaryTable">
						 	<tr>
						 		<th>Males</th>
						 		<th>Females</th>
						 		<th>Total</th>
						 	</tr>
						 	<tr>
						 		<td><?php echo $mtot.' ('.round((($mtot/$sumcnt)*100),2).'%)'; ?></td>
						 		<td><?php echo $ftot.' ('.round((($ftot/$sumcnt)*100),2).'%)'; ?></td>
						 		<td><?php echo $sumcnt; ?></td>
						 	</tr>
						 </table>	   
						<?php
					}elseif($_POST['dtype']=='VA SUMMARY By Year'){
						$mr = $df->MontlyReportYear($year);
						$mnths = $mr['months'];
						$cnt = $mr['counts'];
						$mtot = array_sum($cnt);

						echo '<table class="table-bordered summaryTable">
						 	<tr>
						 		<th>Months</th>
						 		<th>Count</th>
						 	</tr>';
						 	
						 
						for($k=0;$k<sizeof($mnths);$k++){
							echo "<tr>
						 		<td>".$mnths[$k]."</td>
						 		<td>".$cnt[$k]."</td>
						 	</tr>";
						}
						echo "<tr>
						 		<th>Total</th>
						 		<th>".$mtot."</th>
						 	</tr>";
						echo "</table>";
						?>
						<script type="text/javascript">

							var monthlyrpts = [
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($cnt);?>,
									type: 'bar'
								  }];

							var layout = {
								barmode: 'stack',
									title: <?php echo json_encode($_POST['dtype']); ?>+'- DOD:'+<?php echo $year;?>,
						 			height: 500,
									 width: 900,
									 margin:{
											l:20
										}
								};

						 	var config={
						 		displayModeBar:true,
						 		displaylogo:false,
						 		showSendToCloud:false
						 	};

						 	Plotly.newPlot("vagraphPlot",monthlyrpts,layout,config);
						 </script>	      
						<?php
					}elseif($_POST['dtype']=='VA SUMMARY BY AGE GROUP'){
						$mr = $df->MontlyReportByAgeGroup($year);

						$mnths = $mr['months'];
						$adultc = $mr['adult'];
						$childc = $mr['child'];
						$neonc = $mr['neonate'];	

						$atot = array_sum($adultc);
						$ctot= array_sum($childc);
						$ntot= array_sum($neonc);
						$frmtot = $atot+$ctot+$ntot;

						?>
						<script type="text/javascript">
							var adult = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($adultc);?>,
									type: 'scatter',
									name:'Adult'
								  };

							var adult2 = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($adultc);?>,
									type: 'bar',
									name:'Adult'
								  };

							var child = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($childc);?>,
									type: 'scatter',
									name:'Child'
								  };

							var child2 = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($childc);?>,
									type: 'bar',
									name:'Child'
								  };

							var neonate = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($neonc);?>,
									type: 'scatter',
									name:'Neonate'
								  };

							var neonate2 = 
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($neonc);?>,
									type: 'bar',
									name:'Neonate'
								  };

							var sexdata = [adult,child,neonate];
							var sexdata2 = [adult2,child2,neonate2];

							var layout = {
								//barmode: 'stack',
									title: <?php echo json_encode($_POST['dtype']); ?>+' Year:'+<?php echo $year;?>,
						 			height: 600,
									 width: 1000,
									 margin:{
											l:20
										}
								};

								var layout2 = {
								barmode: 'stack',
									title: <?php echo json_encode($_POST['dtype']); ?>+' Year:'+<?php echo $year;?>,
						 			height: 600,
									 width: 1000,
									 margin:{
											l:20
										}
								};

						 	var config={
						 		displayModeBar:true,
						 		displaylogo:false,
						 		showSendToCloud:false
						 	};

						 	Plotly.newPlot("vagraphPlot",sexdata,layout,config);
						 	Plotly.newPlot("vagraphPlot_bar",sexdata2,layout2,config);

						 </script>	 
						  <table class="table-bordered summaryTable">
						 	<tr>
						 		<th>Adult</th>
						 		<th>Child</th>
						 		<th>Neonate</th>
						 		<th>Total</th>
						 	</tr>
						 	<tr>
						 		<td><?php echo $atot.' ('.round((($atot/$frmtot)*100),2).'%)'; ?></td>
						 		<td><?php echo $ctot.' ('.round((($ctot/$frmtot)*100),2).'%)'; ?></td>
						 		<td><?php echo $ntot.' ('.round((($ntot/$frmtot)*100),2).'%)'; ?></td>
						 		<td><?php echo $frmtot; ?></td>
						 	</tr>
						 </table>	

						<?php
					}elseif($_POST['dtype']=='VA SUBMISSION'){
						$intsum = $df->InterviwerSummary($year);
						$intsum2 = $df->InterviwerSummary($year);
						$rows = $intsum2 ->fetchAll();
										
										//var_dump($intsum2 ->fetch(PDO::FETCH_ASSOC));

						echo '<table class="table table-bg table-bordered table-responsive" id="intsumTbl" cellspacing="0" style="width:;">';

						$cntCol = $intsum ->columnCount();
						$cntData = $intsum ->rowCount();

						$columns = array_keys($intsum ->fetch(PDO::FETCH_ASSOC));

						echo "<thead><tr>";
						for($i=0;$i<$cntCol;$i++){
							echo "<th>".$columns[$i]."</th>";
						}
						echo "</tr></thead>";
																				
						echo "<tbody>";
						foreach($rows as $row) {
							echo "<tr>";
							for($k=0;$k<$cntCol;$k++){
								echo "<td>".$row[$k]."</td>";
							}
						 echo "</tr>";
						}
						echo "</tbody>";


						echo "<tfoot><tr>";
						for($i=0;$i<$cntCol;$i++){
							echo "<th>".$columns[$i]."</th>";
						}
						echo "</tr></tfoot>";
											
						echo "</table>"; 
					}
				 	

				}



				//button for submission
				if(isset($_POST['search2'])){
					$year = $_POST['year2'];
					$vaforms = $df->countFormsYear($year);
					//var_dump($vaforms);
					$adult = $vaforms['adult'];
					$child = $vaforms['child'];
					$neonate = $vaforms['neonate'];
					$totalforms = $vaforms['vacnt'];

					if($_POST['dtype2']=='VA SUBMISSION'){
						$intsum = $df->InterviwerSummary($year);
						$intsum2 = $df->InterviwerSummary($year);
						$rows = $intsum2 ->fetchAll();
										
										//var_dump($intsum2 ->fetch(PDO::FETCH_ASSOC));

						echo '<table class="table table-bg table-bordered table-responsive" id="intsumTbl" cellspacing="0" style="width:;">';

						$cntCol = $intsum ->columnCount();
						$cntData = $intsum ->rowCount();

						$columns = array_keys($intsum ->fetch(PDO::FETCH_ASSOC));

						echo "<thead><tr>";
						for($i=0;$i<$cntCol;$i++){
							echo "<th>".$columns[$i]."</th>";
						}
						echo "</tr></thead>";
																				
						echo "<tbody>";
						foreach($rows as $row) {
							echo "<tr>";
							for($k=0;$k<$cntCol;$k++){
								echo "<td>".$row[$k]."</td>";
							}
						 echo "</tr>";
						}
						echo "</tbody>";


						echo "<tfoot><tr>";
						for($i=0;$i<$cntCol;$i++){
							echo "<th>".$columns[$i]."</th>";
						}
						echo "</tr></tfoot>";
											
						echo "</table>"; 
					}
				 	

				}
				 ?>
		</div> <!-- END OF MIDCONTENT-->
		

			
</div>

</body>
</html>