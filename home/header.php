<?php
//session_start();
//print_r($_SESSION);
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

 <!-- Custom fonts for this template
<script type="text/javascript" src="bootstrap/js/jquery.dataTables.min.js"></script>   
<link href="bootstrap/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="bootstrap/js/dataTables.bootstrap.min.js"></script>
 -->
 <script type="text/javascript" src="bootstrap/jquery/jquery.js"></script>

<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="bootstrap/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="bootstrap/datatables/dataTables.bootstrap.min.js"></script>


<script type="text/javascript" src="bootstrap/jquery/jquery-ui.js"></script> 
<script type="text/javascript" src="bootstrap/js/plotly-latest.min.js"></script>

<link href="bootstrap/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="bootstrap/fontawesome/css/all.css" rel="stylesheet" type="text/css">
<link href="bootstrap/jquery/jquery-ui.css" rel="stylesheet" type="text/css">


<style type="text/css">
body{
  background-image: url("");
  background-repeat: no-repeat;
  background-size: cover;
}


/* Sidebar links */
.sidebar a {
  display: block;
  color: white;
  text-decoration: none;
  margin-top: 20px;
  padding-left: 20px;
}

/* On screens that are less than 700px wide, make the sidebar into a topbar */
@media screen and (max-width: 700px) {
  .sidebar {
    width: 100vw;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

/* On screens that are less than 400px, display the bar vertically, instead of horizontally */
@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}

/* Add a black background color to the top navigation */
.topnav {
  background-color: white;
  overflow: hidden;
  margin-left: -15px;
  color: black;
   margin-right:-15px;
   border: 1px ridge;
}
.content{
 
}

/* Create two unequal columns that floats next to each other */
.column {
  float: left;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

 /* The side navigation menu */
.left {
  width: 13vw;
   margin: 0;
  padding: 0;
  margin-left: -15px;
  background-color: #333;
  height: 100vh;
}

.right {
  width: 80vw;
  margin-left: 2vw;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.card{
  width: 13vw;
  height: 13vh;
  margin-left:2vw;
  
}


.card1{
  animation-name: ex21;
  animation-duration: 7s;
  animation-delay:1s;
  animation-iteration-count: infinite;
}
@keyframes card1 {
  0%   {background-color:red; left:0px; top:0px;}
  25%  {background-color:yellow; left:200px; top:0px;}
  50%  {background-color:blue; left:200px; top:200px;}
  75%  {background-color:green; left:0px; top:200px;}
  100% {background-color:red; left:0px; top:0px;}
}

@keyframes ex1 {
  0%   {transform:scaleX(0);}
  25%  {transform:scaleX(1);}
  50%  {transform:scaleX(2);}
  75%  {transform:scaleX(3);}
  100% {transform:scaleX(4);}
}

@keyframes ex2 {
  0%   {transform:rotateY(180deg);}
  100% {transform:rotateY(360deg);}
}

</style>
</head>