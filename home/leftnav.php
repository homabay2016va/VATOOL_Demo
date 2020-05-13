<div class="left column" style=" font-size: 14px;">
      <!-- The sidebar -->
            <?php 
           
    echo '<div class="sidebar">
          <a class="active" href="index.php?sid='.$_SESSION['sid'].'">
          <i class="fa fa-home" aria-hidden="true"></i>Home (Summary)</a>

           <a href="va_submission.php?sid='.$_SESSION['sid'].'"><i class="fa fa-file" aria-hidden="true"></i>VA submission</a>

          <a href="va.php?sid='.$_SESSION['sid'].'"><i class="fa fa-search" aria-hidden="true"></i>
          Search Data</a>

          <a href="cleaning.php?sid='.$_SESSION['sid'].'"><i class="fa fa-tags" aria-hidden="true"></i>Data Cleaning</a>

          <a href="sqltables.php?sid='.$_SESSION['sid'].'"><i class="fa fa-database" aria-hidden="true"></i>
          Table data</a>

          <a href="va_analytics.php?sid='.$_SESSION['sid'].'">
          <i class="fa fa-industry" aria-hidden="true"></i>VA Analytics</a>

          <a href="analytics.php?sid='.$_SESSION['sid'].'"><i class="fa fa-cubes" aria-hidden="true"></i>COD Analytics</a>

           <a href="setting_geomapping.php?sid='.$_SESSION['sid'].'"><i class="fa fa-wrench" aria-hidden="true"></i>Demographics settings</a>

           <a href="dynamic.php?sid='.$_SESSION['sid'].'"><i class="fa fa-book" aria-hidden="true"></i>Pivot table</a>'
          ;

          if($_SESSION['ugroup']=='Administrator'){
          echo ' <a href="create_account.php?sid='.$_SESSION['sid'].'">
           <i class="fa fa-users" aria-hidden="true"></i>Ceate account</a>';
           }
           echo "</div>";
?>

    </div>