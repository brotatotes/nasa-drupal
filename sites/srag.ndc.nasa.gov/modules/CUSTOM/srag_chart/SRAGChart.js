// Filename: SRAGChart.js
//
// Last Modified
// Date: 8/13/2014
// By: Mark Langford
//
// This file implements a JavaScript method for plotting DoseRate, Cumulative Dose Rate and time values.
// This file can be used for any instrument.
// It uses the Dygraphs library (dygraph-combined.js).
//
// Status: (#) [(1)In development; (2)In testing; (3)Production Ready;]
//
/* Summary of major changes since the last release:
...
*/

//extend Date class	with this function to return the numerical day of year.
Date.prototype.getDOY = function() {
	//Need to make sure both dates are UTC
	var onejanUTC = new Date();
	onejanUTC.setUTCFullYear(this.getUTCFullYear());
	onejanUTC.setUTCMonth(0);
	onejanUTC.setUTCDate(1);
	onejanUTC.setUTCHours(0);
	onejanUTC.setUTCMinutes(0);
	onejanUTC.setUTCSeconds(0);

	var hours = this.getUTCHours();
	var rem = (this - onejanUTC) / 86400000;
		
	if (hours == 0) {
		return Math.ceil(rem) + 1;
	} else {
		return Math.ceil(rem);
	  }
} //end Date.prototype.getDOY

hmsStringUTC_=function(a){
	var c=Dygraph.zeropad;
	var b=new Date(a);
	if(b.getUTCSeconds())
	{
	return c(b.getUTCHours())+":"+c(b.getUTCMinutes())+":"+c(b.getUTCSeconds())
	}
	else
	{
	return c(b.getUTCHours())+":"+c(b.getUTCMinutes())
	}
};

function drawChart(data, title, yColor, y2Color, axLabelFontSize ) 
{	
	try 
	{		
	  g = new Dygraph
	  (
			document.getElementById("demodiv"),
			data,
			{//Options
				//Legend Options
				labels: [ "Date", "DoseRate", "CumDose" ],				
				//axisLabelFontSize: 10 is for small, 15 for regular
				axisLabelFontSize: axLabelFontSize,
				series : {
					'DoseRate' : { axis : 'y2' },
				},
				labelsSeparateLines: true, //for the pop-up legend
				labelsDivStyles: {
					'text-align': 'right',
					'background': 'none',
					'color': 'green'
				  },		
				axes: {
					x: {axisLabelColor: 'black',
						valueFormatter: function(ms) {
							//return new Date(ms).strftime("%m/%d/%y %H:%M:%S%z",false);
							return new Date(ms).toUTCString();
						},
						 axisLabelFormatter: 
						 function(d, gran) {
						 try {
							   var dt = new Date(d);
							   
							   if (gran >= Dygraph.DECADAL) {
								 return dt.strftime('%Y');
							   } else if (gran >= Dygraph.MONTHLY) {
								 return dt.strftime('%b %y');
							   } else {
									 var frac = dt.getUTCHours() * 3600 + dt.getUTCMinutes() * 60 + dt.getUTCSeconds() + dt.getUTCMilliseconds();
									 if (frac === 0 || gran >= Dygraph.DAILY) {
											return new Date(dt.getTime() + 3600*1000).strftime( dt.getDOY() + "/" + hmsStringUTC_(dt.getTime()));
									 } else {
									   return hmsStringUTC_( dt.getTime()); // GMT+0 or UTC
									 }
							   }
						   }
						   catch (err) {
							console.log("axisLabelFormatter: " + err.message);
						   }
						 }  
						 },
					y: {
						includeZero: true,
						axisLabelColor: yColor //colors the tick values along the axis						
					},
				  y2: {
					// set axis-related properties here
					includeZero: true,
					axisLabelColor: y2Color, //colors the tick values along the axis
					sigFigs: 2
				  }		  
				},//end axes option
				title: title,
				titleHeight: 32,				
				colors: [y2Color,//doserate; color for line and legend label - these not working in small
						 yColor//cumdose; color for line and legend label
						],
				xlabel: "GMT",
				ylabel: 'Cumulative Dose (mrad)', //left y-axis title
				y2label: 'Dose Rate (mrad/min)',//right y-axis title
				yAxisLabelWidth: 60
			}
	  ); 
	 return g;
	 
	}
	catch (err)
	{
		console.log("error in SRAGChart: " + err.message);
	}
}
