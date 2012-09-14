<? 
ini_alter("session.use_cookies","1"); 
ob_start();
$config = parse_ini_file("ft.ini", true);
//$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);

$pdo = new PDO("mysql:host=".$config['mysql']['host'].";dbname=".$config['mysql']['db_name'], $config['mysql']['user'], $config['mysql']['password']);

// PDO, prepared statement
$t = $pdo->prepare('select fleet_name,fleet_start,fleet_end,closed from fleets where fleet_id= :fleet_id');
$i = $pdo->prepare('replace into fleet_tracking(fleet_id,timestamp,char_name,char_id,corp_name,corp_id,alliance_name,alliance_id,ship_type,ship_type_id,location) values( :fleet_id,:timestamp,:char_name,:char_id,:corp_name,:corp_id,:alliance_name,:alliance_id,:ship_type,:ship_type_id,:location)');

?> 
<HTML> 
<HEAD> 
<TITLE>Fleet Member</TITLE> 
</HEAD> 
<BODY style="background-image:url(bg.jpg);background-color:black;color:white"> 
<form name="form1" method="post" action="joinfleet.php">
<? 
if (strpos($_SERVER['HTTP_USER_AGENT'], 'EVE-IGB'))
{ 
	if ($_SERVER["HTTP_EVE_TRUSTED"]=="No") 
	{ ?>
		<button type="button" onclick="CCPEVE.requestTrust('http://fleet.lawnalliance.org/*')">Request Trust</button>
	<?
	} 
	else 
	{ 
		if ($_SERVER["HTTP_EVE_ALLIANCEID"] === '150097440')
		{
			$fleet_id=$_GET["fleet_id"];
			$alliance_name=$_SERVER["HTTP_EVE_ALLIANCENAME"];
			$alliance_id=$_SERVER["HTTP_EVE_ALLIANCEID"];
			$char_name=$_SERVER["HTTP_EVE_CHARNAME"];
			$char_id=$_SERVER["HTTP_EVE_CHARID"];
			$corp_name=$_SERVER["HTTP_EVE_CORPNAME"];
			$corp_id=$_SERVER["HTTP_EVE_CORPID"];
			$ship_type=$_SERVER["HTTP_EVE_SHIPTYPENAME"];
			$ship_type_id=$_SERVER["HTTP_EVE_SHIPTYPEID"];
			$location=$_SERVER["HTTP_EVE_SOLARSYSTEMNAME"];
			$timestamp=date( 'Y-m-d H:i:s', time() );
			
			
			$t->execute(array(':fleet_id'=>$fleet_id));

			while ($rt = $t->fetch())
			{
				$fleet_start=$rt['fleet_start'];
				$fleet_end=$rt['fleet_end'];
				$fleet_name=$rt['fleet_name'];
				$fleet_closed=$rt['closed'];
				
            		}
			
			if (($fleet_closed == 0) && ((($timestamp >= $fleet_start) && ($timestamp <= $fleet_end))||($fleet_start == "0000-00-00 00:00:00") ))
			{
				//$i->execute(array(':fleet_id'=>$fleet_id,':timestamp'=>$timestamp,':char_name'=>$char_name,':char_id'=>$char_id,':corp_name'=>$corp_name,':corp_id'=>$corp_id,':alliance_name'=>$alliance_name,':alliance_id'=>$alliance_id,':ship_type'=>$ship_type,':ship_type_id'=>$ship_type_id,':location'=>$location));

				?> 
				<b>Pilot:</b>
				<? echo " [".$_SERVER["HTTP_EVE_CORPNAME"] ."] " .$_SERVER["HTTP_EVE_CHARNAME"]."<BR>"; ?> 
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
				echo "<b>Ship Type:</b> ".$ship_type."<BR><BR>";
				
				echo "You are about to join the fleet : <b>".$fleet_name."</b><br>";
				echo "<b>Are you sure ?</b>";
				echo "<input type=\"hidden\" name=\"fleet_id\" value=\"".$fleet_id."\"?";
				echo "<input type=\"hidden\" name=\"char_name\" value=\"".$char_name."\"?";
				echo "<input type=\"hidden\" name=\"char_id\" value=\"".$char_id."\"?";
				echo "<input type=\"hidden\" name=\"corp_name\" value=\"".$corp_name."\"?";
				echo "<input type=\"hidden\" name=\"corp_id\" value=\"".$corp_id."\"?";
				echo "<input type=\"hidden\" name=\"alliance_name\" value=\"".$alliance_name."\"?";
				echo "<input type=\"hidden\" name=\"alliance_id\" value=\"".$alliance_id."\"?";
				echo "<input type=\"hidden\" name=\"ship_type\" value=\"".$ship_type."\"?";
				echo "<input type=\"hidden\" name=\"ship_type_id\" value=\"".$ship_type_id."\"?";
				echo "<input type=\"hidden\" name=\"location\" value=\"".$location."\"?";
				echo "<input type=\"hidden\" name=\"timestamp\" value=\"".$timestamp."\">";
			
				echo "&nbsp;&nbsp;<input type=\"submit\" name=\"Submit\" value=\"Yes\">";
				} 
			}
			else
			{
			?>
				<h3>Not an Active Fleet</h3>
			<?
			}
		}
		else
		{
		?>
			<h3>You are not in the Get off My Lawn Alliance</h3>
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
</form>
</BODY> 
</HTML> 
<? 
ob_end_flush(); 
?>
