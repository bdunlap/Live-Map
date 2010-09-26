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
include '/var/gallupbid-support/settings.php';

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

$startMsg = "BEGIN RUN: ".date('r');
$_logger->info($startMsg);
echo "$startMsg\n";

$accountsToPoll = array(
//    'BIDPrototype',
	'GallupBIDFireG',
	'GallupBIDFire2',
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
$twitterToGallery = array(
	'GallupBIDFire8' => 'Coal Mining Era Mural',
	'GallupBIDFire10' => 'Navajo Code Talkers Mural',
	'GallupBIDFire2' => 'Great Gallup Mural',
	'GallupBIDFireG' => 'Mission G: Painted Horse Sculpture',
	'GallupBIDFireF2' => 'Mission F2: Code Talkers Statue',
	'GallupBIDFireF1' => 'Mission F1 - Chief Manuelito Statue',
);

define('DEFAULT_GALLERY', '13897183'); // Album ID for album titled: To Be Sorted
$galleryIds = array(
	'Mission G: Painted Horse Sculpture' => '13917166',
	'Great Gallup Mural' => '13917195',
);

$photosAdded = $photosUploaded = 0;
foreach ($photos as $photo) {
	$location = "unknown";
	if (isset($twitterToGallery[$photo->twitterAccount])) {
		$location = $twitterToGallery[$photo->twitterAccount];
	}
	$photo->location = $location;

	$gallery = DEFAULT_GALLERY;
	if (isset($galleryIds[$location])) {
		$gallery = $galleryIds[$location];
	}


	try {
		PhotoStorage::addPhoto($photo);
		$photosAdded++;

		SmugStore::uploadPhoto($photo, $gallery);
		$photosUploaded++;
	} catch (PhotoStorageException $e) {
        $_logger->error("addPhoto() failed with [{$e->getMessage()}]");
    } catch(Exception $e) {
        $_logger->error("uploadPhoto() failed with [{$e->getMessage()}]");
	}
}

$msg = "Photos uploaded: $photosUploaded\n"
     . "Photos added to local storage: $photosAdded\n"
     . "END RUN: ".date('r');

$_logger->info($msg);
echo "$msg\n\n";

?>
