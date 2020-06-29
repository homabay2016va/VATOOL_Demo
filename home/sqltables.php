
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




  });
  </script>
<body >
  <?php 
  
  include("sqlite_functions.php");
  $df = new SQLITEDB();
  $cl = $df->AllTables();
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
        <div class="" id="card"><h3>View tables data</h3></div>
      </div>

       <div class="row"> 
        <form action="#midcontent" method="POST" style=""> 
                  <select class="form-control" name="table_name" style="width: 200px; margin-left: 20px; font-size: 12px; float: left;" id="table_name">
                    <?php
                       foreach($cl['table_name'] as $c) {
                         echo "<option>".$c."</option>";
                       }
                        ?>
                  </select>
                  <input type="submit" name="search2" value="View" class="btn btn-success" style="float: left;margin-left:10px;">
        </form>  
         <script type="text/javascript">
          document.getElementById('table_name').value='<?php echo $_POST['table_name']; ?>'
        </script>
      </div>
      <div class="row" style="margin-top: 5vh;"> 
        <?php
        //button for submission
        if(isset($_POST['search2'])){
          $tbl = $_POST['table_name'];
          $tbl=pg_escape_string($tbl);
          $str = "select * from ".$tbl;

          $tcol = $df ->AnytableCols($str);
          $rows = $df ->AnytableData($str);
          
          
           $rcnt = $rows->RowCount();
          if($rcnt>0){
          
            $cntRows = sizeof($tcol);
            $cntCol = sizeof($tcol[0]);

         //   if($cntRows>0){
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
              echo "No data";
            }
  

        }
         ?> 
      </div>



    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

