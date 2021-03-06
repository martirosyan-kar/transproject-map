<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MapMigrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Map Migrations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-migration-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Map Migration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'region',
            'district',
            'community',
            'longitude',
            // 'latitude',
            // 'description',
            // 'image',
            // 'cleaned',
            // 'cleaned_image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
