<?php

// Called in: Structure->Blocks->'Instrument Status'

try {
	
global $databases; 
$server = $databases['srag_dev']['write']['host'];
$username = $databases['srag_dev']['write']['username'];
$password = $databases['srag_dev']['write']['password'];
$database = $databases['srag_dev']['write']['database2'];
$connection = mssql_connect($server, $username, $password);

if($connection != FALSE) {
// echo "Connected to the database server OK<br />";
} else {
	die("Couldn't connect");
}

if(mssql_select_db($database, $connection)) {
// echo "Selected $database ok<br />";
} else {
	die('Failed to select DB');
}

//check for acknowledgements and update them so they are displayed
if (isset($_POST['TEPC_box'])) {
	mssql_query('UPDATE ISSInstrumentCheck SET TEPC="Yellow"');
}

if (isset($_POST['EV1_box'])) {
	mssql_query('UPDATE ISSInstrumentCheck SET EV1="Yellow"');
}

if (isset($_POST['EV2_box'])) {
	mssql_query('UPDATE ISSInstrumentCheck SET EV2="Yellow"');
}

if (isset($_POST['EV3_box'])) {
	mssql_query('UPDATE ISSInstrumentCheck SET EV3="Yellow"');
}

if (isset($_POST['IVTEPC_box'])) {
	mssql_query('UPDATE ISSInstrumentCheck SET IVTEPC="Yellow"');
}

if (isset($_POST['RAD_box'])) {
	mssql_query('UPDATE ISSInstrumentCheck SET RAD="Yellow"');
}

$query_result = mssql_query('SELECT * FROM ISSInstrumentCheck');
$row = mssql_fetch_array($query_result);

if($row != FALSE) {
	$TEPC = $row['TEPC'];
	$IVTEPC = $row['IVTEPC'];
	$RAD = $row['RAD'];
	$EV1 = $row['EV1'];
	$EV2 = $row['EV2'];
	$EV3 = $row['EV3'];
} else {
	die("No query results");
}

mssql_free_result($query_result);
mssql_close($connection);

$table = "<table style=\"width:100%; border: 1px solid black; table-layout: fixed;\">";
$table .= "<tr style=\"border: 1px solid black;\">";
$table .= "<td><center><strong style=\"font-size:20px;\">Instrument</strong></center></td>";
$table .= "<td><center><strong style=\"font-size:20px;\">TEPC</strong></center></td>";
$table .= "<td><center><strong style=\"font-size:20px;\">IV-TEPC</strong></center></td>";
$table .= "<td><center><strong style=\"font-size:20px;\">Rad Detector</strong></center></td>";
$table .= "<td><center><strong style=\"font-size:20px;\">EV1-CPDS</strong></center></td>";
$table .= "<td><center><strong style=\"font-size:20px;\">EV2-CPDS</strong></center></td>";
$table .= "<td><center><strong style=\"font-size:20px;\">EV3-CPDS</strong></center></td>";
$table .= "</tr>";

$table .= "<tr style=\"border: 1px solid black;\">";
$table .= "<td><center><strong style=\"font-size:20px;\">Status</strong></center></td>";
if ($TEPC[0] == "G") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Green.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Green]\"></center></td>";
} elseif ($TEPC[0] == "Y") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Yellow.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Yellow]\"></center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Red.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Red]\"></center></td>";
}

if ($IVTEPC[0] == "G") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Green.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Green]\"></center></td>";
} elseif ($IVTEPC[0] == "Y") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Yellow.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Yellow]\"></center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Red.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Red]\"></center></td>";
}

if ($RAD[0] == "G") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Green.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Green]\"></center></td>";
} elseif ($RAD[0] == "Y") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Yellow.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Yellow]\"></center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Red.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Red]\"></center></td>";
}

if ($EV1[0] == "G") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Green.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Green]\"></center></td>";
} elseif ($EV1[0] == "Y") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Yellow.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Yellow]\"></center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Red.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Red]\"></center></td>";
}

if ($EV2[0] == "G") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Green.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Green]\"></center></td>";
} elseif ($EV2[0] == "Y") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Yellow.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Yellow]\"></center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Red.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Red]\"></center></td>";
}

if ($EV3[0] == "G") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Green.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Green]\"></center></td>";
} elseif ($EV3[0] == "Y") {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Yellow.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Yellow]\"></center></td>";
} else {
	$table .= "<td style=\"background-color:black;\"><center><img src=\"/sites/default/files/Red.gif\" width=\"40\" height=\"40\" border=\"0\" alt=\"[Red]\"></center></td>";
}

$table .= "</tr>";
$table .= "</table>";
echo $table;

	
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


?>

<script>
setInterval(function() {location.reload();},60000);
</script>