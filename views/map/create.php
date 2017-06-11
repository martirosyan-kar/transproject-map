<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MapMigration */

$this->title = 'Create Map Migration';
$this->params['breadcrumbs'][] = ['label' => 'Map Migrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-migration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
