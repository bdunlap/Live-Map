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
        $error = FALSE;
        
        foreach ($twitterAccounts as $account) {
			$_logger->info(__FUNCTION__ . ": about to poll $account");
            try {
                $twitterResponse = self::_getPhotoResponse($account);
                $photoArrayForAccount = self::_parseResponse($twitterResponse, $account);
                $photos = array_merge($photos, $photoArrayForAccount);
            } catch (TwitgooException $e) {
                // log, continue if possible
                $_logger->error("Encountered an error polling twitter for photos "
                    ."from '$account'. Trying next account.", $e);
                $error = TRUE;
                continue;
            }
        }

        if($error === TRUE && empty($photos)) {
            // at least 1 account errored out, AND
            // there are no results from any account(s)
            $_logger->error("Error(s) encountered, and no results found, from "
                ."any of the Twitter accounts in '$twitterAccounts'.");
            throw new TwitgooException("All Twitter accounts failed polling for photos.");
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
				$_logger->debug("examining ".count($xmlobject->children())." media elements");
                //get text and URL
                $text = strval($media->text);

                $imageUrl = filter_var(strval($media->imageurl), FILTER_VALIDATE_URL);
				if ($imageUrl === FALSE) {
					$msg = ("got invalid image URL from Twitgoo");
					$_logger->error($msg);
					throw new TwitgooException($msg);
				}

                $thumbnailUrl = filter_var(strval($media->thumburl), FILTER_VALIDATE_URL);
				if ($thumbnailUrl === FALSE) {
					$msg = ("got invalid thumbnail URL from Twitgoo");
					$_logger->error($msg);
					throw new TwitgooException($msg);
				}

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
				"Caught Exception parsing through XML twitgoo response.");
        }

        return $images;
    }
}

class TwitgooException extends Exception {} 

?>
