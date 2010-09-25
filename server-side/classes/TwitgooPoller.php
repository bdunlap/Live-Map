<?php
/**
 * @package Live-Map
 */

class TwitgooPoller
{
    /**
     * @param array $twitterAccounts List of Twitter usernames to poll
     *
     * @return array List of Photo objects
     *
     * @static
     * 
     * @throws TwitgooException if we encounter something weird
     */
    static public function PollTwitter($twitterAccounts)
    {
        // grab the global logger
        global $_logger;
        $photos = array();

        try {
            foreach ($twitterAccounts as $account) {
                $twitterResponse = self::_getPhotoResponse($account);
                $photoArrayForAccount = self::_parseResponse($twitterResponse, $account);
                $photos = array_merge($photos, $photoArrayForAccount);
            }
        } catch (TwitgooException $e) {
            // log, re-throw
            $_logger->error("Encountered an error polling twitter for photos.", $e);
            throw $e;
        }

        return $photos;
    }

    /**
     * @param string $account Twitter username
     *
     * @return string
     * 
     * @throws TwitgooException
     */
    static private function _getPhotoResponse($account)
    {
        // grab the global logger
        global $_logger;

            $url = 'http://twitgoo.com/api/user/timeline/' . $account;
            $response = file_get_contents($url);

            if ($response === FALSE) {
                // file_get_contents failed
                $_logger->error(
                	"Encountered error getting photo from twitgoo account '$account'.");
                throw new TwitgooException(
                	"Encountered error getting photo from twitgoo account '$account'.");
            }

        return $response;
    }

    /**
     * @param string $response From Twitgoo API call
     * @param string $account Twitter username
     *
     * @return array List of Photo objects
     * 
     * @throws TwitgooException
     */
    static private function _parseResponse($response, $account) 
    {
        // grab the global logger
        global $_logger;
        
        // parse the XML response
        $xmlobject = simplexml_load_string($response);

        if ($xmlobject === FALSE) {
            // simplexml_load_string failed
            $_logger->error(
                	"Encountered error parsing response '$response' from twitgoo account '$account'.");
            throw new TwitgooException(
                	"Encountered error parsing response from twitgoo account '$account'.");
        }

        $images = array();

        try {
            foreach ($xmlobject->children() as $media) {
                //get text and URL
                $text = strval($media->text);
                $imageUrl = strval($media->imageurl);
                $thumbnailUrl = strval($media->thumburl);
                $gooId = strval($media->mediaid);

                $imgObj = new Photo();

                //TODO use getters and setters here?
                $imgObj->text = $text;
                $imgObj->twitterAccount = $account;
                $imgObj->url = $imageUrl;
                $imgObj->thumbnailUrl = $thumbnailUrl;
                $imgObj->gooId = $gooId;

                $images[] = $imgObj;
            }
        } catch (Exception $e) {
            $_logger->error(
            	"Caught Exception parsing through XML twitgoo response.", $e);
            throw new TwitgooException(
            	"Caught Exception parsing through XML twitgoo response.", $e);
        }

        return $images;
    }
}

class TwitgooException extends Exception {} 

?>
