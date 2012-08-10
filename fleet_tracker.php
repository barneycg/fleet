<? 
ini_alter("session.use_cookies","1"); 
ob_start();
$config = parse_ini_file("ft.ini", true);
$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");

?> 
<HTML> 
<HEAD> 
<TITLE>Testpage 2</TITLE> 
</HEAD> 
<BODY> 
<? 
if (strpos($_SERVER['HTTP_USER_AGENT'], 'EVE-IGB'))
{ 
	//var_dump($_SERVER["HTTP_EVE_TRUSTED"]);
	if ($_SERVER["HTTP_EVE_TRUSTED"]=="No") 
	{ ?>
		<button type="button" onclick="CCPEVE.requestTrust('http://fleet.lawnalliance.org/*')">Request Trust</button>
	<?
	} 
	else 
	{ 
		$fleet_id=$_GET["fleet_id"];
		$char_name=mysql_real_escape_string($_SERVER["HTTP_EVE_CHARNAME"]);
		//$char_name=mysql_real_escape_string("o'neil");
		
		$corp_name=mysql_real_escape_string($_SERVER["HTTP_EVE_CORPNAME"]);
		$ship_type=mysql_real_escape_string($_SERVER["HTTP_EVE_SHIPTYPENAME"]);
		$location=mysql_real_escape_string($_SERVER["HTTP_EVE_SOLARSYSTEMNAME"]);
		$timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
		$sql="replace into fleet_tracking(fleet_id,timestamp,char_name,corp_name,ship_type,location) values($fleet_id,'$timestamp','$char_name','$corp_name','$ship_type','$location')";
    	$result=mysql_query($sql,$con) or die(mysql_error());
    	mysql_close($con);
	?> 
	<b>Pilot:</b>
	<? echo "[".$_SERVER["HTTP_EVE_CORPNAME"] ."]" .$_SERVER["HTTP_EVE_CHARNAME"]; ?> 
	<b>Location:</b>
	<? echo $_SERVER["HTTP_EVE_REGIONNAME"]; ?>/<?
	echo $_SERVER["HTTP_EVE_CONSTELLATIONNAME"]; ?>/<?
	echo $_SERVER["HTTP_EVE_SOLARSYSTEMNAME"]; ?><BR> 
	<? 
	if ($_SERVER["HTTP_EVE_STATIONNAME"] != "None") 
	{ 
	?> 
	<b>Station:</b> <? echo $_SERVER["HTTP_EVE_STATIONNAME"]; ?><br> 
	<? 
	} 
	} 
}
else
{
?>
	<h3>This link only works in the IGB</h3>
<?
}
?> 
</BODY> 
</HTML> 
<? 
ob_end_flush(); 
?>
