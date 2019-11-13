<?php
header("content-type: text/html");
	//$dbname="va";
	//$uname="root";
	//$pass="root";
    //$con = mysqli_connect("localhost",$uname,$pass,$dbname,'3306') or die("could not connect".mysqli_connect_error());
    $state=false;
    
     saveToCsv();

      Function saveToCsv(){
      	header("content-type: text/html");
      	$dbname="va";
		$uname="root";
		$pass="root";
      	 $con = mysqli_connect("localhost",$uname,$pass,$dbname,'3306') or die("could not connect".mysqli_connect_error());
	    $cnt=0;
	    //$csv_filename="test_".date("Y-m-d_hh_mm_sss").".csv";
	    $csv_filename="Test.csv";
	//$dir2="Downloads";
	//$dir="/storage/odk/forms/".$csv_filename;
	//if(file_exists("/storage/odk/forms/")){
	   //$file=fopen("C:/VADATA/Test.csv","w");
	  header("Content-Disposition: attachment; filename=".$csv_filename."");
	    $file=fopen("php://output","w");
	    $q = mysqli_query($con,"select * from va.notifications");
	    $arr=array("");
	  
	    while ($c=mysqli_fetch_field($q)){
	        $colname[]=$c->name; 
	    }
	    fputcsv($file,$colname);

	    while($row=mysqli_fetch_row($q)){
	        $arr[$cnt]=$row;
	    if(fputcsv($file,$row)){
	        $state=true;
	    }else{
	        $state=false;
	    }
	     $cnt=$cnt+1;   
	    }
	    
	    fclose($file);
    }
    Function saveToExistingCSV(){
    	 header("content-type: text/html");
    	$dbname="va";
		$uname="root";
		$pass="root";
    	 $con = mysqli_connect("localhost",$uname,$pass,$dbname,'3306') or die("could not connect".mysqli_connect_error());
    	$file=fopen("/storage/emulated/0/odk/forms/Test.csv","w");
	    $q = mysqli_query($con,"select * from va.notifications");
	    //$arr=array("");
	  
	    while ($c=mysqli_fetch_field($q)){
	        $colname[]=$c->name; 
	    }
	    fputcsv($file,$colname);

	    while($row=mysqli_fetch_row($q)){
	        //$arr[$cnt]=$row;
		    if(fputcsv($file,$row)){
		        $state=true;
		    }else{
		        $state=false;
		    }
	    // $cnt=$cnt+1;   
	    }
	    
	    fclose($file);
    }

?>
