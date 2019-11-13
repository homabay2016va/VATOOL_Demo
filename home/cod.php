<?php
include("header.php");
//echo $_SESSION['last_activity']." hhh";
//echo (time()-$_SESSION['expire_time']);
?>
<style type="text/css">

</style>
<script type="text/javascript">
	function showCOD(){
		var yr = document.getElementById("selyear");
		var yrtxt = yr.options[yr.selectedIndex].text;
		//alert("fund "+cutxt);
		var datastring = "selyear="+ yrtxt;
		$.ajax({
		    url: 'response.php',
		    type: 'post',		
		    cache:false,									  
		    data:datastring,
		    success: function(html) {
				$("#codPlots").html(html);          
		       }               
		   });
			
			return false;					
	}

</script>
<body >
	<?php 
	include("connection.php");
	include("sqlite_functions.php");
	$df = new SQLITEDB();
		$TotInt=0;
		$TotIns=0;

		$codyr = 'All';
		$int5 = $df->csmfInterVA($codyr);
		$csmfint = $int5['interva5'];
		$intcnt = $int5['cnt'];
		$TotInt= $int5['total'];

		$ins = $df->csmfInsilico($codyr);
		$csmfins = $ins['insilico'];
		$inscnt = $ins['cnt'];
		$TotIns= $ins['total'];

		$Years = $df->csmfYear();
		$yr = $Years['year'];

		$cmtotal=0;
		$cftotal=0;

		$y="All";
		$sexcod = $df-> InterVA5CODBySex($y);
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
<div class="container-fluid">			
			<?php include("navheader.php"); ?>
			<script type="text/javascript">
				//add class active for active link of current page
				document.querySelector('.active').classList.remove('active');
				document.querySelector('.cod').classList.add('active');
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
						<form style="margin-top: 30px; margin-left: 20px;">
									<div class="form-group row">
									 <select class="form-control" style="width:170px;" id="selyear" onchange="return showCOD()">
									 	<option>All</option>
									 	<?php
									 	 foreach ($yr as $y) {
									 	 	echo "<option>".$y."</option>";
									 	 }
									 	?>
									 	
									 </select>
									 
									 </div>
								</form>
				</div>
				<div class="row">
						<div id="codPlots" style=""></div>
							<div class="col-sm-7" id="csmfint" style="float: left; ">
							  	<div id="csmfintplot" style=""></div>
							  	<script type="text/javascript">
								var trace_int = {
									x: <?php echo json_encode($intcnt);?>,
									y: <?php echo json_encode($csmfint);?>,
									name: 'InterVA5',
									type: 'bar',
									orientation: 'h'
								};

								var trace_ins = {
										x: <?php echo json_encode($inscnt);?>,
										y: <?php echo json_encode($csmfins);?>,
										name: 'Insilico',
										type: 'bar',	
										orientation: 'h',
										marker:{
											color:'rgba(255,55,10,0.6)'
										}
								};
								var data = [trace_int, trace_ins];

								var layout = {
									title:'CODs plot [Deaths: InterVA5('+<?php echo $TotInt;?>+'), Insilico ('+<?php echo $TotIns;?>+')]',
										height: 900,
										width: 800,
										margin:{
											l:220
										},
										barmode:"group"
								};

								Plotly.newPlot('csmfintplot', data, layout);
							 </script>		 
							</div>
							
					<div class="row">
						<div class="col-sm-4" id="codbysex" >
							  <div id="codsexchart" ></div>
							  <script type="text/javascript">
								var trace1 = {
								  x:  <?php echo json_encode($codmales);?>,
								  y: <?php echo json_encode($mcod);?>,
								  name: 'Males',
								  orientation: 'h',
								  type: 'bar'
								};

								var trace2 = {
								  x: <?php echo json_encode($codfemales);?>,
								  y: <?php echo json_encode($fcod);?>,
								  name: 'Females',
								  orientation: 'h',
								  type: 'bar'
								};

								var data = [trace1, trace2];

								var layout = {barmode: 'stack',
												title:'InterVA5: COD by Gender Deaths ['+<?php echo $TotInt;?>+']',
									 			height: 800,
												 width: 600,
												 margin:{
														l:200
													}
											};

							Plotly.newPlot('codsexchart', data, layout);
						 </script>
						</div>
					</div><!-- end of row-->


			</div>
		</div>
</div>

</body>
</html