var map;
var marker;
var bidCenter = new google.maps.LatLng(35.526000, -108.743200);
var districtOutlineAndMarkers;

function renderMap() {
	var myOptions = {
		center: bidCenter,
		mapTypeId: google.maps.MapTypeId.SATELLITE,
        zoom: 20
	}
	 
	map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

    setTimeout("makeMarker()", 4000);

	districtOutlineAndMarkers = new google.maps.KmlLayer('http://gallupbid.digitalcraftworks.com/bid.kml');
	districtOutlineAndMarkers.setMap(map);
}

function makeMarker() {
    marker = new google.maps.Marker({
            position: bidCenter, 
            map: map,
            title:"Hello World!"
        });

setTimeout("manipulateMarker()", 9000);
}

function manipulateMarker() 
{
marker.setVisible(false);
districtOutlineAndMarkers.setMap(map);
}


