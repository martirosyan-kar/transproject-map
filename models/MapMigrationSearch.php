<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MapMigration;

/**
 * MapMigrationSearch represents the model behind the search form about `app\models\MapMigration`.
 */
class MapMigrationSearch extends MapMigration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['region', 'district', 'community', 'description', 'image'], 'safe'],
            [['longitude', 'latitude'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MapMigration::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ]);

        $query->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'community', $this->community])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
