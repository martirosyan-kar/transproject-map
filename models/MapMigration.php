<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "map_migration".
 *
 * @property integer $id
 * @property string $region
 * @property string $district
 * @property string $community
 * @property string $latitude
 * @property string $longitude
 * @property string $description
 * @property string $image
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
            [['region', 'district', 'community', 'description', 'image'], 'string'],
            [['latitude', 'longitude'], 'number'],
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
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'description' => 'Description',
            'image' => 'Image',
        ];
    }
}
