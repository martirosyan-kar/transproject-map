<?php
/**
 * Created by PhpStorm.
 * User: kar
 * Date: 5/27/17
 * Time: 10:31 PM
 */

namespace app\commands;


use app\models\MapMigration;
use yii\console\Controller;

/**
 * Class KmlController
 * @package app\commands
 *
 */
class KmlController extends Controller
{
    public function actionMigrate()
    {

        $xml = simplexml_load_file(__DIR__ . "/files/kml.xml") or die("Error: Cannot create object");
        $document = $xml->Document;
        $folders = $document->Folder;
        $sum = 0;
        foreach ($folders->Folder as $region) {
            echo $region->name."\n";
            foreach ($region->Folder as $district) {
                echo " ".$district->name. ' '. count($district->Placemark)."\n";
                foreach ($district->Placemark as $community) {

                    $data = new MapMigration();
                    $coords = explode(',',$community->Point->coordinates);

                    $latitude = $coords[0];
                    $longitude = $coords[1];
                    $arr = [
                        'region' => trim($region->name),
                        'district' => trim($district->name),
                        'community' => trim($community->name),
                        'description' => trim($community->description),
                        'image' => trim($community->image),
                        'latitude' => $latitude,
                        'longitude' => $longitude

                    ];

                    $data->setAttributes($arr);
                    if(!$data->validate()) {
                        p($arr);
                    }
                    else {
                        $data->save();
                    }
                }
            }



        }
    }
}