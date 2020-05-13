
 <?php include("header.php"); ?>
 <style type="text/css">
   form{
    border-right:inset 1px; width: auto;
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
  width: 300px;
}

div.dataTables_wrapper div.dataTables_filter {
    margin-left: 20vw;
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
  justify-content: flex-start;
  margin-left: 20vw;
}

 </style>
  <script type="text/javascript">
  $(document).ready(function() { 
    //$('#viewint').DataTable({
    //  "pagingType": "simple_numbers" 
    //}); 

    $('#intsumTbl').DataTable({
      "pagingType": "simple_numbers" 
    }); 

   // $('#cusumTbl').DataTable({
   //   "pagingType": "simple_numbers" 
    //}); 

  });
  </script>
<body >
  <?php 

  include("sqlite_functions.php");
  $df = new SQLITEDB();

  $Years = $df->csmfYear();
  $yr = $Years['year'];
  //var_dump($yr);
  $Years2 = $df->VASubmissionYear();
  $yr2 = $Years2['year'];


  $vasex = $df->countGender();
  $sex = $vasex['gender'];
  $sexcnt = $vasex['counts'];

  $vapod = $df->countPod();
  $pod = $vapod['pod'];
  $podcnt = $vapod['counts'];

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
        <div class="" id="card"><h3>VA Data Summary</h3></div>
      </div>

     <div class="row"> 
      <div class="col-sm-3">
         <div class="row">
            <form action="#midcontent" method="POST" style="">
              <b>Data</b>
                  <select class="form-control" name="dtype" style="width: 200px; margin-left: 20px; font-size: 12px;" id="csmf_list">
                    <option>VA SUMMARY By Year</option>
                    <option>VA SUMMARY BY SEX</option>
                    <option>VA SUMMARY BY AGE GROUP</option>
                     <option>VA SUMMARY BY Place of death</option>
                  </select>     
               <b>Year of death</b>
                  <select class="form-control" name="year" style="width: 120px; margin-left: 30px;" id="year">
                      <?php
                       foreach($yr as $y) {
                         echo "<option>".$y."</option>";
                       }
                        ?>
                  </select>
                <input type="submit" name="search" value="Search" class="btn btn-success" style="margin-top: 4px;margin-left:5vw;  ">
        </form>
         </div>
         <div class="row">
           <form action="#midcontent" method="POST" style="background-color: ; margin-top: 5vh;">
              <b>Submission Data</b>
                  <select class="form-control" name="dtype2" style="width: 200px; margin-left: 20px; font-size: 12px;" id="csmf_list2">
                    <option >VA SUBMISSION</option>
                  </select>             
                <b>Year</b>
                  <select class="form-control" name="year2" style="width: 120px; margin-left: 30px;" id="year2">
                      <?php
                       foreach($yr2 as $y) {
                         echo "<option>".$y."</option>";
                       }
                        ?>
                  </select>
                <input type="submit" name="search2" value="View" class="btn btn-success" style="margin-top: 4px;margin-left:5vw;  ">
        </form>  
         </div>
      </div>
      <div class="col-sm-3">
        <?php
          if(isset($_POST['dtype'])){

          
        ?>
        <script type="text/javascript">
          document.getElementById('csmf_list').value='<?php echo $_POST['dtype']; ?>'
          document.getElementById('year').value='<?php echo $_POST['year']; ?>'
        </script>
        <?php
          }
        ?>
          <div class="row">
            <div id="vaPlots" style=""></div>
              <div class="col-sm-7" id="vagraph" style="float: left; ">
                  <div id="vagraphPlot" style=""></div>                    
              </div>
        
             </div>
             <div class="row">
                <div id="vaPlots" style=""></div>
                <div class="col-sm-7" id="vagraph" style="float: left; ">
                    <div id="vagraphPlot_bar" style=""></div>                    
                </div>    
            </div>
              <?php
        if(isset($_POST['search'])){
          $year = $_POST['year'];
          $vaforms = $df->countFormsYear($year);
          //var_dump($vaforms);
          $adult = $vaforms['adult'];
          $child = $vaforms['child'];
          $neonate = $vaforms['neonate'];
          $totalforms = $vaforms['vacnt'];

          ?>
         
          <?php

          if($_POST['dtype']=='VA SUMMARY BY SEX'){
            $mr = $df->MontlyReportSex($year);
            $mnths = $mr['months'];
            $mcnt = $mr['mcounts'];
            $fcnt = $mr['fcounts'];
            $mtot=array_sum($mcnt);
            $ftot=array_sum($fcnt);
            $sumcnt = $mtot+$ftot;

           
            ?>
            <script type="text/javascript">
              var males = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($mcnt);?>,
                  type: 'bar',
                  name:'Males'
                  };

              var females = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($fcnt);?>,
                  type: 'bar',
                  name:'Females'
                  };

              var sexdata = [males, females];

              var layout = {
                barmode: 'stack',
                title: <?php echo $year;?>+' '+<?php echo json_encode($_POST['dtype']); ?>,
                  height: 500,
                   width: 900,
                   margin:{
                      l:40
                    }
                };

              var config={
                displayModeBar:true,
                displaylogo:false,
                showSendToCloud:false
              };

              Plotly.newPlot("vagraphPlot",sexdata,layout,config);

             </script>
             <table class="table-bordered summaryTable">
              <tr>
                <th>Males</th>
                <th>Females</th>
                <th>Total</th>
              </tr>
              <tr>
                <td><?php echo $mtot.' ('.round((($mtot/$sumcnt)*100),2).'%)'; ?></td>
                <td><?php echo $ftot.' ('.round((($ftot/$sumcnt)*100),2).'%)'; ?></td>
                <td><?php echo $sumcnt; ?></td>
              </tr>
             </table>    
            <?php
          }elseif($_POST['dtype']=='VA SUMMARY By Year'){
            $mr = $df->MontlyReportYear($year);
            $mnths = $mr['months'];
            $cnt = $mr['counts'];
            $mtot = array_sum($cnt);

            echo '<table class="table-bordered summaryTable" >
              <tr>
                <th>Months</th>
                <th>Count</th>
              </tr>';
              
             
            for($k=0;$k<sizeof($mnths);$k++){
              echo "<tr>
                <td>".$mnths[$k]."</td>
                <td>".$cnt[$k]."</td>
              </tr>";
            }
            echo "<tr>
                <th>Total</th>
                <th>".$mtot."</th>
              </tr>";
            echo "</table>";
            ?>
            <script type="text/javascript">

              var monthlyrpts = [
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($cnt);?>,
                  type: 'bar'
                  }];

              var layout = {
                barmode: 'stack',
                  title: <?php echo json_encode($_POST['dtype']); ?>+'- DOD:'+<?php echo $year;?>,
                  height: 500,
                   width: 900,
                   margin:{
                      l:40
                    }
                };

              var config={
                displayModeBar:true,
                displaylogo:false,
                showSendToCloud:false
              };

              Plotly.newPlot("vagraphPlot",monthlyrpts,layout,config);
             </script>        
            <?php

          }elseif($_POST['dtype']=='VA SUMMARY BY Place of death'){
            $vapod = $df->countPodYear($year);
            $pod = $vapod['pod'];
            $podcnt = $vapod['counts'];
            $podtot = array_sum($podcnt);

            echo '<table class="table-bordered summaryTable" >
              <tr>
                <th>Months</th>
                <th>Count</th>
              </tr>';
              
             
            for($k=0;$k<sizeof($pod);$k++){
              echo "<tr>
                <td>".$pod[$k]."</td>
                <td>".$podcnt[$k]."</td>
              </tr>";
            }
            echo "<tr>
                <th>Total</th>
                <th>".$podtot."</th>
              </tr>";
            echo "</table>";
            ?>
            <script type="text/javascript">

              var pod =[{
                values:<?php echo json_encode($podcnt);?>,
                labels:<?php echo json_encode($pod);?>,
                type:'pie'
              }];  

              var podlayout = {
                height: 600,
                width: 700,
                title:'Place of death distribution'
              };
            
            Plotly.newPlot("vagraphPlot_bar",pod,podlayout);

             // Plotly.newPlot("vagraphPlot",monthlyrpts,layout,config);
             </script>        
            <?php
          }elseif($_POST['dtype']=='VA SUMMARY BY AGE GROUP'){
            $mr = $df->MontlyReportByAgeGroup($year);

            $mnths = $mr['months'];
            $adultc = $mr['adult'];
            $childc = $mr['child'];
            $neonc = $mr['neonate'];  

            $atot = array_sum($adultc);
            $ctot= array_sum($childc);
            $ntot= array_sum($neonc);
            $frmtot = $atot+$ctot+$ntot;

            ?>
            <script type="text/javascript">
              var adult = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($adultc);?>,
                  type: 'scatter',
                  name:'Adult'
                  };

              var adult2 = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($adultc);?>,
                  type: 'bar',
                  name:'Adult'
                  };

              var child = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($childc);?>,
                  type: 'scatter',
                  name:'Child'
                  };

              var child2 = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($childc);?>,
                  type: 'bar',
                  name:'Child'
                  };

              var neonate = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($neonc);?>,
                  type: 'scatter',
                  name:'Neonate'
                  };

              var neonate2 = 
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($neonc);?>,
                  type: 'bar',
                  name:'Neonate'
                  };

              var agdata = [adult,child,neonate];
              var agdata2 = [adult2,child2,neonate2];

              var layout = {
                //barmode: 'stack',
                  title: <?php echo json_encode($_POST['dtype']); ?>+' Year:'+<?php echo $year;?>,
                  height: 600,
                   width: 1000,
                   margin:{
                      l:40
                    }
                };

                var layout2 = {
                barmode: 'stack',
                  title: <?php echo json_encode($_POST['dtype']); ?>+' Year:'+<?php echo $year;?>,
                  height: 600,
                   width: 1000,
                   margin:{
                      l:40
                    }
                };

              var config={
                displayModeBar:true,
                displaylogo:false,
                showSendToCloud:false
              };

              Plotly.newPlot("vagraphPlot",agdata,layout,config);
              Plotly.newPlot("vagraphPlot_bar",agdata2,layout2,config);

             </script>   
              <table class="table-bordered summaryTable">
              <tr>
                <th>Adult</th>
                <th>Child</th>
                <th>Neonate</th>
                <th>Total</th>
              </tr>
              <tr>
                <td><?php echo $atot.' ('.round((($atot/$frmtot)*100),2).'%)'; ?></td>
                <td><?php echo $ctot.' ('.round((($ctot/$frmtot)*100),2).'%)'; ?></td>
                <td><?php echo $ntot.' ('.round((($ntot/$frmtot)*100),2).'%)'; ?></td>
                <td><?php echo $frmtot; ?></td>
              </tr>
             </table> 

            <?php
          }
          //elseif($_POST['dtype']=='VA SUBMISSION'){
           /* $intsum = $df->InterviwerSummary($year);
            $intsum2 = $df->InterviwerSummary($year);
            $rows = $intsum2 ->fetchAll();
                    
                    //var_dump($intsum2 ->fetch(PDO::FETCH_ASSOC));

            echo '<table class="table table-sm table-bordered" id="intsumTbl" cellspacing="0" style="width:auto;">';

            $cntCol = $intsum ->columnCount();
            $cntData = $intsum ->rowCount();

            $columns = array_keys($intsum ->fetch(PDO::FETCH_ASSOC));

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
                      
            echo "</table>"; */
        //  }
          

        }



        //button for submission
        if(isset($_POST['search2'])){
          $year = $_POST['year2'];
          $vaforms = $df->countFormsYear($year);
          //var_dump($vaforms);
          $adult = $vaforms['adult'];
          $child = $vaforms['child'];
          $neonate = $vaforms['neonate'];
          $totalforms = $vaforms['vacnt'];

          if($_POST['dtype2']=='VA SUBMISSION'){
            $intsum = $df->InterviwerSummary($year);
            $intsum2 = $df->InterviwerSummary($year);
            $rows = $intsum2 ->fetchAll();
        
                    //var_dump($intsum2 ->fetch(PDO::FETCH_ASSOC));
          


            echo '<table class="table table-sm table-bordered " id="intsumTbl" cellspacing="0" style="width:auto;">';

            $cntCol = $intsum ->columnCount();
            $cntData = $intsum ->rowCount();

            $columns = array_keys($intsum ->fetch(PDO::FETCH_ASSOC));

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
            echo "</tr>
                <tr><td colspan=".$cntCol." class='btn btn-success'><a href='va_csv.php?q=".$year."' style='color:white;'>Download csv</a></td></tr>
            </tfoot>";
                      
            echo "</table>"; 
          }
          

        }
         ?>
      </div>
        
 </div>


</div>
 


</div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

