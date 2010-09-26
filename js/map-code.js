var map;
var markers;
var bidCenter = new google.maps.LatLng(35.526000, -108.743200);
var districtOutlineAndMarkers;


function renderMap() {
	var myOptions = {
		center: bidCenter,
		mapTypeId: google.maps.MapTypeId.SATELLITE,
        zoom: 16
	}
	 
	map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

    markers = makeMarkers(map);

	districtOutlineAndMarkers = new google.maps.KmlLayer('http://gallupbid.digitalcraftworks.com/bid-no-markers.kml');
	districtOutlineAndMarkers.setMap(map);

}

function makeMarkers(map)
{
	var markerList = {
		Command_Center: 
			new google.maps.Marker({
				position: new google.maps.LatLng(35.525871, -108.7425690),
				map: map,
				title:"BID New Media Command Center"
			}),

		Coal_Mining_Era_Mural:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.526604,-108.743256),
				map: map,
				title:"Coal Mining Era Mural"
			}),

		Navajo_Code_Talkers_Mural:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.527312,-108.742992),
				map: map,
				title:"Navajo Code Talkers Mural"
			}),

		Great_Gallup_Mural:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.526619,-108.742166),
				map: map,
				title:"Great Gallup Mural"
			}),

		Mission_G_Painted_Horse_Sculpture:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.529345,-108.740294),
				map: map,
				title:"Mission G: Painted Horse Sculpture"
			}),

		Mission_F2_Code_Talkers_Statue:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.529179,-108.74035),
                map: map,
                title:"Mission F2: Code Talkers Statue"
            }),

		Mission_F1_Chief_Manuelito_Statue:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.529138,-108.740535),
                map: map,
                title:"Mission F1: Chief Manuelito Statue"
            }),

		Mission_A2_First_American_Traders:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.528454,-108.741005),
                map: map,
                title:"Mission A2: First American Traders"
            }),

		Womens_MultiCultural_Mural:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.526375,-108.742783),
                map: map,
                title:"Women's Multi-Cultural Mural"
            }),

		Zuni_Mural:
            marker9 = new google.maps.Marker({
                position: new google.maps.LatLng(35.525433,-108.741928),
                map: map,
                title:"Zuni Mural"
            }),

		Veterans_Mural:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.525311,-108.743103),
                map: map,
                title:"Veteran's Mural"
            }),

		Long_Walk_Home_Mural:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.525013,-108.743729),
                map: map,
                title:"Long Walk Home Mural"
            })
	};

	return markerList;
}

