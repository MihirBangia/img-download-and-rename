<?php

function generateUniqueID()
{
    return uniqid();
}

$inputCsvFile = 'image.csv';
$outputCsvFile = 'output.csv';

if (($handle = fopen($inputCsvFile, 'r')) !== FALSE) {
    $outputData = [];
    while (($data = fgetcsv($handle)) !== FALSE) {
        $url = $data[1];
        $size = getimagesize($data[1]);
        $extension = explode('/', $size['mime'])[1];
        $uniqueID = generateUniqueID();
        $newFileName = $uniqueID . '.' . $extension;
        $imageData = file_get_contents($url);
        if ($imageData !== FALSE) {
            file_put_contents($newFileName, $imageData);
            $data[1] = $newFileName;
            $outputData[] = $data;
        } else {
            echo "Failed to download image from URL: $url\n";
        }
    }
    fclose($handle);
    if (($outputHandle = fopen($outputCsvFile, 'w')) !== FALSE) {
        foreach ($outputData as $row) {
            fputcsv($outputHandle, $row);
        }
        fclose($outputHandle);
        echo "Output CSV file created: $outputCsvFile\n";
    } else {
        echo "Failed to create output CSV file.\n";
    }
} else {
    echo "Failed to open input CSV file.\n";
}
?>