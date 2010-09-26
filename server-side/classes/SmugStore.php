<?php
/**
 * @package Live-Map
 *
 * @class SmugStore
 *
 *
 */
class SmugStore
{
    /**
     * Stores a photo on SmugMug
     *
     * This function needs to:
     *
     *  - Open the file and read its data
     *  - Generate a filename for SmugMug (?)
     *  - call _upload()
     *
	 * @param Photo
     * @param int $albumId
     *
     * @throws SmugException
     * @throws Exception
     */
    static public function uploadPhoto($photo, $albumId)
    {
        // grab the global log4php instance
        global $_logger, $settings;
        
        $imageData = file_get_contents($photo->url);
        if (!$imageData) {
            throw new Exception(__FUNCTION__ . ": couldn't download file "
				. " at [$photo->url]");
        }
        
        $smugMugSvc = new phpSmug(array(
			"APIKey" => $settings['smugmug_apikey'], 
			"AppName" => "SmugTweet (http://gallupbid.digitalcraftworks.com/)", 
        ));
        
        $smugMugSvc->login(array(
            "EmailAddress" => $settings['smugmug_email'], 
            "Password" => $settings['smugmug_password']
        ));
        
        $smugMugSvc->images_upload(array(
			"File" => $photo->url,
//            "FileName" => $photo->gooId,
            "AlbumID" => $albumId
        ));
    }
}
?>
