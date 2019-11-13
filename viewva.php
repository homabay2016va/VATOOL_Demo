<?php
   include("sqlite_functions.php");
	$df = new SQLITEDB();

if(isset($_POST['vaid'])){
	$vid = $_POST['vaid'];

	$va = $df ->VADataWHO($vid);
	$va2 = json_decode($va);
	$map = $df ->createMappingArray();
	//var_dump($va2[0]);
	echo "<table class='table table-bordered'>
	<tr>
		<td>Question</td>
		<td>Response</td>
	</tr>";
		foreach ($va2[0] as $key => $value) {
			# code...

			$rt = strtolower($key);
			if(array_key_exists($rt, $map)){

			//echo "[[".$rt."]]";
			//echo $rt;
			//echo " [now: ".$key." ,".$value."]";
			echo "<tr>";
			echo "<td>".$map[$rt]."</td>";
			echo "<td>".ltrim(rtrim($value))."</td>";
			echo "</tr>";

			echo "<script>
			$('#vadialog').hide();
					$('#vadialog').dialog({
				  	modal:true,
				  	title:'INDIVIDUAL VA DATA',
				  	height:700,
				  	width:700,										 
			        position: { my: 'center',
			        			at:'top'
			    				}
				  });
			</script>";
			}else{
				//echo "not found".$rt;
			}
		}
	echo "</table>";
}
?>