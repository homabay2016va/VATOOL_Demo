<?php
include("header.php");
?>
<style type="text/css">
 #cunit{

 }

</style>


<script type="text/javascript">
	function submitData(){
		var cunit = $("#cunit").val();
		$.post("notifications.php", { cunit2: cunit},
		function(data) {
		 //alert("Data Loaded: " + data);
		 });
	}
	function showMe(){
		var cu = document.getElementById("selcunit");
		var cutxt = cu.options[cu.selectedIndex].text;
		//alert("fund "+cutxt);
		var datastring = "cunit2="+ cutxt;
		$.ajax({
		    url: 'response.php',
		    type: 'post',		
		    cache:false,									  
		    data:datastring,
		    success: function(html) {
				$("#cusexchart").html(html);          
		       }               
		   });
			
			return false;					
	}
</script>
<body >
	<?php 
	include("sqlite_functions.php");
	$df = new SQLITEDB();
	$loc = $df-> locatorByPod();
	$pod = $loc['pod'];
	$cnt = $loc['cnt'];
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

	$Cunits = $df->Cunits();
	$cu = $Cunits['cu'];

?>
<div class="container-fluid">			
			<?php include("navheader.php"); ?>
			<script type="text/javascript">
				//add class active for active link of current page
				document.querySelector('.active').classList.remove('active');
				document.querySelector('.notifications').classList.add('active');
			</script>
		<!-- left nav menu-->
		<div class="content" >
			<?php //include("navleft.php"); ?>

			<div class="midcontent">
				<nav class="navbar navbar-dark bg-dark" id="pgheader" >
				  <span class="navbar-text">
				    Dashboard Items
				  </span>
				</nav>

				<div class="row">
						<div class="col-sm-4" id="Podbysex" >
							  <div id="podsexchart" ></div>
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
												title:'Place of death by Gender',
									 			height: 400,
												 width: 380
											};

							Plotly.newPlot('podsexchart', data, layout);
						 </script>
						</div>	
						<div class="col-sm-4" id="summarypod">	
						  <div id="podpiechart"></div>
							<script type="text/javascript">
								 var data2 = [
								  {
									labels: <?php echo json_encode($loc['pod']);?>,
									values: <?php echo json_encode($loc['cnt']);?>,
									type: 'pie'
								  }
								];
								
						 	var layout2 = {
								title:'Place of death distribution',
							  height: 400,
							  width: 380
							};
							
							Plotly.newPlot('podpiechart', data2, layout2);				 
							 </script>
						</div>
						<div class="col-sm-4" id="summarypodpie">
						  <div id="sexchart" ></div>
							<script type="text/javascript">
								 var data2 = [
								  {
									labels: ['Male','Females'],
									values: [<?php echo json_encode($pmtotal);?>,<?php echo json_encode($pftotal);?>],
									type: 'pie'
								  }
								];
								
						 	var layout2 = {
								title:'Gender distribution',
							  height: 400,
							  width: 380
							};
							
							Plotly.newPlot('sexchart', data2, layout2);				 
							 </script>
						</div>
				</div>	<!-- END OF ROW 1-->
				
				<div class="row">
						<div class="col-sm-3" id="cunit" style="margin-left:;">
							<div id="myform">
								<form >
									<div class="form-group row">
									 <select class="form-control" style="width:170px;" id="selcunit" onchange="return showMe()">
									 	<?php
									 	 foreach ($cu as $c) {
									 	 	echo "<option>".$c."</option>";
									 	 }
									 	?>
									 	
									 </select>
									 
									 </div>
								</form>
								 <div id="cusexchart"></div>
							</div>
							 
						</div>

						<div class="col-sm-3" id="cunit" style="margin-top: 52px; margin-left: 70px;">						
								<div id="cupodchart"></div>	 	
						</div>
						<div class="col-sm-3" id="cunit" style="margin-top: 52px; margin-left: 70px;">						
								<div id="cudist"></div>	 	
						</div>

				</div>		 <!-- END OF ROW 2-->



			</div>
		</div>
</div>

</body>
</html>