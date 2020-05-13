<?php

if(isset($_POST['login'])){
	include("home/sqlite_functions.php");

	$lg = new SQLITEDB();
						$uname = $_POST['uname'];
						$pwd = $_POST['pwd'];
						$ud = $lg->login($uname,$pwd);

						if(empty($ud)){
							echo "<div class='alert alert-warning alert-dismissible fade show'
							style='margin-top:5px;'>
							Wrong username/password</div>";
						}else{
							//var_dump($ud);
								
								session_start();
								$_SESSION['uname'] = $ud[0];
								$_SESSION['sid'] =  md5($ud[2]);
								$_SESSION['ugroup'] = $ud[1];
								$_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
								$_SESSION['expire_time'] = 2*60;  //expire time in seconds: three hours (you must change this)
								//print_r($_SESSION);
								header("location:home/index.php?sid='".$_SESSION['sid'] ."'");	
						}
												
}
include("header.php");
?>
<style type="text/css">
	#login_form{
		margin-left: 20vw; 
		width: 40vw;
	}

</style>
<body >
	
<div class="container-fluid">			
			<?php include("navheader.php"); ?>
		<!-- left nav menu-->
		<div class="content" >
			<div class="midcontent">
				<div id="login_form">
					<form action="" method="post" class="form" autocomplete="off">
						<div class="row">
							<label for="uname">Username</label>
							<input type="text" name="uname" class="form-control" 
							autocomplete="new-password" required />
						</div>
						<div class="row">
							<label for="pwd">Password</label>
							<input type="password" name="pwd" class="form-control" 
							autocomplete="new-password" required />
						</div>
						<div class="row" style="margin-top: 30px;">
							<div class="col-sm-3">
								<input type="submit" value="login" name="login" class="form-control btn btn-success"/>
							</div>
						
						</div>			
					</form>
					
				</div>
			</div>
		</div>
</div>

</body>
</html>