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
     * @param string $gallery
     *
     * @throws SmugException
     * @throws Exception
     */
    public function uploadPhoto($photo, $gallery)
    {
        $imageData = file_get_contents($photo->url);
        if (!$imageData) {
            throw new Exception(__FUNCTION__ . ": couldn't download file "
				. " at [$photo->url]");
        }
        /**
         * TODO set a filename for SmugMug? If so, just use the gooId because we
         * know that's unique.
         *
         * It's not necessary if we are just emailing photos in, so I'm not
         * going to worry about it for now.
         */ 
        $filename = NULL;
    }
}
?>
