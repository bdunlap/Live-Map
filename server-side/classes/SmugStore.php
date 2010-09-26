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
	 * @var phpSmug
	 */
	static private $_smugMugSvc = NULL;

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
        
		if (is_null(self::$_smugMugSvc)) {
			self::$_smugMugSvc = new phpSmug(array(
				"APIKey" => $settings['smugmug_apikey'], 
				"AppName" => "SmugTweet (http://gallupbid.digitalcraftworks.com/)", 
			));
		}
        

		self::$_smugMugSvc->login(array(
            "EmailAddress" => $settings['smugmug_email'], 
            "Password" => $settings['smugmug_password'],
        ));
        
		$_logger->info("about to upload to album [$albumId]");
		self::$_smugMugSvc->images_uploadFromURL(array(
			"URL" => $photo->url,
            "FileName" => $photo->gooId,
            "AlbumID" => $albumId,
        ));
    }
}
?>
