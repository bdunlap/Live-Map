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
     */
    static public function PollTwitter($twitterAccounts)
    {
        $photos = array();

        foreach ($twitterAccounts as $account) {
            $twitterResponse = self::_getPhotoResponse($account); 
            $photoArrayForAccount = self::_parseResponse($twitterResponse, $account); 
            $photos = array_merge($photos, $photoArrayForAccount);
        }

        return $photos;
    }

    /**
     * @param string $account Twitter username
     *
     * @return string
     */
    static private function _getPhotoResponse($account)
    {
        $url = 'http://twitgoo.com/api/user/timeline/' . $account;
        $response = file_get_contents($url);
        return $response;
    }

    /**
     * @param string $response From Twitgoo API call
     * @param string $account Twitter username
     *
     * @return array List of Photo objects
     */
    static private function _parseResponse($response, $account) 
    {
        $xmlobject = simplexml_load_string($response);

        //TODO check response status(?)

        $images = array();

        foreach ($xmlobject->children() as $media) {
            //get text and URL
            $text = strval($media->text); 
            $imageUrl = strval($media->imageurl);

            $imgObj = new Photo();

            //TODO use getters and setters here?
            $imgObj->text = $text;
            $imgObj->twitterAccount = $account;
            $imgObj->url = $imageUrl;

            $images[] = $imgObj;
        }
        return $images;
    }
}

?>
