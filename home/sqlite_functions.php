<?php
//include("connection.php");

Class SQLITEDB{

	public function __construct(){
		
		//print($constr);
		try{

			#$this->con=new PDO("sqlite:va.db");
			//$this->con=new PDO("sqlite:va_new.db");
		$this->con = new PDO('pgsql:host=127.0.0.1;dbname=zmdata','vaprogram','P@55w0rd');
			//$this->con = new PDO('sqlite:C:/Users/user/OneDrive/CRVS_DASH_CODE/va.db');
			//echo "ss";		

		}catch(PDOException $e){
			print($e->getMessage());
		}
	}

	function InterViewers($vaid){
		$vaid=pg_escape_string($vaid);
		$vadata="SELECT distinct instanceid, case when id10010='other' then id10010_other else id10010 end as interviwerName,id10017 as Firstname ,id10019 as Gender,id10057 as death_occur,id10058 as death_location, 
 case when isadult='1' or age_group='adult' then 'Adult' 
 when ischild='1' or age_group='child' then 'Child' 
 when isneonatal='1' or age_group='neonate' then 'Neonate' end as Age_group,
  case when isadult='1' then ageinyears when ischild='1' then ageinyears when isneonatal='1' then ageindays else ageinyears2 end as Age 
 from vadata_clean where instanceid='".$vaid."'";
		
		$dt =$this->con->query($vadata);
		//$array['cntloc']=$loc->rowCount();

		return $dt;
	}


	function InterViewersCOD($cod){
		$cod=pg_escape_string($cod);
		$vadata="SELECT distinct instanceid,t1.cause1 as COD, case when id10010='other' then id10010_other else id10010 end as interviwerName,id10017 as Firstname ,id10019 as Gender,id10057 as death_occur,id10058 as death_location, 
 case when isadult='1' or age_group='adult' then 'Adult' 
 when ischild='1' or age_group='child' then 'Child' 
 when isneonatal='1' or age_group='neonate' then 'Neonate' end as Age_group,
  case when isadult='1' then ageinyears when ischild='1' then ageinyears when isneonatal='1' then ageindays else ageinyears2 end as Age 
     FROM vacod t1 JOIN vadata_clean t2 ON t1.id = t2.instanceid 
     where t1.cause1='".$cod."'";
		
		$dt =$this->con->query($vadata);
		//$array['cntloc']=$loc->rowCount();

		return $dt;
	}

 Function saveToCsv($filename,$query){
 		 	$filename=pg_escape_string($filename);
 		 		$query=pg_escape_string($query);
	  //  $csv_filename=$filename;
	//$dir2="Downloads";
	//$dir="/storage/odk/forms/".$csv_filename;
	//if(file_exists("/storage/odk/forms/")){
	   //$file=fopen("C:/VADATA/Test.csv","w");
	    //echo getcwd();
	   //header("Content-Type: text/csv");
	  header("Content-Disposition: attachment; filename=".$filename."");
	 
	    $file=fopen("php://output","w");

		$res = $this->con->query($query);
		$res2 = $this->con->query($query);
		$cntCol = $res ->columnCount();
		$columns = array_keys($res->fetch(PDO::FETCH_ASSOC));
		$rows = $res2->fetchAll();

		for($i=0;$i<$cntCol;$i++){
			$colname[]=$columns[$i];
		}
		fputcsv($file,$colname);

	   // while ($c=mysqli_fetch_field($q)){
	    //    $colname[]=$c->name; 
	    //}
	   // fputcsv($file,$colname);

		foreach($rows as $row) {
			$dt=array("");
				for($i=0;$i<$cntCol;$i++){
					$dt[$i]=$row[$i];
				}			
			fputcsv($file,$dt);		 
		}
	    
	    fclose($file);
    }

function CheckUser($user){
      $user=pg_escape_string($user);
		$arr= array();
		$uq = "select username,usergroup,uid from public.users where username='".$user."'";
		$res = $this->con->query($uq);
		
		if(is_array($res) || is_object($res)){
			foreach($res as $row){
				
				array_push($arr,$row['username']);
				array_push($arr,$row['usergroup']);
				array_push($arr,$row['uid']);
			}
		}	

		return $arr;
	}

	function login($user,$pwd){
          $user=pg_escape_string($user);
            $pwd=pg_escape_string($pwd);
		$arr= array();
		$uq = "select username,usergroup,uid,password from public.users where username='".$user."'";
		
		$res = $this->con->query($uq);
		
		if(is_array($res) || is_object($res)){
			foreach($res as $row){
				if(password_verify($pwd, $row['password'])){
					array_push($arr,$row['username']);
					array_push($arr,$row['usergroup']);
					array_push($arr,$row['uid']);
				}		
			}
		}	

		return $arr;
	}
	public function InterviwerSummary($yr){
      $yr=pg_escape_string($yr);
		$q ="select distinct upper(case when id10010='other' then id10010_other else id10010 end) AS interviewer_name,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 1 THEN 1 ELSE 0 END ) as jan,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 2 THEN 1 ELSE 0 END ) as feb,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 3 THEN 1 ELSE 0 END ) as mar,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 4 THEN 1 ELSE 0 END ) as apr,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 5 THEN 1 ELSE 0 END ) as may,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 6 THEN 1 ELSE 0 END ) as jun,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 7 THEN 1 ELSE 0 END ) as jul,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 8 THEN 1 ELSE 0 END ) as aug,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 9 THEN 1 ELSE 0 END ) as sep,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 10 THEN 1 ELSE 0 END ) as oct,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 11 THEN 1 ELSE 0 END ) as nov,
		  SUM( CASE WHEN date_part('month'::text, submissiondate::date) = 12 THEN 1 ELSE 0 END ) as dec,
		  count(*) as tot,
		   date_part('year'::text, submissiondate::date) as interview_year
		  from vadata_clean  where  date_part('year'::text, submissiondate::date)='".$yr."'
		  group by upper(case when id10010='other' then id10010_other else id10010 end),  date_part('year'::text, submissiondate::date)";

		  $dt =$this->con->query($q);
		//$array['cntloc']=$loc->rowCount();
		return $dt;

	}

	public function InterviwerSummaryDate($from,$to){
		  $from=pg_escape_string($from);
		   $to=pg_escape_string($to);
		$q ="select distinct upper((case when id10010='other' then id10010_other else id10010 end)) AS interviewer_name,count(case when id10010='other' then id10010_other else id10010 end) submitted
		from vadata_clean  where cast(submissiondate as date)>= '".$from."' and cast(submissiondate as date)<='".$to."'
		group by case when id10010='other' then id10010_other else id10010 end";

		  $dt =$this->con->query($q);
		//$array['cntloc']=$loc->rowCount();
		return $dt;

	}


public function countGender(){
		$tot=0; 
		$arr= array();
		$arr2 = array();
		$sexq="select distinct id10019 as gender,count(id10019)counts  from vadata_clean group by id10019";
		$sex = $this->con->query($sexq);

		foreach($sex as $row){
			array_push($arr,$row['gender']);
			array_push($arr2,$row['counts']);
		}

		$tot1 = array_sum($arr2);

		$array['gender']= $arr;
		$array['counts']= $arr2;
		return $array;
	}
	
public function countPod(){
		$tot=0; 
		$arr= array();
		$arr2 = array();
		$sexq="select distinct id10058 as pod,count(id10058)counts  from vadata_clean group by id10058";
		$sex = $this->con->query($sexq);

		foreach($sex as $row){
			array_push($arr,$row['pod']);
			array_push($arr2,$row['counts']);
		}

		$tot1 = array_sum($arr2);

		$array['pod']= $arr;
		$array['counts']= $arr2;
		return $array;
	}

	public function countPodYear($yr){
		  $yr=pg_escape_string($yr);
		$tot=0; 
		$arr= array();
		$arr2 = array();
		$sexq="select distinct id10058 as pod,count(id10058)counts  from vadata_clean where date_part('year'::text, id10023::date)='".$yr."' group by id10058";
		$sex = $this->con->query($sexq);

		foreach($sex as $row){
			array_push($arr,$row['pod']);
			array_push($arr2,$row['counts']);
		}

		$tot1 = array_sum($arr2);

		$array['pod']= $arr;
		$array['counts']= $arr2;
		return $array;
	}

	public function errorCounts($yr){
		  $yr=pg_escape_string($yr);
		$tot=0; 
		$arr= array();
		$arr2 = array();
		$sexq="select distinct id10058 as pod,count(id10058)counts  from vadata_clean where date_part('year'::text, id10023::date)='".$yr."' group by id10058";
		$sex = $this->con->query($sexq);

		foreach($sex as $row){
			array_push($arr,$row['pod']);
			array_push($arr2,$row['counts']);
		}

		$tot1 = array_sum($arr2);

		$array['pod']= $arr;
		$array['counts']= $arr2;
		return $array;
	}


public function DynamicGaphOne($query){
		  $query=pg_escape_string($query);
		$tot=0; 
		$arr= array();
		$qs = $this->con->query($query);

		//foreach($qs as $row){
		//	array_push($arr,$row);
		//}

		return $qs;
	}
	

	public function countToday(){
		$arr = array();
		$yr = "select distinct count( *) as today from vadata_clean where cast(submissiondate as date)=current_date";
		$resyr = $this->con->query($yr);
		foreach($resyr as $row){
			$array['today'] = $row['today'];		
		}
		return $array;
	}

	public function countThisWeek(){
		$arr = array();
		$yr = "select distinct count(*)thisweek from vadata_clean where date_part('week'::text, submissiondate::date)=date_part('week'::text, current_date::date) and 
 date_part('year'::text, submissiondate::date)=date_part('year'::text, current_date::date)";
		$resyr = $this->con->query($yr);
		foreach($resyr as $row){
			$array['thisweek'] = $row['thisweek'];
		}
		return $array;
	}

	public function countThisMonth(){
		$arr = array();
		$yr = "select distinct count( *)thismonth from vadata_clean where date_part('month'::text, submissiondate::date)=date_part('month'::text, current_date::date) and 
 date_part('year'::text, submissiondate::date)=date_part('year'::text, current_date::date)";
		$resyr = $this->con->query($yr);
		foreach($resyr as $row){
			$array['thismonth'] = $row['thismonth'];
		}
		return $array;
	}


public function countThisYear(){
		$arr = array();
		$yr = "select distinct count( *)thisyear from vadata_clean where  date_part('year'::text, submissiondate::date)=date_part('year'::text, current_date::date) ";
		$resyr = $this->con->query($yr);
		foreach($resyr as $row){
			$array['thisyear'] = $row['thisyear'];
		}
		return $array;
	}

	
public function AllColumns(){
		
		$cols=array();
		$data = "SELECT distinct t1.id,t2.index,
    t1.cause1 ,
    t1.comcat,
    t1.insilico,
    t2.submissiondate,
    case when t2.id10010 ='other' then t2.id10010_other else id10010 end,
    t2.id10012,
	 t2.province,
    t2.province_other,
    t2.area,
    t2.other_area,
    t2.hospital,
    t2.other_hospital,
 t2.id10010_other,
    t2.id10011,
    t2.id10023,
	t2.id10017,
	t2.id10019,
	t2.id10057,
	t2.id10058,
    t2.ageindays,
	t2.ageinyears2,
    t2.ageinyears, 
    t2.ageinmonths,   
   t2.age_group,   
    t2.isneonatal,
    t2.ischild,
    t2.isadult,
    date_part('year'::text, t2.id10023::date) AS dodyear,
    date_part('month'::text, t2.id10023::date) AS dodmonth,
    date_part('year'::text, t2.submissiondate::date) AS year,
    date_part('month'::text, t2.submissiondate::date) AS month,
        CASE
            WHEN t2.ischild = '1'::text THEN 'Child'::text
            WHEN t2.isadult = '1'::text THEN 'Adult'::text
            WHEN t2.isneonatal = '1'::text THEN 'Neonate'::text
            ELSE NULL::text
        END AS agegroup
   FROM vacod t1
     JOIN vadata_clean t2 ON t1.id = t2.instanceid order by t2.index";
		//pg_fetch_all_columns($data);
		$res = $this->con->query($data);
		
        $fields = array_keys($res->fetch(PDO::FETCH_ASSOC));
        //var_dump($fields);
        
	  return $fields;
		
	}
	public function MontlyReport(){
		$month = 1; $mtotal=0;
		$mdata=array();
		$arr = array_fill(0,12,0);
		$mnths = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		//$data = "select month,counts from monthlyReportCnt where year='".date('Y')."'";
		$data = "select month,sum(counts)counts from monthlyReportCnt group by month";
		
		$res = $this->con->query($data);

		if(is_array($res) || is_object($res)){
			foreach ($res as $v){
				$month = $v['month']; $mtotal = $v['counts'];
				//echo " [".$month." -".$mtotal."]";
				$arr[$month-1]=$mtotal;		
			}
			//var_dump($arr);
		}
		
		for($i=0;$i<=11;$i++){
			$mdata[$mnths[$i]]=$arr[$i];
		}
		
		$array['months'] = $mnths;
		$array['counts'] = $arr;
		
		return $array;
		
	}

public function MontlyReportSex($yr){
		  $yr=pg_escape_string($yr);
		$mtot=0;
		$ftot=0;

		$month = 1; $mtotal=0; $ftotal=0; $mnthcnt=0;
		$mdata=array();
		$marr = array_fill(0,12,0);
		$fdata=array();
		$farr = array_fill(0,12,0);
		//var_dump($arr);
		$mnths = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		#$data = "select month,counts from monthlyReportCnt where year='".$yr."'";
		
		$males = "select dodmonth,sum(counts)counts from monthlyReportGA WHERE id10019='male' 
		and dodyear='".$yr."' group by dodmonth";

		$females = "select dodmonth,sum(counts)counts from monthlyReportGA WHERE id10019='female' 
		and dodyear='".$yr."' group by dodmonth";
		
		//MALES DATA
		$res = $this->con->query($males);
		if(is_array($res) || is_object($res)){
			foreach ($res as $v){
				$month = $v['dodmonth']; $mnthcnt = $v['counts'];
				$marr[$month-1]=$mnthcnt;		
			}
		}
		$mtot = array_sum($marr);

		//FEMALES DATA
		$res2 = $this->con->query($females);
		if(is_array($res2) || is_object($res2)){
			foreach ($res2 as $v){
				$month = $v['dodmonth']; $mnthcnt = $v['counts'];
				$farr[$month-1]=$mnthcnt;		
			}
		}
		$ftot = array_sum($farr);

		$array['months'] = $mnths;
		$array['mcounts'] = $marr;
		$array['fcounts'] = $farr;		
		return $array;
		
	}

public function MontlyReportByagegroup($yr){
	  $yr=pg_escape_string($yr);
		$arr= array();
		$arra = array_fill(0,12,0);
		$arrc = array_fill(0,12,0);
		$arrn = array_fill(0,12,0);
		$mnths = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

		$atot=0;
		$ctot=0;
		$ntot=0;

		$adult = "select dodmonth,sum(counts)counts from monthlyReportGA 
		WHERE lower(agegroup)='adult' 
		and dodyear='".$yr."' group by dodmonth";

		$child = "select dodmonth,sum(counts)counts from monthlyReportGA 
		WHERE lower(agegroup)='child' 
		and dodyear='".$yr."' group by dodmonth";

		$neon = "select dodmonth,sum(counts)counts from monthlyReportGA 
		WHERE lower(agegroup)='neonate' 
		and dodyear='".$yr."' group by dodmonth";
		
		//echo $adult;
			//ADULT DATA
		$res = $this->con->query($adult);
		if(is_array($res) || is_object($res)){
			foreach ($res as $v){
				$month = $v['dodmonth']; $mnthcnt = $v['counts'];
				$arra[$month-1]=$mnthcnt;		
			}
		}
		$atot = array_sum($arra);
		//var_dump($arra);

		//CHILD DATA
		$res2 = $this->con->query($child);
		if(is_array($res2) || is_object($res2)){
			foreach ($res2 as $v){
				$month = $v['dodmonth']; $mnthcnt = $v['counts'];
				$arrc[$month-1]=$mnthcnt;		
			}
		}
		$ctot = array_sum($arrc);

		//CHILD DATA
		$res3 = $this->con->query($neon);
		if(is_array($res3) || is_object($res3)){
			foreach ($res3 as $v){
				$month = $v['dodmonth']; $mnthcnt = $v['counts'];
				$arrn[$month-1]=$mnthcnt;		
			}
		}
		$ntot = array_sum($arrn);

		$array['months'] = $mnths;
		$array['adult'] = $arra;
		$array['child'] = $arrc;
		$array['neonate'] = $arrn;		

		return $array;
		
	}

	public function MontlyReportYear($yr){
		  $yr=pg_escape_string($yr);
		$month = 1; $mtotal=0;
		$mdata=array();
		$arr = array_fill(0,12,0);
		$mnths = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		//$data = "select month,counts from monthlyReportCnt where year='".date('Y')."'";
		$data = "select dodmonth,sum(counts)counts from monthlyReportGA where dodyear='".$yr."' group by dodmonth";
		//echo $data;
		$res = $this->con->query($data);

		if(is_array($res) || is_object($res)){
			foreach ($res as $v){
				$month = $v['dodmonth']; $mtotal = $v['counts'];
				//echo " [".$month." -".$mtotal."]";
				$arr[$month-1]=$mtotal;		
			}
			//var_dump($arr);
		}
		
		for($i=0;$i<=11;$i++){
			$mdata[$mnths[$i]]=$arr[$i];
		}
		
		$array['months'] = $mnths;
		$array['counts'] = $arr;

		return $array;
		
	}

	

	public function csmfInterVA($year){
		  $year=pg_escape_string($year);
		$arr= array();
		$arr2= array();
		//$ar3= array();
		//$arr2= array();
		$tot = 0;
		if($year=="All"){
			$data = "select * from(
			select interva5,sum(counts)counts from csmfint5sex group by interva5 order by sum(counts) desc limit 20)t1 order by counts asc";
		}else{
			$data = "select * from(
			select dodyear,interva5,sum(counts)counts from csmfint5sex where dodyear='".$year."'
			 group by interva5,dodyear order by sum(counts) desc limit 20)t2 
			 order by counts asc";
		}
		//echo $data;
		$res = $this->con->query($data);

		foreach($res as $row){
			array_push($arr,$row['interva5']);
			array_push($arr2,$row['counts']);
			//array_push($arr3,$row['counts']);
		}
		$tot = array_sum($arr2);

		for($i=0;$i<sizeof($arr2);$i++) {
			$arr2[$i] = round(($arr2[$i]/$tot)*100,2);
		}

		$array['interva5'] = $arr;
		$array['cnt'] = $arr2;
		$array['total'] = $tot;
		
		//var_dump($array);
		return $array;
	}

	public function Undetermined($year){
		  $year=pg_escape_string($year);

		$arr= array();
		$arr2= array();

		$tot = 0;
		if($year=="All"){
			$data = "select * from undetermined order by counts desc";
		}else{
			$data = "select * from undetermined where dodyear='".$year."' order by counts desc";
		}
		//echo $data;
		$res = $this->con->query($data);

		foreach($res as $row){
			array_push($arr,$row['id10010']);
			array_push($arr2,$row['counts']);
			//array_push($arr3,$row['counts']);
		}
		$tot = array_sum($arr2);

		$array['interviewer'] = $arr;
		$array['counts'] = $arr2;
		$array['total'] = $tot;
		
		//var_dump($array);
		return $array;
	}

	
	public function csmfInsilico($year){
		  $year=pg_escape_string($year);
		$arr= array();
		$arr2= array();
		$tot=0;
		
		if($year=="All"){
			$data = "select * from (
			select insilico,sum(counts)counts from csmfInsSex group by insilico order by sum(counts) desc limit 20)t1 order by counts asc ";
		}else{
			$data = "select * from(
			select dodyear,insilico,sum(counts)counts from csmfInsSex where dodyear='".$year."'
			 group by insilico,dodyear order by sum(counts) desc limit 20)t2 order by counts asc
			 ";
		}

		$res = $this->con->query($data);

		foreach($res as $row){
			array_push($arr,$row['insilico']);
			array_push($arr2,$row['counts']);
		}
		$tot = array_sum($arr2);

		for($i=0;$i<sizeof($arr2);$i++) {
			$arr2[$i] = round(($arr2[$i]/$tot)*100,2);
		}
		
		$array['insilico'] = $arr;
		$array['cnt'] = $arr2;
		$array['total'] = $tot;

		return $array;
	}

	
	public function countForms(){
		$adult=0;$child=0;$neonate=0; $totalforms=0;
		$vaforms="select count(case when isadult='1' or age_group='adult' then '1' end)adult,
							count(case when ischild='1' or age_group='child' then '1' end)child,
							count(case when isneonatal='1' or age_group='neonate' then '1' end)neonate ,
							count(case when isneonatal='0' and ischild='0' and isadult='0' then '1' end)nodata,
							count(*)vacnt
							from vadata_clean ";
		$vaformsq = $this->con->query($vaforms);

		foreach($vaformsq as $row){
			$array['adult'] = $row['adult'];
			$array['child'] = $row['child'];
			$array['neonate'] = $row['neonate'];
			$array['vacnt'] = $row['vacnt'];
			$array['nodata'] = $row['nodata'];
		}

		return $array;
	}

	public function countFormsYear($yr){
		  $yr=pg_escape_string($yr);
		$adult=0;$child=0;$neonate=0; $totalforms=0;
		
			$vaforms="select count(case when isadult='1' or age_group='adult' then '1' end)adult,
							count(case when ischild='1' or age_group='child' then '1' end)child,
							count(case when isneonatal='1' or age_group='neonate' then '1' end)neonate ,
							count(case when isneonatal='0' and ischild='0' and isadult='0' then '1' end)nodata,
							count(*)vacnt
							from vadata_clean where date_part('year'::text, submissiondate::date)='".$yr."'";
		
		//echo $vaforms;
		$vaformsq = $this->con->query($vaforms);

		foreach($vaformsq as $row){
			$array['adult'] = $row['adult'];
			$array['child'] = $row['child'];
			$array['neonate'] = $row['neonate'];
			$array['vacnt'] = $row['vacnt'];
			$array['nodata'] = $row['nodata'];
		}

		return $array;
	}

	
	
	public function csmfYear(){
		$arrcu = array();

		$yr = "select DISTINCT  date_part('year'::text, id10023::date) as year from vadata_clean 
 order by  date_part('year'::text, id10023::date) desc";
		$resyr = $this->con->query($yr);

		foreach($resyr as $row){
			array_push($arrcu,$row['year']);
		}
		$array['year'] = $arrcu;

		return $array;
	}

	public function COD(){
		$arrcu = array();

		$yr = "select distinct cause1 as interva5 from vacod";
		$resyr = $this->con->query($yr);

		foreach($resyr as $row){
			array_push($arrcu,$row['interva5']);
		}
		$array['interva5'] = $arrcu;

		return $array;
	}

	public function VASubmissionYear(){
		$arrcu = array();

		$yr = "select DISTINCT date_part('year'::text, submissiondate::date)as year from vadata_clean 
		order by date_part('year'::text, submissiondate::date) desc";
		$resyr = $this->con->query($yr);

		foreach($resyr as $row){
			array_push($arrcu,$row['year']);
		}
		$array['year'] = $arrcu;

		return $array;
	}


	public function SubmissionYear(){
		$arrcu = array();

		$cu = "select DISTINCT date_part('year'::text, submissiondate::date) as year from vadata_clean order by date_part('year'::text, submissiondate::date) desc";
		$rescu = $this->con->query($cu);

		foreach($rescu as $row){
			array_push($arrcu,$row['year']);
		}
		$array['year'] = $arrcu;

		return $array;
	}

	




	public function interva5CODBySex($year){
		  $year=pg_escape_string($year);
		$arr= array();
		$arr2 = array();
		$arr3 = array();
		$arr4 = array();
		$tot1=0;
		$tot2=0;
		if($year=="All"){
			$mdata = "select * from (select interva5,sum(counts)counts ,id10019 as sex
			from csmfint5sex WHERE id10019='male' 
			group by interva5,id10019 order by sum(counts)
			desc limit 20)t1 order by counts asc";

			$fdata = "select * from (select interva5,sum(counts)counts ,id10019 as sex
			from csmfint5sex WHERE id10019='female' 
			group by interva5,id10019 order by sum(counts)
			desc limit 20)t1 order by counts asc";

		}else{
			$mdata = "select * from (select interva5,sum(counts)counts ,id10019 as sex
			from csmfint5sex WHERE id10019='male' and dodyear='".$year."'
			group by interva5,id10019 order by sum(counts)
			desc limit 20)t1 order by counts asc";

			$fdata = "select * from (select interva5,sum(counts)counts ,id10019 as sex
			from csmfint5sex WHERE id10019='female' and dodyear='".$year."'
			group by interva5,id10019 order by sum(counts)
			desc limit 20)t1 order by counts asc";
		}
		
		$res = $this->con->query($mdata);

		foreach($res as $row){
			array_push($arr,$row['interva5']);
			array_push($arr2,$row['counts']);
		}

		$tot1 = array_sum($arr2);
		for($i=0;$i<sizeof($arr2);$i++) {
			$arr2[$i] = round(($arr2[$i]/$tot1)*100,2);
		}

		
		$res2 = $this->con->query($fdata);

		foreach($res2 as $row){
			array_push($arr3,$row['interva5']);
			array_push($arr4,$row['counts']);
		}
		$tot2 = array_sum($arr4);
		for($i=0;$i<sizeof($arr4);$i++) {
			$arr4[$i] = round(($arr4[$i]/$tot2)*100,2);
		}

		$array['mcod'] = $arr;
		$array['males'] = $arr2;
		$array['fcod'] = $arr3;
		$array['females'] = $arr4;

		return $array;
	}

	public function interva5CODByagegroup($year){
		$year=pg_escape_string($year);
		$arr= array();
		$arr2 = array();
		$arr3 = array();
		$arr4 = array();
		$arr5 = array();
		$arr6 = array();

		$tot1=0;
		$tot2=0;
		$tot3=0;
		if($year=="All"){
			$adult = "select * from (select interva5,sum(counts)counts ,agegroup
			from csmfint5agegroup WHERE lower(agegroup)='adult' 
			group by interva5,agegroup order by sum(counts)
			desc limit 20)t1 order by counts asc";

			$child = "select * from (select interva5,sum(counts)counts ,agegroup
			from csmfint5agegroup WHERE lower(agegroup)='child' 
			group by interva5,agegroup order by sum(counts)
			desc limit 20)t1 order by counts asc";

			$neon = "select * from (select interva5,sum(counts)counts ,agegroup
			from csmfint5agegroup WHERE lower(agegroup)='neonate' 
			group by interva5,agegroup order by sum(counts)
			desc limit 20)t1 order by counts asc";

		}else{
			$adult = "select * from (select interva5,sum(counts)counts ,agegroup
			from csmfint5agegroup WHERE lower(agegroup)='adult'   
			and dodyear='".$year."'
			group by interva5,agegroup order by sum(counts)
			desc limit 20)t1 order by counts asc";

			$child = "select * from (select interva5,sum(counts)counts ,agegroup
			from csmfint5agegroup WHERE lower(agegroup)='child' 
			and dodyear='".$year."'
			group by interva5,agegroup order by sum(counts)
			desc limit 20)t1 order by counts asc";

			$neon = "select * from (select interva5,sum(counts)counts ,agegroup
			from csmfint5agegroup WHERE lower(agegroup)='neonate' 
			 and dodyear='".$year."'
			group by interva5,agegroup order by sum(counts)
			desc limit 20)t1 order by counts asc";
		}
		
		//echo $adult;
		$ares = $this->con->query($adult);
		//var_dump($ares);
		foreach($ares as $row){
			array_push($arr,$row['interva5']);
			array_push($arr2,$row['counts']);
		}
		

		$tot1 = array_sum($arr2);
		for($i=0;$i<sizeof($arr2);$i++) {
			$arr2[$i] = round(($arr2[$i]/$tot1)*100,2);
		}

		
		$cres = $this->con->query($child);
		foreach($cres as $row){
			array_push($arr3,$row['interva5']);
			array_push($arr4,$row['counts']);
		}
		$tot2 = array_sum($arr4);
		for($i=0;$i<sizeof($arr4);$i++) {
			$arr4[$i] = round(($arr4[$i]/$tot2)*100,2);
		}

		$nres = $this->con->query($neon);
		foreach($nres as $row){
			array_push($arr5,$row['interva5']);
			array_push($arr6,$row['counts']);
		}
		$tot3 = array_sum($arr6);
		for($i=0;$i<sizeof($arr6);$i++) {
			$arr6[$i] = round(($arr6[$i]/$tot3)*100,2);
		}

		$array['adultcod'] = $arr;
		$array['adult'] = $arr2;
		$array['childcod'] = $arr3;
		$array['child'] = $arr4;
		$array['neoncod'] = $arr5;
		$array['neonate'] = $arr6;

		return $array;
	}



	public function AllTables(){
		
		$tbls=array();
		$data = "select table_name from information_schema.tables where table_schema='public'
		and table_name not in ('vadata','users','vadata_clean','smartva_clean','smartva_field',
		'smartva_temp','smartva_transition','vadata_temp','vadata_transition','vadata_all',
			'vadata_field','tempcod') ";
		//pg_fetch_all_columns($data);
		$res = $this->con->query($data);
		foreach($res as $row){
			array_push($tbls,$row['table_name']);
		}
		$array['table_name'] = $tbls;

        //var_dump($fields);
        
	  return $array;
		
	}

	public function saveProvince($province){
		$province=pg_escape_string($province);
		$ret=0;
		echo $province;
		  $q = "insert into province(province) values('".$province."')";
		  $res = $this->con->execute($q);
		  if($res){
		  	$ret=1;
		  }else{
		  	$ret = 0;
		  }

		  return $ret;
	}

    public function GeoList($type){
    	$type=pg_escape_string($type);
		$arr= array();
		$arr2 = array();
	
		if($type==1){
			##province
			$data = "select distinct tid,province as geoname from province";
		
		}elseif ($type==2) {
			# district
			$data = "select distinct tid,district as geoname from districts";

		}else{
			#facilities
			$data = "select distinct tid,facility geoname from facilities";
		}
		
		//echo $data;
		$res = $this->con->query($data);
		foreach($res as $row){
			$arr[$row['tid']]=$row['geoname'];
			//array_push($arr,$row['geoname']);
			//array_push($arr2,$row['tid']);
		}

		//$array['geoname'] = $arr;
		//$array['tid'] = $arr2;
        //var_dump($array);
        
	  return $arr;
		
	}



	public function InterviwerList($type){
		$type=pg_escape_string($type);
		$arr= array();
		$arr2 = array();
	
		if($type==1){
			##populate dirty columns
			$data = "select distinct id10010 as intname,count(*)counts from public.vadata_clean where id10010 not in 
		(select id10010 from geo where id10010 is not null) and position('_' in id10010)<1
		group by id10010 order by counts";
		
		}elseif ($type==2) {
			# populate clean names
			$data = "select distinct id10010 as intname,count(*)counts from public.vadata_clean where id10010 not in 
		(select id10010 from geo where id10010 is not null) and position('_' in id10010)>0
		group by id10010 order by counts";

		}elseif($type==3){
			##populate dirty columns
			$data = "select distinct id10010 as intname,count(id10010)counts from public.geo
			group by id10010 order by counts";
		
		}else{
			#populate geo mapping names
			$data = "select distinct interviewer as intname,count(*)counts from public.geo where id10010 is null 
		group by interviewer order by counts";
		}
		
		//echo $data;
		$res = $this->con->query($data);
		foreach($res as $row){
			array_push($arr,$row['intname']);
			array_push($arr2,$row['counts']);
		}

		$array['intname'] = $arr;
		$array['counts'] = $arr2;
        //var_dump($array);
        
	  return $array;
		
	}


public function AnytableCols($query){
	$query=pg_escape_string($query);
		$arr= array();
		$res = $this->con->query($query);
		$data = $res->fetchAll(PDO::FETCH_ASSOC);
		
		foreach($res as $row){
			array_push($arr,$row);
		}

		return $data;
	}


public function AnytableData($query){
	$query=pg_escape_string($query);
		$arr= array();
		$res = $this->con->query($query);
		
		return $res;
	}


function VADataWHO($vid){
	$vid=pg_escape_string($vid);
		//$vadata="SELECT * from vadata_all where ID='".$vid."' ";
		$vadata="select distinct t1.id,t1.cause1 AS interva5,t1.comcat, t1.insilico,t2.*
			FROM vacod t1 JOIN vadata_clean t2 ON t1.id = t2.instanceid where ID='".$vid."' ";
		$dt =$this->con->query($vadata);
		$data = $dt->fetchAll(PDO::FETCH_ASSOC);
		
		$json = preg_replace('/,\s*"[^"]+":null|"[^"]+":null,?/', '', json_encode($data));
		//var_dump($json);

		return $json;
	}


	function createMappingArray(){
		$array = array("locator_filenum" =>"Enter the file number of the notification form",
"consent_filenum" =>"Enter again the file number of the notification form to confirm",
"interva5" =>"InterVA5",
"insilico"=>"insilico",
"id10002" =>"(id10002) [Is this a region of high HIV/AidS mortality?]",
"id10003" =>"(id10003) [Is this a region of high malaria mortality?]",
"id10004" =>"(id10004) [During which season did (s)he die?]",
"id10007" =>"(id10007) [What is the name of VA respondent?]",
"id10008" =>"(id10008) What is your/the respondents relationship to the deceased?",
"id10009" =>"(id10009) Did you/the respondent live with the deceased in the period leading to her/his death?",
"id10010" =>"(id10010) [Name of VA interviewer]",
"id10012" =>"(id10012) Date of interview",
"id10013" =>"(id10013) [Did the respondent give consent?]",
"id10011" =>"Start of interview",
"id10017" =>"(id10017) What was the first or given name(s) of the deceased?",
"id10018" =>"(id10018) What was the surname (or family name) of the deceased?",
"id10019" =>"(id10019) What was the sex of the deceased?",
"id10020" =>"(id10020) Is the date of birth known?",
"id10021" =>"(id10021) When was the deceased born?",
"id10022" =>"(id10022) Is the date of death known?",
"id10023_a" =>"(id10023_a) When did (s)he die?",
"id10023_b" =>"(id10023_b) When did (s)he die?",
"id10023" =>"(id10023) When did (s)he die?",
"id10024" =>"(id10024) Please indicate the year of death.",
"ageindays" =>"Age In  Days",
"ageindays2" =>"Age In  Days",
"ageinyears" =>"Age In  Years",
"ageinyears2" =>"Age In  Years",
"age_group" =>"[What age group corresponds to the deceased?] ",
"age_neonate_days" =>"How many days old was the baby? [Enter neonates age in days:]",
"age_in_days_neonate"=>"How many days old was the baby?",
"age_in_months" => "Age in Months",
"instanceid" => "ID",
"age_in_months_by_year" =>"Age in Months by year",
"age_in_months_remain" =>"age in months Remaining",
"age_child_unit" =>"How old was the child? [Enter childs age in:]",
"age_child_days" =>"[Enter childs age in days:]",
"age_child_months" =>"[Enter childs age in months:]",
"age_child_years" =>"[Enter childs age in years:]",
"age_adult" =>"[Enter adults age in years:]",
"isneonatal" =>"isNeonatal",
"ischild" =>"isChild",
"isadult" =>"isAdult",
"id10058" =>"(id10058) Where did the deceased die? ",
"id10051" =>"(id10051) [Is there a need to collect additional demographic data on the deceased?]",
"id10052_a" =>"(id10052_a)What was her/his citizenship/nationality?",
"id10052_b" =>"(id10052_b)Specify Nationality",
"id10052" =>"(id10052)Nationality",
"id10053" =>"(id10053) What was her/his ethnicity?",
"id10054" =>"(id10054) What was her/his place of birth?",
"id10055_a" =>"(id10055_a)Is the place of usual residence same as the place of birth?",
"id10055_b" =>"(id10055_b)What was her/his place of usual residence? (the place where the person lived most of the year) (village)",
"id10055" =>"(id10055)Village of usual residence",
"id10057_a" =>"(id10057_a)Is the place of death same as place of usual residence?",
"id10057_b" =>"(id10057_b)Where did the death occur? (Village)",
"id10057" =>"(id10057)Place of death",
"id10059" =>"(id10059) What was her/his marital status?",
"id10060_check" =>"(id10060_check) [Is the date of marriage available?]",
"id10060" =>"(id10060) What was the date of marriage?",
"id10061" =>"(id10061) What was the name of the father?",
"id10062" =>"(id10062) What was the name of the mother?",
"id10063" =>"(id10063) What was her/his highest level of schooling?",
"id10064" =>"(id10064) Was (s)he able to read and/or write?",
"id10065" =>"(id10065) What was her/his economic activity status in year prior to death?",
"id10066" =>"(id10066) What was her/his occupation, that is, what kind of work did (s)he mainly do?",
"id10069" =>"(id10069) [Is there a need to collect civil registration numbers on the deceased?]",
"id10069_a" =>"(id10069_a) Do you have a death registration certificate?",
"id10070_a" =>"(id10070_a)Form Type",
"id10070" =>"(id10070)[Death registration number/certificate]",
"id10071_check" =>"(id10071_check) [Is the date of registration available?]",
"id10071" =>"(id10071) [Date of registration]",
"id10071_raw" =>"(id10071) [Date of registration]",
"id10072_a" =>"(id10072_a)[Place of registration] (county)",
"id10072_b" =>"(id10072_b)[Place of registration] (sub county)",
"id10072" =>"(id10072)[Place of registration]",
"id10073" =>"(id10073) [National identification number of deceased]",
"id10476" =>"(id10476) Thank you for your information. Now can you please tell me in your own words about the events that led to the death?",
"id10477" =>"(id10477) [Select any of the following words that were mentioned as present in the narrative.]",
"id10478" =>"(id10478) [Select any of the following words that were mentioned as present in the narrative.]",
"id10479" =>"(id10479) [Select any of the following words that were mentioned as present in the narrative.]",
"id10476_image" =>"Please take a picture of the Narrative you have written. Try to take a clear and readable picture.",
"id10104" =>"(id10104) Did the baby ever cry?",
"id10105" =>"(id10105) Did the baby cry immediately after birth, even if only a little bit?",
"id10106" =>"(id10106) How many minutes after birth did the baby first cry?",
"id10107" =>"(id10107) Did the baby stop being able to cry?",
"id10108" =>"(id10108) How many hours before death did the baby stop crying?",
"id10109" =>"(id10109) Did the baby ever move?",
"id10110" =>"(id10110) Did the baby ever breathe?",
"id10111" =>"(id10111) Did the baby breathe immediately after birth, even a little?",
"id10112" =>"(id10112) Did the baby have a breathing problem?",
"id10113" =>"(id10113) Was the baby given assistance to breathe at birth?",
"id10114" =>"(id10114) If the baby didn't show any sign of life, was it born dead?",
"id10115" =>"(id10115) Were there any bruises or signs of injury on babys body after the birth?",
"id10116" =>"(id10116) Was the babys body soft, pulpy and discoloured and the skin peeling away?",
"id10077" =>"(id10077) Did (s)he suffer from any injury or accident that led to her/his death?",
"id10079" =>"(id10079) Was it a road traffic accident?",
"id10080" =>"(id10080) What was her/his role in the road traffic accident?",
"id10081" =>"(id10081) What was the counterpart that was hit during the road traffic accident?",
"id10082" =>"(id10082) Was (s)he injured in a non-road transport accident?",
"id10083" =>"(id10083) Was (s)he injured in a fall?",
"id10084" =>"(id10084) Was there any poisoning?",
"id10085" =>"(id10085) Did (s)he die of drowning?",
"id10086" =>"(id10086) Was (s)he injured by a bite or sting by venomous animal?",
"id10087" =>"(id10087) Was (s)he injured by an animal or insect (non-venomous)?",
"id10088" =>"(id10088) What was the animal/insect?",
"id10089" =>"(id10089) Was (s)he injured by burns/fire?",
"id10090" =>"(id10090) Was (s)he subject to violence (suicide, homicide, abuse)?",
"id10091" =>"(id10091) Was (s)he injured by a firearm?",
"id10092" =>"(id10092) Was (s)he stabbed, cut or pierced?",
"id10093" =>"(id10093) Was (s)he strangled?",
"id10094" =>"(id10094) Was (s)he injured by a blunt force?",
"id10095" =>"(id10095) Was (s)he injured by a force of nature?",
"id10096" =>"(id10096) Was it electrocution?",
"id10097" =>"(id10097) Did (s)he encounter any other injury?",
"id10098" =>"(id10098) Was the injury accidental?",
"id10099" =>"(id10099) Was the injury self-inflicted?",
"id10100" =>"(id10100) Was the injury intentionally inflicted by someone else?",
"id10351" =>"(id10351) How many days old was the baby when the fatal illness started?",
"id10408" =>"(id10408) Before the illness that led to death, was the baby/the child growing normally?",
"id10120_0" =>"(id10120_0) For how many days was (s)he ill before death? ",
"id10120_unit" =>"(id10120_unit) For how long was (s)he ill before death?",
"id10121" =>"(id10121) Months",
"id10122" =>"(id10122) Years",
"id10120_1" =>"(id10120_1) Days",
"id10120" =>"(id10120) Calculated number of Days with illness",
"id10123" =>"(id10123) Did (s)he die suddenly?",
"id10125" =>"(id10125) Was there any diagnosis by a health professional of tuberculosis?",
"id10126" =>"(id10126) Was an HIV test ever positive?",
"id10127" =>"(id10127) Was there any diagnosis by a health professional of AidS?",
"id10128" =>"(id10128) Did (s)he have a recent positive test by a health professional for malaria?",
"id10129" =>"(id10129) Did (s)he have a recent negative test by a health professional for malaria?",
"id10130" =>"(id10130) Was there any diagnosis by a health professional of dengue fever?",
"id10131" =>"(id10131) Was there any diagnosis by a health professional of measles?",
"id10132" =>"(id10132) Was there any diagnosis by a health professional of high blood pressure?",
"id10133" =>"(id10133) Was there any diagnosis by a health professional of heart disease?",
"id10134" =>"(id10134) Was there any diagnosis by a health professional of diabetes?",
"id10135" =>"(id10135) Was there any diagnosis by a health professional of asthma?",
"id10136" =>"(id10136) Was there any diagnosis by a health professional of epilepsy?",
"id10137" =>"(id10137) Was there any diagnosis by a health professional of cancer?",
"id10138" =>"(id10138) Was there any diagnosis by a health professional of Chronic Obstructive Pulmonary Disease (COPD)?",
"id10139" =>"(id10139) Was there any diagnosis by a health professional of dementia?",
"id10140" =>"(id10140) Was there any diagnosis by a health professional of depression?",
"id10141" =>"(id10141) Was there any diagnosis by a health professional of stroke?",
"id10142" =>"(id10142) Was there any diagnosis by a health professional of sickle cell disease?",
"id10143" =>"(id10143) Was there any diagnosis by a health professional of kidney disease?",
"id10144" =>"(id10144) Was there any diagnosis by a health professional of liver disease?",
"id10147" =>"(id10147) Did (s)he have a fever?",
"id10148_a" =>"(id10148_a) How many days did the fever last?",
"id10148_units" =>"(id10148_units) How long did the fever last?",
"id10148_b" =>"(id10148_b) [Enter how long the fever lasted in days]:",
"id10148_c" =>"(id10148_c) [Enter how long the fever lasted in months]:",
"id10148" =>"(id10148) How many days did the fever last?",
"id10149" =>"(id10149) Did the fever continue until death?",
"id10150" =>"(id10150) How severe was the fever?",
"id10151" =>"(id10151) What was the pattern of the fever?",
"id10152" =>"(id10152) Did (s)he have night sweats?",
"id10153" =>"(id10153) Did (s)he have a cough?",
"id10154_units" =>"(id10154_units) For how long did (s)he have a cough?",
"id10154_a" =>"(id10154_a) [Enter how long (s)he had a cough in days]:",
"id10154_b" =>"(id10154_b) [Enter how long (s)he had a cough in months]:",
"id10154" =>"(id10154) For how many days did (s)he have a cough?",
"id10155" =>"(id10155) Was the cough productive, with sputum?",
"id10156" =>"(id10156) Was the cough very severe?",
"id10157" =>"(id10157) Did (s)he cough up blood?",
"id10158" =>"(id10158) Did (s)he make a whooping sound when coughing?",
"id10159" =>"(id10159) Did (s)he have any difficulty breathing?",
"id10161_0" =>"(id10161_0) For how many days did the difficulty breathing last?",
"id10161_unit" =>"(id10161_unit)  For how long did the difficult breathing last?",
"id10161_1" =>"(id10161_1) [Enter how long the difficult breathing lasted in days]:",
"id10162" =>"(id10162) [Enter how long the difficult breathing lasted in months]:",
"id10163" =>"(id10163) [Enter how long the difficult breathing lasted in years]:",
"id10161" =>"(id10161) Calculated number of Days with illness",
"id10165" =>"(id10165) Was the difficulty continuous or on and off?",
"id10166" =>"(id10166) During the illness that led to death, did (s)he have fast breathing?",
"id10167_a" =>"(id10167_a) For how many days did the fast breathing last?",
"id10167_units" =>"(id10167_units) How long did the fast breathing last?",
"id10167_b" =>"(id10167_b) [Enter how long the fast breathing lasted in days]:",
"id10167_c" =>"(id10167_c) [Enter how long the fast breathing lasted in months]:",
"id10167" =>"(id10167) How long did the fast breathing last?",
"id10168" =>"(id10168) Did (s)he have breathlessness?",
"id10169_a" =>"(id10169_a) For how many days did (s)he have breathlessness?",
"id10169_units" =>"(id10169_units) How long did (s)he have breathlessness?",
"id10169_b" =>"(id10169_b) [Enter how long (s)he had breathlessness in days]:",
"id10169_c" =>"(id10169_c) [Enter how long (s)he had breathlessness in months]:",
"id10169" =>"(id10169) How long did (s)he have breathlessness?",
"id10170" =>"(id10170) Was (s)he unable to carry out daily routines due to breathlessness?",
"id10171" =>"(id10171) Was (s)he breathless while lying flat?",
"id10172" =>"(id10172) Did you see the lower chest wall/ribs being pulled in as the child breathed in?",
"id10173_nc" =>"(id10173_nc) During the illness that led to death did his/her breathing sound like any of the following:",
"id10173_a" =>"(id10173_a) During the illness that led to death did (s)he have wheezing?",
"id10173" =>"(id10173) During the illness that led to death did his/her breathing sound like any of the following:",
"id10174" =>"(id10174) Did (s)he have chest pain?",
"id10175" =>"(id10175) Was the chest pain severe?",
"id10176" =>"(id10176) How many days before death did (s)he have chest pain?",
"id10178_unit" =>"(id10178_unit) How long did the chest pain last? ",
"id10178" =>"(id10178) [Enter how long the chest pain lasted in minutes]:",
"id10179" =>"(id10179) [Enter how long the chest pain lasted in hours]:",
"id10179_1" =>"(id10179_1) [Enter how long the chest pain lasted in days]:",
"id10181" =>"(id10181) Did (s)he have more frequent loose or liquid stools than usual?",
"id10182_units" =>"(id10182_units) How long did (s)he have frequent loose or liquid stools?",
"id10182_a" =>"(id10182_a) [Enter how long (s)he had frequent loose or liquid stools in days]:",
"id10182_b" =>"(id10182_b) [Enter how long (s)he had frequent loose or liquid stools in months]:",
"id10182" =>"(id10182) For how many days did (s)he have frequent loose or liquid stools?",
"id10183" =>"(id10183) How many stools did the baby or child have on the day that loose liquid stools were most frequent?",
"id10184_a" =>"(id10184_a) How many days before death did the frequent loose or liquid stools start?",
"id10184_units" =>"(id10184_units) How long before death did the frequent loose or liquid stools start?",
"id10184_b" =>"(id10184_b) [Enter how long before death the frequent loose or liquid stools started in days]:",
"id10184_c" =>"(id10184_c) [Enter how long before death the frequent loose or liquid stools started in months]:",
"id10185" =>"(id10185) Did the frequent loose or liquid stools continue until death?",
"id10186" =>"(id10186) At any time during the final illness was there blood in the stools?",
"id10187" =>"(id10187) Was there blood in the stool up until death?",
"id10188" =>"(id10188) Did (s)he vomit?",
"id10189" =>"(id10189) To clarify: Did (s)he vomit in the week preceding the death?",
"id10190_units" =>"(id10190_units) How long before death did (s)he vomit?",
"id10190_a" =>"(id10190_a) [Enter how long before death(s)he vomited in days]:",
"id10190_b" =>"(id10190_b) [Enter how long before death(s)he vomited in months]:",
"id10191" =>"(id10191) Was there blood in the vomit?",
"id10192" =>"(id10192) Was the vomit black?",
"id10193" =>"(id10193) Did (s)he have any belly (abdominal) problem?",
"id10194" =>"(id10194) Did (s)he have belly (abdominal) pain?",
"id10195" =>"(id10195) Was the belly (abdominal) pain severe?",
"id10196_unit" =>"(id10196_unit) For how long did (s)he have belly (abdominal) pain? ",
"id10196" =>"(id10196) [Enter how long (s)he had  belly (abdominal) pain in hours]:",
"id10197_a" =>"(id10197_a) [Enter how long (s)he had  belly (abdominal) pain in days]:",
"id10198" =>"(id10198) [Enter how long (s)he had  belly (abdominal) pain in months]:",
"id10197" =>"(id10197) Calculated number of Days with belly pain",
"id10199" =>"(id10199) Was the pain in the upper or lower belly (abdomen)?",
"id10200" =>"(id10200) Did (s)he have a more than usually protruding belly (abdomen)?",
"id10201_unit" =>"(id10201_unit) For how long before death did (s)he have a more than usually protruding belly (abdomen)? ",
"id10201_a" =>"(id10201_a) [Enter how long before death (s)he had a more than usually protruding belly (abdomen) in days]:",
"id10202" =>"(id10202) [Enter how long before death (s)he had a more than usually protruding belly (abdomen) in months]:",
"id10201" =>"(id10201) Calculated number of Days with protruding belly (abdomen)",
"id10203" =>"(id10203) How rapidly did (s)he develop the protruding belly (abdomen)?",
"id10204" =>"(id10204) Did (s)he have any mass in the belly (abdomen)?",
"id10205_unit" =>"(id10205_unit) For how long did (s)he have a mass in the belly (abdomen)?",
"id10205_a" =>"(id10205_a) [Enter how long (s)he had a mass in the belly (abdomen) in days]:",
"id10206" =>"(id10206) [Enter how long (s)he had a mass in the belly (abdomen) in months]:",
"id10205" =>"(id10205) Calculated number of Days with a mass in the belly (abdomen)",
"id10207" =>"(id10207) Did (s)he have a severe headache?",
"id10208" =>"(id10208) Did (s)he have a stiff neck during illness that led to death?",
"id10209_units" =>"(id10209_units) How long before death did (s)he have stiff neck?",
"id10209_a" =>"(id10209_a) [Enter how long before death did (s)he have stiff neck in days]:",
"id10209_b" =>"(id10209_b) [Enter how long before death did (s)he have stiff neck in months]:",
"id10209" =>"(id10209) For how many days before death did (s)he have stiff neck?",
"id10210" =>"(id10210) Did (s)he have a painful neck during the illness that led to death?",
"id10211_units" =>"(id10211_units) How long before death did (s)he have a painful neck?",
"id10211_a" =>"(id10211_a) [Enter how long before death (s)he had a painful neck in days]:",
"id10211_b" =>"(id10211_b) [Enter how long before death (s)he had a painful neck in months]:",
"id10211" =>"(id10211) For how many days before death did (s)he have a painful neck?",
"id10212" =>"(id10212) Did (s)he have mental confusion?",
"id10213_units" =>"(id10213_units) How long did (s)he have mental confusion?",
"id10213_a" =>"(id10213_a) [Enter how long (s)he had mental confusion in days]:",
"id10213_b" =>"(id10213_b) [Enter how long (s)he had mental confusion in months]:",
"id10213" =>"(id10213) For how many months did (s)he have mental confusion?",
"id10214" =>"(id10214) Was (s)he unconscious during the illness that led to death?",
"id10215" =>"(id10215) Was (s)he unconscious for more than 24 hours before death?",
"id10216_units" =>"(id10216_units) How long before death did unconsciousness start?",
"id10216_a" =>"(id10216_a) [Enter how long before death unconsciousness started in hours]?",
"id10216_b" =>"(id10216_b) [Enter how long before death unconsciousness started in days]?",
"id10216" =>"(id10216) How many hours before death did unconsciousness start?",
"id10217" =>"(id10217) Did the unconsciousness start suddenly, quickly (at least within a single day)?",
"id10218" =>"(id10218) Did the unconsciousness continue until death?",
"id10219" =>"(id10219) Did (s)he have convulsions?",
"id10220" =>"(id10220) Did (s)he experience any generalized convulsions or fits during the illness that led to death?",
"id10221" =>"(id10221) For how many minutes did the convulsions last?",
"id10222" =>"(id10222) Did (s)he become unconscious immediately after the convulsion?",
"id10223" =>"(id10223) Did (s)he have any urine problems?",
"id10225" =>"(id10225) Did (s)he go to urinate more often than usual?",
"id10226" =>"(id10226) During the final illness did (s)he ever pass blood in the urine?",
"id10224" =>"(id10224) Did (s)he stop urinating?",
"id10227" =>"(id10227) Did (s)he have sores or ulcers anywhere on the body?",
"id10228" =>"(id10228) Did (s)he have sores?",
"id10229" =>"(id10229) Did the sores have clear fluid or pus?",
"id10230" =>"(id10230) Did (s)he have an ulcer (pit) on the foot?",
"id10231" =>"(id10231) Did the ulcer on the foot ooze pus?",
"id10232_units" =>"(id10232_units) How long  did the ulcer on the foot ooze pus?",
"id10232_a" =>"(id10232_a) [Enter how long the ulcer on the foot oozed pus in days]:",
"id10232_b" =>"(id10232_b) [Enter how long the ulcer on the foot oozed pus in months]:",
"id10232" =>"(id10232) For how many days did the ulcer on the foot ooze pus?",
"id10233" =>"(id10233) During the illness that led to death, did (s)he have any skin rash?",
"id10234" =>"(id10234) For how many days did (s)he have the skin rash?",
"id10235" =>"(id10235) Where was the rash?",
"id10236" =>"(id10236) Did (s)he have measles rash (use local term)?",
"id10237" =>"(id10237) Did (s)he ever have shingles or herpes zoster?",
"id10238" =>"(id10238) During the illness that led to death, did her/his skin flake off in patches?",
"id10239" =>"(id10239) During the illness that led to death, did he/she have areas of the skin that turned black?",
"id10240" =>"(id10240) During the illness that led to death, did he/she have areas of the skin with redness and swelling?",
"id10241" =>"(id10241) During the illness that led to death, did (s)he bleed from anywhere?",
"id10242" =>"(id10242) Did (s)he bleed from the nose, mouth or anus?",
"id10243" =>"(id10243) Did (s)he have noticeable weight loss?",
"id10244" =>"(id10244) Was (s)he severely thin or wasted?",
"id10245" =>"(id10245) During the illness that led to death, did s/he have a whitish rash inside the mouth or on the tongue?",
"id10246" =>"(id10246) Did (s)he have stiffness of the whole body or was unable to open the mouth?",
"id10247" =>"(id10247) Did (s)he have puffiness of the face?",
"id10248_units" =>"(id10248_units) How long did (s)he have puffiness of the face?",
"id10248_a" =>"(id10248_a) [Enter how long (s)he had puffiness of the face in days]:",
"id10248_b" =>"(id10248_b) [Enter how long (s)he had puffiness of the face in months]:",
"id10248" =>"(id10248) For how many days did (s)he have puffiness of the face?",
"id10249" =>"(id10249) During the illness that led to death, did (s)he have swollen legs or feet?",
"id10250_units" =>"(id10250_units) How long did the swelling last?",
"id10250_a" =>"(id10250_a) [Enter how long the swelling lasted in days]:",
"id10250_b" =>"(id10250_b) [Enter how long the swelling lasted in months]:",
"id10250" =>"(id10250) How many days did the swelling last?",
"id10251" =>"(id10251) Did (s)he have both feet swollen?",
"id10252" =>"(id10252) Did (s)he have general puffiness all over his/her body?",
"id10253" =>"(id10253) Did (s)he have any lumps?",
"id10254" =>"(id10254) Did (s)he have any lumps or lesions in the mouth?",
"id10255" =>"(id10255) Did (s)he have any lumps on the neck?",
"id10256" =>"(id10256) Did (s)he have any lumps on the armpit?",
"id10257" =>"(id10257) Did (s)he have any lumps on the groin?",
"id10258" =>"(id10258) Was (s)he in any way paralysed?",
"id10259" =>"(id10259) Did (s)he have paralysis of only one side of the body?",
"id10260" =>"(id10260) Which were the limbs or body parts paralysed?",
"id10261" =>"(id10261) Did (s)he have difficulty swallowing?",
"id10262_units" =>"(id10262_units) For how long before death did (s)he have difficulty swallowing?",
"id10262_a" =>"(id10262_a) [Enter how long before death (s)he had difficulty swallowing in days]:",
"id10262_b" =>"(id10262_b) [Enter how long before death (s)he had difficulty swallowing in months]:",
"id10262" =>"(id10262) For how many days before death did (s)he have difficulty swallowing?",
"id10263" =>"(id10263) Was the difficulty with swallowing with solids, liquids, or both?",
"id10264" =>"(id10264) Did (s)he have pain upon swallowing?",
"id10265" =>"(id10265) Did (s)he have yellow discoloration of the eyes?",
"id10266_units" =>"(id10266_units) For how long did (s)he have the yellow discoloration?",
"id10266_a" =>"(id10266_a) [Enter how long (s)he had the yellow discoloration in days]:",
"id10266_b" =>"(id10266_b) [Enter how long (s)he had the yellow discoloration in months]:",
"id10266" =>"(id10266) For how many days did (s)he have the yellow discoloration?",
"id10267" =>"(id10267) Did her/his hair change in color to a reddish or yellowish color?",
"id10268" =>"(id10268) Did (s)he look pale (thinning/lack of blood) or have pale palms, eyes or nail beds?",
"id10269" =>"(id10269) Did (s)he have sunken eyes?",
"id10270" =>"(id10270) Did (s)he drink a lot more water than usual?",
"id10271" =>"(id10271) Was the baby able to suckle or bottle-feed within the first 24 hours after birth?",
"id10272" =>"(id10272) Did the baby ever suckle in a normal way?",
"id10273" =>"(id10273) Did the baby stop suckling?",
"id10274_a" =>"(id10274_a) How many days after birth did the baby stop suckling?",
"id10274_units" =>"(id10274_units) How long after birth did the baby stop suckling?",
"id10274_b" =>"(id10274_b) [Enter how long after birth  the baby stopped suckling in days]:",
"id10274_c" =>"(id10274_c) [Enter how long after birth  the baby stopped suckling in months]:",
"id10274" =>"(id10274) How many days after birth did the baby stop suckling?",
"id10275" =>"(id10275) Did the baby have convulsions starting within the first 24 hours of life?",
"id10276" =>"(id10276) Did the baby have convulsions starting more than 24 hours after birth?",
"id10277" =>"(id10277) Did the babys body become stiff, with the back arched backwards?",
"id10278" =>"(id10278) During the illness that led to death, did the baby have a bulging or raised fontanelle? ",
"id10279" =>"(id10279) During the illness that led to death, did the baby have a sunken fontanelle? ",
"id10281" =>"(id10281) During the illness that led to death, did the baby become unresponsive or unconscious?",
"id10282" =>"(id10282) Did the baby become unresponsive or unconscious soon after birth, within less than 24 hours?",
"id10283" =>"(id10283) Did the baby become unresponsive or unconscious more than 24 hours after birth?",
"id10284" =>"(id10284) During the illness that led to death, did the baby become cold to touch?",
"id10285" =>"(id10285) How many days old was the baby when it started feeling cold to touch?",
"id10286" =>"(id10286) During the illness that led to death, did the baby become lethargic after a period of normal activity?",
"id10287" =>"(id10287) Did the baby have redness or pus drainage from the umbilical cord stump?",
"id10288" =>"(id10288) During the illness that led to death, did the baby have skin ulcer(s) or pits?",
"id10289" =>"(id10289) During the illness that led to death, did the baby have yellow skin, palms (hand) or soles (foot)?",
"id10290" =>"(id10290) Did the baby or infant appear to be healthy and then just die suddenly?",
"id10294" =>"(id10294) Did she have any swelling or lump in the breast?",
"id10295" =>"(id10295) Did she have any ulcers (pits) in the breast?",
"id10296" =>"(id10296) Did she ever have a period or menstruate?",
"id10297" =>"(id10297) When she had her period, did she have vaginal bleeding in between menstrual periods?",
"id10298" =>"(id10298) Was the bleeding excessive?",
"id10301" =>"(id10301) Was there excessive vaginal bleeding in the week prior to death?",
"id10299" =>"(id10299) Did her menstrual period stop naturally because of menopause or removal of uterus?",
"id10302" =>"(id10302) At the time of death was her period overdue?",
"id10303" =>"(id10303) For how many weeks had her period been overdue?",
"id10300" =>"(id10300) Did she have vaginal bleeding after cessation of menstruation?",
"id10304" =>"(id10304) Did she have a sharp pain in her belly (abdomen) shortly before death?",
"id10305" =>"(id10305)Was she pregnant or in labour at the time of death",
"id10306" =>"(id10306) Did she die within 6 weeks of delivery, abortion or miscarriage?",
"id10307" =>"(id10307) Did this woman die more than 6 weeks after being pregnant or delivering a baby?",
"id10308" =>"(id10308) Was this a woman who died less than 1 year after being pregnant or delivering a baby?",
"id10309" =>"(id10309) For how many months was she pregnant?",
"id10310" =>"(id10310) Please confirm, when she died, she was NEITHER pregnant NOR had delivered, had an abortion, or miscarried within 12 months of when she died--is that right?",
"id10312" =>"(id10312) Did she die during labour or delivery?",
"id10313" =>"(id10313) Did she die after delivering a baby?",
"id10314" =>"(id10314) Did she die within 24 hours after delivery?",
"id10315_a" =>"(id10315) Did she die within 6 weeks of childbirth?",
"id10315" =>"(id10315) Did she die within 6 weeks of childbirth?",
"id10316" =>"(id10316) Did she give birth to a live baby (within 6 weeks of her death)?",
"id10317" =>"(id10317) Did she die during or after a multiple pregnancy?",
"id10318" =>"(id10318) Was she breastfeeding the child in the days before death?",
"id10319" =>"(id10319) How many births, including stillbirths, did she/the mother have before this baby?",
"id10320" =>"(id10320) Had she had any previous Caesarean section?",
"id10321" =>"(id10321) During pregnancy, did she suffer from high blood pressure?",
"id10322" =>"(id10322) Did she have foul smelling vaginal discharge during pregnancy or after delivery?",
"id10323" =>"(id10323) During the last 3 months of pregnancy, did she suffer from convulsions?",
"id10324" =>"(id10324) During the last 3 months of pregnancy did she suffer from blurred vision?",
"id10325" =>"(id10325) Did bleeding occur while she was pregnant?",
"id10326" =>"(id10326) Was there vaginal bleeding during the first 6 months of pregnancy?",
"id10327" =>"(id10327) Was there vaginal bleeding during the last 3 months of pregnancy but before labour started?",
"id10328" =>"(id10328) Did she have excessive bleeding during labour or delivery?",
"id10329" =>"(id10329) Did she have excessive bleeding after delivery or abortion?",
"id10330" =>"(id10330) Was the placenta completely delivered?",
"id10331" =>"(id10331) Did she deliver or try to deliver an abnormally positioned baby?",
"id10332" =>"(id10332) For how many hours was she in labour?",
"id10333" =>"(id10333) Did she attempt to terminate the pregnancy?",
"id10334" =>"(id10334) Did she recently have a pregnancy that ended in an abortion (spontaneous or induced)?",
"id10335" =>"(id10335) Did she die during an abortion?",
"id10336" =>"(id10336) Did she die within 6 weeks of having an abortion?",
"id10337" =>"(id10337) Where did she (give birth / complete the miscarriage / have the abortion)?",
"id10338" =>"(id10338) Did she receive professional assistance during the delivery?",
"id10339" =>"(id10339) Who (delivered the baby / completed the miscarriage / performed the abortion)?",
"id10342" =>"(id10342) Was the delivery normal vaginal, without forceps or vacuum?",
"id10343" =>"(id10343) Was the delivery vaginal, with forceps or vacuum?",
"id10344" =>"(id10344) Was the delivery a Caesarean section?",
"id10347" =>"(id10347) Was the baby born more than one month early?",
"id10340" =>"(id10340) Did she have an operation to remove her uterus shortly before death?",
"id10352_units" =>"(id10352_units) How old was the child when the fatal illness started?",
"id10352_a" =>"(id10352_a) [Enter how old the child was  when the fatal illness started in months]:",
"id10352_b" =>"(id10352_b) [Enter how old the child was  when the fatal illness started in years]:",
"id10352" =>"(id10352) How many years old was the child when the fatal illness started?",
"id10354" =>"(id10354) Was the child part of a multiple  birth?",
"id10355" =>"(id10355) Was the child the first, second, or later in the birth order?",
"id10356" =>"(id10356) Is the mother still alive?",
"id10357" =>"(id10357) Did the mother die before, during or after the delivery?",
"id10358_units" =>"(id10358_units) How long after the delivery did the mother die?",
"id10358" =>"(id10358) How many months after the delivery did the mother die?",
"id10359" =>"(id10359) How many days after the delivery did the mother die?",
"id10359_a" =>"(id10359_a) How many weeks after the delivery did the mother die?",
"id10360" =>"(id10360) Where was the deceased born?",
"id10361" =>"(id10361) Did you/the mother receive professional assistance during the delivery?",
"id10362" =>"(id10362) At birth, was the baby of usual size?",
"id10363" =>"(id10363) At birth, was the baby smaller than usual, (weighing under 2.5 kg)?",
"id10364" =>"(id10364) At birth, was the baby very much smaller than usual, (weighing under 1 kg)?",
"id10365" =>"(id10365) At birth, was the baby larger than usual, (weighing over 4.5 kg)?",
"id10366" =>"(id10366) What was the weight (in grammes) of the deceased at birth?",
"id10367" =>"(id10367) How many months long was the pregnancy before the child was born?",
"id10368" =>"(id10368) Were there any complications in the late part of the pregnancy (defined as the last 3 months, before labour)? ",
"id10369" =>"(id10369) Were there any complications during labour or delivery? ",
"id10370" =>"(id10370) Was any part of the baby physically abnormal at time of delivery? (for example: body part too large or too small, additional growth on body)?",
"id10371" =>"(id10371) Did the baby/ child have a swelling or defect on the back at time of birth?",
"id10372" =>"(id10372) Did the baby/ child have a very large head at time of birth?",
"id10373" =>"(id10373) Did the baby/ child have a very small head at time of birth?",
"id10394" =>"(id10394) How many births, including stillbirths, did the babys mother have before this baby?",
"id10376" =>"(id10376) Was the baby moving in the last few days before the birth?",
"id10377" =>"(id10377) Did the baby stop moving in the womb before labour started?",
"id10379_unit" =>"(id10379_unit) How long before labour did you/the mother last feel the baby move?",
"id10379" =>"(id10379) [Enter how long before labour did you/the mother last feel the baby move in days]:",
"id10380" =>"(id10380) [Enter how long before labour did you/the mother last feel the baby move in hours]:",
"id10382" =>"(id10382) How many hours did labour and delivery take?",
"id10383" =>"(id10383) Was the baby born 24 hours or more after the water broke?",
"id10384" =>"(id10384) Was the liquor foul smelling?",
"id10385" =>"(id10385) What was the colour of the liquor when the water broke?",
"id10387" =>"(id10387) Was the delivery normal vaginal, without forceps or vacuum?",
"id10388" =>"(id10388) Was the delivery vaginal, with forceps or vacuum?",
"id10389" =>"(id10389) Was the delivery a Caesarean section?",
"id10391" =>"(id10391) Did you/the mother receive any vaccinations since reaching adulthood including during this pregnancy?",
"id10392" =>"(id10392) How many doses?",
"id10393" =>"(id10393) Did you/the mother receive tetanus toxoid (TT) vaccine?",
"id10395" =>"(id10395) During labour, did the babys mother suffer from fever?",
"id10396" =>"(id10396) During the last 3 months of pregnancy, labour or delivery, did you/the babys mother suffer from high blood pressure?",
"id10397" =>"(id10397) Did you/the babys mother have diabetes mellitus?",
"id10398" =>"(id10398) Did you/the babys mother have foul smelling vaginal discharge during pregnancy or after delivery?",
"id10399" =>"(id10399) During the last 3 months of pregnancy, labour or delivery, did you/the babys mother suffer from convulsions?",
"id10400" =>"(id10400) During the last 3 months of pregnancy did you/the babys mother suffer from blurred vision?",
"id10401" =>"(id10401) Did you/the babys mother have severe anemia?",
"id10402" =>"(id10402) Did you/the babys mother have vaginal bleeding during the last 3 months of pregnancy but before labour started?",
"id10403" =>"(id10403) Did the babys bottom, feet, arm or hand come out of the vagina before its head?",
"id10404" =>"(id10404) Was the umbilical cord wrapped more than once around the neck of the child at birth?",
"id10405" =>"(id10405) Was the umbilical cord delivered first?",
"id10406" =>"(id10406) Was the baby blue in colour at birth?",
"id10411" =>"(id10411) Did (s)he drink alcohol?",
"id10412" =>"(id10412) Did (s)he use tobacco?",
"id10413" =>"(id10413) Did (s)he smoke tobacco (cigarette, cigar, pipe, etc.)?",
"id10414" =>"(id10414) What kind of tobacco did (s)he use ?",
"id10415" =>"(id10415) How many cigarettes did (s)he smoke daily?",
"id10416" =>"(id10416) How many times did (s)he use tobacco products each day?",
"id10418" =>"(id10418) Did (s)he receive any treatment for the illness that led to death?",
"id10419" =>"(id10419) Did (s)he receive oral rehydration salts?",
"id10420" =>"(id10420) Did (s)he receive (or need) intravenous fluids (drip) treatment?",
"id10421" =>"(id10421) Did (s)he receive (or need) a blood transfusion?",
"id10422" =>"(id10422) Did (s)he receive (or need) treatment/food through a tube passed through the nose?",
"id10423" =>"(id10423) Did (s)he receive (or need) injectable antibiotics?",
"id10424" =>"(id10424) Did (s)he receive (or need) antiretroviral therapy (ART)?",
"id10425" =>"(id10425) Did (s)he have (or need) an operation for the illness?",
"id10426" =>"(id10426) Did (s)he have the operation within 1 month before death?",
"id10427" =>"(id10427) Was (s)he discharged from hospital very ill?",
"id10428" =>"(id10428) Did (s)he receive any immunizations?",
"id10429" =>"(id10429) Do you have the childs vaccination card?",
"id10430" =>"(id10430) Can I see the vaccination card (note the vaccines the child received)?",
"id10431" =>"(id10431) Select EPI vaccines done",
"id10432" =>"(id10432) Was care sought outside the home while (s)he had this illness?",
"id10433" =>"(id10433) Where or from whom did you seek care?",
"id10434" =>"(id10434) What was the name and address of any hospital, health center or clinic where care was sought",
"id10435" =>"(id10435) Did a health care worker tell you the cause of death?",
"id10436" =>"(id10436) What did the health care worker say?",
"id10437" =>"(id10437) Do you have any health records that belonged to the deceased?",
"id10438" =>"(id10438) Can I see the health records?",
"id10439_check" =>"(id10439_check) [Is the date of the most recent (last) visit available?]",
"id10439" =>"(id10439) [Record the date of the most recent (last) visit]",
"id10440_check" =>"(id10440_check) [Is the date of the second most recent visit available?]",
"id10440" =>"(id10440) [Record the date of the second most recent visit]",
"id10441_check" =>"(id10441_check) [Is the date of the last note on the health records available?]",
"id10441" =>"(id10441) [Record the date of the last note on the health records]",
"id10442" =>"(id10442) [Record the weight (in kilogrammes) written at the most recent (last) visit]",
"id10443" =>"(id10443) [Record the weight (in kilogrammes) written at the second most recent visit]",
"id10444" =>"(id10444) [Transcribe the last note on the health records]",
"id10445" =>"(id10445) Has the deceased’s (biological) mother ever been tested for HIV?",
"id10446" =>"(id10446) Has the deceased’s (biological) mother ever been told she had HIV/AidS by a health worker?",
"id10450" =>"(id10450) In the final days before death, did s/he travel to a hospital or health facility?",
"id10451" =>"(id10451) Did (s)he use motorised transport to get to the hospital or health facility?",
"id10452" =>"(id10452) Were there any problems during admission to the hospital or health facility?",
"id10453" =>"(id10453) Were there any problems with the way (s)he was treated (medical treatment, procedures, interpersonal attitudes, respect, dignity) in the hospital or health facility?",
"id10454" =>"(id10454) Were there any problems getting medications or diagnostic tests in the hospital or health facility?",
"id10455" =>"(id10455) Does it take more than 2 hours to get to the nearest hospital or health facility from the deceaseds household?",
"id10456" =>"(id10456) In the final days before death, were there any doubts about whether medical care was needed?",
"id10457" =>"(id10457) In the final days before death, was traditional medicine used?",
"id10458" =>"(id10458) In the final days before death, did anyone use a telephone or cell phone to call for help?",
"id10459" =>"(id10459) Over the course of illness, did the total costs of care and treatment prohibit other household payments?",
"id10462" =>"(id10462) Was a death certificate issued?",
"id10463" =>"(id10463) Can I see the death certificate?",
"id10464" =>"(id10464) [Record the immediate cause of death from the certificate (line 1a)]",
"id10465" =>"(id10465) [Duration (Ia):]",
"id10466" =>"(id10466) [Record the first antecedent cause of death from the certificate  (line 1b)]",
"id10467" =>"(id10467) [Duration (Ib):]",
"id10468" =>"(id10468) [Record the second antecedent cause of death from the certificate (line 1c)]",
"id10469" =>"(id10469) [Duration (Ic):]",
"id10470" =>"(id10470) [Record the third antecedent cause of death from the certificate (line 1d)]",
"id10471" =>"(id10471) [Duration (id):]",
"id10472" =>"(id10472) [Record the contributing cause(s) of death from the certificate (part 2)]",
"id10473" =>"(id10473) [Duration (part2):]",
"comment" =>"(comment) Comment");

		return $array;
	}





} //end class
					


?>