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

    if(data.cleaned == 1) {
      var pinIcon = getCleanedMarker();
    }
    else if (data.cleaned == 2) {
      var pinIcon = getApprovedMarker();
    }
    else if (data.cleaned == 3) {
      var pinIcon = getDumpsitesMarker();
    }
    else {
      var pinIcon = getActiveMarker();
    }

    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      icon: pinIcon
    });

    google.maps.event.addListener(map,'click', function(event) {
      placeMarker(event.latLng, map);
    });
  }
</script>


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

    <?= $form->field($model, 'cleaned')->radio(['label' => 'Trash', 'value' => 0, 'uncheck' => null]) ?>

    <?= $form->field($model, 'cleaned')->radio(['label' => 'Cleaned', 'value' => 1, 'uncheck' => null]) ?>

    <?= $form->field($model, 'cleaned')->radio(['label' => 'Should be approved', 'value' => 2, 'uncheck' => null]) ?>

    <?= $form->field($model, 'cleaned')->radio(['label' => 'Main dumpsites', 'value' => 3, 'uncheck' => null]) ?>

    <?= $form->field($model, 'cleaned_image')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


