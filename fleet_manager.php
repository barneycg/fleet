<HTML> 
<HEAD> 
<TITLE>Report on a fleet</TITLE> 
<STYLE TYPE="text/css">
<!--
TD{font-family: Arial; font-size: 10pt;}
-->
</STYLE>
</HEAD> 
<BODY style="background-image:url(bg.jpg);background-color:black;color:white">
      <form action="fm_form.php" method="get"> 
        <table width="900" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="black"> 
          <tr>
			<td colspan="6"><img align="center" src="tracker_rep.jpg" width="600" height="84" alt="tracker" style="display: block;margin-left: auto;margin-right: auto;"></td>
		  </tr>
          <!-- <tr> 
          	<td colspan="4"></td>
            <td><input type="submit" name="Submit" value="Update"></td> 
          </tr> --> 
          <tr> 
            <td><strong></strong></td> 
            <td><strong>Fleet ID</strong></td> 
            <td><strong>Fleet Name</strong></td> 
            <!-- <td><strong>Fleet Start</strong></td>
            <td><strong>Fleet End</strong></td> -->
            <td><strong>Timestamp</strong></td> 
            <td><strong>Closed</strong></td>
          </tr> 

<?
$config = parse_ini_file("ft.ini", true);
$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");
//include("conn.php");
$sql = "SELECT fleet_id,fleet_name,timestamp,fleet_start,fleet_end,closed FROM fleets order by fleet_id desc";
$result=mysql_query($sql,$con);

//$dbarray = mysql_fetch_array($result);
while($row=mysql_fetch_array($result)) { 
?> 
          <tr> 
            <td><!-- <input name="<? echo $row['fleet_id']; ?>" type="checkbox" class="check"> --></td> 
            <td><? echo "<a href=\"http://fleet.lawnalliance.org/fleet_tracker2.php?fleet_id=".$row['fleet_id']."\">".$row['fleet_id']."</a>"; ?></td> 
            <td><? echo $row['fleet_name']; ?></td>
            <!-- <td><? echo $row['fleet_start']; ?></td>
            <td><? echo $row['fleet_end']; ?></td> -->
            <td><? echo $row['timestamp']; ?></td>
            <td><? if ($row['closed']==1) { echo "Yes";}else { echo "No";} ?></td>
			<td><? if ($row['fleet_start']=="0000-00-00 00:00:00"){ echo "<button type=\"button\" value=\"Modify\" onClick=\"window.location='http://fleet.lawnalliance.org/fleetform_adv.php?fleet_id=".$row['fleet_id']."&mode=Modify'\">Modify</button>";} else { echo "<button type=\"button\" value=\"Modify\" onClick=\"window.location='http://fleet.lawnalliance.org/fleetform_adv.php?fleet_id=".$row['fleet_id']."&mode=Modify_Adv'\">Modify</button>";} ?></td>
          </tr> 
          <? } ?> 

        </table> 

		<!--<button type="button" value="Delete" onclick="goDel();">Delete</button>
		<div align=right><input type="submit" name="mode" value="Add"></div>-->

    </form>
</BODY>
</HTML>
