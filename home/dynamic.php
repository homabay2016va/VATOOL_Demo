<?php include("header.php"); ?>

<body >
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
ul.pagination {
  width: 300px;
}

div.dataTables_wrapper div.dataTables_filter {
    margin-left: 20vw;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
  justify-content: flex-start;
  margin-left: 20vw;
}

 </style>
<?php 
	//include("connection.php");
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

<?php include("topnav.php"); ?>

<!-- Page content -->
<div class="content">

  <div class="row" style=""><!-- mid content -->
    <?php include("leftnav.php"); ?>


    <div class="right column" style="">
      <!-- dash items -->
      <div class="row"> 
        <div class="" id="card"><h3>Pivot table</h3></div>
      </div>

 	<div class="row"> 
        <div class="col-sm-3">
        	<form action="#midcontent" method="POST">
				<b>Summary column</b>

				<select class="form-control" name="val1[]" style="width: 10vw; margin-left: 20px; font-size: 12px; height:30vh ;" id="val1" multiple required>
					<?php
						 foreach($cl as $c) {
						 	 echo "<option>".$c."</option>";
						 }
				 	    ?>
				</select>				
				
				<b>Group By</b>
					<select class="form-control sel" name="gb[]" style="width: 10vw; margin-left: 20px;font-size: 12px; height:30vh ;" id="gb" multiple required>
							<?php
							 foreach($cl as $c) {
							 	 echo "<option>".$c."</option>";
							 }
					 	    ?>
					</select>
				<b>Function</b>
					<select class="form-control" name="fn" style="width: 200px; margin-left: 20px;font-size: 12px;" >
							<option>Count</option>
					 	    ?>
					</select>
				<input type="submit" name="search2" value="View" class="btn btn-success">
			</form>	
        </div>
        <div class="col-sm-3">
        	 <?php
				//button for submission
				if(isset($_POST['search2'])){
					$arr = "";
					$arr2 = "";
					$val1="";

					foreach ($_POST['gb'] as $op) {
						$arr= $arr.$op.",";	
						$val1=$op;				
					}
					$arr= $arr."_";
					$arr = str_replace(",_", "", $arr);
					
					foreach ($_POST['val1'] as $op2) {
						$arr2= $arr2.$op2.",";	
					}
					$arr2= $arr2."_";
					$arr2 = str_replace(",_", "", $arr2);

					$fun = $_POST['fn'];
					$dq="select ".$arr2." ,".$fun."(".$val1.")counts  from vadata_clean 
					JOIN vacod ON vacod.id = vadata_clean.instanceid 
					group by ".$arr." order by ".$fun."(".$val1.") asc";
					//echo $dq;	

					 $intsum = $df->DynamicGaphOne($dq);
					 $intsum2 = $df->DynamicGaphOne($dq);
					$rows = $intsum2 ->fetchAll();
					  echo '<table class="table table-sm table-bordered" id="intsumTbl" cellspacing="0" style="width:auto;">';

			            $cntCol = $intsum ->columnCount();
			            $cntData = $intsum2 ->rowCount();

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
				 ?>

        </div>
      </div>

    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

