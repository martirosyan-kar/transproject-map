<?php
use app\assets\SlickAsset;
use app\assets\UnderscoreAsset;
SlickAsset::register($this);
UnderscoreAsset::register($this);
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
  var markers = [];
  var map;

  var labelObject =  {
    color: 'white',
    fontWeight: 'bold',
    text: ''
  };

  function clearMarkers() {
    setMapOnAll(null);
  }

  function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }

  function initMapData(map, data) {
    infowindow = new google.maps.InfoWindow();

    for (var i = 0; i < data.length; i++) {
      var latLng =  {lat: +data[i].latitude, lng: +data[i].longitude};

      if(data[i].cleaned == 1) {
        var pinIcon = getCleanedMarker();
      }
      else if (data[i].cleaned == 2) {
        var pinIcon = getApprovedMarker();
      }
      else {
        var pinIcon = getActiveMarker();
      }

      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: pinIcon,
        hoverContent: data[i].community
      });

      markers.push(marker);

      google.maps.event.addListener(marker, 'click', (function(marker,data,infowindow){
        return function() {
          if (infowindow) {
            infowindow.close();
          }

          infowindow.setContent(getInfoWindowContent(data));
          infowindow.open(map,marker);


          setTimeout(function(){
            $('#slides_'+data.id).bxSlider({
              slideWidth: 450
            });
          },700);

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
      '<ul id="slides_'+data.id+'" class="slides">' +
      '<li><img class="map-image-max-size" src="'+data.image + '" /></li>' +
      ((data.cleaned == 1 || data.cleaned == 2)? '<li><img class="map-image-max-size" src="'+data.cleaned_image + '" /></li>' : '') +
      '</ul></div>';
  }

  function initMap() {
    map = generateMap();
    initMapData(map, data);
  }
  function initNewData(data) {
    clearMarkers();
    initMapData(map,data);
  }

  window.onload=function(){
    $('#searchButton').on('click',function() {
      var val = $('#searchText').val().toUpperCase();
      if(val.length > 2) {
        var newData = _.filter(data,function(row){
          return row.region.toUpperCase().indexOf(val) !== -1 || row.district.toUpperCase().indexOf(val) !== -1 || row.community.toUpperCase().indexOf(val) !== -1;
        });

        initNewData(newData);
      }
      return false;
    });
  };

</script>

<div class="container">
    <div class="input-group">
        <input id="searchText" value="" class="form-control" type="text">
        <span class="input-group-btn">
               <button class="btn btn-default" id="searchButton">
                   <span class="glyphicon glyphicon-search"></span>
               </button>
            </span>
    </div>
</div>

<div class="cols-xs-12">
    <?= $this->render('//public/_maps'); ?>
</div>
