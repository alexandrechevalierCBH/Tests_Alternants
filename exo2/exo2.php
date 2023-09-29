<?php

// define the API url and the fuels to check
const API = "https://data.economie.gouv.fr/api/explore/v2.1/catalog/datasets/prix-des-carburants-en-france-flux-instantane-v2/records?limit=-1";
const FUELS = ['Gazole', 'SP95', 'SP98'];

// calls the function to get the cheapest prices
try {
    getCheapestPrices();
} catch (Exception $e) {
    echo "Error while fetching datas from API: ";
    return;
}

function getCheapestPrices(array $fuels = FUELS, string $api = API): void
{
    // get the datas from the API
    $json = @file_get_contents($api);

    if ($json === false) {
        throw new Exception("Impossible de récupérer les données depuis l'API.");
    }

    // decode the json
    $datas = json_decode($json, true);

    // initialize the array to store the datas by region
    $regions_datas = [];

    // loop through the datas
    foreach ($datas['results'] as $record) {

        // initialize the array to store the prices
        $regions = $record['region'];

        if (isset($record['prix']) && $record['prix'] != null) {

            // decode the prices
            $prices = json_decode($record['prix'], true);
        }

        if (is_array($prices) && !empty($prices)) {
            foreach ($prices as $fuel_infos) {

                // get the fuel name and price
                $fuel_name = $fuel_infos['@nom'];
                $fuel_price = (float)$fuel_infos['@valeur'];

                // check if the fuel is in the list and if the price is lower than the previous one
                if (in_array($fuel_name, $fuels)) {
                    if (!isset($regions_datas[$regions][$fuel_name]) || $fuel_price < $regions_datas[$regions][$fuel_name]['prix']) {

                        // store the datas
                        $regions_datas[$regions][$fuel_name] = [
                            'prix' => $fuel_price,
                            'adresse' => $record['adresse'],
                            'cp' => $record['cp'],
                            'ville' => $record['ville'],
                        ];
                    }
                }
            }
        }
    }

    // display the results
    foreach ($regions_datas as $region => $carburants) {
        echo $region . PHP_EOL;
        foreach ($carburants as $fuel_name => $info) {
            echo "  $fuel_name : " . $info['prix'] . '€ / ' . $info['adresse'] . " " . $info['cp'] . " " . $info['ville'] . PHP_EOL;
        }
    }
}
