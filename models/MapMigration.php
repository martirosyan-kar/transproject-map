<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "map_migration".
 *
 * @property integer $id
 * @property string $region
 * @property string $district
 * @property string $community
 * @property string $longitude
 * @property string $latitude
 * @property string $description
 * @property string $image
 * @property integer $cleaned
 * @property string $cleaned_image
 */
class MapMigration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map_migration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region', 'district', 'community', 'description', 'image', 'cleaned_image'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['cleaned'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region' => 'Region',
            'district' => 'District',
            'community' => 'Community',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'description' => 'Description',
            'image' => 'Image',
            'cleaned' => 'Cleaned?',
            'cleaned_image' => 'Cleaned Image',
        ];
    }

    public static function getDataAndHierarchy()
    {
        $data = MapMigration::find()->asArray()->all();
        $hierarchy = [];
        foreach($data as $value) {
            $region = ucfirst(strtolower($value['region']));
            if(!isset($hierarchy[$region])) {
                $hierarchy[$region] = [];
            }

            $district = ucfirst(strtolower($value['district']));
            if(!isset($hierarchy[$region][$district])) {
                $hierarchy[$region][$district] = [];
            }

            $community = ucfirst(strtolower($value['community']));
            $hierarchy[$region][$district][] = $community;
        }

        return ['data'=>$data,'hierarchy'=>$hierarchy];
    }
}
