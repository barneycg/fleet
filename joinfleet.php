<?php ?>
<HTML>
<BODY style="background-image:url(bg.jpg);background-color:black;color:white">
<?
ob_start();
$config = parse_ini_file("ft.ini", true);
//$con = mysql_connect($config['mysql']['host'],$config['mysql']['user'],$config['mysql']['password']);

$pdo = new PDO("mysql:host=".$config['mysql']['host'].";dbname=".$config['mysql']['db_name'], $config['mysql']['user'], $config['mysql']['password']);

// PDO, prepared statement
$i = $pdo->prepare('replace into fleet_tracking(fleet_id,timestamp,char_name,char_id,corp_name,corp_id,alliance_name,alliance_id,ship_type,ship_type_id,location) values( :fleet_id,:timestamp,:char_name,:char_id,:corp_name,:corp_id,:alliance_name,:alliance_id,:ship_type,:ship_type_id,:location)');

$fleet_id=$_POST['fleet_id'];
$char_name=$_POST['char_name'];
$char_id=$_POST['char_id'];
$corp_name=$_POST['corp_name'];
$corp_id=$_POST['corp_id'];
$alliance_name=$_POST['alliance_name'];
$alliance_id=$_POST['alliance_id'];
$ship_type=$_POST['ship_type'];
$ship_type_id=$_POST['ship_type_id'];
$location=$_POST['location'];
$timestamp=$_POST['timestamp'];

$i->execute(array(':fleet_id'=>$fleet_id,':timestamp'=>$timestamp,':char_name'=>$char_name,':char_id'=>$char_id,':corp_name'=>$corp_name,':corp_id'=>$corp_id,':alliance_name'=>$alliance_name,':alliance_id'=>$alliance_id,':ship_type'=>$ship_type,':ship_type_id'=>$ship_type_id,':location'=>$location));

?>
<b>Thank you for joining the fight</b>
</BODY>
</HTML>