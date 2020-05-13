<?php
//session_start();
//print_r($_SESSION);
//include("session.php");
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

<script type="text/javascript" src="home/bootstrap/js/bootstrap.min.js"></script>
<link href="home/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">



<style type="text/css">
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
  .midcontent{
    margin-left: 30px;
    margin-top: 20px;
    float: left;
    background-color:;
    height: 200vh;
    width:75vw;
    
    }
     #imgicon{
    width: 60px;
    height: 50px;
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
</style>
</head>