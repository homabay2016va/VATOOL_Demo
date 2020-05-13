
 <?php include("header.php"); ?>
<body >
<?php 
  //include("connection.php");
  include("sqlite_functions.php");
  $df = new SQLITEDB();

  $Years = $df->csmfYear();
  $yr = $Years['year'];
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
        <div class="" id="card"><h3>We are here</h3></div>
      </div>

	<div class="row"> 
       <div class="col-sm-3">
       	 <form action="#midcontent" method="POST">
              <b>Data</b>
                  <select class="form-control" name="dtype" style="width: 240px; margin-left: 30px;" id="csmf_list">
                    <option>COD CSMF</option>
                    <option>COD CSMF by Age Groups</option>
                    <option>COD CSMF by Sex</option>
                  </select>     
                <b>Year</b>
                  <select class="form-control" name="year" style="width: 120px; margin-left: 30px;" id="year">
                    <option>All</option>
                      <?php
                         foreach($yr as $y) {
                          echo "<option>".$y."</option>";
                         }
                        ?>
                  </select>
              <input type="submit" name="search" value="Search" class="btn btn-success" style="margin-left: 23px; margin-top: 20px;">
        </form>           
       </div>
       <div class="col-sm-3">
       	<?php
          if(isset($_POST['dtype'])){

          
        ?>
        <script type="text/javascript">
          //var d = new Date('2017-10-10T00:00:00.000+03');
          //console.log(d.getUTCHours()); // Hours
          document.getElementById('csmf_list').value='<?php echo $_POST['dtype']; ?>'
          document.getElementById('year').value='<?php echo $_POST['year']; ?>'
        </script>
        <?php
          }
        ?>
          <div class="row">
            <div id="codPlots" style=""></div>
              <div class="col-sm-7" id="csmfint" style="float: left; ">
                  <div id="csmfintplot" style="float: left;"></div>
                     
              </div>
        
          </div>
    
       <?php
        if(isset($_POST['search'])){
          $TotInt=0;
          $TotIns=0;
          $cmtotal=0;
          $cftotal=0;
          $catotal=0;
          $cctotal=0;
          $cntotal=0;

          $codyr = $_POST['year'];

          $int5 = $df->csmfInterVA($codyr);
          $TotInt= $int5['total'];
          if($_POST['dtype']=='COD CSMF'){
            
            $csmfint = $int5['interva5'];
            $intcnt = $int5['cnt'];
            
            ?>
            <script type="text/javascript">
                var trace_int = [{
                  x: <?php echo json_encode($intcnt);?>,
                  y: <?php echo json_encode($csmfint);?>,
                  name: 'interva5',
                  type: 'bar',
                  orientation: 'h'
                }];

                var layout = {
                  title:<?php echo json_encode($_POST['dtype']); ?>+' ['+<?php echo json_encode($codyr); ?>+' Deaths:'+<?php echo $TotInt;?>+']',
                    height: 1000,
                    width: 800,
                    margin:{
                      l:220
                    },
                    barmode:"group"
                };

                Plotly.newPlot('csmfintplot', trace_int, layout);
               </script>  
              <?php

          }elseif($_POST['dtype']=='COD CSMF by Sex'){
            $sexcod = $df-> interva5CODBySex($codyr);
            $mcod = $sexcod['mcod'];
            $codmales = $sexcod['males'];
            foreach ($codmales as $pm) {
              $cmtotal= $cmtotal + $pm;
            }

            $fcod = $sexcod['fcod'];
            $codfemales = $sexcod['females'];
            foreach ($codfemales as $pf) {
              $cftotal= $cftotal + $pf;
            }

            ?>
            <script type="text/javascript">
                //cod by sex
            var trace3 = {
                x:  <?php echo json_encode($codmales);?>,
                y: <?php echo json_encode($mcod);?>,
                name: 'Males',
                orientation: 'h',
                type: 'bar'
              };

              var trace4 = {
                x: <?php echo json_encode($codfemales);?>,
                y: <?php echo json_encode($fcod);?>,
                name: 'Females',
                orientation: 'h',
                type: 'bar'
              };

              var data4 = [trace3, trace4];

              var layout4 = {
                barmode: 'stack',
                  title: <?php echo json_encode($_POST['dtype']); ?>+' ['+<?php echo json_encode($codyr); ?>+' Deaths:'+<?php echo $TotInt;?>+']',
                  height: 1000,
                   width: 600,
                   margin:{
                      l:200
                    }
                };

              Plotly.newPlot('csmfintplot', data4, layout4);
               </script>  
              <?php

          }elseif($_POST['dtype']=='COD Undetermined'){

            $undetq = $df-> Undetermined($codyr);
            $undet = $undetq['interviewer'];
            $undetcnt = $undetq['counts'];
            $totundet = $undetq['total'];

            echo '<table class="table table-bg table-bordered table-responsive" id="undet" cellspacing="0">
              <thead><tr>
                <th>Interviwer</th>
                <th>Undetermined cases (total:'.$totundet.')</th>
              </tr></thead>';
                       
              for($k=0;$k<sizeof($undet);$k++){
                echo "<tr>
                  <td>".$undet[$k]."</td>
                  <td>".$undetcnt[$k]."</td>
                </tr>";
              }           
              echo " <tfoot><tr>
                <th>Interviwer</th>
              <th>Undetermined cases (total:".$totundet.")</th>
              </tr></tfoot>';";

              echo "</table>";


          }elseif($_POST['dtype']=='COD CSMF by Age Groups'){
            $agegroupcod = $df-> interva5CODByAgeGroup($codyr);
            $acod = $agegroupcod['adultcod'];
            $codadult = $agegroupcod['adult'];
            foreach ($codadult as $pa) {
              $catotal= $catotal + $pa;
            }

            $ccod = $agegroupcod['childcod'];
            $codchild = $agegroupcod['child'];
            foreach ($codchild as $pc) {
              $cctotal= $cctotal + $pc;
            }

            $ncod = $agegroupcod['neoncod'];
            $codneon = $agegroupcod['neonate'];
            foreach ($codneon as $pn) {
              $cntotal= $cntotal + $pn;
            }

            ?>
            <script type="text/javascript">
                //cod by sex
            var adult = {
                x:  <?php echo json_encode($codadult);?>,
                y: <?php echo json_encode($acod);?>,
                name: 'Adult',
                orientation: 'h',
                type: 'bar'
              };

              var child = {
                x: <?php echo json_encode($codchild);?>,
                y: <?php echo json_encode($ccod);?>,
                name: 'Child',
                orientation: 'h',
                type: 'bar'
              };

              var neonate = {
                x: <?php echo json_encode($codneon);?>,
                y: <?php echo json_encode($ncod);?>,
                name: 'Neonate',
                orientation: 'h',
                type: 'bar'
              };

              var data4 = [adult, child,neonate];

              var layout4 = {
                barmode: 'stack',
                  title: <?php echo json_encode($_POST['dtype']); ?>+' ['+<?php echo json_encode($codyr); ?>+' Deaths:'+<?php echo $TotInt;?>+']',
                  height: 1000,
                   width: 600,
                   margin:{
                      l:200
                    }
                };

              Plotly.newPlot('csmfintplot', data4, layout4);
               </script>  
              <?php

          }

          
          //var_dump($intcnt);

        }
       ?>
       </div>
    </div>



    </div>
 


  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

