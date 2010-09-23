<?php
error_reporting(-1);
ini_set('display_errors', 'On');
/**
 * @package Live-Map
 *
 * Invokes the Twitter poller to get new images and then "stores" them -- which
 * will either mean uploading them to a location-specific SmugMug gallery via
 * the SmugMug API, or (if we can't get a SmugMug API key in time) emailing them
 * in to the 
 * directory locally.
 */
require './TwitterPoller.php';

$accountsToPoll = array(
    'BIDPrototype',
);

$poller = new TwitterPoller($accountsToPoll); // pass list of accounts here

try {
    $photos = $poller->getTwitterPhotos();
} catch(TwitterPollerException $e) {
    die ("couldn't poll twitter. Exception follows.\n"
        . print_r($e, 1)
    );
}

/**
 * Each Twitter account is associated with a specific gallery inside the SmugMug
 * account. Map those associations here, thus:
 *
 *      <twitter account> => <SmugMug Gallery title>
 */
$galleryMap = array(
    'BIDPrototype' => 'BIDPrototype', // real gallery titles s/b user-friendly
);

$storage = new PhotoStorage();
$storage->setGalleryMap($galleryMap);

foreach ($photos as $photo) {
    try {
        $storage->storePhoto($photo);
    } catch(PhotoStorageException $e) {
        $logger->error("storePhoto() failed. Exception follows.\n"
            . print_r($e, 1)
        );
    }
}

?>
