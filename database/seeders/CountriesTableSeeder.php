<?php

namespace Database\Seeders;

use App\Models\CountryModel;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$url = 'https://cdn.markuslerner.com/travelscope/data/4.1.0/country_data.json?v=4.1.0.2';
        $json = json_decode(file_get_contents(public_path('countries_cities/country_data.json')), true);
        $features = $json['features'];
        $file = Excel::toArray(null, public_path('countries_cities/countries_centroids.xlsx'), null,
            \Maatwebsite\Excel\Excel::XLSX)[0];
        $centroides = collect($file)->mapWithKeys(function ($item, $key) {
            return [$item[0] => $item];
        })->toArray();


        foreach ($features as $feature) {
            $countryISO = $feature['properties']['ISO_A2'];
            if ($feature['properties']['ISO_A2'] == -99) {
                $countryISO = $feature['properties']['WB_A2'];
            }

            $country_type = $feature['properties']['featurecla'] === 'Admin-0 country';
            if ($country_type) {
                $country = CountryModel::create([
                    'name' => $feature['properties']['NAME'],
                    'WOEID' => $feature['properties']['WOE_ID'] ??'',//($countryISO == 'ss' ? 'E52B07D1-6BAC-4F7B-A942-69B7467545DA' : '') : '',
                    'postal' => $feature['properties']['POSTAL'],
                    'is_active' => false,
                    "iso_code" => strtolower($countryISO),
                    'calling_code' => '',
                    'continent' => $feature['properties']['CONTINENT'],
                    'properties' => [
                        'en' => $feature['properties']['NAME_EN'],
                        'ar' => $feature['properties']['NAME_AR'],
                        'tr' => $feature['properties']['NAME_TR'],
                        'fr' => $feature['properties']['NAME_FR'],
                    ],
                    "geometry" => $feature['geometry'],
                    "latitude" => $centroides[$countryISO][1] ?? '',
                    "longitude" => $centroides[$countryISO][2] ?? '',
                ]);
            }
        }
    }
}
