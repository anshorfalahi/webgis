<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web GIS</title>
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <link href="<?= base_url()?>assets/vendor/leaflet/leaflet.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.min.css">

  <style type="text/css">
    .user {
      padding: 5px;
      margin-bottom: 5px;
    }

    #mapid {
      height: 380px;
    }

    .peta {
      float: left;
      width: 50%;
    }

    .foto {
      float: right;
      width: 50%;
      height: 380px;
    }

    .foto img {
      height: 380px;
      width: 100%;
    }

    .detilpeta {
      width: 100%;
      padding-top: 20px;
    }
  </style>
</head>

<body>
    <div class="peta">
        <div id="mapid"></div>
    </div>
    <div class="foto owl-carousel">
        <?php foreach($dok as $data) { ?>
        <img src="<?= base_url()?>assets/images/<?= $data['gambar'] ?>">
        <?php } ?>
    </div>
    <div class="detilpeta">
        <h3>Informasi Detil Peta</h3>
        <h5>Nama Bidang : <?= $bidang['nama']; ?></h5>
        <h5>Keterangan : <?= $bidang['ket']; ?></h5>
    </div>
    
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="<?= base_url()?>assets/vendor/leaflet/leaflet.js"></script>
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>

<script type="text/javascript">
  var owl = $('.owl-carousel');
  owl.owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 1000,
    autoplayHoverPause: true
  });
</script>

<script type="text/javascript">
  var map = L.map('mapid').setView([-3.842695, 114.6620476], 13);
  var base_url = "<?= base_url() ?>";
  var v_kode = "<?= $kode ?>";
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

      $.getJSON(base_url + "assets/geojson/map.geojson", function (result) {
        geoLayer = L.geoJson(result, {
          style: function (feature) {
            var kode = feature.properties.kode;
            if (kode == v_kode) {
              return {
                fillOpacity: 0.8,
                fillColor: "#3dfc03",
                weight: 1,
                opacity: 1,
                color: "#ff0000 "
          };
            } else {
              return {
                fillOpacity: 0.0,
                weight: 1,
                opacity: 1,
                color: "#ff0000"
          };
            }
        },
        onEachFeature: function (feature, layer) {
          var kode = feature.properties.kode;
          var center = getCentroid(feature.geometry.coordinates[0]);
          if (kode == v_kode) {
            map.flyTo([center[1], center[0]], 18, {
              animate: true,
              duration: 1
            });
            L.marker([center[1], center[0]]).addTo(map);
          }
        }
      }).addTo(map);
    });
    var getCentroid = function (coord) {
      var center = coord.reduce(function (x, y) {
        return [x[0] + y[0] / coord.length, x[1] + y[1] / coord.length]
      }, [0, 0])
    return center;
  }

</script>
</body>
</html>