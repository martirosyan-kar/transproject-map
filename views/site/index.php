<?php

/* @var $this yii\web\View */

$this->title = 'Trash Map';
?>
<style>
    #map {
        height: 100% !important;
        padding-bottom: 50%;
        position: relative;
        width: 100%;
    }
</style>
<div class="cols-xs-12">
    <div id="map"></div>
</div>
<script>
  function initMap() {
    var uluru = {lat: 40.1555406, lng: 44.5457157};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: uluru
    });
  }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJFP_x7Ux1gyyBJ7lxyWl6wexCmfRU8oI&callback=initMap">
</script>

