function renderMap() {
	var bidCenter = new google.maps.LatLng(35.526000, -108.743200);
	var myOptions = {
		center: bidCenter,
		mapTypeId: google.maps.MapTypeId.SATELLITE
	}
	 
	var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
	   
	var ctaLayer = new google.maps.KmlLayer('http://gallupbid.digitalcraftworks.com/bid.kml');
	ctaLayer.setMap(map);
}
