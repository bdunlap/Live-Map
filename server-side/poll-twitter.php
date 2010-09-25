<?php
error_reporting(-1);
ini_set('display_errors', 'On');
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
define('DEFAULT_GALLERY', 'To-Be-Sorted');
$galleryMap = array(
    'BIDPrototype' => 'BIDPrototype', // real gallery titles s/b user-friendly
);

foreach ($photos as $photo) {
	$gallery = DEFAULT_GALLERY;
	if (isset($galleryMap[$photo->twitterAccount])) {
		$gallery = $galleryMap[$photo->twitterAccount];
	}

	$photo->location = $gallery;

	try {
		SmugStore::uploadPhoto($photo, $gallery);
		PhotoStorage::addPhoto($photo, $gallery);
    } catch(PhotoException $e) {
        $_logger->error("storePhoto() failed. Exception follows.\n"
            . print_r($e, 1)
        );
	} catch (Exception $e) {
		echo "addPhoto() failed. Exception follows.\n";
		print_r($e);
    }
}

?>
