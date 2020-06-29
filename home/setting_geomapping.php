
 <?php include("header.php"); ?>
 <style type="text/css">

  .content{
    width: 100%;
  }
  #ana_leftnav{
    width: 17vw;
      min-width: 150px;
      max-width: 20vw;
      background-color:white;
      border-right: inset 1px;
      padding-top:40px ; 
      float: left;
      height: 200vh;
      align-items: stretch;
  }

  ul.pagination li{
  margin-left: ;
  border: solid 1px #ddd;
  width: auto;
  text-align: center;
  padding-left: 10px;
  padding-right: 10px;
  
}

ul.pagination {
  width: 600px;
}
div.dataTables_wrapper div.dataTables_filter {
    margin-left: 20vw;

}
div.dataTables_wrapper div.dataTables_paginate ul.pagination {
  justify-content: flex-start;
}

tr,td {
  font-size: 12px;
}

.form-inline {
    display: -ms-flexbox;
    display: block;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    -ms-flex-align: center;
    align-items: center;
}
</style>

 <script type="text/javascript">
  $(document).ready(function() {   
    //$('#intsumTbl2').DataTable({
      //"pagingType": "simple_numbers"
   // }); 

 $('#intsumTbl2 thead tr').clone(true).appendTo( '#intsumTbl2 thead' );
    $('#intsumTbl2 thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#intsumTbl2').DataTable( {
        orderCellsTop: true,
        fixedHeader: true
    } );

    dialog = $("#add_province").dialog({
      autoOpen: false,
      modal:true
    }); 
    
     dialog2 = $("#add_district").dialog({
      autoOpen: false,
      modal:true
    }); 

    dialog3 = $("#add_facility").dialog({
      autoOpen: false,
      modal:true
    }); 

 dialog4 = $("#add_interviewers").dialog({
      autoOpen: false,
      modal:true
    }); 

$("#btn_add_province").button().on("click", function() {
      dialog.dialog("open");
    });

$("#btn_add_district").button().on("click", function() {
      dialog2.dialog("open");
    });

$("#btn_add_facility").button().on("click", function() {
      dialog3.dialog("open");
    });


$("#btn_add_interviewers").button().on("click", function() {
      dialog4.dialog("open");
    });

  });

   
 
  </script>
<body >
  <?php 
  
  include("sqlite_functions.php");
  $df = new SQLITEDB();
  //$cl = $df->AllTables();
   //$dirty = $df->InterviwerList(1);
  $clean = $df->InterviwerList(3);
  $geo = $df->InterviwerList(4);


  $prov = $df->GeoList(1);
  ///var_dump($prov);
  $dist = $df->GeoList(2);
  $fac = $df->GeoList(3);
  
  
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
        <div class="" id="card"><h3>Geo mapping</h3></div>
      </div>

       <div class="row"> 
       <form action="" method="POST">
        <table class="table" style="width:auto;">
          <tr>
            <td><b>WHO Interviewer name:</b></td>
            <td>
              <select class="form-control" name="interviewer" style="width: 15vw; margin-left: 20px; font-size: 12px; float: left;" id="interviewer" required>
                <option></option>
                    <?php                 
                       foreach($clean['intname'] as $c) {
                         echo "<option>".$c."</option>";
                      }
                        ?>
                  </select>
            </td>
            <td></td>
            </tr>
          <tr>
            <td><b>Geo mapping value</b></td>
            <td>
              <select class="form-control" name="geovalue" style="width: 15vw; margin-left: 20px; font-size: 12px; float: left;" id="geovalue" required>
                <option></option>
                    <?php                 
                       foreach($geo['intname'] as $c) {
                         echo "<option>".$c."</option>";
                      }
                        ?>
                  </select>
            </td>
            <td>
              <input type="submit" name="updateGeo" value="Update" class="btn btn-success" style="float: left;margin-left:10px;">
            </td>
          </tr>           
        </table> 
      </form>

      <div id="add_province" style="margin-left: 30px;">
        <form style="width: 200px;" action="" method="POST">
          <b>Province name</b>
           <input type="text" name="Province" class="form-control" style="">
           <input type="submit" name="saveProvince" class="btn btn-primary" value="Save" style="margin-top: 20px;">
        </form>
      </div>

      <div id="add_district" style="margin-left: 30px;">
        <form style="width: 200px;" action="" method="POST">
          <b>Province name</b>
          <select class="form-control" name="province" style="" id="province" required>
                <option></option>
                    <?php            
                    foreach ($prov as $key => $value) {
                      echo "<option value='".$key."'>".$value."</option>";
                      }     
                    ?>
                  </select>

            <b>District name</b>
           <input type="text" name="district" class="form-control" style="" required>
           <input type="submit" name="saveDistrict" class="btn btn-primary" value="Save" style="margin-top: 20px;">
        </form>
      </div>

      <div id="add_facility" style="margin-left: 30px;">
        <form style="width: 200px;" action="" method="POST">
          <b>Province name</b>
            <select class="form-control" name="province" style="" id="province" required>
                <option></option>
                    <?php            
                    foreach ($prov as $key => $value) {
                      echo "<option value='".$key."'>".$value."</option>";
                      }     
                    ?>
                  </select>
            <b>District name</b>
            <select class="form-control" name="district" style="" id="district" required>
                <option></option>
                    <?php            
                    foreach ($dist as $key => $value) {
                      echo "<option value='".$key."'>".$value."</option>";
                      }     
                    ?>
                  </select>
            <b>Facility name</b>
           <input type="text" name="facility" class="form-control" style="" required>
           <input type="submit" name="saveFacility" class="btn btn-primary" value="Save" style="margin-top: 20px;">
        </form>
      </div>

      <div id="add_interviewers" style="margin-left: 30px;">
        <form style="width: 200px;" action="" method="POST">
          <b>Province name</b>
            <select class="form-control" name="province" style="" id="province" required>
                <option></option>
                    <?php            
                    foreach ($prov as $key => $value) {
                      echo "<option >".$value."</option>";
                      }     
                    ?>
                  </select>
            <b>District name</b>
            <select class="form-control" name="district" style="" id="district" required>
                <option></option>
                    <?php            
                    foreach ($dist as $key => $value) {
                      echo "<option>".$value."</option>";
                      }     
                    ?>
                  </select>
            <b>Facility name</b>
           <select class="form-control" name="facility" style="" id="facility" required>
                <option></option>
                    <?php            
                    foreach ($fac as $key => $value) {
                      echo "<option>".$value."</option>";
                      }     
                    ?>
                  </select>
            <b>Interviewer name</b>
           <input type="text" name="interviewer" class="form-control" style="" required>
           <input type="submit" name="saveInterviewer" class="btn btn-primary" value="Save" style="margin-top: 20px;">
        </form>
      </div>

      </div>

      <button class="btn btn-primary" id="btn_add_province">Add Province</button>
      <button class="btn btn-primary" id="btn_add_district">Add District</button>
      <button class="btn btn-primary" id="btn_add_facility">Add Facilities</button>
      <button class="btn btn-primary" id="btn_add_interviewers">Add Interviewers</button> 
      
      
      <div class="row" style="margin-top: 5vh;"> 
        <?php
        if(isset($_POST['saveProvince'])){
          $provname= $_POST['Province'];
          $provname=pg_escape_string($provname);

          $q = "insert into public.province(province) values('".$provname."')";
          $res = $df->con->exec($q);
          if($res){
           echo "<script>
                  alert('Record saved!');
                  </script>";
                  echo "<meta http-equiv='refresh' content='0'>";
          }else{
            echo "<script>
                  alert('Record Not saved!');
                  </script>";
          }
        }

     if(isset($_POST['saveDistrict'])){
          $provid= $_POST['province'];
          $dist= $_POST['district'];

          $provid=pg_escape_string($provid);
          $dist=pg_escape_string($dist);
          //echo $provid.' '.$dist;

          $q = "insert into districts(provinceid,district) values('".$provid."','".$dist."')";
          $res = $df->con->exec($q);

          if($res){
           echo "<script>
                  alert('Record saved!');
                  </script>";
                  echo "<meta http-equiv='refresh' content='0'>";
          }else{

            echo "<script>
                  alert('Record Not saved!');
                  </script>";
          }
        }

    if(isset($_POST['saveFacility'])){
          $provid= pg_escape_string($_POST['province']);
          $dist= pg_escape_string($_POST['district']);
          $fac= pg_escape_string($_POST['facility']);
          //echo $provid.' '.$dist; 

          $q = "insert into public.facilities(provinceid,districtid,facility) 
          values('".$provid."','".$dist."','".$fac."')";
          $res = $df->con->exec($q);

          if($res){
           echo "<script>
                  alert('Record saved!');
                  </script>";
                  echo "<meta http-equiv='refresh' content='0'>";
          }else{
            echo "<script>
                  alert('Record Not saved!');
                  </script>";
          }
        }


 if(isset($_POST['saveInterviewer'])){
          $provid= pg_escape_string($_POST['province']);
          $dist= pg_escape_string($_POST['district']);
          $fac= pg_escape_string($_POST['facility']);
           $int= pg_escape_string($_POST['interviewer']);
          //echo $provid.' '.$dist;

          $q = "insert into geo(province,district,facility,interviewer) 
          values('".$provid."','".$dist."','".$fac."','".$int."')";
          $res = $df->con->exec($q);

          if($res){
           echo "<script>
                  alert('Record saved!');
                  </script>";
                  echo "<meta http-equiv='refresh' content='0'>";
          }else{
            echo "<script>
                  alert('Record Not saved!');
                  </script>";
          }
        }


        if(isset($_POST['updateGeo'])){
          $int= pg_escape_string($_POST['interviewer']);
          $geo= pg_escape_string($_POST['geovalue']);
        


          $q = "update geo set id10010='".$int."' where interviewer='".$geo."' ";
          
          $res = $df->con->exec($q);

          if($res){
           echo "<script>
                  alert('Record updated!');
                  </script>";
                  echo "<meta http-equiv='refresh' content='0'>";
          }else{
            echo "<script>
                  alert('Record Not Updated!');
                  </script>";
          }

        }
        //button for submission; updateGeo
      
          $str = "select * from geo";

          $tcol = $df ->AnytableCols($str);
          $rows = $df ->AnytableData($str);
          
          $rcnt = $rows->RowCount();
          if($rcnt>0){

          $cntRows = sizeof($tcol);
          $cntCol = sizeof($tcol[0]);
          echo '<table class="table table-sm table-bordered " id="intsumTbl2" cellspacing="0" style="width:auto;">';

            $columns = array_keys($tcol[0]);
            //var_dump($columns);

            echo "<thead><tr>";
            for($i=0;$i<$cntCol;$i++){
              echo "<th>".$columns[$i]."</th>";
            }
            echo "</tr></thead>";
                                        
            echo "<tbody>";
            foreach($rows as $row) {
              echo "<tr>";
              for($k=0;$k<$cntCol;$k++){
                echo "<td>".$row[$k]."</td>";
              }
             echo "</tr>";
            }
            echo "</tbody>";


            echo "<tfoot><tr>";
            for($i=0;$i<$cntCol;$i++){
              echo "<th>".$columns[$i]."</th>";
            }
            echo "</tr></tfoot>";
                      
            echo "</table>"; 
        }else{
          echo "no data!";
        }      
         ?> 
      </div>



    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

