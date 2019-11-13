<style type="text/css">


.topnav .active{
		background: green;
	} 

.topnav{
	background: black;
	width: 30vw;

}

.navbar2 {
  overflow: ;
  background-color: #333;

}

.navbar2 a {
  float: left;
  font-size: 13px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: ;
}

.dropdown .dropbtn {
  font-size: 13px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar2 a:hover, .dropdown:hover .dropbtn {
  background-color: green;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 9999;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
  display: block;
}

.dropdown:hover .dropdown-content {
  display: block;
}

</style>
<script type="text/javascript">
/* $(document).ready(function () {
 	//e.preventDefault();
        $('.topnav a').click(function () {
             $('.topnav a').removeClass("active");
    		$(this).addClass("active");

        })
    });*/

   

</script>
<div class="top">
	<span style="font-size: 1.8em; float: left;">
	
		<img src="icons\analytics.png" id="imgicon">
		<b><i>VATool</i></b></span>
		<div class="topnav" style="float: left; margin-left: 20vw;">
		 <!--	<nav class="navbar"> -->
			<?php	
				  
			echo '<div class="navbar2">
			<a href="index.php?sid='.$_SESSION['sid'].'" class="active">Home</a>
				  <a href="va.php?sid='.$_SESSION['sid'].'" class="va">VA Data</a>
				  <a href="sqltables.php?sid='.$_SESSION['sid'].'" class="va">Table data</a>
				  <div class="dropdown">
				    <button class="dropbtn">Analytics 
				      <i class="fa fa-caret-down"></i>
				    </button>
				    <div class="dropdown-content">
				      <a href="analytics.php?sid='.$_SESSION['sid'].'" class="codanalytics">COD Analytics</a>
				      <a href="va_analytics.php?sid='.$_SESSION['sid'].'" class="vaanalytics">VA Analytics</a>
				      <a href="cod.php?sid='.$_SESSION['sid'].'" class="cod">COD</a>
				    </div>
				  </div> 
				</div>';
				?>
		
			 <!-- </nav> -->
		</div>
		
	<span id="spanright"><b>
		<?php echo "welcome ".$_SESSION['uname']."( 
		<a href='logout.php'>Logout</a>)";?></b></span>
</div>

