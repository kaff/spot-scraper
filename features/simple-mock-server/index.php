<?php

const RESPONSE_DIR = 'response';
$pageNumber = $_POST['pageNr'];
$jobSlug = $_GET['job'];

if (!empty($pageNumber)) {
    $fileWithResponse = 'jobOffersList' . DIRECTORY_SEPARATOR . $pageNumber . '.json';
    response('Content-Type: application/json', $fileWithResponse);
}

if (!empty($jobSlug)) {
    $fileWithResponse = 'jobOffer' . DIRECTORY_SEPARATOR . $jobSlug . '.html';
    response('Content-Type: text/html; charset=UTF-8', $fileWithResponse);
}

function response(string $header, string $fileWithResponse) {
    header($header);

    $fileWithResponse = dirname(__FILE__) . DIRECTORY_SEPARATOR
        . RESPONSE_DIR . DIRECTORY_SEPARATOR
        . $fileWithResponse;

    if (file_exists($fileWithResponse)) {
        echo file_get_contents($fileWithResponse);
        die;
    }
}
