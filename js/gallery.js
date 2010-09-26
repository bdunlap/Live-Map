var t;
var timer_is_on=0;
var galleryInterval = 15000; // 15 seconds

function getNext()
{
    // Check to see if the counter has been initialized
    if ( typeof getNext.counter == 'undefined' ) {
        // It has not... perform the initilization
        getNext.counter = 1;
    }

    var Img = $.ajax({
        url: 'server-side/get-next.php?id=' + getNext.counter,
        async: false
        }).responseText;

    var parsedImg = $.parseJSON(Img);
    //check parsed image status
    
    if(parsedImg.status === "FAIL") {
        //do something with failed response
        $('#server-status').text(parsedImg.status);

        return null;

    } else if (parsedImg.status === "EMPTY") {
        //do something with empty response
        $('#server-status').text(parsedImg.status);

        return null;

    } else if (parsedImg.status === "SUCCESS") {
        //response is good
        $('#server-status').text(parsedImg.status);

        console.log(parsedImg);

        getNext.counter++;

        return parsedImg;
    }

}

var imageCounter = 0;
var maxThumbnails = 6;

function timedCount()
{
	if (!timer_is_on) {
		return;
	}
    // Check to see if the counter has been initialized
    if ( typeof timedCount.counter == 'undefined' ) {
        // It has not... perform the initilization
        timedCount.counter = 0;
    }

        placeNext();
        timedCount.counter++;
        t=setTimeout("timedCount()",galleryInterval);
}

function startGallery()
{
	timer_is_on=1;
	timedCount();
}

function pauseGallery()
{
	timer_is_on=0;
}

function placeNext()
{
	var newImgObject = getNext();
	if (newImgObject === null) {
		console.log("getNext() returned null.");
		return;
    }
    var newUrl = newImgObject.url;
    var thumbUrl = newImgObject.thumbnailUrl;
	var caption = newImgObject.text;
	var locationId = newImgObject.locationId;
    console.log(newUrl);

	/**
	 * Create HTML code for the featured image:
	 *
	 *   <img id="featured-[X]" src="[image URL here, with 'S' suffix so we use SmugMug's 'Small' version of the photo]" />
	 *
	 * ... where X is the value of imageCounter. Thus our "img" elements will
	 * end up with IDs of 'featured-0', 'featured-1', 'featured-2', etc.
	 */
	var featuredImg = '<img id="featured-' + imageCounter + '" '
		            + 'src="' + newUrl + '" />';
	/**
	 * Then create HTML code for the thumbnail. This one needs to be in a div so
	 * that we can force the divs to have uniform dimensions:
	 *
	 *   <div id="thumb-[X]" class="thumb">
	 *       <img src="[image URL here, with 'Ti' suffix so we use SmugMug's 'Tiny' version of the photo]" />
     *   </div>
	 */
	var newThumb = '<img src="' + thumbUrl + '" '
	                  + 'title="' + caption + '" '
					  + '/>';

	var newThumbDiv = '<div id="thumb-' + imageCounter + '" '
		            + 'class="thumb">' + newThumb + '</div>';

	if (imageCounter > 0) {
		/**
		 * We're past the first image in our rotation, so hide the current
		 * featured image, before adding a new one, and show the current
		 * thumbnail (before adding a new one).
		 */
		$('#featured-' + (imageCounter - 1)).remove();
		$('#thumb-' + (imageCounter -1)).show();
	}

    //remove oldest thumbnail once we get to a predetermined limit
    if (imageCounter > maxThumbnails) {
        $('#thumb-' + (imageCounter - (maxThumbnails + 1))).remove();
    }
	imageCounter++;

	/**
	 * Add the new featured image to the 'featured' div, and add the new
	 * thumbnail, hidden, to the front of the thumbnail gallery. We will
	 * 'show()' the thumbnail next time through this loop, see above.
	 */
	$('#featured').append(featuredImg);
	$(newThumbDiv).hide().prependTo('#thumbnails');

    if ( typeof placeNext.infoWindow == 'undefined' ) {
		placeNext.infoWindow = new google.maps.InfoWindow();
    }

	placeNext.infoWindow.setContent("<p>" + caption + "</p><p class='location-attribution'>from " + locationId + "</p>");
	placeNext.infoWindow.open(map, markers[locationId]);
}

