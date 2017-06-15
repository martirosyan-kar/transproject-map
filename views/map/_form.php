<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MapMigration */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    #map {
        height: 500px;
    }
</style>

<div class="map-migration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region')->textInput() ?>

    <?= $form->field($model, 'district')->textInput() ?>

    <?= $form->field($model, 'community')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <div class="">
        <?= $this->render('//public/_maps'); ?>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => '10']) ?>

    <?= $form->field($model, 'image')->textInput() ?>

    <?= $form->field($model, 'cleaned')->checkbox() ?>

    <?= $form->field($model, 'cleaned_image')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
  var newMarker = null;
  function placeMarker(location, map) {

    var pinIcon = getActiveMarker();

    if (newMarker == null)
    {
      newMarker = new google.maps.Marker({
        position: location,
        map: map,
        icon: pinIcon
      });
    }
    else
    {
      newMarker.setPosition(location);
    }

    $('#mapmigration-longitude').val(location.lng());
    $('#mapmigration-latitude').val(location.lat());
  }

  function initMap() {
    var map = generateMap();

    var data = <?= json_encode($model->getAttributes()); ?>;

    var latLng =  {lat: +data.latitude, lng: +data.longitude};

    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      icon: getActiveMarker()
    });

    google.maps.event.addListener(map,'click', function(event) {
      placeMarker(event.latLng, map);
    });
  }
</script>
