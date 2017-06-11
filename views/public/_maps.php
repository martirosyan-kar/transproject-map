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
      mapTypeId: 'satellite',
      center: uluru,
      scrollwheel: false,
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
    return new google.maps.MarkerImage(
      "http://images.transproject.am/map/pin.png",
      null, /* size is determined at runtime */
      null, /* origin is 0,0 */
      null, /* anchor is bottom center of the scaled image */
      new google.maps.Size(36, 48)
    );
  }

  function getCleanedMarker() {
    return new google.maps.MarkerImage(
      "http://images.transproject.am/map/pin.png",
      null, /* size is determined at runtime */
      null, /* origin is 0,0 */
      null, /* anchor is bottom center of the scaled image */
      new google.maps.Size(36, 48)
    );
  }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJFP_x7Ux1gyyBJ7lxyWl6wexCmfRU8oI&callback=initMap">
</script>
