<?php

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
	<!--- <td id="currentGMT" align="center" bgcolor="##BCF1F4">#DayOfYear("#foo.GMTDate#")#/#TimeFormat("#foo.GMTDate#","HH:mm:ss")#</td> --->
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
	<!--- <td align="center" bgcolor="##BCF1F4">#DayOfYear("#foo.RecDate#")#/#TimeFormat("#foo.RecDate#","HH:mm:ss")#</td> --->
	<td id="lastUpdate" align="center" bgcolor="##BCF1F4"></td>
	<td id="doseRate" align="center" bgcolor="##BCF1F4"></td>
	<td id="doseEqRate" align="center" bgcolor="##BCF1F4"></td>
</tr>

</table>
<hr>
<!-- Table for Cumulative Data ------------------------------------------------------------------------------->

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
<!-- Table for Instrument Status ----------------------------------------------------------------------------->

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

<!-- Table for Real Time Monitor ----------------------------------------------------------------------------->

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
