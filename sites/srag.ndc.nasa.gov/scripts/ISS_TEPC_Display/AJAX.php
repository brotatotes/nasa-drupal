<?php
// Content->TEPX AJAX->Panel Content

try {

// these three lines make the global variable $databases work on an external plain php page:
// define('DRUPAL_ROOT', '/opt/bitnami/apps/drupal/htdocs/'); //the most important line
// require_once '../../../../includes/bootstrap.inc';
// drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

//url should look something like: srag.ndc.nasa.gov/node/86?key=vxtgh&data=DoseRates
// data can be DoseData, DoseRates, or DoseData (not case sensitive)
if(!array_key_exists("data",$_GET) || !array_key_exists("key",$_GET)) { //check if they exist first
	echo "Unable to authorize."; 
} elseif(strtolower(htmlspecialchars($_GET["key"])) == "vxtgh") {
	if(strtoupper(htmlspecialchars($_GET["data"])) == "DOSERATES") {

		global $databases;
		$server = $databases['srag_dev']['default']['host'];
		$username = $databases['srag_dev']['default']['username'];
		$password = $databases['srag_dev']['default']['password'];
		$database = $databases['srag_dev']['default']['database2']; //Doses-Dev
		$connection = mssql_connect($server, $username, $password);

		//check connection
		if($connection == FALSE) { echo "Couldn't connect<br>"; }

		//select database and check 
		if(!mssql_select_db($database, $connection)) { echo "Failed to select DB<br>" ; }

		$today = date("Y-m-d H:i:s", strtotime('now',time()));
		$yesterday = date("Y-m-d H:i:s", strtotime('-24 hours', time()));

		$q = 'SELECT ISSTEPC.RecDate, ISSTEPC.DoseRate, ISSStateVectors.Lat1, ISSStateVectors.Lon1 FROM ISSTEPC INNER JOIN ISSStateVectors ON ISSTEPC.RecDate = ISSStateVectors.RecDate WHERE (ISSTEPC.RecDate >= "'. $yesterday . '" AND ISSTEPC.RecDate <= "'. $today . '" AND ISSStateVectors.Lat1 Is Not Null AND ISSStateVectors.Lon1 Is Not Null AND ISSTEPC.DoseRate Is Not Null ) order by ISSTEPC.RecDate';
		$result = mssql_query($q);

		// id="ajax_data" so ajax calls can find it
		$data = '<div id="ajax_data">'; 
		$data .= '[';
		$row = mssql_fetch_array($result);
		$data .= '"' . $row["Lat1"] . "," . $row["Lon1"] . "," . $row["DoseRate"] . '"';
		while ($row = mssql_fetch_array($result)) {
		 	$data .= ',"' . $row["Lat1"] . "," . $row["Lon1"] . "," . $row["DoseRate"] . '"';
		}
		$data .= ']';
		$data .= '</div>';
		echo $data;

		mssql_close($connection);

	} elseif(strtoupper(htmlspecialchars($_GET["data"])) == "DOSEDATA") {

		global $databases; 
		$server = $databases['srag_dev']['default']['host'];
		$username = $databases['srag_dev']['default']['username'];
		$password = $databases['srag_dev']['default']['password'];
		$database = $databases['srag_dev']['default']['database2']; //Doses-Dev
		$connection = mssql_connect($server, $username, $password);

		//check connection
		if($connection == FALSE) { echo "Couldn't connect<br>"; }

		//select database and check 
		if(!mssql_select_db($database, $connection)) { echo "Failed to select DB<br>"; }


		$today = date("Y-m-d H:i:s", strtotime('now',time()));
		$yesterday = date("Y-m-d H:i:s", strtotime('-24 hours', time()));

		$result = mssql_query('SELECT * FROM ISSTEPC WHERE RecDate >= "' . $yesterday . '" and RecDate <= "' . $today . '" order by RecDate');
		// id="ajax_data" so ajax calls can find it
		$data = '<div id="ajax_data">';
		$data .= '["Date,DoseRate,CumDose"';
		while ($row = mssql_fetch_array($result)) {
			$d = date("Y-m-d\TH:i:s-00:00", strtotime($row["RecDate"],time()));
		    $data .= ',"' . $d . "," . $row["DoseRate"] . "," . $row["CumDose"] . '"';
		}
		$data .= "]";
		$data .= '</div>';
		echo $data;

		mssql_close($connection);

	} elseif(strtoupper(htmlspecialchars($_GET["data"])) == "TEXTDATA") {

		global $databases; 
		$server = $databases['srag_dev']['default']['host'];
		$username = $databases['srag_dev']['default']['username'];
		$password = $databases['srag_dev']['default']['password'];
		$database1 = $databases['srag_dev']['default']['database2']; //Doses-Dev
		$database2 = $databases['srag_dev']['default']['database3']; //Instruments-Dev
		$connection = mssql_connect($server, $username, $password);

		//check connection
		if($connection == FALSE) { echo "Couldn't connect<br>"; }

		//select database and check 
		if(!mssql_select_db($database1, $connection)) { echo "Failed to select DB<br>"; }

		$q1 = 'SELECT max(Cycle) as MaxCycle from ISSTEPC';
		$result1 = mssql_query($q1);
		$MaxCycle = mssql_fetch_array($result1)["MaxCycle"];

		$q2 = 'SELECT top 1 * from ISSTEPC where Cycle = "' . $MaxCycle . '" order by ElapsedTime desc';
		$result2 = mssql_query($q2);
		$LastRecord = mssql_fetch_array($result2);

		$q3 = 'SELECT * from TEPCStatus';
		$result3 = mssql_query($q3);
		$Status = mssql_fetch_array($result3);

		$q4 = 'SELECT * from TEPCRTM where code = "' . $Status["RealTimeMonitor"] . '"';
		$result4 = mssql_query($q4);
		$RTM = mssql_fetch_array($result4);

		// get dates
		$yesterday = date("Y-m-d 00:00:00", strtotime('-24 hours', time()));
		$today = date("Y-m-d 00:00:00", strtotime('now', time()));

		$q5 = 'SELECT distinct cycle from ISSTEPC where RecDate >= "' . $yesterday . '" and RecDate < "' . $today . '"';
		$result5 = mssql_query($q5);
		$YesterdayCycle = mssql_fetch_array($result5)["cycle"];

		$q6 = 'SELECT Min(CumDose) as MinDose, Min(CumDoseEquiv) as MinDoseEquiv, Max(CumDose) as MaxDose, Max(CumDoseEquiv) as MaxDoseEquiv from ISSTEPC where Cycle = "' . $YesterdayCycle . '" and RecDate >= "' . $yesterday . '" and RecDate < "' . $today . '"';
		$result6 = mssql_query($q6);
		$YesterdayData = mssql_fetch_array($result6);

		$q7 = 'SELECT distinct cycle from ISSTEPC where RecDate >= "' . $today . '"';
		$result7 = mssql_query($q7);
		$TodayCycle = mssql_fetch_array($result7)["cycle"];

		$q8 = 'SELECT Min(CumDose) as MinDose, Min(CumDoseEquiv) as MinDoseEquiv, Max(CumDose) as MaxDose, Max(CumDoseEquiv) as MaxDoseEquiv from ISSTEPC where Cycle = "' . $TodayCycle . '" and RecDate >= "' . $today . '"';
		$result8 = mssql_query($q8);
		$TodayData = mssql_fetch_array($result8);

		// get 'absolute' dates, including exact time
		$absYesterday = date("F d, Y H:i:s", strtotime('-24 hours',time()));
		$absToday = date("F d, Y H:i:s", strtotime('now',time()));

		$q9 = 'SELECT distinct cycle from ISSTEPC where RecDate >= "' . $absYesterday . '" and RecDate < "' . $absToday . '"';
		$result9 = mssql_query($q9);
		$absYesterdayCycle = mssql_fetch_array($result9)["cycle"];

		$q10 = 'SELECT Min(CumDose) as absMinDose, Min(CumDoseEquiv) as absMinDoseEquiv, Max(CumDose) as absMaxDose, Max(CumDoseEquiv) as absMaxDoseEquiv from ISSTEPC where Cycle = "' . $absYesterdayCycle . '" and RecDate >= "' . $absYesterday . '" and RecDate < "' . $absToday . '"';
		$result10 = mssql_query($q10);
		$absYesterdayData = mssql_fetch_array($result10);
 
		if(!mssql_select_db($database2, $connection)) { echo "Failed to select DB<br>"; }

		$q11 = 'SELECT top 1 * from ActivityLog where Instrument = "TEPC" and Activity = "Location Change" order by LogDate desc';
		$result11 = mssql_query($q11);
		$LogData = mssql_fetch_array($result11);

		//compile result data based on queries
		$result = array();
		$result["DELTANOW"] = time() - strtotime($LastRecord["RecDate"], time());
		$result["GMTDATE"] = date('z') + 1 . "/" . date("H:i:s", strtotime('now',time()));
		$result["CURRENTMODE"] = $Status["CurrentMode"];
		$result["ALARMSTATUS"] = $LastRecord["AlarmStatus"];
		$result["DETECTORSN"] = $LogData["DetectorSN"];
		$result["SPECTROMETERSN"] = $LogData["SpectrometerSN"];
		$result["LOCATION"] = $LogData["Location"];
		$result["POSITION"] = $LogData["Position"];
		$result["RECDATE"] = date('z',strtotime($LastRecord["RecDate"],time())) . "/" . date("H:i:s",strtotime($LastRecord["RecDate"],time()));
		$result["DOSERATE"] = number_format($LastRecord["DoseRate"],3,'.','');
		$result["DOSEEQUIVRATE"] = number_format($LastRecord["DoseEquivRate"],3,'.','');
		$DaysOn = $LastRecord["ElapsedTime"]/1440;
		$result["DAYSON"] = str_pad(intval($DaysOn),3,"0",STR_PAD_LEFT);
		$HoursOn = ($DaysOn - $result["DAYSON"])*24;
		$result["HOURSON"] = str_pad(intval($HoursOn),2,"0",STR_PAD_LEFT);
		$result["MINUTESON"] = str_pad(intval(($HoursOn - $result["HOURSON"])*60),2,"0",STR_PAD_LEFT);
		$result["JYESTERDAY"] = date('z',strtotime('-24 hours',time())) + 1;
		$result["JTODAY"] = $result["JYESTERDAY"]+1;
		$result["ABSYESTERDAY"] = $absYesterday;
		$result["ABSTODAY"] = $absToday;
		$result["CUMDOSE"] = number_format($LastRecord["CumDose"],1,'.','');
		$result["YESTERDAYDOSE"] = number_format(($YesterdayData["MaxDose"]-$YesterdayData["MinDose"]),1,'.','');
		$result["TODAYDOSE"] = number_format(($TodayData["MaxDose"]-$TodayData["MinDose"]),1,'.','');
		$result["ABSYESTERDAYDOSE"] = number_format(($absYesterdayData["absMaxDose"]-$absYesterdayData["absMinDose"]),1,'.','');
		$result["CUMDOSEEQUIV"] = number_format($LastRecord["CumDoseEquiv"],1,'.','');
		$result["YESTERDAYDOSEEQUIV"] = number_format(($YesterdayData["MaxDoseEquiv"]-$YesterdayData["MinDoseEquiv"]),1,'.','');
		$result["TODAYDOSEEQUIV"] = number_format(($TodayData["MaxDoseEquiv"]-$TodayData["MinDoseEquiv"]),1,'.','');
		$result["ABSYESTERDAYDOSEEQUIV"] = number_format(($absYesterdayData["absMaxDoseEquiv"]-$absYesterdayData["absMinDoseEquiv"]),1,'.','');

		if ($Status["Power"] == 1) { $result["POWER"] = "OK"; } 
		else { $result["POWER"] = "ERROR"; }

		if ($LastRecord["FFTCard"] == 1) { $result["FFTCARD"] = "OK"; } 
		else { $result["FFTCARD"] = "ERROR"; }

		if ($LastRecord["CPUCard"] == 1) { $result["CPUCARD"] = "OK"; } 
		else { $result["CPUCARD"] = "ERROR"; }

		if ($LastRecord["MCACard"] == 1) { $result["MCACARD"] = "OK"; } 
		else { $result["MCACARD"] = "ERROR"; }

		if ($LastRecord["DisCard"] == 1) { $result["DISCARD"] = "OK"; } 
		else { $result["DISCARD"] = "ERROR"; }

		if ($LastRecord["MemCard"] == 1) { $result["MEMCARD"] = "OK"; } 
		else { $result["MEMCARD"] = "ERROR"; }

		$result["FIRSTFILE"] = $Status["FirstFile"];
		$result["LASTFILE"] = $Status["LastFile"];
		$result["CURRENTFILE"] = $Status["CurrentFile"];
		$result["REALTIMEMONITOR"] = $Status["RealTimeMonitor"];
		$result["RTMRECORDCOUNT"] = mssql_num_rows($result4);
		$result["RTMDESCRIPTION"] = $RTM["Description"];

		// id="ajax_data" so ajax calls can find it
		echo '<div id="ajax_data">';
		print_r(json_encode($result));
		echo '</div>';
		
		mssql_close($connection);

	} else {
		echo "Unable to authorize.";
	}

} else {
	echo "Unable to authorize.";
}

} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
