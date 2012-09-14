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
	<form name="form1" method="post" action="fleetformsubmit.php?mode=add">
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
		  	<!-- <style type="text/css">
  				#fleet_start, #fleet_end {
    			background-image:url("cal.gif");
    			background-position:right center;
    			background-repeat:no-repeat; }
			</style>
			Start: <input name="fleet_start" type="text" id="fleet_start" size="30"/>
			Finish: <input name="fleet_end" type="text" id="fleet_end" size="30" />
			<input type="button" id="fleet_today" value="today" />
			<input type="button" id="fleet_clear" value="clear" />
			<input type="button" id="fleet_eve" value="Convert to Eve" />
			<script>
			var oneDay = 24*60*60*1000;
			var twoHour = 2*60*60*1000;
  			var rangeDemoFormat = "%Y-%m-%d %H:%i:%s";
  			var rangeDemoConv = new AnyTime.Converter({format:rangeDemoFormat});
  			var eveConv = new AnyTime.Converter({format:rangeDemoFormat,utcFormatOffsetImposed:0});
  			var now = new Date();
  			now.setSeconds(0);

  			$("#fleet_today").click( function(e) {
      			$("#fleet_start").val(rangeDemoConv.format(now)).change(); } );
  			$("#fleet_clear").click( function(e) {
      			$("#fleet_start").val("").change(); } );
      		$("#fleet_eve").click( function(e) {
				var starts = eveConv.format(eveConv.parse($("#fleet_start").val()));
				var ends = eveConv.format(eveConv.parse($("#fleet_end").val()));   		
      		
      			$("#fleet_start").val(starts).change();
      			$("#fleet_end").val(ends).change();
      			} );
			$("#fleet_start").AnyTime_picker({format:rangeDemoFormat,askSecond:false}).val(rangeDemoConv.format(now)).change();
            
			var endt = rangeDemoConv.parse($("#fleet_start").val()).getTime();
      		var end = new Date(endt+twoHour);
  			$("#fleet_end").AnyTime_picker({format: rangeDemoFormat,askSecond: false}).val(rangeDemoConv.format(end)).change();

  			$("#fleet_start").change( function(e) { 
  				try {
  					
      				var fromDay = rangeDemoConv.parse($("#fleet_start").val()).getTime();
      				var dayLater = new Date(fromDay+twoHour);

      				var ninetyDaysLater = new Date(fromDay+(90*oneDay));
      				ninetyDaysLater.setHours(23,59,59,999);
      				$("#fleet_end").AnyTime_noPicker().removeAttr("disabled").val(rangeDemoConv.format(dayLater)).AnyTime_picker(
      				{ 
              			earliest: dayLater,
                		format: rangeDemoFormat,
                		latest: ninetyDaysLater,
                		askSecond: false
              		} );
              		
      			} catch(e){ $("#fleet_end").val("").attr("disabled","disabled"); } } );
			</script> -->
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
</BODY> 
</HTML>
