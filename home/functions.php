<?php
//include("connection.php");
class Functions{ 
	
 	
public function __construct(){
	$dbname="va";
	$uname="root";
	$pass="root";
	$this->con = mysqli_connect("localhost",$uname,$pass,$dbname,'3306') or die("could not connect".mysqli_connect_error());
}

public  function getAllVAs(){
	try{
		$query=mysqli_query($con,"SELECT * FROM verbalautopsy.hrio_hb_locator_form_v1_core");
		$fields=mysqli_num_rows($query);

	}catch(Exception $e){
		echo "Error".$e->getMessage();
	}
	return $fields;
}

public function post_notifications($fname,$mname,$lname,$idnum,$serialno,$sex,$age_units,$age,$dod,$usualres_loc,
$usualres_sub){	
	
	try{
		$fname=mysqli_real_escape_string($this->con,$fname);
		$mname=mysqli_real_escape_string($this->con, $mname);
		$lname=mysqli_real_escape_string($this->con, $lname);
		 $idnum=mysqli_real_escape_string($this->con, $idnum);
		$serialno=mysqli_real_escape_string($this->con, $serialno); 
		$sex=mysqli_real_escape_string($this->con, $sex);
		$age_units=mysqli_real_escape_string($this->con, $age_units);
		 $age=mysqli_real_escape_string($this->con, $age);
		$dod=mysqli_real_escape_string($this->con, $dod);
		 $usualres_loc=mysqli_real_escape_string($this->con, $usualres_loc);
		$usualres_sub=mysqli_real_escape_string($this->con, $usualres_sub); 
	
		
		$st= mysqli_query($this->con,"INSERT INTO va.post_notifications(fname,mname,lname,idnum,serialno,sex,age_units,age,dod,usualres_loc,usualres_sub,type) 
			values('".$fname."','".$mname."','".$lname."','".$idnum."','".$serialno."','".$sex."','".$age_units."','".$age."','".$dod."','".$usualres_loc."',
		'".$usualres_sub."','D2')");

	//	$st= $this->con->prepare("CALL va.post_notifications(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		//	$st->bind_param("sssiississssssisi",$fname,$mname,$lname,$idnum,$serialno,$sex,$age_units,$age,$dod,$usualres_loc,
		//	$usualres_sub,$date,$regAssist_loc,$recipient,$recipient_id,$approve,$type);
			//$st->execute() ;
			if($st){
				echo "<div class='text-succsess'>Successfully added!</div>";	
			}else{
				echo "<div class='text-succsess'>FAILED!</div>";	
				?>
				<script>alert("failed");</script>
				<?php	
			}
		  		
		//	$st->close();		
			
	}catch(Exception $e){
		echo "Error".$e->getMessage();
	}//end try
	$this->con->close();
}//end post function


	function exportCSV(){
		$csv_filename="test_".date("Y-m-d hh:mm:sss").".csv";
		$conn=$this->con;
		$csv_export="";
		$query=mysqli_query($conn,"select * from va.notifications");
		$fields=mysqli_num_rows($query);
		//for ($i=0;$i<$fields;$i++){
			$csv_export .= mysqli_fetch_assoc($query).",";
	//	}
		$csv_export .= "
		";

		while($row=mysqli_fetch_array($query)){
			//for ($i=0;$i<$fields;$i++){
				$csv_export .= "'".$row[mysqli_fetch_assoc($query)]."',";
			//}
			$csv_export .= "
		";
		}
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=".$csv_filename."");
		echo($csv_export);
	}
//OBTAINED FROM "select form_id,replace(form_id,'_','') as newid from _form_info";
	function processodk($frmid,$newid){
					 			include("connection.php");
					 			$tbl = array();
						 		$darray = array();
						 		$frstr="";
						 		$datastr="";
						 		$grpby="";
						 		$fid="";
						 		$tablesquery = "select form_id,replace(form_id,'_','')as newid from _form_info";
					 			$res=0;

					 			$tblfields ="select distinct persist_as_table_name from _form_data_model where 
								 ELEMENT_TYPE not in ('group','geopoint','binary','BINARY_CONTENT_REF_BLOB','REF_BLOB') and ELEMENT_NAME is not null and
								 persist_as_table_name like '%".$newid."%'";

					 			
								 $tblfq = mysqli_query($con,$tblfields);
								 $tblcnt = mysqli_num_rows($tblfq);

								 if($tblcnt==0){
								 	$fid=$frmid;
								 }else{
								 	$fid=$newid;
								 }

								 $tblfields ="select distinct persist_as_table_name from _form_data_model where 
								 ELEMENT_TYPE not in ('group','geopoint','binary','BINARY_CONTENT_REF_BLOB','REF_BLOB') and ELEMENT_NAME is not null and
								 persist_as_table_name like '%".$fid."%'";
					 			
								 $tblfq = mysqli_query($con,$tblfields);

								/* $data="select replace(ELEMENT_NAME,'-','_') as ELEMENT_NAME,ELEMENT_TYPE,persist_as_table_name,
								case when persist_as_column_name is null then 'VALUE' else persist_as_column_name end as persist_as_column_name
								from _form_data_model 
								where ELEMENT_TYPE not in ('group','geopoint','binary','BINARY_CONTENT_REF_BLOB','REF_BLOB') and ELEMENT_NAME is not null and
								 persist_as_table_name like '%".$fid."%'";*/

								 $data="select replace(ELEMENT_NAME,'-','_') as ELEMENT_NAME,ELEMENT_TYPE,persist_as_table_name,
								case when persist_as_column_name is null then 'VALUE' else persist_as_column_name end as persist_as_column_name
								from _form_data_model 
								where ELEMENT_TYPE not in ('group','geopoint','binary','BINARY_CONTENT_REF_BLOB','REF_BLOB') and ELEMENT_NAME is not null and
								 persist_as_table_name like '%".$fid."%'";

							 		$cnt = mysqli_num_rows($tblfq);
							 		$dataq = mysqli_query($con,$data);
							 		$cntdata = mysqli_num_rows($dataq);

							 		$parenttable=$fid."core";

							 		while($r = mysqli_fetch_array($tblfq)){
							 			array_push($tbl, $r['persist_as_table_name']);
							 		}

							 		if(sizeof($tbl)==1){
							 			$i=0;
							 			$frstr=$frstr.'"'.$tbl[$i].'"';
							 		}else{
								 		for($i=0;$i<sizeof($tbl);$i++){
								 			//echo "table".$i." is ".$tbl[$i];
								 			
								 			if(($i+1)==sizeof($tbl)){

								 			}else{
								 				if($i==0){
								 					$frstr=$frstr.'"'.$tbl[$i].'" left join "'.$tbl[$i+1].'"" on "'.$tbl[$i].'"."_URI" ="'.$tbl[$i+1].'"."_TOP_LEVEL_AURI"';

								 				}else{
								 					//$frstr=$frstr." left join ".$tbl[$i+1]." on ".$tbl[$i]."._URI =".$tbl[$i+1]."._URI";
								 					$frstr=$frstr.' left join odk."'.$tbl[$i+1].'" on odk."'.$parenttable.'"."_URI" =odk."'.$tbl[$i+1].'"."_TOP_LEVEL_AURI"';
								 				}
								 				
								 			}
								 		}
								 	}
							 		//echo $frstr;
							 		//var_dump($tbl);
							 		//select data
							 		$datastr = $datastr.'"'.$parenttable.'"."_SUBMISSION_DATE" as submission_date,';
							 		while($r2 = mysqli_fetch_array($dataq)){
							 			$ename=$r2['ELEMENT_NAME'];
							 			$table='"'.$r2['persist_as_table_name'].'"';
							 			$col='"'.$r2['persist_as_column_name'].'"';
							 			if($ename=="geopoint"){
							 				$datastr = $datastr." ".$table.".".$col." as ".$col.",";
							 			}else{
							 				//$datastr = $datastr." ".$table.".".$col." as ".$ename.",";
							 				if($col=='"VALUE"'){
							 					#group_concat(VALUE separator ', ')VALUE
							 					$datastr = $datastr." string_agg(distinct ".$table.".".$col." , ',') as ".$ename.",";
							 					$grpby=$grpby.' odk.'.$table.'."_PARENT_AURI" ,';
							 				}else{
							 					//$datastr = $datastr." ".$table.".".$col.",";
							 					$datastr = $datastr." ".$table.".".$col." as ".$ename.",";
							 				}
							 				
							 			}
							 			
							 		}

							 		$grpby=$grpby.'_';
							 		$grpby=str_replace(',_', '', $grpby);
							 		$datastr= $datastr."_";
							 		$datastr= 'SELECT '.str_replace(",_","",$datastr)." from ".$frstr." group by ".$grpby;
							 		
							 		echo $datastr;
							 		//echo "creating view starting...";
							 		//create a view
							 		//$dropvw="drop view if exists vadata";
							 		$view= " create or replace view vadata2 as ".$datastr;
							 		//if(mysqli_query($con,$dropvw) ){
							 			//echo "dropping view success";
							 			
							 			if(mysqli_query($con,$view) ){
							 				//echo "creating view success";
							 				$res=1;

							 			}else{
							 				//echo "creating view failed";
							 				$res=0;
							 			}
							 		//}else{
							 			//echo "dropping fail";
							 		//	$res=0;
							 		//}
							 			
							 		return $res;
					 		} //end function

}//end class
?>