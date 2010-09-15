  // Load the latest version of the Google Data JavaScript Client
  google.load('gdata', '2.x', {packages: ['maps']});


  var service = null;

  function showMapData() {

		var token = google.accounts.user.checkLogin('http://maps.google.com/maps/feeds');
		if (!token) {
			token = google.accounts.user.login('http://maps.google.com/maps/feeds');
		}
		service = new google.gdata.maps.MapsService('bid-poc');
		var mapFeedUrl = 'http://maps.google.com/maps/feeds/maps/default/owned';

	    service.getMapFeed(mapFeedUrl, function(feedRoot) {
			var feed = feedRoot.feed;
			var entries = feed.getEntries();
			var finalText = "";
			for (var i = 0; i < entries.length; i++) {
				var entry = entries[i];
				var mapTitle = entry.getTitle().getText();
				finalText += mapTitle + "\n";
			}

			$('#output').val(finalText);
		});
  }

  function checkLogin() {
      return google.accounts.user.checkLogin('http://maps.google.com/maps/feeds');
  }
