<?php
// Structure->Blocks->"ISS TEPC Dose Rates"
try {
	drupal_add_js('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js','external');
	drupal_add_js('http://dygraphs.com/1.1.1/dygraph-combined.js','external');
	drupal_add_js('/sites/srag.ndc.nasa.gov/modules/CUSTOM/srag_chart/LLPlot.js','file'); 
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>

<div align="center" style="width:100%; height:auto; text-align:center; zoom:0.9; -ms-zoom: 0.78; -webkit-zoom: 0.78; -moz-transform: scale(0.78,0.78); -moz-transform-origin: left top;"> 
<canvas style="background-image:url('/sites/srag.ndc.nasa.gov/files/world766x400.jpg');" id="llplot" width="766" height="400"></canvas>
 
<br>

<img src="/sites/srag.ndc.nasa.gov/files/DoseLegend.jpg" width="793" height="24" border="0" alt="Dose Legend"><br>
<img src="/sites/srag.ndc.nasa.gov/files/DoseLegend2.jpg" width="114" height="31" border="0" alt="Dose Legend2">
</div>

<script>

$(document).ready(function() {
	$.ajaxSetup({cache: false});
	
	try {
		// $.getJSON('../data/TepcLLPlotData.cfc','method=getTepcLLPlotData',updateLLPlot).error(errorResponse);
		$.get("http://srag.ndc.nasa.gov/node/86?key=vxtgh&data=DoseRates", function (data) {
			data = JSON.parse($(data).find("#ajax_data").text()); //data is in div with id #ajax_data
			updateLLPlot(data);
		});		
	}
	catch (err)
	{
		//alert("Error  in ready: " + err.message);
		console.log("Error: " + err.message);
	}
});//end ready

function updateLLPlotData()
{
	// $.getJSON('../data/TepcLLPlotData.cfc','method=getTepcLLPlotData',updateLLPlot).error(errorResponse);
	$.get("http://srag.ndc.nasa.gov/node/86?key=vxtgh&data=DoseRates", function (data) {
		data = JSON.parse($(data).find("#ajax_data").text()); //data is in div with id #ajax_data
		updateLLPlot(data);
	});	
}

function updateLLPlot(data)
{
	 try
	   {
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
		}
		catch (err)
		{
			//alert("updateLLPlot error: " + err.message);
			console.log("updateLLPlot error: " + err.message);	
		}
}


// function errorResponse() {
// 	//alert("error");
// 	console.log("error from json updateLLPlot()");
// }
setInterval(function() 
	{
		//alert("15 seconds");
		updateLLPlotData(); //update without refreshing every minute
	},60000);
</script>
