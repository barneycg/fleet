<?php

$config = parse_ini_file("ft.ini", true);
$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");

$id=$_GET["id"];
$type=$_GET["type"];

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
if ($_GET["name"]!=''){
	//var_dump($_GET['name']);
	$header="Content-Disposition: attachment; filename=\"".$_GET["name"]."-".$type.".csv\"";
}
else
{
	$header="Content-Disposition: attachment; filename=report.csv";
}
header($header);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

if ($type=="cc")
{
	fputcsv($output, array('Corp', 'Count'));
	$sql = "SELECT corp_name,count(*) as count from fleet_tracking where fleet_id='$id' group by corp_name";
	$result=mysql_query($sql,$con);
}
else if ($type=="fm")
{
	fputcsv($output, array('Corp', 'Character','Ship','Location','Timestamp'));
	$sql = "SELECT corp_name,char_name,ship_type,location,timestamp from fleet_tracking where fleet_id='$id' order by corp_name,char_name";
	$result=mysql_query($sql,$con);
}

// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($result)) fputcsv($output, $row);

?>
