<?php
require './settings.php';

require './Photo.php';
require './PhotoStorage.php';
require './FauxLogger.php';

$_logger = Logger::getLogger('get-next');

try {
    $nextPhoto = PhotoStorage::getNextUnseen();

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
                            "text" => $nextPhoto->text,
                            "location" => $nextPhoto->location
                          );
    return json_encode($relevantData);
}
?>
