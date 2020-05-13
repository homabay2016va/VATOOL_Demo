
 <?php include("header.php"); ?>
<body >
  <?php 
  #include("dash_functions.php");

  include("sqlite_functions.php");


  $df = new SQLITEDB();

  $mr = $df->MontlyReport();
  $mnths = $mr['months'];
  $mcnt = $mr['counts'];

  $vaforms = $df->countForms();
  $adult = $vaforms['adult'];
  $child = $vaforms['child'];
  $neonate = $vaforms['neonate'];
  $totalforms = $vaforms['vacnt'];

  $subyr = $df->SubmissionYear();
  $yr = $subyr['year'];

  $vasex = $df->countGender();
  $sex = $vasex['gender'];
  $sexcnt = $vasex['counts'];

  $vapod = $df->countPod();
  $pod = $vapod['pod'];
  $podcnt = $vapod['counts'];

  $todayq = $df->countToday();
  $today = $todayq['today'];

 $thisweekq = $df->countThisWeek();
  $thisweek = $thisweekq['thisweek'];

  $thismonq = $df->countThisMonth();
  $thismon = $thismonq['thismonth'];

   $thisyearq = $df->countThisYear();
  $thisyear = $thisyearq['thisyear'];


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

      <div class="row" style="margin-top: 2vh;"> 
          <div class="card btn card1" style="background-color:orange; color: white;">
             <span class="txtsummary"><b>Neonate</b></span>
               <p><i><?php echo $neonate." (".(int)(($neonate/$totalforms)*100)."%)";?></i></p>
          </div>
         <div class="card btn" style="background-color:green; color: white;">
           <span class="txtsummary"><b>Child</b></span>
              <p><i><?php echo $child." (".(int)(($child/$totalforms)*100)."%)";?></i></p>
          </div>
         <div class="card btn " style="background-color:brown; color: white;">
              <span class="txtsummary"><b>Adult</b></span>
            <p><i><?php echo $adult." (".(int)(($adult/$totalforms)*100)."%)";?></i></p>

          </div>
         <div class="card btn" style="background-color:purple; color: white;">
             <span class="txtsummary"><b>Total</b></span>
             <p><i><?php echo $totalforms;?></i></p>                                                   
          </div>
      </div>

      
      <div class="row" style="margin-top: 2vh;"> 
        <div class="" id="card"><h5>Summary</h5></div>
      </div>

      <div class="row">
        <div id="vagraphPlot"></div>
        <div id="genderplot"></div>
              <script type="text/javascript">

              var sex =[{
                values:<?php echo json_encode($sexcnt);?>,
                labels:<?php echo json_encode($sex);?>,
                type:'pie'
              }];  

              var sexlayout = {
                height: 400,
                width: 500,
                title:'Gender distribution'
              };
              

             

              var monthlyrpts = [
                  {
                  x: <?php echo json_encode($mnths);?>,
                  y: <?php echo json_encode($mcnt);?>,
                  type: 'bar'
                  }];

              var layout = {
                title:"Cumulative VA data summary",
                height:350
              };

              var config={
                displayModeBar:true,
                displaylogo:false,
                showSendToCloud:false,
                showTips: true 
              };

              Plotly.newPlot("vagraphPlot",monthlyrpts,layout,config);
              Plotly.newPlot("genderplot",sex,sexlayout);
            
             </script>
      </div>

      <div class="row" style="margin-top: 2vh; "> 
        <table class="table table-bordered" cellspacing="0" style="width: 200px;">
           <tr><th>Today</th><th><?php echo $today;?></th></tr>
            <tr> <th>This week</th><th><?php echo $thisweek;?></th></tr>
           <tr>  <th>This month</th><th><?php echo $thismon;?></th></tr>
            <tr> <th>This Year</th><th><?php echo $thisyear;?></th></tr>          
        </table>
        <div id="podPlot" style="margin-left: 3vw;"></div>
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
            
            Plotly.newPlot("podPlot",pod,podlayout);
        </script>
      </div>


    </div><!-- right column---main page -->
  </div><!-- mid content -->




  

 </div> <!-- Page content -->
    

</div><!-- container -->
</body>


    

