<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $region
 * @property string $latitude
 * @property string $longitude
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'region', 'latitude', 'longitude'], 'required'],
            [['name', 'description', 'region', 'latitude', 'longitude'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'region' => 'Region',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
}
