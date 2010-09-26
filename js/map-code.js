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

    makeMarker();

	districtOutlineAndMarkers = new google.maps.KmlLayer('http://gallupbid.digitalcraftworks.com/new-code/bid-no-markers.kml');
	districtOutlineAndMarkers.setMap(map);

}

function makeMarker() {
    marker1 = new google.maps.Marker({
            position: bidCenter, 
            map: map,
            title:"Hello World!"
        });

    var markerCenter = new google.maps.LatLng(35.525871, -108.7425690);
    marker2 = new google.maps.Marker({
            position: markerCenter, 
            map: map,
            title:"BID New Media Command Center"
        });

    var infoWindow = new google.maps.InfoWindow({
            content:"some balloon content for all to see."
        });

    google.maps.event.addListener(marker2, 'click', function() {
      infoWindow.open(map,marker2);
    });
    markerCenter = new google.maps.LatLng(35.528454,-108.740700);
    marker3 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Mission A2 - First American Traders"
        });
      markerCenter = new google.maps.LatLng(35.528942,-108.741005);
      marker4 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Missions F1 and F2 - statues"
        });
      markerCenter = new google.maps.LatLng(35.529415,-108.740059);
     marker5 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Mission G - Painted Horse Sculpture"
        });
      markerCenter = new google.maps.LatLng(35.526516,-108.74231);
     marker6 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Gallup Community Life Mural"
        });
      markerCenter = new google.maps.LatLng(-108.741966,35.526585,0.000000);
      marker7 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Great Gallup Mural"
        });
      markerCenter = new google.maps.LatLng(-108.741966,35.526585,0.000000);
      marker8 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Great Gallup Mural"
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
            title:"Walk Home Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Richard K. Yazzie, Artist</i><div>In 1864... thousands of Navajo people were forcibly marched from Canyon de Chelly... to Fort Sumner four hundred miles away. &nbsp;Eventually 7,000 Navajo were imprisoned there. &nbsp;The captives suffered four yeas of deplorable conditions... until it no longer became feasible to hold them. &nbsp;The Peace Treaty of 1868 was signed and the Navajo were released.</div>'
        });
      markerCenter = new google.maps.LatLng(35.525311,-108.743103);
        marker12 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"&#39;s Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Jerry Brown, Artist</i>'
        });
      markerCenter = new google.maps.LatLng(35.526375,-108.742783);
     marker13 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Women&#39;s Multi-Cultural Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Erica Rae Sykes, Artist</i><div>We offer a tribute to the women who have carried on the traditions of daily life of their own cultures...The large symbolic storyteller at the left of the mural pays homage to women who have kept multi-cultural memories alive by telling stories of the past.</div>'
        });
      markerCenter = new google.maps.LatLng(35.526585,-108.744202);
     marker14 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Native American Trading Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Chester Kahn, Artist</i><div>In the 1920s there was an awakening appreciation for Native American art supported and encouraged by numerous traders. &nbsp;As tribes sought self-sufficiency in the 1960s trading on the reservation decreased... Many traders settled in Gallup where they are major supporters of Native American artisans.</div>'
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
      markerCenter = new google.maps.LatLng(35.527214,-108.742912);
     marker16 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Gallup Inter-Tribal Indian Ceremonial Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Irving Bahe, Artist</i><div>"This mural is about unity and life... The rainbow has all the colors so it represents all the Indian tribes that are in the world. &nbsp;Also the rainbow is carrying the songs to the dancers. &nbsp;Native Americans celebrate life through song and dance...that\'s what dance is about; to celebrate life."</div>>'
        });
      markerCenter = new google.maps.LatLng(35.527512,-108.742592);
     marker17 = new google.maps.Marker({
            position: markerCenter,
            map: map,
            title:"Navajo Code Talkers&#39; Mural"
        });
    var infoWindow = new google.maps.InfoWindow({
        contents:'<i>Be Sargent, Artist</i><div>"The first 29 Code Talkers devised the Navajo Code. &nbsp;Part of the code was an alphabet which was used to spell words like names of strategic places. &nbsp;The mural depicts the code being passed on to the children of the Code Talkers symbolizing the perpetuation of the Navajo language."</div>'
        });


}

