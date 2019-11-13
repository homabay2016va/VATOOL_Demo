<?php
include("connection.php");
if(isset($_GET[''])){
$cunit=$_GET['cunit'];
 $query="SELECT * FROM smsdata where cunit like '%".$cunit."%'";
}else{
 $query="SELECT * FROM smsdata ";
}

//$con=mysqli_connect($host,$uname,$pass,$db,$port);
$arr=array();
if($con){
   
    $res=mysqli_query($con,$query);
    $count=mysqli_num_rows($res);
    $currid=0;
    if($res){
        if($count>0){
            while($row=mysqli_fetch_assoc($res)){
                $data[]=$row;
            }
            echo json_encode($data);
        }else{
            echo "No rows found"; 
            exit;
        }
    }else{

    }

}else{
    echo "connection failed";
}


?>