<?php
// Structure->Blocks->"ISS TEPC Text Display"
try {
	drupal_add_js('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js','external');
	// drupal_add_js('http://dygraphs.com/1.1.1/dygraph-combined.js','external');
	// drupal_add_js('/sites/srag.ndc.nasa.gov/modules/CUSTOM/srag_chart/SRAGChart.js','file');
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
<body>
<div id="txtArea">

<table id="txtData" cellpadding="2" cellspacing="3" border="0">	

	
<tr>
	<td colspan="4"><b>Current</b></td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<th align="center" scope="col">Current GMT</th>
	<th align="center" scope="col">Instrument Mode</th>
	<th align="center" scope="col">Alarm Status<br><font size="-2"><i>(Set Point: 5 mrad/min)</i></font></th>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<!-- <td id="currentGMT" align="center" bgcolor="##BCF1F4">#DayOfYear("#foo.GMTDate#")#/#TimeFormat("#foo.GMTDate#","HH:mm:ss")#</td>  -->
	<td id="currentGMT" align="center" bgcolor="##BCF1F4"></td>	
	<td id="currentMode" align="center" bgcolor="##BCF1F4"></td>
	<td id="alarmStatus" align="center" bgcolor="##BCF1F4"></td>
</tr>

<tr>
	<td colspan="4">&nbsp;&nbsp;</td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<th align="center" scope="col">SN Detector/Spectrometer</th>
	<th align="center" scope="col">Location</th>
	<th align="center" scope="col">Position</th>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td id="SnDetSpect" align="center" bgcolor="##BCF1F4"></td>
	<td id="location" align="center" bgcolor="##BCF1F4"></td>
	<td id="position" align="center" bgcolor="##BCF1F4"></td>
</tr>

<tr>
	<td colspan="4">&nbsp;&nbsp;</td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<th align="center" scope="col">GMT (Last Update)</th>
	<th align="center" scope="col">Dose Rate (mrad/min)</th>
	<th align="center" scope="col">Dose Eq. Rate (mrem/min)</th>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<!-- <td align="center" bgcolor="##BCF1F4">#DayOfYear("#foo.RecDate#")#/#TimeFormat("#foo.RecDate#","HH:mm:ss")#</td> -->
	<td id="lastUpdate" align="center" bgcolor="##BCF1F4"></td>
	<td id="doseRate" align="center" bgcolor="##BCF1F4"></td>
	<td id="doseEqRate" align="center" bgcolor="##BCF1F4"></td>
</tr>

</table>
<hr>
<!-- Table for Cumulative Data   -->

<table id="tblCumData" cellpadding="2" cellspacing="3">	


<tr>
	<td colspan="5"><b>Cumulative</b></td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;</td>
	<th align="center" scope="col">Total<br><font size="-2"><i>(Since Instrument<br>Turned On)</i></font></th>
	<th align="center" scope="col">Yesterday</th>
	<th align="center" scope="col">Today</th>
	<th align="center" scope="col">Last 24 Hours</th>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>&nbsp;</td>
	<td id="totalTimeOn" align="center" bgcolor="##BCF1F4"></td>
	<td id="JYesterday" align="center" bgcolor="##BCF1F4"></td>
	<td id="JToday" align="center" bgcolor="##BCF1F4"></td>
	<td id="last24HRS" align="center" bgcolor="##BCF1F4"></td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td align="right">Dose (mrad)</td>
	<td id="cumDose" align="center" bgcolor="##BCF1F4"></td>
	<td id="yesterdayDose" align="center" bgcolor="##BCF1F4"></td>
	<td id="todayDose" align="center" bgcolor="##BCF1F4"></td>
	<td id="absYesterdayDose" align="center" bgcolor="##BCF1F4"></td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td align="right">Dose Eq. (mrem)</td>
	<td id="cumDoseEquiv" align="center" bgcolor="##BCF1F4"></td>
	<td id="yesterdayDoseEquiv" align="center" bgcolor="##BCF1F4"></td>
	<td id="todayDoseEquiv" align="center" bgcolor="##BCF1F4"></td>
	<td id="absYesterdayDoseEquiv" align="center" bgcolor="##BCF1F4"></td>
</tr>

</table>
<hr>
<!-- Table for Instrument Status -->

<table id="tblInstStatus" cellpadding="2" cellspacing="3" border="0">	


<tr>
	<td colspan="7"><b>Instrument Status</b></td>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td colspan="4"><b>File Status</b></td>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<th align="center" scope="col">Power</th>
	<th align="center" scope="col">1553</th>
	<th align="center" scope="col">CPU</th>
	<th align="center" scope="col">MCA</th>
	<th align="center" scope="col">Display</th>
	<th align="center" scope="col">Memory</th>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<th align="center" scope="col">First File</th>
	<th align="center" scope="col">Last File</th>
	<th align="center" scope="col">Current<br>File</th>
</tr>

<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td id="power" align="center" bgcolor="##BCF1F4">OK</td>
	<td id="FFTCard" align="center" bgcolor="##BCF1F4">OK</td>
	<td id="CPUCard" align="center" bgcolor="##BCF1F4">OK</td>
	<td id="MCACard" align="center" bgcolor="##BCF1F4">OK</td>
	<td id="DisCard" align="center" bgcolor="##BCF1F4">OK</td>
	<td id="MemCard" align="center" bgcolor="##BCF1F4">OK</td>

	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td id="FirstFile" align="center" bgcolor="##BCF1F4"></td>
	<td id="LastFile" align="center" bgcolor="##BCF1F4"></td>
	<td id="CurrentFile" align="center" bgcolor="##BCF1F4"></td>
</tr>
</table>

<!-- Table for Real Time Monitor -->

	<table id="tblRTM" cellpadding="2" cellspacing="3">	

<tr>
	<td colspan="3">&nbsp;<br><b>Real Time Monitor</b></td>
</tr>
<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<th scope="col">Code</th>
	<th scope="col">Descripton</th>
</tr>
<tr>
	<td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

	<td id="rtmCode" align="center" bgcolor="##BCF1F4"></td>
	<td id="rtmDesc" align="center" bgcolor="##BCF1F4"></td>

</tr>
</table>
</div>
</body>

<script>
$(document).ready(function() {

	$.ajaxSetup({cache: false});
	var g;
	
	try {			
		// $.getJSON('../data/TepcDoseChartData.cfc','method=getTEPCDoseChartData',processDoseChartData).error(errorDoseChartResponse);
		// $.getJSON('../data/24HourTepcTextData.cfc','method=get24HourTepcTextData',updateText).error(errorTextResponse);
		// $.getJSON('../data/TepcLLPlotData.cfc','method=getTepcLLPlotData',updateLLPlot).error(errorLLPlotResponse);
		$.get("http://srag.ndc.nasa.gov/node/86?key=vxtgh&data=TextData", function (data) {
			data = JSON.parse($(data).find("#ajax_data").text()); //data is in div with id #ajax_data
			updateText(data);
		});
	} catch (err) {
		console.log("Error  in ready: " + err.message);
	}
});//end ready	

function updateTextData()
{
	// $.getJSON('../data/24HourTepcTextData.cfc','method=get24HourTepcTextData',updateText).error(errorTextResponse);
	$.get("http://srag.ndc.nasa.gov/node/86?key=vxtgh&data=TextData", function (data) {
		data = JSON.parse($(data).find("#ajax_data").text()); //data is in div with id #ajax_data
		updateText(data);
	});
}

function addZero(i)
{
	if (i<10) 
	  {
	  i="0" + i;
	  }
	return i;
}

function updateText(data)	{
	//Update the text area data
	try
	{
		var GMT = data.GMTDATE;
		var currentMode = parseInt(data.CURRENTMODE,10);
		var deltaNow = parseInt(data.DELTANOW, 10);
		var detectorSN = parseInt(data.DETECTORSN,10);
		var spectrometerSN = parseInt(data.SPECTROMETERSN,10);
		var daysOn = parseInt(data.DAYSON,10);
		var hoursOn = parseInt(data.HOURSON,10);
		var minutesOn = parseInt(data.MINUTESON,10);
		var alarmStatus = parseInt(data.ALARMSTATUS,10);
		var jToday = parseInt(data.JTODAY,10);
		var jYesterday = parseInt(data.JYESTERDAY,10);
		var firstFile = parseInt(data.FIRSTFILE,10);
		var lastFile = parseInt(data.LASTFILE,10);
		var currentFile = parseInt(data.CURRENTFILE,10);
		var rtmRecordCount = parseInt(data.RTMRECORDCOUNT,10);

	   
		var newHTML = data.GMTDATE;
		//CURRENT GMT
		$('#currentGMT').html(newHTML);
		
		if (deltaNow > 180) {
			$('#txtData').css('color','#A0A0A0');
			$('#tblCumData').css('color','#A0A0A0');
			$('#tblInstStatus').css('color','#A0A0A0');
			$('#tblRTM').css('color','#A0A0A0');
		} else {//else what color to set for restoring normal?
			$('#txtData').css('color','#000000');
			$('#tblCumData').css('color','#000000');
			$('#tblInstStatus').css('color','#000000');
			$('#tblRTM').css('color','#000000');
		}
		var clr = $('#txtData').css('color');
		

		//CurrentMode
		if (currentMode == 0) {
			$('#currentMode').html("No Signal");
			$('#currentMode').attr('bgcolor','#FF0000');
		} else if (currentMode == 1) {
			$('#currentMode').html("Standby");
			$('#currentMode').attr('bgcolor','#FF0000');
		} else if (currentMode == 2) {
			if (deltaNow > 180) {
				$('#currentMode').html("LOS");
				$('#currentMode').attr('bgcolor','#FF0000');
			} else {
				$('#currentMode').html("Data Acquisition");
				$('#currentMode').attr('bgcolor','#BCF1F4');
			}	
		} else if (currentMode == 3) {
			$('#currentMode').html("Invalid");
			$('#currentMode').attr('bgcolor','#FF0000');
		}

		//AlarmStatus
		if (alarmStatus == 0) {
			$('#alarmStatus').html("Nominal");
			$('#alarmStatus').attr('bgcolor','#BCF1F4');
		} else if (alarmStatus == 1) {
			$('#alarmStatus').html("Alert");
			$('#alarmStatus').attr('bgcolor','#FF0000');
		}
		$('#SnDetSpect').html(detectorSN + "/" + spectrometerSN);
		$('#location').html(data.LOCATION);
		$('#position').html(data.POSITION);
		
		$('#lastUpdate').html(data.RECDATE);
		$('#doseRate').html(data.DOSERATE);
		$('#doseEqRate').html(data.DOSEEQUIVRATE);
		
		$('#totalTimeOn').html(daysOn + "/" + hoursOn + ":" + minutesOn + ":00");
		$('#JYesterday').html(jYesterday);
		$('#JToday').html(jToday);
		var dt = new Date(data.ABSYESTERDAY);
		//alert(dt.toUTCString());	
		var h = addZero(dt.getHours());	
		var m = addZero(dt.getMinutes());	
		var s = addZero(dt.getSeconds());	
		$('#last24HRS').html(jYesterday + "-" + jToday + "<br>"+  h + ":" + m + ":" + s);

		
		$('#cumDose').html(data.CUMDOSE);
		$('#yesterdayDose').html(data.YESTERDAYDOSE);
		$('#todayDose').html(data.TODAYDOSE);
		$('#absYesterdayDose').html(data.ABSYESTERDAYDOSE);
		$('#cumDoseEquiv').html(data.CUMDOSEEQUIV);
		$('#yesterdayDoseEquiv').html(data.YESTERDAYDOSEEQUIV);
		$('#todayDoseEquiv').html(data.TODAYDOSEEQUIV);
		$('#absYesterdayDoseEquiv').html(data.ABSYESTERDAYDOSEEQUIV);

		
		if (data.POWER == "OK") {
			$('#power').html("OK");
			$('#power').attr('bgcolor','#BCF1F4');
		} else if (data.POWER == "ERROR") {
			$('#power').html("ERROR");
			$('#power').attr('bgcolor','#FF0000');
		}
		if (data.FFTCARD == "OK") {
			$('#FFTCard').html("OK");
			$('#FFTCard').attr('bgcolor','#BCF1F4');
		} else if (data.FFTCARD == "ERROR") {
			$('#FFTCard').html("ERROR");
			$('#FFTCard').attr('bgcolor','#FF0000');
		}
		if (data.CPUCARD == "OK") {
			$('#CPUCard').html("OK");
			$('#CPUCard').attr('bgcolor','#BCF1F4');
		} else if (data.CPUCARD == "ERROR") {
			$('#CPUCard').html("ERROR");
			$('#CPUCard').attr('bgcolor','#FF0000');
		}
		if (data.MCACARD == "OK") {
			$('#MCACard').html("OK");
			$('#MCACard').attr('bgcolor','#BCF1F4');
		} else if (data.MCACARD == "ERROR") {
			$('#MCACard').html("ERROR");
			$('#MCACard').attr('bgcolor','#FF0000');
		}
		if (data.DISCARD == "OK") {
			$('#DisCard').html("OK");
			$('#DisCard').attr('bgcolor','#BCF1F4');
		} else if (data.DISCARD == "ERROR") {
			$('#DisCard').html("ERROR");
			$('#DisCard').attr('bgcolor','#FF0000');
		}
		if (data.MEMCARD == "OK") {
			$('#MemCard').html("OK");
			$('#MemCard').attr('bgcolor','#BCF1F4');
		} else if (data.MEMCARD == "ERROR") {
			$('#MemCard').html("ERROR");
			$('#MemCard').attr('bgcolor','#FF0000');
		}
		$('#FirstFile').html(firstFile);
		$('#LastFile').html(lastFile);
		$('#CurrentFile').html(currentFile);

		
		if (rtmRecordCount > 0) {
			$('#rtmCode').html(data.REALTIMEMONITOR);
			$('#rtmCode').attr('bgcolor','#BCF1F4');
			$('#rtmDesc').html(data.RTMDESCRIPTION);
			$('#rtmDesc').attr('bgcolor','#BCF1F4');	
		} else {
			$('#rtmCode').html("-");
			$('#rtmCode').attr('bgcolor','#FF0000');
			$('#rtmDesc').html("Invalid code.");
			$('#rtmDesc').attr('bgcolor','#FF0000');
		}

	}	
	catch (err)	
	{
		console.log("updateText: " + err.message);
	}
		
}//end updateTextData
	
function errorTextResponse() {
	console.log("errorTextResponse");
}

setInterval(function() 
	{		
		updateTextData();
	},60000);
	
</script>