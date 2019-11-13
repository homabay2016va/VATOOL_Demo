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
	width: 600px;
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

#in
</style>

 <script type="text/javascript">
	$(document).ready(function() { 
		//$('#viewint').DataTable({
		//	"pagingType": "simple_numbers" 
		//}); 

		

		$('#intsumTbl2').DataTable({
			"pagingType": "simple_numbers"
		}); 

	});
	</script>
<body >
	<?php 
	include("connection.php");
	include("sqlite_functions.php");
	$df = new SQLITEDB();


	$cl = $df->AllTables();
	//var_dump($cl['table_name']);


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
							<b>Tables</b>
							<ul>
								<li>
									<select class="form-control" name="table_name" style="width: 200px; margin-left: 20px; font-size: 12px;" id="table_name">
										<?php
											 foreach($cl['table_name'] as $c) {
											 	 echo "<option>".$c."</option>";
											 }
									 	    ?>
									</select>
								</li>
							</ul>
						</li>
						
						<li>							
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
			 <script type="text/javascript">
					document.getElementById('table_name').value='<?php echo $_POST['table_name']; ?>'
				</script>
					<div class="row">
						<div id="vaPlots" style=""></div>
							<div class="col-sm-7" id="vagraph" style="float: left; ">
							  	<div id="vagraphPlot" style=""></div>							  		 
							</div>
				
			       </div>
			  
			        <?php
				//button for submission
				if(isset($_POST['search2'])){
					$tbl = $_POST['table_name'];
					$str = "select * from ".$tbl;

					$tcol = $df ->AnytableCols($str);
					$rows = $df ->AnytableData($str);
					
					
					$cntRows = sizeof($tcol);
					$cntCol = sizeof($tcol[0]);
					echo '<table class="table table-bg table-bordered table-responsive" id="intsumTbl2" cellspacing="0" style="width:600px;">';

						$columns = array_keys($tcol[0]);
						//var_dump($columns);

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
				 ?>
		</div> <!-- END OF MIDCONTENT-->
		

			
</div>

</body>
</html>