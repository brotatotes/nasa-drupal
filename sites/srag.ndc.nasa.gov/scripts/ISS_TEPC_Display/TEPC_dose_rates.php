<?php


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

$q = 'SELECT ISSTEPC.RecDate, ISSTEPC.DoseRate, ISSStateVectors.Lat1, ISSStateVectors.Lon1 FROM ISSTEPC INNER JOIN ISSStateVectors ON ISSTEPC.RecDate = ISSStateVectors.RecDate WHERE (ISSTEPC.RecDate >= "'. $pdate . '" AND ISSTEPC.RecDate <= "'. $tdate . '" AND ISSStateVectors.Lat1 Is Not Null AND ISSStateVectors.Lon1 Is Not Null AND ISSTEPC.DoseRate Is Not Null ) order by ISSTEPC.RecDate';
$qResult = mssql_query($q);
$data = '[';
while ($row = mssql_fetch_array($qResult)) {
	// $d = date("Y-m-d\TH:i:s-00:00", strtotime($row["RecDate"],time()));
 	$data .= '"' . $row["Lat1"] . "," . $row["Lon1"] . "," . $row["DoseRate"] . '",';
}
$data = trim($data,",");
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
	drupal_add_js('/sites/srag.ndc.nasa.gov/modules/CUSTOM/srag_chart/LLPlot.js','file'); 
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<div align="center" style="width:100%; height:500px;"> 
<canvas style="background-image:url('/sites/srag.ndc.nasa.gov/files/world766x400.jpg');" id="llplot" width="766" height="400"></canvas>
 
<br>

<img src="/sites/srag.ndc.nasa.gov/files/DoseLegend.jpg" width="793" height="24" border="0" alt="Dose Legend"><br>
<img src="/sites/srag.ndc.nasa.gov/files/DoseLegend2.jpg" width="114" height="31" border="0" alt="Dose Legend2">
</div>

<script>
var data = '<?php echo $data; ?>';
data = JSON.parse(data);
function updateLLPlot() {
	try {
		var latArray = [];
		var lonArray = [];
		var doseArray = [];
		$.each(data, function(index, value)
		{
			//console.log(value);
			//no header in returned data
			var row = value.split(",");
			//row[0] = new Date(row[0]); 
		  	// Turn the string date into a Date. Dygraphs is very picky about this.		      
		    for (var rowIdx = 0; rowIdx < row.length; rowIdx++) {
		      // Turn "123" into 123.
		      row[rowIdx] = parseFloat(row[rowIdx]);
		    }
			console.log(row[0],row[1]);
			latArray.push(row[0]);
			lonArray.push(row[1]);
			doseArray.push(row[2]);
		});//end each
		//update the plot
		var canvas = document.getElementById("llplot");
		var ctx = canvas.getContext("2d");
		//if redrawing, clear existing dots
		ctx.clearRect(0,0,766,400);
		drawPlot("2.12",latArray,lonArray,doseArray);
	} catch(err) {
		console.log("UpdateLLPlot error: " + err.message);
	}
}
updateLLPlot();
setInterval(function() {location.reload();},60000);
</script>
