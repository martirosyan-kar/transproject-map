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

<script>
  var data = <?= json_encode($data); ?>;
  var infowindow = null;

  var labelObject =  {
    color: 'white',
    fontWeight: 'bold',
    text: ''
  };

  function initMapData(map) {
    var pinIcon = getActiveMarker();
    infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < data.length; i++) {
      var latLng =  {lat: +data[i].latitude, lng: +data[i].longitude};

      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: pinIcon,
        hoverContent: data[i].community
      });

      google.maps.event.addListener(marker, 'click', (function(marker,data,infowindow){
        return function() {
          if (infowindow) {
            infowindow.close();
          }

          infowindow.setContent(getInfoWindowContent(data));
          setTimeout(function(){
            infowindow.open(map,marker);
          },300);

          window.scrollTo(0, 0);
        };
      })(marker,data[i],infowindow));

      google.maps.event.addListener(marker,'mouseover',function(e){
          var label = labelObject;
          label.text = this.get('hoverContent');
          this.set('label', label);
      });

      google.maps.event.addListener(marker,'mouseout',function(e){
        this.set('label', null);
      });
    }
  }

  function getInfoWindowContent(data) {

    return '<div id="content" class="infoContent">'+
      '<div id="bodyContent">'+
      '<p>' + data.description + '</p>'+
      '</div>'+
      '<img class="map-image-max-size" src="'+data.image + '" />' +
      '</div>';
  }

  function initMap() {
    var map = generateMap();
    initMapData(map);
  }

</script>

<div class="cols-xs-12">
    <?= $this->render('//public/_maps'); ?>
</div>
