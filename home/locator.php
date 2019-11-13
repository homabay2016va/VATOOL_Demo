<?php
include("header.php");
?>
<style type="text/css">
	#summarypod{
		float: left;
		margin-left: 20px;
	}
	#summarysex{
		float: left;
		margin-left: 30px;
	}
	#summarycunit{
		float: left;
		margin-left: 36px;
	}
	#summarybymonths,#Podbysex,#summarybyInt{

	}
	 #subloc{
    float: left;
    width: 65vw;
    height: 150vh;
    margin-top: 30px;
    margin-left: 30px; 
    background-color: white; 
    padding-left: 20px;
    padding-top: 20px;
    border-radius: 20px;
   }
</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$('#viewint').DataTable({
			"pagingType": "simple_numbers" 
		}); 		 
	});
</script>
<body >
	<?php 
	#include("connection.php");
	include("sqlite_functions.php");
	$df = new SQLITEDB();
	$mr = $df->MontlyReport();
	$mnths = $mr['months'];
	$mcnt = $mr['counts'];
	$loc = $df-> locatorByPod();
	
	$pod = $loc['pod'];
	$cnt = $loc['cnt'];

	$cu = $df-> CunitSex();
	//var_dump($cu);
	$mcunit = $cu['mcunit'];
	$males = $cu['males'];
	$fcunit = $cu['fcunit'];
	$females = $cu['females'];
	$pmtotal=0;
	$pftotal=0;

	$sexpod = $df-> PodBySex();
	$mpod = $sexpod['mpod'];
	$podmales = $sexpod['males'];
	foreach ($podmales as $pm) {
		$pmtotal= $pmtotal + $pm;
	}

	$fpod = $sexpod['fpod'];
	$podfemales = $sexpod['females'];
	foreach ($podfemales as $pf) {
		$pftotal= $pftotal + $pf;
	}


	$vai = $df-> VAByInterviewer();
	$vainame = $vai['name'];
	$vaicnt = $vai['cnt'];
	$vaidata = $vai['vai'];
?>
<div class="maincontainer">			
			<?php include("navheader.php"); ?>
		<!-- left nav menu-->
		<div class="content" >
			<?php include("navleft.php"); ?>

			<div class="midcontent">
				<div id="subloc">
					<div id="summarypod">
			 			<p class="text-success">Deaths notified by place of deaths</p>
					 	<span class=""></span>
					 	<table class="table table-hover table-striped table-condensed table-responsive">
					 		<?php
					 		echo "<tr>";
								foreach ($loc['pod'] as $r) {
									echo "<th>".$r."</th>";
								}
							echo "</tr><tr>";
								foreach ($loc['cnt'] as $r) {
									echo "<td>".$r."</td>";
								}
						 			echo "</tr>"; 	
					 		?>
					 	</table>					
					 </div>
					 <div id="summarysex">
					 	<p class="text-success">Gender by Community unit</p>
					 	<span class=""></span>
						<div id="genderchart" style="float:left;"></div>
						<script type="text/javascript">
							var trace1 = {
								  x: <?php echo json_encode($mcunit);?>,
								  y: <?php echo json_encode($males);?>,
								  name: 'Males',
								  type: 'bar'
								};

								var trace2 = {
								  x: <?php echo json_encode($fcunit);?>,
								  y: <?php echo json_encode($females);?>,
								  name: 'Females',
								  type: 'bar'
								};

								var data = [trace1, trace2];

								var layout = {barmode: 'stack',
												title:'Gender by Community unit',
									 			height: 400,
												 width: 1100
											};

							Plotly.newPlot('genderchart', data, layout);
						 
						 </script>
					 </div>	
					 <div id="summarybymonths">
						 <div id="bymonths" style="float:left;"></div>
							<script type="text/javascript">
								var data = [
									  {
										x: <?php echo json_encode($mnths);?>,
										y: <?php echo json_encode($mcnt);?>,
										type: 'bar',
										title:'By Unit'
									  }
									];
									
							 	var layout = {
									title:'VAs by Months',
								  height: 400,
								  width: 700
								};
								
								Plotly.newPlot('bymonths', data,layout);				 
							 </script>
						</div>	
					</div> 

					 <div id="Podbysex">
						<div id="podchart" style="float:left;"></div>
						
						<script type="text/javascript">
							var trace1 = {
								  x: <?php echo json_encode($mpod);?>,
								  y: <?php echo json_encode($podmales);?>,
								  name: 'Males',
								  type: 'bar'
								};

								var trace2 = {
								  x: <?php echo json_encode($fpod);?>,
								  y: <?php echo json_encode($podfemales);?>,
								  name: 'Females',
								  type: 'bar'
								};

								var data = [trace1, trace2];

								var layout = {barmode: 'stack',
												title:'Gender by Place of death',
									 			height: 400,
												 width: 500
											};

							Plotly.newPlot('podchart', data, layout);
						 </script>
					 </div>	

					 <div id="summarybyInt">
						  <div id="vainterviewer" style="float:left;"></div>
							<script type="text/javascript">
								var data = [
									  {
										x: <?php echo json_encode($vainame);?>,
										y: <?php echo json_encode($vaicnt);?>,
										type: 'bar',
										title:'Va by Interviwer'
									  }
									];
									
							 	var layout = {
									title:'VA BY INTERVIEWER',
								  height: 400,
								  width: 1100
								};
								
								Plotly.newPlot('vainterviewer', data,layout);				 
							 </script>
						</div>	
						 
						<table class="table table-hover table-striped table-condensed table-responsive" id="viewint" style="height:;">
						<thead>
							</tr>
							<th>InterViewer</th><th>VAs</th>
							</tr>
						</thead>
						<tbody>
						<?php  
							foreach ($vaidata as $key => $value) {
								# code...
								echo "</tr><td>".$key."</td><td>".$vaidata[$key]."</td></tr>";
							}
						?>
						</tbody>
						<tfoot>
							</tr>
							<th>InterViewer</th><th>VAs</th>
							</tr>
						</tfoot>

						</table>

					<div id="summarypodpie">
						  <div id="podpiechart" style="float:left;"></div>
							<script type="text/javascript">
								 var data2 = [
								  {
									labels: ['Male','Females'],
									values: [<?php echo $pmtotal;?>,
									<?php echo $pftotal;?>],
									type: 'pie'
								  }
								];
								
						 	var layout2 = {
								title:'Gender pie',
							  height: 400,
							  width: 500
							};
							
							Plotly.newPlot('podpiechart', data2, layout2);				 
							 </script>
						</div>	

			 		</div>
					 
			 		




			</div>
		</div>
</div>

</body>
</html>