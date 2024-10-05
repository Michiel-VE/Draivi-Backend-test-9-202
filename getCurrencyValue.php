<?php

function getGBPValue($url) {
    $req = curl_init();

    curl_setopt($req, CURLOPT_URL, $url);
    // needed to save the response
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($req);


    if ($response === false) {
        echo 'Error: ' . curl_error($req);
    } else {
        $data = json_decode($response, true);
        return $data['quotes']['EURGBP'];
    }

    curl_close($req);
}
