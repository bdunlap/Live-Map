var c=0;
var t;
var timer_is_on=0;

function changeMarker()
{
}

function getNext()
{
    var Img = $.ajax({
        url: "get-next.php",
        async: false
        }).responseText;

    var parsedImg = $.parseJSON(Img);

    alert(parsedImg);

   return parsedImg;
}

var imageCounter = 0;

function timedCount()
{
        placeNext();
        c=c+1;
        if (c < 5)
        {
            t=setTimeout("timedCount()",5000);
        }
}

function doTimer()
{
    if (!timer_is_on)
    {
        timer_is_on=1;
        timedCount();
    }
}

function placeNext()
{
	var newImgObject = getNext();
	if (newImgObject == null) {
		alert("end of the line!");
		return;
    }
    var newUrl = newImgObject.url;
    var thumbUrl = newImgObject.thumbnailUrl;
    alert(newUrl);

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
	var newThumb = '<img src="' + thumbUrl + '" />';

	var newThumbDiv = '<div id="thumb-' + imageCounter + '" '
		            + 'class="thumb">' + newThumb + '</div>';

	if (imageCounter > 0) {
		/**
		 * We're past the first image in our rotation, so hide the current
		 * featured image, before adding a new one, and show the current
		 * thumbnail (before adding a new one).
		 */
		$('#featured-' + (imageCounter - 1)).hide();
		$('#thumb-' + (imageCounter -1)).show();
	}

	imageCounter++;

	/**
	 * Add the new featured image to the 'featured' div, and add the new
	 * thumbnail, hidden, to the front of the thumbnail gallery. We will
	 * 'show()' the thumbnail next time through this loop, see above.
	 */
	$('#featured').append(featuredImg);
	$(newThumbDiv).hide().prependTo('#thumbnails');
}

