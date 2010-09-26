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
require './include-path.php';
include INCLUDE_PATH.'/settings.php';

require './classes/TwitgooPoller.php';
require './classes/Photo.php';
require './classes/PhotoStorage.php';
require './classes/SmugStore.php';
require './phpSmug/phpSmug.php';

/**
 * Log4PHP setup
 */
require './log4php/Logger.php'; 
Logger::configure(INCLUDE_PATH.'/log4php.properties'); 

if (!isset($_logger)) {
    $_logger = Logger::getLogger('poll-twitter');
}

$startMsg = "BEGIN RUN: ".date('r');
$_logger->info($startMsg);
echo "$startMsg\n";

$accountsToPoll = array(
	'GallupBIDFire8',
	'GallupBIDFire10',
	'GallupBIDFire2',
	'GallupBIDFireG',
	'GallupBIDFireF2',
	'GallupBIDFireF1',
    'GallupBIDFireA2',
    'GallupBIDFire6',
    'GallupBIDFire3',
    'GallupBIDFire5',
    'GallupBIDFire4',
);

try {
    $photos = TwitgooPoller::PollTwitter($accountsToPoll);
} catch(TwitgooException $e) {
    die ("Couldn't poll twitter. Exception follows.\n"
        . print_r($e, 1)
    );
}

/**
 * Each Twitter account is associated with a specific location.  Map those
 * associations here, thus:
 *
 *      <twitter account> => <Location Name>
 */
$twitterToLocation = array(
	'GallupBIDFire8' => 'Coal_Mining_Era_Mural',
	'GallupBIDFire10' => 'Navajo_Code_Talkers_Mural',
	'GallupBIDFire2' => 'Great_Gallup_Mural',
	'GallupBIDFireG' => 'Mission_G_Painted_Horse_Sculpture',
	'GallupBIDFireF2' => 'Mission_F2_Code_Talkers_Statue',
	'GallupBIDFireF1' => 'Mission_F1_Chief_Manuelito_Statue',
    'GallupBIDFireA2' => 'Mission_A2_First_American_Traders',
    'GallupBIDFire6' => 'Womens_MultiCultural_Mural',
    'GallupBIDFire3' => 'Zuni_Mural',
    'GallupBIDFire5' => 'Veterans_Mural',
    'GallupBIDFire4' => 'Long_Walk_Home_Mural',
);

define('DEFAULT_GALLERY', '13897183'); // Album ID for album titled: To Be Sorted
$galleryIds = array(
    'Coal_Mining_Era_Mural' => '13917226',
    'Navajo_Code_Talkers_Mural' => '13917204',
    'Great_Gallup_Mural' => '13917195',
    'Mission_G_Painted_Horse_Sculpture' => '13917166',
    'Mission_F2_Code_Talkers_Statue' => '13917155',
    'Mission_F1_Chief_Manuelito_Statue' => '13917148',
    'Mission_A2_First_American_Traders' => '13917122',
    'Womens_MultiCultural_Mural' => '13923530',
    'Zuni_Mural' => '13923538',
    'Veterans_Mural' => '13923547',
    'Long_Walk_Home_Mural' => '13923595',
);

$photosAdded = $photosUploaded = 0;
foreach ($photos as $photo) {
	$location = "unknown";
	if (isset($twitterToLocation[$photo->twitterAccount])) {
		$location = $twitterToLocation[$photo->twitterAccount];
	}
	$photo->location = $location;

	$gallery = DEFAULT_GALLERY;
	if (isset($galleryIds[$location])) {
		$gallery = $galleryIds[$location];
	}


	try {
		$_logger->info("about to add photo {$photo->gooId} to local storage");
		PhotoStorage::addPhoto($photo);
		$_logger->info("added photo {$photo->gooId} to local storage");
		$photosAdded++;

		$_logger->info("about to upload photo {$photo->gooId} to SmugMug gallery $gallery");
		SmugStore::uploadPhoto($photo, $gallery);
		$_logger->info("uploaded photo {$photo->gooId} to SmugMug gallery $gallery");
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
