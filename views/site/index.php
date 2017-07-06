<?php
use app\assets\SlickAsset;
use app\assets\UnderscoreAsset;
use app\assets\TreeAsset;
SlickAsset::register($this);
UnderscoreAsset::register($this);
TreeAsset::register($this);
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
  var hierarchy = <?= json_encode($hierarchy); ?>;
  var infowindow = null;
  var markers = [];
  var map;
  var editPermission = '<?= Yii::$app->user->can('map.*'); ?>';

  var labelObject =  {
    color: 'white',
    fontWeight: 'bold',
    text: ''
  };

  function clearMarkers() {
    setMapOnAll(null);
  }

  function getTree() {
    var data = [];
    _.each(hierarchy, function(districts, region) {
      var regionObject = {
        text: region,
        nodes: [],
        state: {
          checked: true,
          expanded: false
        }
      };

      _.each(districts, function(communities, district){
        var districtObject = {
          text:district,
          nodes: [],
          state: {
            checked: true,
          }
        };
        _.each(communities, function(community){
          districtObject.nodes.push({
            'text':community,
            state: {
              checked: true,
            }
          });
        });
        regionObject.nodes.push(districtObject);
      });
      data.push(regionObject);
    });
    return data;
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
      else if (data[i].cleaned == 3) {
        var pinIcon = getDumpsitesMarker();
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
      ((editPermission === "1")?'<div><h4><a href="/map/update/' + data.id + '" target="_blank">Edit</a></h4></div>':'') +
      '<div id="bodyContent">'+
      '<p>' + data.description + '</p>'+
      '</div>'+
      '<ul id="slides_'+data.id+'" class="slides">' +
      '<li><img class="map-image-max-size" src="'+data.image + '" /></li>' +
      ((data.cleaned == 1 || data.cleaned == 2 || data.cleaned == 3)? '<li><img class="map-image-max-size" src="'+data.cleaned_image + '" /></li>' : '') +
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
    $('#searchText').on('keyup',function(e) {
      var code = (e.keyCode ? e.keyCode : e.which);
      if (code==13) {
        $('#searchButton').trigger('click');
      }
    });

    $('#searchButton').on('click',function() {
      var val = $('#searchText').val().toUpperCase();
      if(val.length > 2) {
        generatePinsBasedOnText(data,val);
      }
      return false;
    });

    function generatePinsBasedOnText(data,val) {
      var newData = _.filter(data,function(row){
        return row.region.toUpperCase().indexOf(val) !== -1 || row.district.toUpperCase().indexOf(val) !== -1 || row.community.toUpperCase().indexOf(val) !== -1;
      });
      initNewData(newData);
    }

    function generatePinsBasedOnArray(data, array) {
      var newData = _.filter(data, function(row) {
        return array.indexOf(row.region.toUpperCase() + ' ' + row.district.toUpperCase() + ' ' + row.community.toUpperCase()) !== -1;
      });
      initNewData(newData);
    }

    var $checkableTree = $('#tree').treeview({
        data: getTree(),
        showIcon: false,
        showCheckbox: true,
        onNodeChecked: function(event, node) {
          checkChildren(node);
          filterMap();
        },
        onNodeUnchecked: function(event, node) {
          unCheckParent(node);
          unCheckChildren(node);
          filterMap();
        }
      }
    );

    function checkChildren(node) {
      if(node.nodes) {
        _.each(node.nodes,function(childNode){
          $checkableTree.treeview('checkNode',[childNode.nodeId, {silent: true}]);
          checkChildren(childNode);
        });
      }
    }

    function unCheckParent(node) {
      var parentNode = $checkableTree.treeview('getParent', node);
      if(parentNode.state) {
        $checkableTree.treeview('uncheckNode', [parentNode.nodeId, {silent: true}]);
        unCheckParent(parentNode);
      }
    }

    function unCheckChildren(node) {
      if(node.nodes) {
        _.each(node.nodes,function(childNode){
          $checkableTree.treeview('uncheckNode',[childNode.nodeId, {silent: true}]);
          unCheckChildren(childNode);
        });
      }
    }

    function filterMap() {
      var checkedRows = $checkableTree.treeview('getChecked');
      var textArray = _.map(checkedRows, function(node){
        if(!node.nodes) {
          var parentNode = $checkableTree.treeview('getParent', node);
          var grandParentNode = $checkableTree.treeview('getParent', parentNode);
          return grandParentNode.text.toUpperCase() + ' ' + parentNode.text.toUpperCase() + ' ' + node.text.toUpperCase();
        }
      });
      generatePinsBasedOnArray(data,textArray);
    }

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

<div class="cols-xs-12" style="position: relative">
    <div class="hidden-xs col-sm-6 col-md-3" style="position: absolute; z-index: 999; top: 20px; left: 20px;">
        <div id="tree"></div>
    </div>
    <?= $this->render('//public/_maps'); ?>
</div>


