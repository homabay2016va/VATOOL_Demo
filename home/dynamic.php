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

	ul.pagination li{
	margin-left: ;
	border: solid 1px #ddd;
	width: auto;
	text-align: center;
	padding-left: 10px;
	padding-right: 10px;
	
}
.midcontent{
		width: 50vw;
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
			"pagingType": "simple_numbers" ,
			orderCellsTop: true,
			fixedHeader: true
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

	$cl = $df->AllColumns();
	//var_dump($cl);
	$Years2 = $df->VASubmissionYear();
	$yr2 = $Years2['year'];



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
							<b>Column X axis</b>
							<ul>
								<li>
									<select class="form-control" name="val1" style="width: 200px; margin-left: 20px; font-size: 12px;" id="val1">
										<?php
											 foreach($cl as $c) {
											 	 echo "<option>".$c."</option>";
											 }
									 	    ?>
									</select>
								</li>
							</ul>
						</li>
						
						<li>							
							<ul style="margin-top: 8px;">
								<li id="csmf"><b>Column Y axis</b>
									<select class="form-control" name="val2" style="width: 200px; margin-left: 20px;font-size: 12px;" id="val2">
											<?php
											 foreach($cl as $c) {
											 	 echo "<option>".$c."</option>";
											 }
									 	    ?>
									</select>
								</li>
								
								<li id="csmf"><b>Group By</b>
									<select class="form-control sel" name="gb[]" style="width: 200px; margin-left: 20px;font-size: 12px;" id="gb" multiple>
											<?php
											 foreach($cl as $c) {
											 	 echo "<option>".$c."</option>";
											 }
									 	    ?>
									</select>
								</li>

								<li id="csmf"><b>Function</b>
									<select class="form-control" name="fn" style="width: 200px; margin-left: 20px;font-size: 12px;" id="gb">
											<option>Count</option>
											<option>Sum</option>
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
			 
					<div class="row">
						<div id="vaPlots" style=""></div>
							<div class="col-sm-7" id="vagraph" style="float: left; ">
							  	<div id="vagraphPlot" style=""></div>							  		 
							</div>
				
			       </div>
			  
			        <?php
				//button for submission
				if(isset($_POST['search2'])){
					$val1 = $_POST['val1'];
					$val2 = $_POST['val2'];
					$gb = $_POST['gb'];
					
					echo "SELECT ".$val1.",count(".$val2.") from coddata group by ".$gb;
 	

				}
				 ?>
		</div> <!-- END OF MIDCONTENT-->
		

			
</div>

</body>
</html>