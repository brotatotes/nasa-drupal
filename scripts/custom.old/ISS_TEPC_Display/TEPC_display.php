<?php
// Called in: Structure->Blocks->"ISS TEPC Cumulative Dose & Dose Data"

try {

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
	die("Couldn't connect");
}

//select database and check 
if(mssql_select_db($database, $connection)) {
// echo "Selected $database ok<br />";
} else {
	die('Failed to select DB');
}


$tdate = date("Y-m-d H:i:s", strtotime('now',time()));
$pdate = date("Y-m-d H:i:s", strtotime('-24 hours', time()));

$qResult = mssql_query('SELECT * FROM ISSTEPC WHERE RecDate >= "' . $pdate . '" and RecDate <= "' . $tdate . '" order by RecDate');
$data = '["Date,DoseRate,CumDose"';
while ($row = mssql_fetch_array($qResult)) {
	$d = date("Y-m-d\TH:i:s-00:00", strtotime($row["RecDate"],time()));
    $data .= ',"' . $d . "," . $row["DoseRate"] . "," . $row["CumDose"] . '"';
}
$data .= "]";

mssql_close($connection);

} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<?php
try {
	drupal_add_js('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js','external');
	drupal_add_js('http://dygraphs.com/1.1.1/dygraph-combined.js','external');
	drupal_add_js('/sites/all/modules/CUSTOM/srag_chart/SRAGChart.js','file');
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<div align="center">
<div id="demodiv" name="demodiv" style="width: 100%; height: 360px"></div>
<div style="font-family:arial;color:black;font-size:15px;font-style:italic">Click and drag left/right or up/down to zoom. Dbl Click to restore.</div>
<script>
try {
	var data = '<?php echo $data; ?>';
	data = JSON.parse(data);
	var g;
	var dcArray = [];
	$.each(data, function(index, value)
	{
   		//console.log(value);
   		if (index > 0 ) {
	   		var row = value.split(",");
	   		row[0] = new Date(row[0]); 
	      	// Turn the string date into a Date. Dygraphs is very picky about this.		      
		    for (var rowIdx = 1; rowIdx < row.length; rowIdx++) {
		      // Turn "123" into 123.
		      row[rowIdx] = parseFloat(row[rowIdx]);
		    }    
	   		dcArray.push(row);
   		}
	});
	g = drawChart(dcArray,"ISS TEPC Cumulative Dose & Dose Data", "blue", "red", 15);
} catch(err) {
	console.log("TEPC Display error: " + err.message);
}

setInterval(function() {location.reload();},60000);
</script>

