<?php
/**
 * @package Live-Map
 *
 * @class Photo
 *
 * Responsible for uploading photos to SmugMug, along with an optional text
 * caption. If possible, will upload the photo to a specific gallery.
 */
class Photo
{
    public $text;
    public $twitterAccount;
    public $url;

    /**
     * Stores a photo on SmugMug
     *
     * This function needs to:
     *
     *  - Open the file and read its data
     *  - Generate a filename for SmugMug (?)
     *  - call _upload()
     *
     * @param string $gallery
     *
     * @throws PhotoException
     */
    public function store($gallery)
    {
        $imageData = $this->_getImage();
        if (!$imageData) {
            /**
             * TODO should we be using try/catch here instead?
             */
            throw new PhotoException("_getImage() failed");
        }
        /**
         * TODO set a filename for SmugMug? If so, just use the gooId because we
         * know that's unique.
         *
         * It's not necessary if we are just emailing photos in, so I'm not
         * going to worry about it for now.
         */ 
        $filename = NULL;
        $this->_upload($filename, $imageData, $gallery);
    }

    /**
     * Does the nitty-gritty uploading to SmugMug
     *
     * For now use the 'email a photo' method:
     *
     * http://www.smugmug.com/help/camera-phones
     */
    private function _upload($filename, $imageData, $gallery)
    {
        $imageSize = strlen($imageData);
        echo "Here we would upload an $imageSize-byte photo named $filename "
           . "to the $gallery gallery, with caption [$this->text]\n";
    }

    /**
     * Retrieves the raw image data at $this->url
     *
     * @return string
     */
    private function _getImage()
    {
        $imageData = file_get_contents($this->url);
        return $imageData;
    }
}

?>
