<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function readExcelFromUrl($url) {
    $tempFile = tempnam(sys_get_temp_dir(), 'excel');
    $fileContent = file_get_contents($url);


    if ($fileContent === false) {
        die("Error downloading file from the URL.");
    }

    file_put_contents($tempFile, $fileContent);


    $spreadsheet = IOFactory::load($tempFile);
    unlink($tempFile);

    $data = $spreadsheet->getActiveSheet()->toArray();

    return $data;
}
