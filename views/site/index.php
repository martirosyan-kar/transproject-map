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
  var data = <?= json_encode($data); ?>;
  var infowindow = null;

  function initMap() {
    var uluru = {lat: 40.1555406, lng: 44.5457157};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      mapTypeId: 'satellite',
      center: uluru,
      scrollwheel: false
    });

    var pinIcon = new google.maps.MarkerImage(
      "http://images.transproject.am/map/pin.png",
      null, /* size is determined at runtime */
      null, /* origin is 0,0 */
      null, /* anchor is bottom center of the scaled image */
      new google.maps.Size(36, 48)
    );

    infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < data.length; i++) {
      var latLng =  {lat: +data[i].latitude, lng: +data[i].longitude};

      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: pinIcon
      });

      google.maps.event.addListener(marker, 'click', (function(marker,data,infowindow){
        return function() {
          if (infowindow) {
            infowindow.close();
          }

          infowindow.setContent(getContent(data));
          infowindow.open(map,marker);
        };
      })(marker,data[i],infowindow));


    }



    function getContent(data) {

      return '<div id="content">'+
        '<img class="map-image-max-size" src="'+data.image + '" />' +
        '<div id="bodyContent">'+
        '<p>' + data.description + '</p>'+
        '</div>'+
        '</div>';
    }
  }


</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJFP_x7Ux1gyyBJ7lxyWl6wexCmfRU8oI&callback=initMap">
</script>

