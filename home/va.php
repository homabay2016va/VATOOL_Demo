
 <?php include("header.php");
header("Cache-Control: no cache");

  ?>
 <script type="text/javascript">

	$(document).ready(function() { 
		$('#viewva').DataTable({
			"pagingType": "simple_numbers" 
		}); 
		 
	});

	function showVA(vaid){
		//var vaid = document.getElementById("txtid").Value;
		//var cutxt = cu.options[cu.selectedIndex].text;
		//alert("fund "+vaid);
		var datastring = "vaid="+ vaid;
		$.ajax({
		    url: 'viewva.php',
		    type: 'post',		
		    cache:false,									  
		    data:datastring,
		    success: function(html) {
				$("#individualva").html(html);          
		       }               
		   });
			
			return false;					
	}


function DownloadVA(vaid){
		//var vaid = document.getElementById("txtid").Value;
		//var cutxt = cu.options[cu.selectedIndex].text;
		//alert("fund "+vaid);
		//header("pdf_output.php?vaid="+vaid);
		var datastring = "vid="+ vaid;
		$.ajax({
		    url: 'pdf_output.php',
		    type: 'post',		
		    cache:false,									  
		    data:datastring,
		    success: function(html) {
				$("#downloadva").html(html);          
		       }               
		   });
			
			return false;					
	}
</script>
<style type="text/css">

.content{
/*width: 100%;
margin-left:0px*/
}

#vatable{
	background: #FFFFFF;
	margin-left:30px;
	margin-right:30px;
	margin-top: 30px;
	border-radius: 7px;
	padding-top: 10px;
}

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
<div class="container-fluid">

<?php include("topnav.php"); 
include("sqlite_functions.php");?>

	<script type="text/javascript">
				//add class active for active link of current page
				document.querySelector('.active').classList.remove('active');
				document.querySelector('.va').classList.add('active');
			</script>

<!-- Page content -->
<div class="content">
<?php //include("navleft.php"); 
	$df = new SQLITEDB();
	 $codlist = $df->COD();
     $cod = $codlist['interva5'];			
?>
  <div class="row" style=""><!-- mid content -->
    <?php include("leftnav.php"); ?>


    <div class="right column" style="">
      <!-- dash items -->

	 <div class="row"> 
        <div class="" id="card"><h3>Search VA</h3></div>
     </div>
      <div class="row"> 
      	<div class="col-sm-3">
      		 <form action="" method="post" autocomplete="off">
      		 	<table>
	        		<tr><td><b>VAID (InstanceID)</b></td></tr>
	        		<tr><td><input type="text" class="form-control" name="vaid" required></td></tr>
	        		<tr><td><input type="submit" class="btn btn-info" name="searchva" value="Search VAID" /></td></tr>
        		</table>
        	</form>
      	</div>

      	<div class="col-sm-3">
      		<form action="" method="post" autocomplete="off">
      		 	<table>
	        		<tr><td><b style="margin-left: 30px;">Search by COD</b></td></tr>
	        		<tr><td>
	        			 <select class="form-control" name="cod" style="width: 14vw;" id="cod" required>
        				 	<option></option>
	                      <?php
	                       foreach($cod as $c) {
	                         echo "<option>".$c."</option>";
	                       }
                        ?>
                  </select>
	        		</td></tr>
	        		<tr><td><input type="submit" class="btn btn-info" name="searchcod" value="Search COD" /></td></tr>
        		</table>
        	</form>
      	</div>
      	<div class="col-sm-3">
      		 <form action="va_csv.php" method="post" autocomplete="off">
      		 	<table>
	        		<tr><td><b>Download Data </b></td></tr>
	        		<tr><td><input type="submit" class="btn btn-info" name="allcsv" value="All VA Data(CSV)" /></td></tr>
	        		<tr><td></td></tr>
        		</table>
        	</form>
      	</div>


      
      </div>

      <div class="row">
      						
			
				<?php
				echo '<table class="table table-bordered table-sm " id="viewva" cellspacing="0">';
					if(isset($_POST['searchva'])){
						$vaid = $_POST['vaid'];

		 				$datatable = $df ->InterViewers($vaid);
						$datatable2 = $df ->InterViewers($vaid);

						$cntCol = $datatable ->columnCount();
						$cntData = $datatable ->rowCount();

						
						//echo $cntCol." ,".$cntData;
					
						if($cntData<1){
							echo "<div class='alert alert-warning alert-dismissible fade show'
							style='margin-top:5px;'>
							Nothing found!
							</div>";
						}else{
							$map = $df ->createMappingArray();
							$rows = $datatable2->fetchAll();
 							
							$columns = array_keys($datatable->fetch(PDO::FETCH_ASSOC));
							
							//var_dump($columns);
							echo "<thead><tr>";
							for($i=0;$i<$cntCol;$i++){
								echo "<th>".$columns[$i]."</th>";
							}
							echo "<th>Browse Data</th><th>Download PDF</th>
							</tr></thead>";
														
							echo "<tbody>";
							foreach($rows as $row) {
								echo "<tr>";
								for($k=0;$k<$cntCol;$k++){
									echo "<td>".$row[$k]."</td>";
								}
								echo "<td><form >	
								<input type='text' name='txtid' value='".$row['instanceid']."' hidden/>
								<input type='submit' class='btn btn-success viewdialog' id='".$row['instanceid']."'
								 onclick='return showVA(this.id)' value='View'/></form></td>

								 <td><form >	
								<input type='text' name='txtid' value='".$row['instanceid']."' hidden/>
								<button class='btn btn-success' id='".$row['instanceid']."'/>
								 <a href='pdf_output.php?vid=".$row['instanceid']."' style='color:white;'>PDF dowbload</a></button> 
								 </form> </td>
								 </tr>";


							}
							echo "</tbody>";


							echo "<tfoot><tr>";
							for($i=0;$i<$cntCol;$i++){
								echo "<th>".$columns[$i]."</th>";
							}
							echo "<th>Browse Data</th><th>Download PDF</th>
							</tr>					
							</tfoot>"; 
						}
						
					}
				



				if(isset($_POST['searchcod'])){
						$cod = $_POST['cod'];

		 				$datatable = $df ->InterViewersCOD($cod);
						$datatable2 = $df ->InterViewersCOD($cod);

						$cntCol = $datatable ->columnCount();
						$cntData = $datatable ->rowCount();

						
						//echo $cntCol." ,".$cntData;
					
						if($cntData<1){
							echo "<div class='alert alert-warning alert-dismissible fade show'
							style='margin-top:5px;'>
							Nothing found!
							</div>";
						}else{
							$map = $df ->createMappingArray();
							$rows = $datatable2->fetchAll();
 							
							$columns = array_keys($datatable->fetch(PDO::FETCH_ASSOC));
							
							//var_dump($columns);
							echo "<thead><tr>";
							for($i=0;$i<$cntCol;$i++){
								echo "<th>".$columns[$i]."</th>";
							}
							echo "<th>Browse Data</th><th>Download PDF</th>
							</tr></thead>";
														
							echo "<tbody>";
							foreach($rows as $row) {
								echo "<tr>";
								for($k=0;$k<$cntCol;$k++){
									echo "<td>".$row[$k]."</td>";
								}
								echo "<td><form >	
								<input type='text' name='txtid' value='".$row['instanceid']."' hidden/>
								<input type='submit' class='btn btn-success viewdialog' id='".$row['instanceid']."'
								 onclick='return showVA(this.id)' value='View'/></form></td>

 								<td><form >	
								<input type='text' name='txtid' value='".$row['instanceid']."' hidden/>
								<button class='btn btn-success' id='".$row['instanceid']."'/>
								 <a href='pdf_output.php?vid=".$row['instanceid']."' style='color:white;'>PDF dowbload</a></button>  </form></td>
								 </tr>";

								 	//<input type='submit' class='btn btn-success viewdialog' id='".$row['instanceid']."'
								// onclick='return DownloadVA(this.id)' value='Download pdf'/>



							}
							echo "</tbody>";


							echo "<tfoot><tr>";
							for($i=0;$i<$cntCol;$i++){
								echo "<th>".$columns[$i]."</th>";
							}
							echo "<th>Browse Data</th><th>Download PDF</th>
							</tr></tfoot>";
						}
						
					}

					echo "</table>";
				?>					
			
			

      	<div id="vadialog">				
				<div id="individualva"></div>
		</div>

       <div id="message">     					
				<div id="downloadva"></div>
		</div>
	
      </div>

    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

