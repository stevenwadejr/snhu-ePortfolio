<?php

$filePath = __DIR__ . '/DAT220-final-project-data.json';
$destinationFile = __DIR__ . '/DAT220-groomed.json';
$surveyData = json_decode(file_get_contents($filePath), true);

$groomedData = [];

foreach ($surveyData as $data) {
    if (empty(trim($data['first_name'])) && empty(trim($data['last_name']))) {
        continue;
    }

    $groomedData[] = [
        'first_name' => trim($data['first_name']),
        'last_name' => trim($data['last_name']),
        'city' => trim($data['city']),
        'county' => trim($data['county']),
        'state' => trim($data['state']),
        'zip' => (string) str_pad($data['zip'], 5, '0', STR_PAD_LEFT),
        'ZIP_2' => $data['ZIP_2'],
        'Restaurant' => $data['Restaurant'],
        'RES_VISITS' => $data['RES_VISITS'],
        'WEB_PURCH_YN' => $data['WEB_PURCH_YN'] == 1 ? 'Y' : 'N',
        'Webstore_Spend' => $data['Webstore_Spend'],
        'WEB_VISITS' => $data['WEB_VISITS'],
        'THIRD_SPEND' => $data['THIRD_SPEND'],
        'THIRD_VISITS' => $data['THIRD_VISITS'],
        'Age' => $data['Age'],
        'Married_YN' => $data['Married_YN'],
        'MARR_BIN' => $data['MARR_BIN'],
        'Income' => $data['Income'],
        'Age Binned' => $data['Age Binned']
    ];
}

file_put_contents($destinationFile, json_encode($groomedData, JSON_PRETTY_PRINT));