<?php
include("session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>VATool</title>
  <!-- Bootstrap core CSS-->

 <!-- Custom fonts for this template-->

    <script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>   
  <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/plotly-1.5.0.min.js"></script>

<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="vendor/jquery/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="vendor/dataTables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="vendor/jquery/jquery-ui.js"></script> 


  <script type="text/javascript">

    function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
           

  </script>
  
 <style type="text/css">
 .maincontainer{
  
 }
 * {box-sizing: border-box;}
  #leftnav{
    width: 9vw;
    min-width: 150px;
    max-width: 150px;
    background-color:white;
    margin-left: 0px;
    border-right: inset 1px;
    padding-top:40px ; 
    float: left;
    height: 200vh;
    align-items: stretch;
  }
  .navbar{
    
  }
 
  #leftnavlist{
    padding-left: 1%;
  }
  #leftnavlist ul{
    padding-left: 0px;
  }
  #leftnavlist ul li{
    list-style-type: none;

  }
  #leftnavlist ul li a{
    text-decoration: none;    
    color: grey;
    font-size: 13px;
  }
  .navheader{
    padding-left: 2%;
    padding-top: 1%;
    border-bottom: inset 1px;
    height:10vh;
  }
  
  .content{
    padding-left: 10px; 
    float: left;
  }
  #sub1,#sub2,#sub3{
    width: 250px;
    height: 120px;
    padding-left: 20px;
    padding-top: 10px;
    border-radius: 20px;
    float: left;
    margin-top: 30px;
    margin-left: 30px; 
    background-color: white; 
  }
  #sub1{
    margin-left: 20px;
  }
  .midcontent{
    margin-left: 30px;
    margin-top: 20px;
    float: left;
    background-color:;
    height: 200vh;
    width:75vw;
    
    }
  #spanleft{  }
  #spanright{
   float: right;
  margin-right: 30px;
   }
#subcontent{

}
   #sub4,#sub5{
    float: left;
    width: 26vw;
    height: 66vh;
    margin-top: 30px;
    margin-left: 30px; 
    background-color: white; 
    padding-left: 20px;
    padding-top: 20px;
    border-radius: 20px;
   }
  
   #sub6{
    float: left;
    width: 40vw;
    height: 66vh;
    margin-top: 30px;
    margin-left: 30px; 
    background-color: white; 
    padding-left: 20px;
    padding-top: 20px;
    border-radius: 20px;
   }
   #imgicon{
    width: 60px;
    height: 50px;
   }
    #iconleft{
    width: 30px;
    height: 30px;
   }
 </style>
</head>


    

