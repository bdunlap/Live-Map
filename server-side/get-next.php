<?php
error_reporting(-1);
require './include-path.php';
include INCLUDE_PATH.'/settings.php';

require './classes/Photo.php';
require './classes/PhotoStorage.php';

/**
 * Log4PHP setup
 */
require './log4php/Logger.php'; 
Logger::configure(INCLUDE_PATH.'/log4php.properties'); 

if (!isset($_logger)) {
    $_logger = Logger::getLogger('get-next');
}


$photoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT,
    array(
        'options' => array(
            'min_range' => 0,
            'max_range' => 5000,
        ),
    )
);

try {
    if ($photoId !== FALSE) {
        $nextPhoto = PhotoStorage::getPhoto($photoId);
    } else {
        $nextPhoto = PhotoStorage::getNextUnseen();
    }

} catch(Exception $e) {
    //log exception
    $_logger->error("Call to database failed... exception: " . $e);

    //return array with FAIL status
    $relevantData = array("status" => "FAIL");
    $JSData = json_encode($relevantData);
}

if (isset($nextPhoto)) {
    $JSData = encodeData($nextPhoto);
} else {
    $relevantData = array("status" => "EMPTY");
    $JSData = json_encode($relevantData);
}

echo $JSData;

/*
 * @return json representation of important data
 */
function encodeData($nextPhoto)
{
    $relevantData  = array( "status" => "SUCCESS",
                            "url" => $nextPhoto->url,
                            "thumbnailUrl" => $nextPhoto->thumbnailUrl,
                            "text" => $nextPhoto->text,
                            "location" => $nextPhoto->location
                          );
    return json_encode($relevantData);
}
?>
