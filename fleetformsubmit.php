<?php
ob_start();
$config = parse_ini_file("ft.ini", true);
$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");

$mode='';
$mode=$_GET["mode"];

if (empty($mode))
{
	$mode=$_POST['Submit'];
	$fleet_id=$_POST['fleet_id'];
	$timestamp=$_POST['timestamp'];
	$adv=$_POST['adv'];
}

if ($mode=="delete")
{
	$fleet_id=mysql_real_escape_string($_GET["fleet_id"]);

	$sql1="delete from fleets where fleet_id=$fleet_id";
	$result1=mysql_query($sql1,$con) or die(mysql_error());
	//$row1=mysql_fetch_array($result1);
	mysql_close($con);
	exit;
}
elseif (empty($_POST["fleet_name"]) && (empty($_GET["fleet_name"])))
{
	echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
	echo "You need a fleet name you muppet";
}
else
{
	if ($mode=="add")
	{
		$fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
		$timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
		$fleet_start="0000-00-00 00:00:00";//mysql_real_escape_string($_POST["fleet_start"]);
		$fleet_end="0000-00-00 00:00:00";//mysql_real_escape_string($_POST["fleet_end"]);

		//if (($fleet_start!="0000-00-00 00:00:00") && ($fleet_end!="0000-00-00 00:00:00") && (!empty($fleet_start)) && (!empty($fleet_end)))
		//{
		$sql="insert into fleets(fleet_name,timestamp,fleet_start,fleet_end) values('$fleet_name','$timestamp','$fleet_start','$fleet_end')";
		$result=mysql_query($sql,$con) or die(mysql_error());
		$sql1="select fleet_id from fleets where fleet_name = '$fleet_name' and timestamp = '$timestamp'";
		$result1=mysql_query($sql1,$con) or die(mysql_error());
		$row1=mysql_fetch_array($result1);
		$fleet_id=$row1['fleet_id'];
		mysql_close($con);
		echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
		echo "<a href='http://fleet.lawnalliance.org/fleet_tracker.php?fleet_id=" . $fleet_id ."'>".$fleet_name."</a>";
		//}
		//else
		//{
		//	echo "Invalid Start or End date Please make sure it is in Eve Time in the format YYYY-MM-DD HH:MM:SS";
		//}
	}

	if ($mode=="Submit")
	{
		$fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
		$timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
		$fleet_start=mysql_real_escape_string($_POST["fleet_start"]);
		$fleet_end=mysql_real_escape_string($_POST["fleet_end"]);

		if (($fleet_start!="0000-00-00 00:00:00") && ($fleet_end!="0000-00-00 00:00:00") && (!empty($fleet_start)) && (!empty($fleet_end)))
		{
			$sql="insert into fleets(fleet_name,timestamp,fleet_start,fleet_end) values('$fleet_name','$timestamp','$fleet_start','$fleet_end')";
			$result=mysql_query($sql,$con) or die(mysql_error());
			$sql1="select fleet_id from fleets where fleet_name = '$fleet_name' and timestamp = '$timestamp'";
			$result1=mysql_query($sql1,$con) or die(mysql_error());
			$row1=mysql_fetch_array($result1);
			$fleet_id=$row1['fleet_id'];
			mysql_close($con);
			echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
			echo "<a href='http://fleet.lawnalliance.org/fleet_tracker.php?fleet_id=" . $fleet_id ."'>".$fleet_name."</a>";
		}
		else
		{
			echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
			echo "Invalid Start or End date Please make sure it is in Eve Time in the format YYYY-MM-DD HH:MM:SS";
		}
	}

	if ($mode=="sched")
	{
		$fleet_name=mysql_real_escape_string($_GET["fleet_name"]);
                $timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
                $fleet_start=mysql_real_escape_string($_GET["fleet_start"]);
                $fleet_end=mysql_real_escape_string($_GET["fleet_end"]);

                if (($fleet_start!="0000-00-00 00:00:00") && ($fleet_end!="0000-00-00 00:00:00") && (!empty($fleet_start)) && (!empty($fleet_end)))
                {
                        $sql="insert into fleets(fleet_name,timestamp,fleet_start,fleet_end) values('$fleet_name','$timestamp','$fleet_start','$fleet_end')";
                        $result=mysql_query($sql,$con) or die(mysql_error());
                       	$sql1="select fleet_id from fleets where fleet_name = '$fleet_name' and timestamp = '$timestamp'";
                        $result1=mysql_query($sql1,$con) or die(mysql_error());
                        $row1=mysql_fetch_array($result1);
                        $fleet_id=$row1['fleet_id'];
                        mysql_close($con);
                        echo $fleet_id;
                        exit;
                }
	}
	
	if (($mode=="Modify")&&($adv=="n"))
	{
		$fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
		$timestamp=mysql_real_escape_string($_POST["timestamp"]);
		
		$sql="replace into fleets(fleet_id,fleet_name,timestamp) values('$fleet_id','$fleet_name','$timestamp')";
		$result=mysql_query($sql,$con) or die(mysql_error());
		mysql_close($con);
		echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
		echo "<a href='http://fleet.lawnalliance.org/fleet_tracker.php?fleet_id=" . $fleet_id ."'>".$fleet_name."</a>";
	}
	
	if(($mode=="Modify")&&($adv=="y"))
	{
		$fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
		//$timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
		$fleet_start=mysql_real_escape_string($_POST["fleet_start"]);
		$fleet_end=mysql_real_escape_string($_POST["fleet_end"]);
		if (($fleet_start!="0000-00-00 00:00:00") && ($fleet_end!="0000-00-00 00:00:00") && (!empty($fleet_start)) && (!empty($fleet_end)))
		{
			$sql="replace into fleets(fleet_id,fleet_name,timestamp,fleet_start,fleet_end) values('$fleet_id','$fleet_name','$timestamp','$fleet_start','$fleet_end')";
			$result=mysql_query($sql,$con) or die(mysql_error());
			mysql_close($con);
			echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
			echo "<a href='http://fleet.lawnalliance.org/fleet_tracker.php?fleet_id=" . $fleet_id ."'>".$fleet_name."</a>";
		}
		else
		{
			echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
			echo "Invalid Start or End date Please make sure it is in Eve Time in the format YYYY-MM-DD HH:MM:SS";
		}
	}
	
	if($mode=="Close Fleet")
	{
		$fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
		//$timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
		$fleet_start=mysql_real_escape_string($_POST["fleet_start"]);
		$fleet_end=mysql_real_escape_string($_POST["fleet_end"]);
	
		$sql="update fleets set closed=1 where fleet_id=$fleet_id";
		$result=mysql_query($sql,$con) or die(mysql_error());
		mysql_close($con);
		echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
		echo "Fleet Closed";
	}
	
	if($mode=="Re-Open Fleet")
	{
		$fleet_name=mysql_real_escape_string($_POST["fleet_name"]);
		//$timestamp=mysql_real_escape_string(date( 'Y-m-d H:i:s', time() ));
		$fleet_start=mysql_real_escape_string($_POST["fleet_start"]);
		$fleet_end=mysql_real_escape_string($_POST["fleet_end"]);
	
		$sql="update fleets set closed=0 where fleet_id=$fleet_id";
		$result=mysql_query($sql,$con) or die(mysql_error());
		mysql_close($con);
		echo "<HTML>\n<BODY style=\"background-image:url(bg.jpg);background-color:black;color:white\">\n";
		echo "Fleet Re-Opened";
	}
}

?>
</BODY>
</HTML>
