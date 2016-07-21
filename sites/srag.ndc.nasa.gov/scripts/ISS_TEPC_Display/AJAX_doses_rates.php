<?php

try {

// define('DRUPAL_ROOT', '/opt/bitnami/apps/drupal/htdocs/'); //the most important line
// require_once '../../../../includes/bootstrap.inc';
// drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

if(!array_key_exists("method",$_GET) || htmlspecialchars($_GET["method"]) != "vxtgh") {
	echo("Unable to authorize.");
} else {

global $databases;
$server = $databases['srag_dev']['default']['host'];
$username = $databases['srag_dev']['default']['username'];
$password = $databases['srag_dev']['default']['password'];
$database = $databases['srag_dev']['default']['database2']; //Doses-Dev
$connection = mssql_connect($server, $username, $password);

//check connection
if($connection != FALSE) {
// echo "Connected to the database server OK<br />";
} else {
	echo "Couldn't connect<br>";
}

//select database and check 
if(mssql_select_db($database, $connection)) {
// echo "Selected $database ok<br />";
} else {
	echo "Failed to select DB<br>" ;
}

$tdate = date("Y-m-d H:i:s", strtotime('now',time()));
$pdate = date("Y-m-d H:i:s", strtotime('-24 hours', time()));

$q = 'SELECT ISSTEPC.RecDate, ISSTEPC.DoseRate, ISSStateVectors.Lat1, ISSStateVectors.Lon1 FROM ISSTEPC INNER JOIN ISSStateVectors ON ISSTEPC.RecDate = ISSStateVectors.RecDate WHERE (ISSTEPC.RecDate >= "'. $pdate . '" AND ISSTEPC.RecDate <= "'. $tdate . '" AND ISSStateVectors.Lat1 Is Not Null AND ISSStateVectors.Lon1 Is Not Null AND ISSTEPC.DoseRate Is Not Null ) order by ISSTEPC.RecDate';
$qResult = mssql_query($q);
$data = '[';
while ($row = mssql_fetch_array($qResult)) {
	// $d = date("Y-m-d\TH:i:s-00:00", strtotime($row["RecDate"],time()));
 	$data .= '"' . $row["Lat1"] . "," . $row["Lon1"] . "," . $row["DoseRate"] . '",';
}
$data = trim($data,",");
$data .= "]";
echo '<div id="ajax_data" style="word-break:break-all;">';
echo $data;
echo '</div>';

mssql_close($connection);
}
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
