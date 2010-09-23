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
require './TwitgooPoller.php';
require './Photo.php';

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
define(DEFAULT_GALLERY, 'To-Be-Sorted');
$galleryMap = array(
    'BIDPrototype' => 'BIDPrototype', // real gallery titles s/b user-friendly
);

foreach ($photos as $photo) {
    try {
        $gallery = DEFAULT_GALLERY;
        if (isset($galleryMap[$photo->twitterAccount])) {
            $gallery = $galleryMap[$photo->twitterAccount];
        }

        $photo->upload($gallery);
    } catch(PhotoException $e) {
        $logger->error("storePhoto() failed. Exception follows.\n"
            . print_r($e, 1)
        );
    }
}

?>
