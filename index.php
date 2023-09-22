<?php

$csvFile = "simpleproducts.csv";
$csv = fopen($csvFile, "r");
$destination = './images/';

$sku = array();
$ext = array();
$newCsvData = array();
$data = array();

if ($csv !== FALSE) {
    fgetcsv($csv);
    while (!feof($csv)) {
        $data = fgetcsv($csv);
        if (!empty($data)) {
            array_push($sku, $data[0]);
            print_r($data[0]);
            $size = getimagesize($data[1]);
            $extension = explode('/', $size['mime'])[1];
            array_push($ext, $extension);

            file_put_contents(
                $destination . basename($data[1]),
                file_get_contents($data[1])
            );
        }
        array_push($newCsvData, $data);
        // print_r($data);

    }

    echo count($newCsvData);

    $fileName = glob($destination . "*?", GLOB_BRACE);
    print_r(count($fileName));

    for ($index = 0; $index < count($fileName); $index++) {
        $rename = $destination . $sku[$index] . "." . $ext[$index];
        rename($fileName[$index], $rename);
        array_push($newCsvData[$index], $sku[$index] . "." . $ext[$index]);
        unset($rename);
    }
    print_r($newCsvData);

}

fclose($csv);

$fpo = fopen($csvFile, 'w');

if (!$fpo)
    die("BROKE");
fseek($fpo, 0);
fputcsv($fpo, ['Sku', 'Image url', '', 'New image url']);
foreach ($newCsvData as $coulmns) {
    fputcsv($fpo, $coulmns);
}
fclose($fpo);
?>