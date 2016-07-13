<?php

// Called in: Structure->Blocks->'console duty information'

try {

	global $databases; 
	$server = $databases['srag_dev']['default']['host'];
	$username = $databases['srag_dev']['default']['username'];
	$password = $databases['srag_dev']['default']['password'];
	$database = $databases['srag_dev']['default']['database1'];
	$connection = mssql_connect($server, $username, $password);
	 
	if($connection != FALSE)
	{
	// echo "Connected to the database server OK<br />";
	}
	else
	{
		die("Couldn't connect");
	}
	 
	if(mssql_select_db($database, $connection))
	{
	// echo "Selected $database ok<br />";
	}
	else
	{
		die('Failed to select DB');
	}
	 
	$query_result = mssql_query('SELECT * FROM Status');
	$row = mssql_fetch_array($query_result);
	 
	if($row != FALSE)
	{
		$ConsoleStatus = $row[2];
		$ConsoleStatusDate = $row[3];
		// echo "Console Status is {$row[2]}<br />";
		// echo "Console Status Date is {$row[3]}<br />";
	} else {
		die("No query results");
	}

	// get today's date and format it for query
	$tdate = getdate();
	$spacer = " ";
	if(strlen($tdate['mday']) < 2) {
		$spacer .= " "; // spacer gets extra space for single digit month days
	}
	$d = substr($tdate['month'],0,3) . $spacer . $tdate['mday'] . " " . $tdate['year'];

	// sample test date
	//$d = "Sep 18 2013";

	$query_result = mssql_query("SELECT * FROM ShiftSchedule WHERE LEFT(dte,11)='" . $d . "'");
	$row = mssql_fetch_array($query_result);
	if($row) {
		$ShiftConsole = $row[3];
		$ShiftCall = $row[4];
	}

	$date = explode("-",$ConsoleStatusDate);
	$day = $date[0];
	$month = $date[1];
	$year = explode(" ",$date[2])[0];
	$cstatus = "Console Manning Status is<br>";
	if($ConsoleStatus == "Green") {
		$cstatus .= "<b>OnConsole</b>.";
	} else {
		$cstatus .= "<b>Off Console/On Pager</b>.";
	}

	echo $ShiftConsole . " is primary.<br>";
	if (isset($ShiftCall)) {
		echo $ShiftCall . " is backup.";
	} else {
		echo "No backup is assigned.";
	}
	echo "<br>";
	echo $cstatus;


	mssql_free_result($query_result);
	mssql_close($connection);

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
