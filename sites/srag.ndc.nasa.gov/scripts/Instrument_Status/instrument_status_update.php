<?php

// Called in: Structure->Blocks->'instrument status update (srag only)'

try {

global $databases; 
$server = $databases['srag_dev']['default']['host'];
$username = $databases['srag_dev']['default']['username'];
$password = $databases['srag_dev']['default']['password'];
$database = $databases['srag_dev']['default']['database2'];
$connection = mssql_connect($server, $username, $password);

//check connection
if($connection != FALSE) {
// echo "Connected to the database server OK<br />";
} else {
	die("Couldn't connect");
}

//select database and check 
if(mssql_select_db($database, $connection)) {
// echo "Selected $database ok<br />";
} else {
	die('Failed to select DB');
}

$query_result = mssql_query('SELECT * FROM ISSInstrumentCheck');
$status = mssql_fetch_array($query_result);
if($status == FALSE) {
	die("No query results");
}

//create and store checkboxes:
$checkboxes = array();
$checkboxes['TEPC'] = '<input type="checkbox" name="TEPC_box" value="1">';
$checkboxes['EV1'] = '<input type="checkbox" name="EV1_box" value="1">';
$checkboxes['EV2'] = '<input type="checkbox" name="EV2_box" value="1">';
$checkboxes['EV3'] = '<input type="checkbox" name="EV3_box" value="1">';
$checkboxes['IVTEPC'] = '<input type="checkbox" name="IVTEPC_box" value="1">';
$checkboxes['RAD'] = '<input type="checkbox" name="RAD_box" value="1">';

//create table:
$table = "<table role='presentation' style=\"width:100%; border: 1px solid black; table-layout: fixed;\">";
$table .= "<tr style=\"border: 1px solid black;\">";
$table .= "<td><center><strong style=\"font-size:20px;\">Acknowledge</strong></center></td>";
if($status['TEPC'][0] == 'R') {
	$table .= "<td style=\"background-color:black;\"><center>" . $checkboxes['TEPC'] . "</center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center>" . "</center></td>";
}

if($status['IVTEPC'][0] == 'R') {
	$table .= "<td style=\"background-color:black;\"><center>" . $checkboxes['IVTEPC'] . "</center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center>" . "</center></td>";
}

if($status['RAD'][0] == 'R') {
	$table .= "<td style=\"background-color:black;\"><center>" . $checkboxes['RAD'] . "</center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center>" . "</center></td>";
}

if($status['EV1'][0] == 'R') {
	$table .= "<td style=\"background-color:black;\"><center>" . $checkboxes['EV1'] . "</center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center>" . "</center></td>";
}

if($status['EV2'][0] == 'R') {
	$table .= "<td style=\"background-color:black;\"><center>" . $checkboxes['EV2'] . "</center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center>" . "</center></td>";
}

if($status['EV3'][0] == 'R') {
	$table .= "<td style=\"background-color:black;\"><center>" . $checkboxes['EV3'] . "</center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center>" . "</center></td>";
}

$table .= "</tr>";
$table .= "</table>";

echo '<form method="post">';
echo $table;
echo '<center><input type="submit" name="submit" value="Submit" style="font-size:20px"></center>';
echo '</form>';

mssql_close($connection);

} catch (Exception $e) {
	echo 'Caught Exception: ', $e->getMessage(), "\n";
}

?>
