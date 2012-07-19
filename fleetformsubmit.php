<?
ob_start();
$config = parse_ini_file("ft.ini", true);
$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");

$mode=$_GET["mode"];
if($mode=="add")
{
    $fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
    $timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
    $sql="insert into fleets(fleet_name,timestamp) values('$fleet_name','$timestamp')";
    $result=mysql_query($sql,$con) or die(mysql_error());
    $sql1="select fleet_id from fleets where fleet_name = '$fleet_name' and timestamp = '$timestamp'";
    $result1=mysql_query($sql1,$con) or die(mysql_error());
    $row1=mysql_fetch_array($result1);
    $fleet_id=$row1['fleet_id'];
    mysql_close($con);
	echo "<a href='http://fleet.lawnalliance.org/fleet_tracker.php?fleet_id=" . $fleet_id ."'>".$fleet_name."</a>";
}


?> 
