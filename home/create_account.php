
 <?php include("header.php"); ?>
 <style type="text/css">
	#login_form{
		margin-left: 20vw; 
		width: 30vw;
	}
</style>
<body >
<?php 
	include("sqlite_functions.php");
	$lg = new SQLITEDB();
?>
<div class="container-fluid">

<?php include("topnav.php"); ?>


<!-- Page content -->
<div class="content">

  <div class="row" style=""><!-- mid content -->
    <?php include("leftnav.php"); ?>


    <div class="right column" style="">
      <!-- dash items -->
      <div class="row"> 
        <div class="" id="card"><h3>Create Account</h3></div>
      </div>

      <div class="row">
      	<div id="login_form">
					<form action="" method="post" class="form" autocomplete="off">
						<div class="row">
							<label for="uname">Username</label>
							<input type="text" id="uname" name="uname" class="form-control" required 
							 />
						</div>
						<div class="row">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" required />
						</div>
						<div class="row">
							<label for="phonenumber">Phonenumber</label>
							<input type="number" name="phonenumber" class="form-control" required />
						</div>
						<div class="row">
							<label for="ugroup">User group</label>
							<select class="form-control" name="ugroup">
								<option>Administrator</option>
								<option>Supervisor</option>
								<option>Fieldworker</option>
							</select>
							
						</div>
						<div class="row">
							<label for="pwd">Password</label>
							<input type="password" name="pwd" class="form-control" 
							autocomplete="new-password" required />
						</div>
						<div class="row">
							<label for="cpwd">Confirm password</label>
							<input type="password" name="cpwd" class="form-control" 
							autocomplete="new-password" required="true" />
						</div>
						<div class="row" style="margin-top: 30px;">
							<div class="col-sm-5">
								<input type="submit" value="create account" name="create_acc" class="form-control btn btn-success"/>
							</div>
							
						</div>			
					</form>
					<?php
					if(isset($_POST['create_acc'])){
						$uname = $_POST['uname'];
						//$hashed_password = password_hash('qollins',PASSWORD_DEFAULT);	
						//echo $hashed_password;
						$ud = $lg->CheckUser($uname);
						
						if(empty($ud)){
							$email = $_POST['email'];
							$phonenumber = $_POST['phonenumber'];
							$ugroup = $_POST['ugroup'];
							$pwd = password_hash($_POST['pwd'],PASSWORD_DEFAULT);
							$cpwd = password_hash($_POST['cpwd'],PASSWORD_DEFAULT);
							if(password_verify($_POST['pwd'], $cpwd)){
								//echo "verr";
								$vadata="insert into public.users(username,email,phonenumber,usergroup,Password) 
								values('".$uname."','".$email."','".$phonenumber."','".$ugroup."',
								'".$pwd."')";
											
								//sqlite_exec($df->con, $vadata)

								if($lg->con->exec($vadata)){
									echo "saved";
								}else{
									echo "not saved";
								}

							}else{
								echo "<div class='alert alert-warning alert-dismissible fade show'
							style='margin-top:5px;'>
							Passwords dont match!</div>";
								
							}

						}else{
							echo "<div class='alert alert-warning alert-dismissible fade show'
							style='margin-top:5px;'>
							Username already exists!</div>";
						}
					}

					?>
				</div>
			</div>
      	</div>


    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

