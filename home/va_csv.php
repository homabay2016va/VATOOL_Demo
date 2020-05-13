<?php
header("content-type: text/html");
include("sqlite_functions.php");
$df = new SQLITEDB();

if(isset($_GET['q'])){
	$year= pg_escape_string($_GET['q']);

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
		  from vadata_clean  where  date_part('year'::text, submissiondate::date)='".$year."'
        group by upper(case when id10010='other' then id10010_other else id10010 end),  date_part('year'::text, submissiondate::date)";

	$va = $df ->saveToCsv("va_submissions.csv",$q);
}else{
	$query= "select distinct t1.cause1 as interva5,t1.insilico,t1.comcat,t2.* FROM  vadata_clean t2 inner join vacod t1 on t1.id = t2.instanceid
	order by t2.index asc";
	$va = $df ->saveToCsv("vadata_all.csv",$query);
	
}









?>