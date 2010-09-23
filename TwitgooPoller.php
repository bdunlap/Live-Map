<?php

function PollTwitter($twitterAccounts) {

    //TODO temporary
    $twitterAccounts = array("bidPrototype");

    $photos = array();

    foreach ($twitterAccounts as $account) {
        $twitterResponse = getPhotoResponse($account); 
        $photoArrayForAccount = parseResponse($twitterResponse, $account); 
        $photos = array_merge($photos, $photoArrayForAccount);
    }

    return $photos;
}

function getPhotoResponse($account)
{
    $url = 'http://twitgoo.com/api/user/timeline/' . $account;
    $response = file_get_contents($url);
    return $response;
}

function parseResponse($response, $account) 
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

?>
