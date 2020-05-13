
 <?php include("header.php"); ?>
<body >
<?php 
  include("sqlite_functions.php");
  $df = new SQLITEDB();
  $dirty = $df->InterviwerList(1);
  $clean = $df->InterviwerList(3);
  $geo = $df->InterviwerList(4);
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
        <div id="card"><h3>Data cleaning (Interviewer Name)</h3></div>
      </div>

      <div class="row" >
      	<div class="col-sm-5">
      	<form action="#midcontent" method="POST">
      	<table class="table" style="width:auto;">
      		<tr>
      			<td><b>Interviwer name</b> </td>
      			<td> 
      				<select class="form-control" name="oldname" style="width: 15vw; margin-left: 20px; font-size: 12px; float: left;" required>
      					<option></option>
                    <?php                 
                       foreach($dirty['intname'] as $c) {
                         echo "<option>".$c."</option>";
                     	}
                        ?>
                  </select>
              </td>
      			<td></td>
      		
      	    </tr>
      		<tr>
      			<td><b>Replace with:</b></td>
      			<td>
      				<select class="form-control" name="newname" style="width: 15vw; margin-left: 20px; font-size: 12px; float: left;" required>
                    <?php                 
                       foreach($clean['intname'] as $c) {
                         echo "<option>".$c."</option>";
                     	}
                        ?>
                  </select>
      			</td>
      			<td>
              
            </td>
      	    </tr>
      		<tr>
      			<td>
           <input type="submit" name="update" value="Update" class="btn btn-success" style="float: left;margin-left:10px;">   
            </td>
      			<td>
      			</td>
      			<td>
      				
      			</td>
      		</tr>          	
      	</table> 
      </form>
      <?php
        if(isset($_POST['update'])){
          $old = pg_escape_string($_POST['oldname']);
          $new = pg_escape_string($_POST['newname']);


          $q = "update public.vadata_clean set id10010='".$new."' where id10010='".$old."' ";
          $res = $df->con->exec($q);

          if($res){
           echo "<script>
                  alert('Record updated!');
                  </script>";
                  echo "<meta http-equiv='refresh' content='0'>";
          }else{

            echo "<script>
                  alert('Record Not saved!');
                  </script>";
          }


        }

      ?>
      	</div>
      	<div class="col-sm-5">
      		<div class="row">
      			<b></b>
           
      		</div>
      	</div>  	
     </div>
 	


    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

