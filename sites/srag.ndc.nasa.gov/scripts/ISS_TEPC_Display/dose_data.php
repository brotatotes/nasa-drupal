<?php
// Structure->Blocks->"ISS TEPC Cumulative Dose & Dose Data"
try {
	drupal_add_js('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js','external');
	drupal_add_js('http://dygraphs.com/1.1.1/dygraph-combined.js','external');
	drupal_add_js('/sites/srag.ndc.nasa.gov/modules/CUSTOM/srag_chart/SRAGChart.js','file');
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<div align="center">
<div id="demodiv" name="demodiv" style="width: 100%; height: 360px"></div>
<div style="font-family:arial;color:black;font-size:15px;font-style:italic">Click and drag left/right or up/down to zoom. Dbl Click to restore.</div>
<script>
	
$(document).ready(function() {
	$.ajaxSetup({cache: false});
	var g;
	
	try {
		
		// $.getJSON('../data/TepcDoseChartData.cfc','method=getTEPCDoseChartData',processDoseChartData).error(errorResponse);	
		$.get("http://srag.ndc.nasa.gov/node/86?key=vxtgh&data=DoseData", function (data) {
			data = JSON.parse($(data).find("#ajax_data").text()); //data is in div with id #ajax_data
			processDoseChartData(data);
		});	
	}
	catch (err)
		{
		//alert("Error  in ready: " + err.message);
		console.log("Error  in ready: " + err.message);
		}
});//end ready
	
function updateDoseChartData()
{
	// $.getJSON('../data/TepcDoseChartData.cfc','method=getTEPCDoseChartData',updateDoseChart).error(errorResponse);
	$.get("http://srag.ndc.nasa.gov/node/86?key=vxtgh&data=DoseData", function (data) {
		data = JSON.parse($(data).find("#ajax_data").text()); //data is in div with id #ajax_data
		updateDoseChart(data);
	});		
}
function updateDoseChart(data)	{
	   try
	   {
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
		   //alert("DoseChartData:  "+ dcArray.length);
		   //var g = drawChart(dcArray);
		   g.updateOptions(
			{//reload the updated data
				'file': dcArray
			}	
			);
		}
		catch (err)
		{
			//alert("updateDoseChart error: " + err.message);
			console.log("error in updateDoseChart(): " + err.message);	
		}
		//alert("currentmode: " + currentMode);
}//end updateDoseChart
function processDoseChartData(data)	{
	   
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
	   
		//alert("currentmode: " + currentMode);
}//end processDoseChartData

// function errorResponse() {
// 	//alert("error");
// 	console.log("error from json get24HourTEPCDoseChartData");
// }
setInterval(function() 
	{
		//alert("15 seconds");			
		updateDoseChartData(); //update without refreshing every minute
	},60000);
	

</script>

