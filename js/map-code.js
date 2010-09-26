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
	var icons = {
		red:
			new google.maps.MarkerImage(
				'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%20|FF0000|000000'
			),
		blue:
			new google.maps.MarkerImage(
				'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%20|0090D8|000000'
			),
		turquoise:
			new google.maps.MarkerImage(
				'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%20|61D1D1|000000'
			)
	};
	
	var markerList = {
		Command_Center: 
			new google.maps.Marker({
				position: new google.maps.LatLng(35.525871, -108.7425690),
				map: map,
				title:"BID New Media Command Center",
				icon: icons.red
			}),

		Coal_Mining_Era_Mural:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.526604,-108.743256),
				map: map,
				title:"Coal Mining Era Mural",
				icon: icons.turquoise
			}),

		Navajo_Code_Talkers_Mural:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.527312,-108.742992),
				map: map,
				title:"Navajo Code Talkers Mural",
				icon: icons.turquoise
			}),

		Great_Gallup_Mural:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.526619,-108.742166),
				map: map,
				title:"Great Gallup Mural",
				icon: icons.turquoise
			}),

		Mission_G_Painted_Horse_Sculpture:
			new google.maps.Marker({
				position: new google.maps.LatLng(35.529345,-108.740294),
				map: map,
				title:"Mission G: Painted Horse Sculpture",
				icon: icons.blue
			}),

		Mission_F2_Code_Talkers_Statue:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.529179,-108.74035),
                map: map,
                title:"Mission F2: Code Talkers Statue",
				icon: icons.blue
            }),

		Mission_F1_Chief_Manuelito_Statue:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.529138,-108.740535),
                map: map,
                title:"Mission F1: Chief Manuelito Statue",
				icon: icons.blue
            }),

		Mission_A2_First_American_Traders:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.528454,-108.741005),
                map: map,
                title:"Mission A2: First American Traders",
				icon: icons.blue
            }),

		Womens_MultiCultural_Mural:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.526375,-108.742783),
                map: map,
                title:"Women's Multi-Cultural Mural",
				icon: icons.turquoise
            }),

		Zuni_Mural:
			new google.maps.Marker({
                position: new google.maps.LatLng(35.525433,-108.741928),
                map: map,
                title:"Zuni Mural",
				icon: icons.turquoise
            }),

		Veterans_Mural:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.525311,-108.743103),
                map: map,
                title:"Veteran's Mural",
				icon: icons.turquoise
            }),

		Long_Walk_Home_Mural:
            new google.maps.Marker({
                position: new google.maps.LatLng(35.525013,-108.743729),
                map: map,
                title:"Long Walk Home Mural",
				icon: icons.turquoise
            })
	};

	return markerList;
}

