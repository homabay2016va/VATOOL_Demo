
<?php
include("header.php");
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
	<?php 
	include("sqlite_functions.php");				 
?>
<div class="container-fluid">			
			<?php include("navheader.php"); ?>
		<!-- left nav menu-->
			<script type="text/javascript">
				//add class active for active link of current page
				document.querySelector('.active').classList.remove('active');
				document.querySelector('.va').classList.add('active');
			</script>

		<div class="content" >
			<?php //include("navleft.php"); 

			$df = new SQLITEDB();

			$datatable = $df ->InterViewers();
			$datatable2 = $df ->InterViewers();
			$map = $df ->createMappingArray();
			$rows = $datatable2->fetchAll();	
			
			?>
			<div class="midcontent">
			<nav class="navbar navbar-dark bg-dark" id="pgheader" >
				  <span class="navbar-text">
				    Dashboard Items
				  </span>
				</nav>

			
				<div class="row">
						<div class="col-sm" id="vatable">
						<form >					
							<table class="table table-bordered table-sm table-responsive" id="viewva" cellspacing="0">
								<?php

									$cntCol = $datatable ->columnCount();
									$cntData = $datatable ->rowCount();
									//echo $cntCol." ,".$cntData;

									$columns = array_keys($datatable->fetch(PDO::FETCH_ASSOC));
									
									//var_dump($columns);
									echo "<thead><tr>";
									for($i=1;$i<$cntCol;$i++){
										echo "<th>".$columns[$i]."</th>";
									}
									echo "<th>Action</th>
									</tr></thead>";
																
									echo "<tbody>";
									foreach($rows as $row) {
										echo "<tr>";
										for($k=1;$k<$cntCol;$k++){
											echo "<td>".$row[$k]."</td>";
										}
										echo "<td>
										<input type='text' name='txtid' value='".$row['instanceid']."' hidden/>
										<input type='submit' class='btn btn-success viewdialog' id='".$row['instanceid']."'
										 onclick='return showVA(this.id)' value='View'/></td></tr>";
									}
									echo "</tbody>";


									echo "<tfoot><tr>";
									for($i=1;$i<$cntCol;$i++){
										echo "<th>".$columns[$i]."</th>";
									}
									echo "<th>Action</th></tr></tfoot>";

								
								?>					
							</table>
							</form>
							
						</div>
				</div> <!-- row 1-->
				
				<div id="vadialog">				
					<div id="individualva"></div>
				</div>
				

				
			</div>
		</div>
</div>

 
</body>
</html>