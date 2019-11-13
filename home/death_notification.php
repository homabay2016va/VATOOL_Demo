<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">

  <meta name="author" content="">
  <title>E-DNS</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <style type="text/css">
    #formarea{
      width: ;
      margin-left: 5%;
    }
    input[type="text"]{
      width: ;
    }
  </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
 <?php include("nav.php");?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Death Notification</li>
      </ol>
      <div class="row">
        <div class="col-12">
          <h3>Death Notification Form (D2)</h3>
          <!-- <p>This is an example of a blank page that you can use as a starting point for creating new ones.</p>-->
          <!--BEGINING OF NOTIFICATION FORM -->
          <div id="formarea">
          <form action="" method="POST">

          <div class="form-group">
            <div class="row">
              <div class="col-3">
                <label for="filenum">File number</label>
                <input class="form-control" id="filenum" type="text"  name="filenum" placeholder="Enter file number">
              </div>
              <div class="col-3">
                <label for="ftype">Form type</label>
                <select class="form-control" name="ftype" id="ftype" >
                  <option>----</option>
                  <option>D1</option>
                  <option>D2</option>
                  <option>Not Available</option>
                  <option>Available but lost/misplaced</option>
                </select>
              </div>
              <div class="col-3">
                <label for="serialno">Serial number</label>
                <input class="form-control" id="serialno" name="serialno" type="text" placeholder="Serial number">
              </div>
            </div>
         </div>

          <div class="form-group">
            <div class="row">
              <div class="col-3">
                  <label for="dod">Date of Report</label>
                  <input class="form-control" id="dod" type="Date" name="dod" placeholder="Date of deaths">
              </div>
              <div class="col-3">
                <label for="sex">Community Unit</label>
                <select class="form-control" name="sex" id="sex" >
                  <option>RABUOR</option>
                  <option>KOBUYA_WEST</option>
                  <option>KOCHOLA</option>
                  <option>KANYADENDA</option>
                  <option>KAWITI</option>
                  <option>KAYOO_WEST</option>
                  <option>KOGWENO_ORIANG_EAST</option>
                  <option>KOWILI</option>
                  <option>KAWADHGONE</option>
                  <option>KOBUYA_EAST</option>
                  <option>KAMSER_B</option>
                  <option>KOGUTA</option>
                  <option>KAJIEI</option>
                  <option>OUKO_ONDENGE</option>
                  <option>KOKIDI</option>
                  <option>RAKWARO</option>
                  <option>KOYUMBRE</option>
                  <option>KARABONDI_A</option>
                  <option>KAMWANIA</option>
                  <option>KOTIENO</option>
                  <option>KARABONDI_B</option>
                  <option>KOWUOR</option>
                  <option>KODONDI</option>
                  <option>KANYANGO</option>
                  <option>KADIK</option>
                  <option>KAMSER_A</option>
                  <option>KAMENYA_SOUTH</option>
                  <option>KAMUGA</option>
                  <option>WAGWE_SOUTH</option>
                  <option>KOKOTH_B_EAST</option>
                  <option>WAGWE_NORTH</option>
                  <option>KANYONGO</option>
                  <option>SIMBI_KOGEMBO</option>
                  <option>KATONDE</option>
                  <option>KAMSER_SEKA</option>
                  <option>KOGWENO_KAWUOR</option>
                  <option>KAYOO_EAST</option>
                  <option>KOWUOR_EAST</option>
                  <option>KOBILA</option>
                  <option>KAKOKO</option>
                  <option>KODERO</option>
                  <option>KOMUOYO</option>
                  <option>KALWAL</option>
                  <option>KONYANGO_MAJIERI</option>
                  <option>KOBALA</option>
                  <option>KONYANGO</option>
                  <option>KAGWA</option>
                  <option>KOGWENO_ORIANG_WEST</option>
                  <option>KOREDO</option>
                  <option>KOJWANG</option>
                  <option>KOKOTH_B_WEST</option>
                  <option>UPPER_KAKWAJUOK</option>
                  <option>KOWUOR_WEST</option>
                  <option>WEST_KAMWALA</option>
                  <option>LOWER_KAKWAJUOK</option>
                  <option>KANYADHIANG</option>
                  <option>KAMENYA_NORTH</option>
                  <option>KAMWALA</option>
                  <option>KAYOO_CENTRAL</option>
                  <option>KAMENYA_CENTRAL</option>

                </select>
                </div>
                <div class="col-3">
                  <label for="age">Community Health Volunteer name</label>
                  <input class="form-control" id="age" type="text" name="age" placeholder="Enter Age">
                </div>                
              </div>
            </div>

          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <label for="usualres">Usual Residence (Sublocation/estate/town)</label>
                <input class="form-control" id="usualres" type="text" name="usualres_loc" placeholder="Sublocation/estate/town">
              </div>
              <div class="col-3">
                <label for="usualres2">Usual Residence(Sub County)</label>
                <input class="form-control" id="usualres2" type="text" name="usualres_sub" placeholder="Sub County">
              </div>
            </div>        
          </div>
          <h3 style="margin-top: 30px;"> Head of compound Information</h3>

           <div class="form-group">
            <div class="row">
              <div class="col-3">
                <label for="Fname"> First name</label>
                <input class="form-control" id="Fname" type="text"  name="fname" placeholder="Enter first name">
              </div>
              <div class="col-3">
                <label for="Mname">Middle name</label>
                <input class="form-control" id="Mname" name="mname" type="text"  placeholder="Enter middle name">
              </div>
              <div class="col-3">
                <label for="lname">Last name</label>
                <input class="form-control" id="lname" name="lname" type="text"  placeholder="Enter last name">
              </div>
            </div> 
          </div>

        <h3 style="margin-top: 30px;"> Deceased information</h3>
          <div class="form-group">
            <div class="row">
              <div class="col-3">
                <label for="Fname">First name</label>
                <input class="form-control" id="Fname" type="text"  name="fname" placeholder="Enter first name">
              </div>
              <div class="col-3">
                <label for="Mname">Middle name</label>
                <input class="form-control" id="Mname" name="mname" type="text"  placeholder="Enter middle name">
              </div>
              <div class="col-3">
                <label for="lname">Last name</label>
                <input class="form-control" id="lname" name="lname" type="text"  placeholder="Enter last name">
              </div>
            </div> 
          </div>
           
           <div class="form-group">
            <div class="row">
              <div class="col-3">
                <label for="IDnum">Identification/Passport number</label>
                <input class="form-control" id="IDnum" name="idnum" type="text" placeholder="Identification/Passport number">
              </div>
              <div class="col-3">
                <label for="serialno">Serial number</label>
                <input class="form-control" id="serialno" name="serialno" type="text" placeholder="Serial number">
              </div>
            </div>
         </div>

          <div class="form-group">
            <div class="row">
              <div class="col-3">
                <label for="sex">SEX</label>
                <select class="form-control" name="sex" id="sex" >
                  <option>----</option>
                  <option>Male</option>
                  <option>Female</option>
                  <option>Unknown</option>
                </select>
                </div>
                <div class="col-3">
                  <label for="age">Age (Years/Months/Days)</label>
                <select class="form-control" name="age_units" id="age_units" >
                  <option>----</option>
                  <option>Years</option>
                  <option>Months</option>
                  <option>Days</option>
                </select>
                  <input class="form-control" id="age" type="number" name="age" placeholder="Enter Age">
                </div>
                  <div class="col-3">
                  <label for="dod">Date of Death</label>
                  <input class="form-control" id="dod" type="Date" name="dod" placeholder="Date of deaths">
                </div>
              </div>
            </div>
         
         
         <!-- <a class="btn btn-primary btn-block" href="login.php">Register</a> -->
           <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                <input class="btn btn-primary" id="exampleInputPassword1" type="submit" name="btnsave" value="Submit">
              </div>
            </div>
          </div>

        </form>
        <?php
        require "functions.php";
        $fn = new Functions;
        if(isset($_POST['btnsave'])){
            
        $fname=$_POST["fname"]; $mname=$_POST["mname"]; $lname=$_POST["lname"]; 
        $idnum=$_POST["idnum"]; $serialno=$_POST["serialno"]; $sex=$_POST["sex"];
        $age_units=$_POST["age_units"]; $age=$_POST["age"];$dod=$_POST["dod"];
        $usualres_loc=$_POST["usualres_loc"];$usualres_sub=$_POST["usualres_sub"];
       

        $fn.post_Notifications($fname,$mname,$lname,$idnum,$serialno,$sex,$age_units,$age,$dod,$usualres_loc,$usualres_sub);
        echo "posted successfuly!";
          }else{

          }
        ?>
        <div class="text-center">
          <a class="d-block small mt-3" href="login.php">Login Page</a>
          <a class="d-block small" href="forgot-password.php">Forgot Password?</a>
        </div>
      </div>
        </div> <!--END OF FORM -->

      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
  </div>
</body>

</html>
