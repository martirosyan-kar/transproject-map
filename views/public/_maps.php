<?php
/**
 * Created by PhpStorm.
 * User: kar
 * Date: 6/11/17
 * Time: 8:38 AM
 *
 * This view is for generating the map.
 * IMPORTANT: initMap function should be defined in the view calling this view
 */


?>

<div id="map"></div>
<script>


  function generateMap() {
    var uluru = {lat: 40.1555406, lng: 44.5457157};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      mapTypeId: 'hybrid',
      center: uluru,
      scrollwheel: true,
      mapTypeControl: false,
      zoomControl: true,
      scaleControl: true,
      streetViewControl: false,
      rotateControl: false,
      fullscreenControl: false
    });

    return map;
  }

  function getActiveMarker () {
    return {
      labelOrigin: new google.maps.Point(23, 30),
      url: 'http://images.transproject.am/map/pin.png',
      size: new google.maps.Size(23, 30),
      scaledSize: new google.maps.Size(23, 30)
    };
  }

  function getCleanedMarker() {
    return {
      labelOrigin: new google.maps.Point(23, 30),
      url: 'http://images.transproject.am/map/pin.png',
      size: new google.maps.Size(23, 30),
      scaledSize: new google.maps.Size(23, 30)
    };
  }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJFP_x7Ux1gyyBJ7lxyWl6wexCmfRU8oI&callback=initMap">
</script>
