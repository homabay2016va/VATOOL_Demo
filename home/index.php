<?php
include("header.php");
#print_r($_SESSION);
?>

<style type="text/css">
#pgheader{
	  position: relative; /*position: fixed;*/
   top: 0;
   left: 0;
   width: 100%;
   height:;
   border-radius:7px;
}
.content{
/*width: 100%;
margin-left:0px*/
}
.row{
width: 100%;
}
#leftnav{
	width:20%;
	margin-left:0px;
}
#quicksummary{

}

#vagraph,#quicksummary, #hmgraph,#hfgraph{
	background: #FFFFFF;
	margin-left:30px;
	margin-right:30px;
	margin-top: 30px;
	border-radius: 7px;
	padding-top: 10px;
}
.txtsummary{

}
.table{
	
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

</style>

   <script type="text/javascript">
	$(document).ready(function() { 
		//$('#viewint').DataTable({
		//	"pagingType": "simple_numbers" 
		//}); 

	//	$('#intsumTbl').DataTable({
	//		"pagingType": "simple_numbers" 
	//	}); 

		$('#cusumTbl').DataTable({
			"pagingType": "simple_numbers" 
		}); 

	});


	function InterviewerSummaryJS(){
		var intyear = document.getElementById("intyear");
		var intyeartxt = intyear.options[intyear.selectedIndex].text;
		//alert("fund "+cutxt);
		var datastring = "intyear="+ intyeartxt;
		$.ajax({
		    url: 'response.php',
		    type: 'post',		
		    cache:false,									  
		    data:datastring,
		    success: function(html) {
				$("#IntSummary").html(html);          
		       }               
		   });
			
			return false;					
	}

	function CUSummaryJS(){
		var cuyear = document.getElementById("cuyear");
		var cuyeartxt = cuyear.options[cuyear.selectedIndex].text;
		//alert("fund "+cutxt);
		var datastring = "cuyear="+ cuyeartxt;
		$.ajax({
		    url: 'response.php',
		    type: 'post',		
		    cache:false,									  
		    data:datastring,
		    success: function(html) {
				$("#CUSummary").html(html);          
		       }               
		   });
			
			return false;					
	}

</script>

<body >
	<?php 
	#include("dash_functions.php");
	include("sqlite_functions.php");
	$df = new SQLITEDB();

	$mr = $df->MontlyReport();
	$mnths = $mr['months'];
	$mcnt = $mr['counts'];
	 //var_dump($mcnt);
	#$df = new DashboardFunctions();

	$vaforms = $df->countForms();
	$adult = $vaforms['adult'];
	$child = $vaforms['child'];
	$neonate = $vaforms['neonate'];
	$totalforms = $vaforms['vacnt'];

 $todayq = $df->countToday();
  $today = $todayq['today'];

 $thisweekq = $df->countThisWeek();
  $thisweek = $thisweekq['thisweek'];

  $thismonq = $df->countThisMonth();
  $thismon = $thismonq['thismonth'];

   $thisyearq = $df->countThisYear();
  $thisyear = $thisyearq['thisyear'];
	/* LOCATOR FORM DATA
	$cntloc = $df->CountLocatorForm();
	$cntloc = $cntloc['cntloc'];

	$homeq = $df -> LocatorSummaryByYear('Home');
	$homecnt = $homeq['Count'];
	$homeyr = $homeq['Year'];

	//var_dump($homecnt);

	$hfq = $df -> LocatorSummaryByYear('Health_facility');
	$hfcnt = $hfq['Count'];
	$hfyr = $hfq['Year'];


	$otq = $df -> LocatorSummaryByYear('other');
	$otcnt = $otq['Count'];
	$otyr = $otq['Year']; */

	//$totloc = array_sum($homecnt)+array_sum($hfcnt)+array_sum($otcnt)

	$subyr = $df->SubmissionYear();
	$yr = $subyr['year'];

/*	$locyr = $df->LocatorYear();
	$lyr = $locyr['year']; */

			
	?>
		<div class="container-fluid">			
			<?php include("navheader.php"); ?>

		<!-- left nav menu-->
		<div class="content" >
			<?php //include("navleft.php"); ?>

			<div class="midcontent" >	
				<nav class="navbar navbar-dark bg-dark" id="pgheader" >
				  <span class="navbar-text">
				    Dashboard Items
				  </span>
				</nav>

				<div class="row">
				    <div class="col-sm btn btn-warning" id="quicksummary" style="background-color: orange; color: white;">	
				   	<span class="txtsummary"><b>Adult forms</b></span>
				    <p><i><?php echo $adult." (".(int)(($adult/$totalforms)*100)."%)";?></i></p>
					    <!-- <div class="progress">
						 <div class="progress-bar" role="progressbar" style="width:<?php //echo (int)(($adult/$totalforms)*100);?>%" aria-valuenow="25" 
						  aria-valuemin="0" aria-valuemax="100"
						  title="<?php //echo (int)(($adult/$totalforms)*100);?>"></div>
						</div>	-->	      
				    </div>

				    <div class="col-sm btn btn-warning" id="quicksummary" style="background-color: green; color: white;">
				      <span class="txtsummary"><b>Child forms</b></span>
				      <p><i><?php echo $child." (".(int)(($child/$totalforms)*100)."%)";?></i></p>
					    <!-- <div class="progress">
						  <div class="progress-bar" role="progressbar" style="width:<?php //echo (int)(($child/$totalforms)*100);?>%;
						   background:#993300;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
						  title="<?php //echo (int)(($child/$totalforms)*100);?>"></div>
						</div> -->	 
						
				    </div>
				    <div class="col-sm btn btn-warning" id="quicksummary" style="background-color: brown; color: white;">
				       <span class="txtsummary"><b>Neonate forms</b></span>
				       <p><i><?php echo $neonate." (".(int)(($neonate/$totalforms)*100)."%)";?></i></p>
					   <!-- <div class="progress">
						  <div class="progress-bar" role="progressbar" style="width: <?php //echo (int)(($neonate/$totalforms)*100);?>%; 
						  background:#006600;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
						   title="<?php //echo (int)(($neonate/$totalforms)*100);?>"></div>
						</div> -->
				    </div>

				    <div class="col-sm btn btn-primary" id="quicksummary" style="background-color: beige; color: black;">
				     <span class="txtsummary"><b>Total</b></span>
				     <p><i><?php echo $totalforms;?></i></p>
					    
				    </div>
				 </div> <!-- END OF ROW 1-->
				 
				<div class="row" style="height:50vh;">
						<div class="col-sm" id="vagraph">	
							<div id="vagraphPlot"></div>
							<script type="text/javascript">

							var monthlyrpts = [
								  {
									x: <?php echo json_encode($mnths);?>,
									y: <?php echo json_encode($mcnt);?>,
									type: 'bar'
								  }];

							var layout = {
						 		title:"Cumulative VA data summary",
						 		height:350
						 	};

						 	var config={
						 		displayModeBar:true,
						 		displaylogo:false,
						 		showSendToCloud:false,
						 		showTips: true 
						 	};

						 	Plotly.newPlot("vagraphPlot",monthlyrpts,layout,config);
						 </script>	      
						</div>	
				</div>	<!-- END OF ROW 2-->
				
				<div class="row" style="margin-top: 2vh;"> 
							        <table class="table table-bordered" cellspacing="0" style="width: 200px;">
							           <tr><th>Today</th><th><?php echo $today;?></th></tr>
							            <tr> <th>This week</th><th><?php echo $thisweek;?></th></tr>
							           <tr>  <th>This month</th><th><?php echo $thismon;?></th></tr>
							            <tr> <th>This Year</th><th><?php echo $thisyear;?></th></tr>          
							        </table>
							      </div>

					<div class="row">
						<div class="col-sm" id="vagraph">	
						<p>Add another section</p>

							<div class="progress">
							  <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							  	
							</div>
						</div>
					</div> <!-- END OF ROW 7 -->
			</div> <!-- END OF midcontent-->
			
		</div>		<!-- END OF content-->
 </div><!-- END OF Container-->
  
</body>
</html>
