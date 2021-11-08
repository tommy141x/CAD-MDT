<?php
// PRELOADER
echo "
<link rel='shortcut icon' type='image/ico' href='../../assets/images/favicon.ico'>
<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-bg {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
  background-color: rgba(0, 0, 0, 1.0);
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.blackout {
	display: none;
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background-image: url('assets/images/blackout.png');
	background-position: center;
  background-color: rgba(0, 0, 0, 0.75);
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
<div class='se-pre-bg'></div>
<div class='blackout'></div>
";
// PRELOADER
include '../../config.php';
if(!$extraFeaturesEnabled){
header("Location: ../../");
}
?>
<style>
body, html {
	padding:0px;
	margin:0px;
}

#map {
	width:100%;
	height:100%;
	color: #000;
	background: #EFEFEF;
	margin:0 auto;
}
span.loading {
	display: block;
	text-align: center;
	font: 300 italic 72px/400px "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
}
</style>
<head>
 <title><?php echo $communityName;?> | Live Map </title>
</head>
<div id="map"><span class="loading">Loading Map...</span></div>
<div id="backend"></div>
    <!-- PRELOADER -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script>
    	$(window).load(function() {
    		// Animate loader off screen
    		$(".se-pre-bg").fadeOut("slow");
    	});
    </script>
    <!-- PRELOADER -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
var repeatOnXAxis = false; // Do we need to repeat the image on the X-axis? Most likely you'll want to set this to false
function getNormalizedCoord(coord, zoom) {
	if (!repeatOnXAxis) return coord;
	var y = coord.y;
	var x = coord.x;
	// tile range in one direction range is dependent on zoom level
	// 0 = 1 tile, 1 = 2 tiles, 2 = 4 tiles, 3 = 8 tiles, etc
	var tileRange = 1 << zoom;
	// don't repeat across Y-axis (vertically)
	if (y < 0 || y >= tileRange) {
		return null;
	}
	// repeat across X-axis
	if (x < 0 || x >= tileRange) {
		x = (x % tileRange + tileRange) % tileRange;
	}
	return {
		x: x,
		y: y
	};
}

var map;
var static_markers = [];

// Define our custom map type
var satellite = new google.maps.ImageMapType({
	getTileUrl: function(coord, zoom) {
		var normalizedCoord = getNormalizedCoord(coord, zoom);
		if(normalizedCoord && (normalizedCoord.x < Math.pow(2, zoom)) && (normalizedCoord.x > -1) && (normalizedCoord.y < Math.pow(2, zoom)) && (normalizedCoord.y > -1)) {
			return 'Satellite/' + zoom + '_' + normalizedCoord.x + '_' + normalizedCoord.y + '.jpg';
		} else {
			return 'Satellite/empty.jpg';
		}
	},
	tileSize: new google.maps.Size(256, 256),
	maxZoom: 7,
	minZoom:2,
    zoom:2,
	name: 'Satellite'
});
var roadmap = new google.maps.ImageMapType({
	getTileUrl: function(coord, zoom) {
		var normalizedCoord = getNormalizedCoord(coord, zoom);
		if(normalizedCoord && (normalizedCoord.x < Math.pow(2, zoom)) && (normalizedCoord.x > -1) && (normalizedCoord.y < Math.pow(2, zoom)) && (normalizedCoord.y > -1)) {
			return 'Roadmap/' + zoom + '_' + normalizedCoord.x + '_' + normalizedCoord.y + '.jpg';
		} else {
			return 'Roadmap/empty.jpg';
		}
	},
	tileSize: new google.maps.Size(256, 256),
	maxZoom: 7,
	minZoom:2,
    zoom:2,
	name: 'Roadmap'
});
var atlas = new google.maps.ImageMapType({
	getTileUrl: function(coord, zoom) {
		var normalizedCoord = getNormalizedCoord(coord, zoom);
		if(normalizedCoord && (normalizedCoord.x < Math.pow(2, zoom)) && (normalizedCoord.x > -1) && (normalizedCoord.y < Math.pow(2, zoom)) && (normalizedCoord.y > -1)) {
			return 'Atlas/' + zoom + '_' + normalizedCoord.x + '_' + normalizedCoord.y + '.jpg';
		} else {
			return 'Atlas/empty.jpg';
		}
	},
	tileSize: new google.maps.Size(256, 256),
	maxZoom: 7,
	minZoom:2,
    zoom:2,
	name: 'Atlas'
});

// Basic options for our map
var myOptions = {
	center: new google.maps.LatLng(0, 0),
	zoom: 2,
	minZoom: 0,
	streetViewControl: false,
	mapTypeControl: true,
	mapTypeControlOptions: {
		mapTypeIds: ["gta_satellite", "gta_roadmap", "gta_atlas"]
	}
};

// Init the map and hook our custom map type to it
map = new google.maps.Map(document.getElementById('map'), myOptions);
map.mapTypes.set('gta_satellite', satellite);
map.mapTypes.set('gta_roadmap', roadmap);
map.mapTypes.set('gta_atlas', atlas);
// sets default 'startup' map
map.setMapTypeId('gta_satellite');

var overlay = new google.maps.OverlayView();
overlay.draw = function() {};
overlay.setMap(map);

// Sets the map on all markers in the array.
function setAllMap(map) {
  for (var i = 0; i < static_markers.length; i++) {
	static_markers[i].setMap(map);
  }
}

function setMapType(type) {
map.setMapTypeId(type);
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setAllMap(null);
  static_markers = [];
}

// Shows any markers currently in the array.
function showMarkers() {
  setAllMap(map);
}

	function gtamp2googlepx(x,y) {
		// IMPORTANT
		// for this to work #map must be width:1126.69px; height:600px;
		// you can change this AFTER all markers are placed...
		//--------------------------------------
		//conversion increment from x,y to px,py
		var mx = 0.05030;
		var my = -0.05030; //-0.05003
		//math mVAR * cVAR
		var x = mx * x;
		var y = my * y;
		//offset for correction
		var x = x -486.97;
		var y = y +408.9;
		//return latlong coordinates
		return pixelLatLng = overlay.getProjection().fromContainerPixelToLatLng(new google.maps.Point(x,y));
	}

	function addMarker(x,y, type, content_html, icon, ig) {
	  if(ig) {
			//to ingame 2 google coords here, use function.
			var location = gtamp2googlepx(x,y);
		} else {
			var location = new google.maps.LatLng(x,y);
		}
	  var marker = new google.maps.Marker({
		position: location,
		map: map,
		icon: icon+'.png',
		optimized: false //to prevent it from repeating on the x axis.
	  });
	  if(type == "static") { static_markers.push(marker); }

		var infowindow = new google.maps.InfoWindow({
			content: content_html
		});
		//when you click anywhere on the map, close all open windows...
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);

			google.maps.event.addListener(map, 'click', function() {
				infowindow.close();
            });
		});
	}
</script>
<script type="text/javascript">
	var timeout = setInterval(reloadChat, 2500);
		function reloadChat () {
		$('#backend').load('backend.php');
		}
</script>
