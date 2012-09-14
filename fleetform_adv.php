<HTML> 
<HEAD> 
<TITLE>Create a new fleet tracker</TITLE> 
<!-- <script language="javascript" type="text/javascript" src="datetimepicker.js"> -->
<link rel="stylesheet" type="text/css" href="/anytime.css" />
<script src="/jquery.js"></script>
<script src="/anytime.js"></script>
<script src="/anytimetz.js"></script>
</script>
</HEAD>
<BODY style="background-image:url(bg.jpg); background-color:black; color:white; font-family: Arial, Helvetica, sans-serif; font-weight: bold;">
<?php
	$mode='';
	$mode=$_GET['mode'];
	$fleet_id=$_GET['fleet_id'];
	if ($mode=='Modify_Adv')
	{
	$config = parse_ini_file("ft.ini", true);
	$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");
	//include("conn.php");
	$sql = "SELECT fleet_id,fleet_name,timestamp,fleet_start,fleet_end,closed FROM fleets where fleet_id=".$fleet_id." order by fleet_id desc";
	$result=mysql_query($sql,$con);
	while($row=mysql_fetch_array($result))
	{
		$fid = $row['fleet_id'];
		$fn = $row['fleet_name'];
		$st = $row['fleet_start'];
		$et = $row['fleet_end'];
		$ts = $row['timestamp'];
		$closed = $row['closed'];
		}
	?>
	<form name="form1" method="post" action="fleetformsubmit.php">
		<!-- <input type="hidden" name="mode" value="modify"> -->
		<input type="hidden" name="timestamp" value=<? echo "\"".$ts."\""; ?>>
		<input type="hidden" name="fleet_id" value=<? echo "\"".$fid."\""; ?>>
		<input type="hidden" name="adv" value="y">
		<table width="600" border="0" align="center" cellpadding="4" cellspacing="2" valign="middle">
		  <tr>
			<td colspan="4"><img src="tracker_add.jpg" width="600" height="84" alt="tracker"></td>
		  </tr>
		  <tr>
			<td width="95"><br><br>Fleet Name :</td>
			<td colspan="3"><br><br><input name="fleet_name" type="text" id="fleet_name" size="93" value="<? echo $fn; ?>"></td>
		  </tr>
		  <tr>
			<!-- <input  name="fleet_start" type="text" id="fleet_start" size="25" value=><a href="javascript:NewCal('fleet_start','yyyymmdd',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td> -->
			<!-- <td><br>End Time :</td>
			<td><br><input name="fleet_end" type="text" id="fleet_end" size="25"><a href="javascript:NewCal('fleet_end','yyyymmdd',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>	  
		  -->
		  <td>
		  	    <style type="text/css">
  				#fleet_start, #fleet_end {
    			background-image:url("cal.gif");
    			background-position:right center;
    			background-repeat:no-repeat; }
			</style>
			Start: <input name="fleet_start" type="text" id="fleet_start" size="30" value="<? echo $st; ?>"/>
			Finish: <input name="fleet_end" type="text" id="fleet_end" size="30" value="<? echo $et; ?>"/>
			<input type="button" id="fleet_now" value="now" />
			<input type="button" id="fleet_clear" value="clear" />
			<script>
			var oneDay = 24*60*60*1000;
			var twoHour = 2*60*60*1000;
  			var rangeDemoFormat = "%Y-%m-%d %H:%i:%s";
  			var rangeDemoConv = new AnyTime.Converter({format:rangeDemoFormat});
  			var eveConv = new AnyTime.Converter({format:rangeDemoFormat,utcFormatOffsetImposed:0});
  			
			//alert($("#fleet_start").val());
  			var start = new Date(eveConv.parse($("#fleet_start").val()).getTime());
   			var end = new Date(eveConv.parse($("#fleet_end").val()).getTime());
			var fromDay = start.getTime();
			
			var oneDayLater = new Date(fromDay+oneDay);
			oneDayLater.setHours(23,59,59,999);
			
 			//now button
  			$("#fleet_now").click( function(e) {
  			  	var start = new Date();
  				start.setSeconds(0);
  				var end = new Date(Date.parse(start.toString())+twoHour);
				end.setSeconds(0);
      			$("#fleet_start").val(eveConv.format(start)).change(); 
      			$("#fleet_end").val(eveConv.format(end)).change();
      		} );
      			
      		//clear button	
  			$("#fleet_clear").click( function(e) {
      			$("#fleet_start").val("").change(); } );
      		
			
      		//set defaults	
      		$("#fleet_start").AnyTime_picker({format:rangeDemoFormat,askSecond:false}).val(rangeDemoConv.format(start)).change();
  			$("#fleet_end").AnyTime_picker({format: rangeDemoFormat,askSecond: false}).val(rangeDemoConv.format(end)).change();

			//Set the 
  			$("#fleet_start").change( function(e) { 
  				try {
      				$("#fleet_end").AnyTime_noPicker().removeAttr("disabled").val(eveConv.format(end)).AnyTime_picker(
      				{ 
                		format: rangeDemoFormat,
                		askSecond: false
              		} );
      			} catch(e){ $("#fleet_end").val("").attr("disabled","disabled"); } } );
			</script>
			</td>
		  </tr>
		  <tr>
		  	<td colspan="4"><!-- <font size="2">Note : Fleet Start and End times <strong>must</strong> be in Eve time and in the format YYYY-MM-DD HH:MM:SS</font> --></td>
		  </tr>	
		  <tr>
			<td colspan="4" align="center"><br>
			<input type="submit" name="Submit" value="Modify"><? if ($closed == 1) { echo "<input type=\"submit\" name=\"Submit\" value=\"Re-Open Fleet\">";} else {echo "<input type=\"submit\" name=\"Submit\" value=\"Close Fleet\">";} ?> </td>
			<!-- <td> </td> -->
		  </tr>
		</table>
	</form>
	<?
	}
	else if ($mode=='Modify')
	{
	$config = parse_ini_file("ft.ini", true);
	$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	$db=mysql_select_db($config['mysql']['db_name'],$con) or die("I Couldn't select your database");
	//include("conn.php");
	$sql = "SELECT fleet_id,fleet_name,timestamp,fleet_start,fleet_end,closed FROM fleets where fleet_id=".$fleet_id." order by fleet_id desc";
	$result=mysql_query($sql,$con);
	while($row=mysql_fetch_array($result))
	{
		$fid = $row['fleet_id'];
		$fn = $row['fleet_name'];
		$st = $row['fleet_start'];
		$et = $row['fleet_end'];
		$ts = $row['timestamp'];
		$closed = $row['closed'];
		}
	?>
	<form name="form1" method="post" action="fleetformsubmit.php">
		<!-- <input type="hidden" name="mode" value="modify"> -->
		<input type="hidden" name="timestamp" value=<? echo "\"".$ts."\""; ?>>
		<input type="hidden" name="fleet_id" value=<? echo "\"".$fid."\""; ?>>
		<input type="hidden" name="adv" value="n">
		<table width="600" border="0" align="center" cellpadding="4" cellspacing="2" valign="middle">
		  <tr>
			<td colspan="2"><img src="tracker_add.jpg" width="600" height="84" alt="tracker"></td>
		  </tr>
		  <tr>
			<td ><br><br>Fleet Name :</td>
			<td><br><br><input name="fleet_name" type="text" id="fleet_name" size="77" value="<? echo $fn; ?>"></td>
		  </tr>
		  <tr>
			<td colspan="2" align="center"><br>
			<input type="submit" name="Submit" value="Modify"><? if ($closed == 1) { echo "<input type=\"submit\" name=\"Submit\" value=\"Re-Open Fleet\">";} else {echo "<input type=\"submit\" name=\"Submit\" value=\"Close Fleet\">";} ?> </td>
			<!-- <td> </td> -->
		  </tr>
		</table>
	</form>
	<?
	}
	else
	{
	?>
	<form name="form1" method="post" action="fleetformsubmit.php">
		<!-- <input type="hidden" name="mode" value="add"> -->
		<table width="600" border="0" align="center" cellpadding="4" cellspacing="2" valign="middle">
		  <tr>
			<td colspan="4"><img src="tracker_add.jpg" width="600" height="84" alt="tracker"></td>
		  </tr>
		  <tr>
			<td width="95"><br><br>Fleet Name :</td>
			<td colspan="3"><br><br><input name="fleet_name" type="text" id="fleet_name" size="93"></td>
		  </tr>
		  <tr>
			<!-- <input  name="fleet_start" type="text" id="fleet_start" size="25" value=><a href="javascript:NewCal('fleet_start','yyyymmdd',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td> -->
			<!-- <td><br>End Time :</td>
			<td><br><input name="fleet_end" type="text" id="fleet_end" size="25"><a href="javascript:NewCal('fleet_end','yyyymmdd',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>	  
		  -->
		  <td>
		  	    <style type="text/css">
  				#fleet_start, #fleet_end {
    			background-image:url("cal.gif");
    			background-position:right center;
    			background-repeat:no-repeat; }
			</style>
			Start: <input name="fleet_start" type="text" id="fleet_start" size="30"/>
			Finish: <input name="fleet_end" type="text" id="fleet_end" size="30" />
			<input type="button" id="fleet_now" value="now" />
			<input type="button" id="fleet_clear" value="clear" />
			<script>
			var oneDay = 24*60*60*1000;
			var twoHour = 2*60*60*1000;
  			var rangeDemoFormat = "%Y-%m-%d %H:%i:%s";
  			var rangeDemoConv = new AnyTime.Converter({format:rangeDemoFormat});
  			var eveConv = new AnyTime.Converter({format:rangeDemoFormat,utcFormatOffsetImposed:0});
  			
  			var start = new Date();
  			start.setSeconds(0);
  			var end = new Date(Date.parse(start.toString())+twoHour);
			end.setSeconds(0);
			var fromDay = start.getTime();
			
			var oneDayLater = new Date(fromDay+oneDay);
			oneDayLater.setHours(23,59,59,999);
			//alert(start.toString());
			
  			//now button
  			$("#fleet_now").click( function(e) {
  			  	var start = new Date();
  				start.setSeconds(0);
  				var end = new Date(Date.parse(start.toString())+twoHour);
				end.setSeconds(0);
      			$("#fleet_start").val(eveConv.format(start)).change(); 
      			$("#fleet_end").val(eveConv.format(end)).change();
      		} );
      			
      		//clear button	
  			$("#fleet_clear").click( function(e) {
      			$("#fleet_start").val("").change(); } );
      		
      		//set defaults	
      		$("#fleet_start").AnyTime_picker({format:rangeDemoFormat,askSecond:false}).val(eveConv.format(start)).change();
  			$("#fleet_end").AnyTime_picker({earliest: eveConv.format(start), format: rangeDemoFormat,latest: oneDayLater,askSecond: false}).val(eveConv.format(end)).change();

			//Set the 
  			$("#fleet_start").change( function(e) { 
  				try {
  					
      				var fromDay = eveConv.parse($("#fleet_start").val()).getTime();
					var startDay = new Date(fromDay);
      				//var oneDayLater = new Date(fromDay+oneDay);
      				//oneDayLater.setHours(23,59,59,999);
      				//rangeDemoConv.format(dayLater)
      				$("#fleet_end").AnyTime_noPicker().removeAttr("disabled").val(eveConv.format(end)).AnyTime_picker(
      				{ 
              			earliest: startDay,
                		format: rangeDemoFormat,
                		latest: oneDayLater,
                		askSecond: false
              		} );
      			} catch(e){ $("#fleet_end").val("").attr("disabled","disabled"); } } );
			</script>
			</td>
		  </tr>
		  <tr>
		  	<td colspan="4"><!-- <font size="2">Note : Fleet Start and End times <strong>must</strong> be in Eve time and in the format YYYY-MM-DD HH:MM:SS</font> --></td>
		  </tr>	
		  <tr>
			<td colspan="4" align="center"><br>
			<input type="submit" name="Submit" value="Submit"></td>
			<!-- <td> </td> -->
		  </tr>
		</table>
	</form>
	<?
	}
	?>
</BODY> 
</HTML>
