<?php
error_reporting(-1);
/**
 * @package Live-Map
 *
 * Invokes the Twitter poller to get new images and then "stores" them -- which
 * will either mean uploading them to a location-specific SmugMug gallery via
 * the SmugMug API, or (if we can't get a SmugMug API key in time) emailing them
 * in to the default gallery.
 */
include './settings.php';

require './classes/TwitgooPoller.php';
require './classes/Photo.php';
require './classes/PhotoStorage.php';
require './classes/SmugStore.php';
require_once './phpSmug/phpSmug.php';

/**
 * Log4PHP setup
 */
require_once("log4php/Logger.php"); 
Logger::configure('log4php.properties'); 

if (!isset($_logger)) {
    $_logger = Logger::getLogger('poll-twitter');
}

$accountsToPoll = array(
    'BIDPrototype'
);

try {
    $photos = TwitgooPoller::PollTwitter($accountsToPoll);
} catch(TwitgooException $e) {
    die ("Couldn't poll twitter. Exception follows.\n"
        . print_r($e, 1)
    );
}

/**
 * Each Twitter account is associated with a specific gallery inside the SmugMug
 * account. Map those associations here, thus:
 *
 *      <twitter account> => <SmugMug Gallery title>
 */
define('DEFAULT_GALLERY', '13897183'); // Album ID for album titled: To Be Sorted
$galleryMap = array(
    'BIDPrototype' => 'BIDPrototype', // real gallery titles s/b user-friendly
);

$photosAdded = $photosUploaded = 0;
foreach ($photos as $photo) {
	$gallery = DEFAULT_GALLERY;
	// TODO have translate these to appropriate (integer) albumIDs
	//  before we use them...
//	if (isset($galleryMap[$photo->twitterAccount])) {
//		$gallery = $galleryMap[$photo->twitterAccount];
//	}

	$photo->location = $gallery;

	try {
		SmugStore::uploadPhoto($photo, $gallery);
		$photosUploaded++;
    } catch(Exception $e) {
        $_logger->error("uploadPhoto() failed with [{$e->getMessage()}]");
	}

	try {
		PhotoStorage::addPhoto($photo, $gallery);
		$photosAdded++;
	} catch (Exception $e) {
        $_logger->error("addPhoto() failed with [{$e->getMessage()}]");
    }
}

$msg = "Photos uploaded: $photosUploaded\n"
     . "Photos added to local storage: $photosAdded";

$_logger->info($msg);
echo "$msg\n";

?>
