<script type="text/javascript">
	$(document).ready(function() { 
		$('#cusumTbl').DataTable({
			"pagingType": "simple_numbers" 
		}); 		 
	});
</script>

<?php
   include("sqlite_functions.php");
	$df = new SQLITEDB();

	if(isset($_POST['cunit2'])){
		//$tr = $_POST['cunit2'];
		//echo $_POST['cunit2']." here";

		$lcunit =  $_POST['cunit2'];
		$lcunit_lw = strtolower( $_POST['cunit2']);
		$cumtotal = 0;
		$cuftotal = 0;

		$homeq2 = $df -> LocatorSummaryByYearCunit('Home',$lcunit);
		$homecnt2 = $homeq2['Count'];
		$homeyr2 = $homeq2['Year'];

		$hfq2 = $df -> LocatorSummaryByYearCunit('Health_facility',$lcunit);
		$hfcnt2 = $hfq2['Count'];
		$hfyr2 = $hfq2['Year'];

		$otq2 = $df -> LocatorSummaryByYearCunit('other',$lcunit);
		$otcnt2 = $otq2['Count'];
		$otyr2 = $otq2['Year'];

		$sexcu = $df-> CunitSexFilter($lcunit);
		$mpod = $sexcu['mcunit'];
		$cumales = $sexcu['males'];

		$loc2 = $df-> locatorByPodCunit($lcunit);
		$pod2 = $loc2['pod'];
		$cnt2 = $loc2['cnt'];


		//var_dump($cumales);
		foreach ($cumales as $pm) {
			$cumtotal= $cumtotal + $pm;
		}
									

		$fpod = $sexcu['fcunit'];
		$cufemales = $sexcu['females'];
		foreach ($cufemales as $pf) {
			$cuftotal= $cuftotal + $pf;
		}

		?>

<script type="text/javascript">
		var data2 = [
				 {
				labels: ['Male','Females'],
				values: [<?php echo json_encode($cumtotal); ?>,<?php echo json_encode($cuftotal); ?>],
				type: 'pie'
					}
			];
			var layout2 = {
			title:'Gender distribution for '+<?php echo json_encode($lcunit_lw); ?>,
			 height: 400,
				width: 380
			};
				Plotly.newPlot('cusexchart', data2, layout2);


				 var cudata = [
						{
						labels: <?php echo json_encode($loc2['pod']);?>,
						values: <?php echo json_encode($loc2['cnt']);?>,
						type: 'pie'
						 }
					];
								
				var culayout = {
				title:'Place of death distribution for '+<?php echo json_encode($lcunit_lw); ?>,
					//showlegend:true,
					//legend:{
					//	x:0,
					//	y:0
					//},
					height: 400,
					width: 380
				};
							
				Plotly.newPlot('cupodchart', cudata, culayout);


				var homedths2 = {
					x: <?php echo json_encode($homeyr2);?>,
					y: <?php echo json_encode($homecnt2);?>,
						 // mode: 'lines+markers',
						//  marker: {
						   // color: 'rgb(55, 128, 191)',
						  //  size: 8
						 // },
						  name:'home deaths'
						  ,type:"bar"
						 // ,line: {
						   // color: 'rgb(55, 128, 191)',
						    //width: 1
						 // }
						};

	  				var hfdths2 = {
						 x: <?php echo json_encode($hfyr2);?>,
						 y: <?php echo json_encode($hfcnt2);?>,
						 // mode: 'lines+markers',
						 // marker: {
						   // color: 'rgb(219, 64, 82)',
						    //size: 8
						  //},
						  name:'health facility deaths'
						 , type:"bar"
						 // ,line: {
						    //color: 'rgb(219, 64, 82)',
						    //width: 1
						  //}
						};

					var other2 = {
						 x: <?php echo json_encode($otyr2);?>,
						 y: <?php echo json_encode($otcnt2);?>,
						 // mode: 'lines+markers',										
						  name:'Other deaths'
						 ,type:"bar"									  
						};


					var distdata = [homedths2,hfdths2,other2];
											  
					var layout2 = {
							title:"Locator deaths Yearly distribution ["+<?php echo json_encode($lcunit_lw); ?>+"]",
							barmode:"group",
							height:400,
							width:500
						};

					var config2 ={
						displayModeBar:true,
						displaylogo:false,
						showSendToCloud:false
					};
					Plotly.newPlot("cudist",distdata,layout2,config2);
</script>
		<?php

	}



#VAs By Interviews by Year
	if(isset($_POST['year'])){
		$yr = $_POST['year'];
		if($yr=='All'){
			$yr="2018";
		}
		$vai = $df-> VAByInterviewer_year($yr);
		$vainame = $vai['name'];
		$vaicnt = $vai['cnt'];
		$vaidata = $vai['vai'];

		?>
		<script type="text/javascript">
			var data = [
						{
					x: <?php echo json_encode($vainame);?>,
					y: <?php echo json_encode($vaicnt);?>,
					type: 'bar'
					}
				];
									
				var layout = {
				title:'VAs by Interviewers Year:'+<?php echo json_encode($yr); ?>,
					height: 400,
					width: 1100
				};
								
				Plotly.newPlot('vainterviewer', data,layout);				 
			 	</script>

		<?php
	}


	if(isset($_POST['selyear'])){
		$TotInt=0;
		$TotIns=0;

		$yr = $_POST['selyear'];
		$int5 = $df->csmfInterVA($yr);
		$csmfint = $int5['interva5'];
		$intcnt = $int5['cnt'];
		$TotInt= $int5['total'];

		$ins = $df->csmfInsilico($yr);
		$csmfins = $ins['insilico'];
		$inscnt = $ins['cnt'];
		$TotIns= $ins['total']; 

		$cmtotal=0;
		$cftotal=0;

		$sexcod = $df-> InterVA5CODBySex($yr);
		$mcod = $sexcod['mcod'];
		$codmales = $sexcod['males'];
		foreach ($codmales as $pm) {
			$cmtotal= $cmtotal + $pm;
		}

		$fcod = $sexcod['fcod'];
		$codfemales = $sexcod['females'];
		foreach ($codfemales as $pf) {
			$cftotal= $cftotal + $pf;
		}


		?>
		 	<script type="text/javascript">

				var trace1 = {
					x: <?php echo json_encode($intcnt);?>,
					y: <?php echo json_encode($csmfint);?>,
					name: 'InterVA5 plot',
					type: 'bar',
					orientation: 'h'
				};

				var trace2 = {
						x: <?php echo json_encode($inscnt);?>,
						y: <?php echo json_encode($csmfins);?>,
						name: 'Insilico',
						type: 'bar',
						orientation: 'h',
						marker:{
							color:'rgba(255,55,10,0.6)'
						}
				};

				var layout = {
					title:'CODs plot [Total: InterVA5('+<?php echo $TotInt;?>+'), Insilico ('+<?php echo $TotIns;?>+')] for Year:'+<?php echo json_encode($yr); ?>,
						height: 900,
						width: 800,
						margin:{
							l:220
						},
						barmode:"group"
				};

				var data = [trace1, trace2];

				Plotly.newPlot('csmfintplot', data, layout);

				//cod by sex
				var trace3 = {
					  x:  <?php echo json_encode($codmales);?>,
					  y: <?php echo json_encode($mcod);?>,
					  name: 'Males',
					  orientation: 'h',
					  type: 'bar'
					};

					var trace4 = {
					  x: <?php echo json_encode($codfemales);?>,
					  y: <?php echo json_encode($fcod);?>,
					  name: 'Females',
					  orientation: 'h',
					  type: 'bar'
					};

					var data4 = [trace3, trace4];

					var layout4 = {barmode: 'stack',
							title:'InterVA5-COD by Gender Year:'+<?php echo json_encode($yr); ?>+' [Deaths:'+<?php echo $TotInt;?>+']',
				 			height: 800,
							 width: 600,
							 margin:{
									l:200
								}
						};

							Plotly.newPlot('codsexchart', data4, layout4);
			 </script>
		<?php

	}



	if(isset($_POST['cuyear'])){

		$yr = $_POST['cuyear'];
		
		$cusum = $df->CunitSummary($yr);
		$cusum2 = $df->CunitSummary($yr);
		$rows = $cusum2 ->fetchAll();
		
		//var_dump($intsum2 ->fetch(PDO::FETCH_ASSOC));

		echo '<table class="table table-bg table-bordered table-responsive" id="cusumTbl" cellspacing="0" style="width:;">';

		$cntcuCol = $cusum ->columnCount();
		$cntcuData = $cusum ->rowCount();

		$columns = array_keys($cusum ->fetch(PDO::FETCH_ASSOC));
		//var_dump($columns);
		echo "<thead><tr>";
		for($i=0;$i<$cntcuCol;$i++){
			echo "<th>".$columns[$i]."</th>";
		}
		echo "</tr></thead>";
																
		echo "<tbody>";
		foreach($rows as $row) {
			echo "<tr>";
			for($k=0;$k<$cntcuCol;$k++){
				echo "<td>".$row[$k]."</td>";
			}
		 echo "</tr>";
		}
		echo "</tbody>";


		echo "<tfoot><tr>";
		for($i=0;$i<$cntcuCol;$i++){
			echo "<th>".$columns[$i]."</th>";
		}
		echo "</tr></tfoot>";
							
		echo "</table>"; 
		

	}
?>
