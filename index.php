<?php

$csvFile = "InventoryDetails.csv";
$csv = fopen($csvFile, "r");
$destination = './image/';

$sku = array();
$newCsvData = array();
// $data = array();

if ($csv !== FALSE) {
    $i = 0;
    while (!feof($csv)) {
        $data = fgetcsv($csv);
        if (!empty($data) && $i != 0) {
            array_push($sku, $data[0]);
            file_put_contents(
                $destination . basename($data[1]),
                file_get_contents($data[1])
            );
        }
        $i++;
        array_push($newCsvData, $data);
        // print_r($data);
    }
    array_push($newCsvData[0], 'New Url');

    $fileName = glob($destination . "*?", GLOB_BRACE);

    for ($index = 0; $index < count($fileName); $index++) {

        $size = getimagesize($fileName[$index]);
        $extension = explode('/', $size['mime'])[1];

        if ($extension == '') {
            $rename = "NULL";
            rename($fileName[$index], $destination . $rename);
        } else {
            $rename = $sku[$index] . "." . $extension;
            rename($fileName[$index], $destination . $rename);
        }

        array_push($newCsvData[$index + 1], $rename);
        unset($rename, $extension);
    }
}
print_r($newCsvData[42]);
fclose($csv);

$updatedCsv = fopen($csvFile, 'w');

if (!$updatedCsv)
    die("Something went wrong!");
// fseek($updatedCsv, 0);
foreach ($newCsvData as $coulmns) {
    fputcsv($updatedCsv, $coulmns);
}
fclose($updatedCsv);
?>
