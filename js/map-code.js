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
			})
			/*
		Mission_F2_Code_Talkers_Statue:
		Mission_F1_Chief_Manuelito_Statue:
		Mission_A2_First_American_Traders:
		Womens_MultiCultural_Mural:
		Zuni_Mural:
		Veterans_Mural:
		Long_Walk_Home_Mural:
	*/
	};

	return markerList;

    markerCenter = new google.maps.LatLng(35.528454,-108.741005);
    marker3 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Mission A2: First American Traders"
        });
      markerCenter = new google.maps.LatLng(35.529138,-108.740535);
      marker4 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Mission F1: Chief Manuelito Statue"
        });
      markerCenter = new google.maps.LatLng(35.529179,-108.74035);
      marker4a = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Mission F2: Code Talkers Statue"
        });
    var infoWindow = new google.maps.InfoWindow({
        content:'<i>Paul Newman, Artist</i><div>"...Most of the history of a community takes place in the residents\' daily lives, for instance, where they work and, importantly, their environment. &nbsp;We chose to emphasize five broad themes - the landscape, railroads, Highway 66, rodeos, western life and coal mining."</div>'
        });
      markerCenter = new google.maps.LatLng(35.525433,-108.741928);
       marker9 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Zuni Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Geddy Epaloose, Artist</i><div>"The story line reads from south to north like the road from Zuni to Gallup and shows how Zunis from their world and their beginnings have brought Zuni traditions, culture, religion and history into this new world and Gallup..."</div>'
        });
      markerCenter = new google.maps.LatLng(35.525013,-108.743729);
        marker11 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Long Walk Home Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Richard K. Yazzie, Artist</i><div>In 1864... thousands of Navajo people were forcibly marched from Canyon de Chelly... to Fort Sumner four hundred miles away. &nbsp;Eventually 7,000 Navajo were imprisoned there. &nbsp;The captives suffered four yeas of deplorable conditions... until it no longer became feasible to hold them. &nbsp;The Peace Treaty of 1868 was signed and the Navajo were released.</div>'
        });
      markerCenter = new google.maps.LatLng(35.525311,-108.743103);
        marker12 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Veteran's Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Jerry Brown, Artist</i>'
        });
      markerCenter = new google.maps.LatLng(35.526375,-108.742783);
     marker13 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Women's Multi-Cultural Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Erica Rae Sykes, Artist</i><div>We offer a tribute to the women who have carried on the traditions of daily life of their own cultures...The large symbolic storyteller at the left of the mural pays homage to women who have kept multi-cultural memories alive by telling stories of the past.</div>'
        });
      markerCenter = new google.maps.LatLng(35.526604,-108.743256);
     marker15 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Coal Mining Era Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Andrew Butler, Artist</i><div>The 1935 Gallup Riot took place along this alley during which Sheriff Carmichael was killed. &nbsp;Depicted are a Navajo rail crew, legendary for their speed, the McKinley strip mine on the Navajo Reservation, the Gamerco Electric Generating Plant, coal competitions on days off, and the McGaffey timber industry nearby supplying the mines with structural materials.</div>>'
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Be Sargent, Artist</i><div>"The first 29 Code Talkers devised the Navajo Code. &nbsp;Part of the code was an alphabet which was used to spell words like names of strategic places. &nbsp;The mural depicts the code being passed on to the children of the Code Talkers symbolizing the perpetuation of the Navajo language."</div>'
        });


}

