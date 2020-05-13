
 <?php include("header.php"); ?>
  <script type="text/javascript">

	$(document).ready(function() { 
		$('#intsumTbl').DataTable({
			"pagingType": "simple_numbers" 
		}); 
		 
	});
</script>
 <style type="text/css">
 	
ul.pagination li{
	margin-left: ;
	border: solid 1px #ddd;
	width: auto;
	text-align: center;
	padding-left: 10px;
	padding-right: 10px;
	
}
div.dataTables_wrapper div.dataTables_filter {
    margin-left: 20vw;
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
div.dataTables_wrapper div.dataTables_paginate {
   width: 30vw;
   margin-left: 50px;
}
 </style>
<body >
	<?php include("sqlite_functions.php"); 
?>
<div class="container-fluid">

<?php include("topnav.php"); ?>


<!-- Page content -->
<div class="content">

  <div class="row" style=""><!-- mid content -->
    <?php include("leftnav.php"); ?>


    <div class="right column" style="">
      <!-- dash items -->
      <div class="row"> 
        <div class="" id="card"><h3>Interviewer Submissions by Submission date</h3></div>
      </div>

      <div class="row"> 
        <div class="col-sm-3">
        	<form action="#midcontent" method="POST">
				<b>From</b>
				<input type="date" name="from" class="form-control" required style="width: 15vw;">			
				<b>To</b>
					<input type="date" name="to" class="form-control" required style="width: 15vw;">
				<input type="submit" name="search2" value="View" class="btn btn-success" style="margin-top: 2vh;">
			</form>	
        </div>
        <div class="col-sm-3" style="margin-top: 10vh;">
        	 <?php
				//button for submission
				if(isset($_POST['search2'])){
						$df = new SQLITEDB();
						$from = $_POST['from'];
						$to = $_POST['to'];

						$intsum = $df ->InterviwerSummaryDate($from,$to);						
						$datatable2 = $df ->InterviwerSummaryDate($from,$to);

						$rows = $datatable2 ->fetchAll();
						echo '<b class="text-info">Showing data from '.$from.' to '.$to.'</b>';
					  	echo '<table class="table table-sm table-bordered" id="intsumTbl" cellspacing="0" style="width:auto;">';
			            $cntCol = $intsum ->columnCount();
			            $cntData = $datatable2 ->rowCount();

			            if($cntData>0){
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
			            }else{
			            	echo "<div class='alert alert-warning alert-dismissible fade show'
							style='margin-top:5px;'>
							Nothing to show</div>";
			            }
			            
			                      
			            echo "</table>"; 
				}
				 ?>

        </div>
      </div>


    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

