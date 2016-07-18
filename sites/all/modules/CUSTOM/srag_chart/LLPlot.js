// Filename: LLPlot.js
//
// Last Modified
// Date: 5/7/2013
// By: Mark Langford
//
// Parent Code: Based on LLPlot.java.  This file implements a JavaScript method for plotting DoseRate values and Lat/Lon positions.
//
// Status: (#) [(1)In development; (2)In testing; (3)Production Ready;]
//
/* Summary of major changes since the last release:
...
*/
 //pass in scalefactor
 function drawPlot( scaleFactor, jsLatArray, jsLonArray, jsValArray, units) {

     var canvas = document.getElementById("llplot");
      var plotLat, plotLon;
      //var scaleFactor = 1.5;
      var sf = parseFloat(scaleFactor);

      if (canvas.getContext) {
        var ctx = canvas.getContext("2d");
        //if redrawing, clear existing dots
		//ctx.clearRect(0,0,500,300);
        //assuming all arrays have same number elements
        for (i in jsLatArray)
        {
		//console.log("i=" + i);
          //Convert lon into grid x coordinates
          var dblLon = parseFloat(jsLonArray[i]);
          plotLon = (180 + dblLon) * sf;
          //Convert lat into grid y coordinates
          var dblLat = parseFloat(jsLatArray[i]);
          if (dblLat >= 0)
          {
          plotLat = (90 - dblLat) * sf;
          }
          else
          {
          plotLat = (90 + Math.abs(dblLat)) * sf;
          }
		  //console.log(plotLat + " " + plotLon + " ");
          if (i == jsLatArray.length - 1)
          { //we are at the last point, this is current position of the ISS
             ctx.fillStyle = "rgb(0,255,255)";
            //the LLTigerPlot.java and LLBkgPlot.java files from which this is based used the + 10 for the x & y values.  Not sure why.
             //ctx.fillRect(plotLon + 8,plotLat + 8 ,7,7);
             ctx.beginPath();
             // ctx.arc(plotLon + 10,plotLat + 10,3,0,2*Math.PI); // (ORIGINAL, changed because image changed)
             ctx.arc(plotLon,plotLat,4,0,2*Math.PI);
             ctx.fill();
          }
          else {
            //Determine the color for this plot point
            //console.log("units: " + units);
            if (units == "mGy") {
               var style = getColorStylemGy(jsValArray[i]);
            } else {   //probably undefined, default value so don't have to change all other code calling this function that want to use mrad
               var style = getColorStyle(jsValArray[i]);
            }
            ctx.fillStyle = style;
            //the LLTigerPlot.java and LLBkgPlot.java files from which this is based used the + 10 for the x & y values.  Not sure why.
            // ctx.fillRect(plotLon + 10,plotLat + 10 ,3,3); // (ORIGINAL, changed because image changed)
            ctx.fillRect(plotLon,plotLat,4,3);
            
          }
          i++;
	}
      }
}

function getColorStyle(value){
	//For Tiger Plot Background.  Based on LLBkgPlot.java
	var dblValue = parseFloat(value);
	var colorStyle = "rgb(0,0,0)";//default to black to see if one gets missed
	//Using rgb values instead of colornames to better match between Java and HTML rendering
	if (dblValue >= 0 & dblValue < 0.01) colorStyle = "rgb(128,128,128)";//g.setColor(Color.gray);
        if (dblValue >= 0.01 & dblValue < 0.1) colorStyle ="rgb(255,105,180)";//g.setColor(Color.pink); // CHANGED TO HOT PINK
        if (dblValue >= 0.1 & dblValue < 0.2) colorStyle ="rgb(0,0,255)";//g.setColor(Color.blue); 
        if (dblValue >= 0.2 & dblValue < 0.5) colorStyle ="rgb(0,255,083)";//g.setColor(Color.green);
        if (dblValue >= 0.5 & dblValue < 1.0) colorStyle ="rgb(255,255,0)";//g.setColor(Color.yellow);
        if (dblValue >= 1.0 & dblValue < 2.0) colorStyle ="rgb(255,140,0)";//g.setColor(Color.orange); //CHANGED TO BRIGHTER ORANGE
        if (dblValue >= 2.0 & dblValue < 5.0) colorStyle ="rgb(255,0,0)";//g.setColor(Color.red);
        if (dblValue >= 5.0) colorStyle ="rgb(138,43,226)";//g.setColor(Color.white); // CHANGED TO BLUEVIOLET
			
	return colorStyle;
}

function getColorStylemGy(value){
	//For Tiger Plot Background.  Based on LLBkgPlot.java
	var dblValue = parseFloat(value);
	var colorStyle = "rgb(0,0,0)";//default to black to see if one gets missed
	//Using rgb values instead of colornames to better match between Java and HTML rendering
	if (dblValue >= 0 & dblValue < 0.1) colorStyle = "rgb(128,128,128)";//g.setColor(Color.gray);
        if (dblValue >= 0.1 & dblValue < 1.0) colorStyle ="rgb(255,105,180)";//g.setColor(Color.pink); // CHANGED TO HOT PINK
        if (dblValue >= 1.0 & dblValue < 2.0) colorStyle ="rgb(0,0,255)";//g.setColor(Color.blue);
        if (dblValue >= 2.0 & dblValue < 5.0) colorStyle ="rgb(0,255,083)";//g.setColor(Color.green);
        if (dblValue >= 5.0 & dblValue < 10.0) colorStyle ="rgb(255,255,0)";//g.setColor(Color.yellow);
        if (dblValue >= 10.0 & dblValue < 20.0) colorStyle ="rgb(255,140,0)";//g.setColor(Color.orange); // CHANGED TO BRIGHTER ORANGE
        if (dblValue >= 20.0 & dblValue < 50.0) colorStyle ="rgb(255,0,0)";//g.setColor(Color.red);
        if (dblValue >= 50.0) colorStyle ="rgb(138,43,226)";//g.setColor(Color.white); // CHANGED TO BLUEVIOLET
			
	return colorStyle;
}
