<?php

// Called in: Configuration->Workflow->Rules->Components->'instrument status updater'->'Execute custom PHP code'

try {

global $databases; 
//use 'write' for update permissions
$server = $databases['srag_dev']['write']['host'];
$username = $databases['srag_dev']['write']['username'];
$password = $databases['srag_dev']['write']['password'];
$database = $databases['srag_dev']['write']['database2'];
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

//very simple more concise query function
function get_query($q) {
	$qResult = mssql_query($q);
	$row = mssql_fetch_array($qResult);
	return $row;
}

//get all of the most recent data times and store them
$instrChk = array();
$row = get_query('SELECT max(RecDate) FROM ISSTEPC');
if ($row != FALSE) { $instrChk['TEPC'] = $row[0]; }
$row = get_query('SELECT max(RecDate) FROM ISSEVCPDS1');
if ($row != FALSE) { $instrChk['EV1'] = $row[0]; }
$row = get_query('SELECT max(RecDate) FROM ISSEVCPDS2');
if ($row != FALSE) { $instrChk['EV2'] = $row[0]; }
$row = get_query('SELECT max(RecDate) FROM ISSEVCPDS3');
if ($row != FALSE) { $instrChk['EV3'] = $row[0]; }
$row = get_query('SELECT max(RecDate) FROM ISSIVTEPC');
if ($row != FALSE) { $instrChk['IVTEPC'] = $row[0]; }
$row = get_query('SELECT max(RecDate) FROM ISSRAD');
if ($row != FALSE) { $instrChk['RAD'] = $row[0]; }

//stores how long ago last received data was
$lastRcvd = array();
$lastRcvd['TEPC'] = strtotime('now',time()) - strtotime($instrChk['TEPC'], time());
$lastRcvd['EV1'] = strtotime('now',time()) - strtotime($instrChk['EV1'], time());
$lastRcvd['EV2'] = strtotime('now',time()) - strtotime($instrChk['EV2'], time());
$lastRcvd['EV3'] = strtotime('now',time()) - strtotime($instrChk['EV3'], time());
$lastRcvd['IVTEPC'] = strtotime('now',time()) - strtotime($instrChk['IVTEPC'], time());
$lastRcvd['RAD'] = strtotime('now',time()) - strtotime($instrChk['RAD'], time());

//if there has been data within the last 90 minutes, update to green.
$threshold = 5 * 60; //5 minutes in seconds
if ($lastRcvd['TEPC'] < $threshold) { mssql_query('UPDATE ISSInstrumentCheck SET TEPC = "Green"'); }
if ($lastRcvd['EV1'] < $threshold) { mssql_query('UPDATE ISSInstrumentCheck SET EV1 = "Green"'); }
if ($lastRcvd['EV2'] < $threshold) { mssql_query('UPDATE ISSInstrumentCheck SET EV2 = "Green"'); }
if ($lastRcvd['EV3'] < $threshold) { mssql_query('UPDATE ISSInstrumentCheck SET EV3 = "Green"'); }
if ($lastRcvd['IVTEPC'] < $threshold) { mssql_query('UPDATE ISSInstrumentCheck SET IVTEPC = "Green"'); }
if ($lastRcvd['RAD'] < $threshold) { mssql_query('UPDATE ISSInstrumentCheck SET RAD = "Green"'); }

//FUTURE IMPLEMENTATION: Check if any instruments are red, and then send an email notifier.

mssql_close($connection);

} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>
