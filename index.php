<?php

$csvFile = "image.csv";
$csv = fopen($csvFile, "r");
$destination = './product/';

$sku = array();
$newCsvData = array();
$fileName = array();


if ($csv !== FALSE) {
    $i = 0;
    while (!feof($csv)) {
        $data = fgetcsv($csv);


        if (!empty($data) && $i != 0) {
            array_push($sku, $data[0]);
            array_push($fileName, $destination . basename($data[1]));


            $size = getimagesize($data[1]);
            $extension = explode('/', $size['mime'])[1];
            // print_r($extension);
            // echo "<br/>";


            if ($extension == '') {
                echo "extension not found";
                continue;
            }
            file_put_contents(
                $destination . basename($data[1]),
                file_get_contents($data[1])
            );

        }
        $i++;
        array_push($newCsvData, $data);

    }
    array_push($newCsvData[0], 'New Url');



    // for ($index = 0; $index < count($fileName); $index++) {

    //     $size = getimagesize($fileName[$index]);
    //     $extension = explode('/', $size['mime'])[1];

    //     $rename = uniqid($index) . '.' . $extension;
    //     rename($fileName[$index], $destination . $rename);

    //     array_push($newCsvData[$index + 1], $rename);
    //     unset($rename, $extension);
    // }
}
// print_r($fileName);
// echo "<br/> ";
fclose($csv);


// $updatedCsv = fopen('finalProductImage.csv', 'w');

// if (!$updatedCsv)
//     die("Something went wrong!");
// fseek($updatedCsv, 0);
// foreach ($newCsvData as $coulmns) {
//     fputcsv($updatedCsv, $coulmns);
// }
// fclose($updatedCsv);
?>