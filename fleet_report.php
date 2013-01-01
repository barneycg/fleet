<HTML> 
<HEAD> 
<TITLE>Report on a fleet</TITLE> 
<STYLE TYPE="text/css">
<!--
TD{font-family: Arial; font-size: 10pt;}
--->
</STYLE>
</HEAD> 
<BODY style="background-image:url(bg.jpg);background-color:black;color:white">
      <form action="fr_form.php" method="post">
        <table width="900" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="black"> 
          <tr>
			<td colspan="7"><img align="center" src="tracker_rep.jpg" width="600" height="84" alt="tracker" style="display: block;margin-left: auto;margin-right: auto;"></td>
		  </tr>
          <tr> 
            <td><!--<input name="topcheckbox" type="checkbox" class="check" id="topcheckbox" onClick="selectall();" value="ON"> 
Select All   --> </td> 
          </tr> 
          <tr> 
            <td><strong></strong></td> 
            <td><strong>Fleet ID</strong></td> 
            <td><strong>Fleet Name</strong></td> 
            <!-- <td><strong>Fleet Start</strong></td>
            <td><strong>Fleet End</strong></td> -->
            <td><strong>Timestamp</strong></td>
            <td><strong>Corp Count</strong></td>
            <td><strong>Fleet Members</strong></td> 
          </tr> 

<?
//require('/home/sites/lawnalliance.org/forum2/SSI.php');
//$ssi=$context;
//global $ssi,$user_info;
//if (($ssi['user']['is_logged'])&& (in_array(28, $user_info['groups'])))
//{
	$config = parse_ini_file("ft.ini", true);
	$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");
	$sql = "SELECT fleet_id,fleet_name,timestamp,fleet_start,fleet_end FROM fleets order by fleet_id desc";
	$result=mysql_query($sql,$con);

	while($row=mysql_fetch_array($result)) { 
		?> 
			<tr> 
			<td> 
			<!--<input name="<? echo $row['fleet_id']; ?>" type="checkbox" class="check"> --> 
			</td> 
			<td><? echo $row['fleet_id']; ?></td> 
			<td><? echo $row['fleet_name']; ?></td>
			<!-- <td><? echo $row['fleet_start']; ?></td>
			<td><? echo $row['fleet_end']; ?></td> -->
			<td><? echo $row['timestamp']; ?></td>
			<td><a href="<? echo "fr_form.php?id=".$row['fleet_id']."&name=".urlencode($row['fleet_name'])."&type=cc"; ?>">Fetch</a></td> 
			<td><a href="<? echo "fr_form.php?id=".$row['fleet_id']."&name=".urlencode($row['fleet_name'])."&type=fm"; ?>">Fetch</a></td> 
			</tr> 
			<? } ?> 

			</table> 

			<!--<button type="button" value="Delete" onclick="goDel();">Delete</button>
			<div align=right><input type="submit" name="mode" value="Add"></div>-->

			</form>
<?//}
//else
//{
//	echo "You need to log in on the LAWN forums and be a member of the FC Group";
//}
?>
</BODY>
</HTML>
