
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title> Codeigniter dan leaflet local </title>
          <link rel="shortcut icon" type="image/x-icon" href="https://telegra.ph/file/ef6105e92cab05d1a5eb3.jpg" />
        <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
          <!-- Bootstrap -->
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

          <link href="<?php echo base_url()?>assets/vendor/css/BootSideMenu.css" rel="stylesheet">
          <link href="<?php echo base_url()?>assets/vendor/leaflet/leaflet.css" rel="stylesheet">
          <!-- HTML5 shim e Respond.js per rendere compatibile l'HTML 5 in IE8 -->
          <!-- ATTENZIONE: Respond.js non funziona se la pagina viene visualizzata in locale file:// -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">
          .user{
            padding:5px;
            margin-bottom: 5px;
          }
          #mapid {
              height: 830px;
              width: 100%;
        }
        </style>
        </head>
        <body>

          <!--Test -->
          <div id="test">
            <h2>Boot Side Menu</h2>
            <div class="list-group">
              <a href="#" class="list-group-item active">Cras justo odio</a>
              <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
              <a href="#" class="list-group-item">Morbi leo risus</a>
              <a href="#" class="list-group-item">Morbi leo risus</a>
              <a href="#" class="list-group-item">Porta ac consectetur ac</a>
              <a href="#subTest" class="list-group-item">Sub menù test</a>
              <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
              <a href="#" class="list-group-item">Morbi leo risus</a>
              <a href="#" class="list-group-item">Porta Porta Porta sdaf s fs hfuis uif ac consectetur ac</a>
            </div>

            <div class="list-group submenu" id="subTest">
              <a href="#" class="list-group-item">Morbi leo risus</a>
              <a href="#subTestSub" class="list-group-item">Sub di Sub</a>
              <a href="#" class="list-group-item">Porta ac consectetur ac</a>
            </div> 

            <div class="list-group submenu" id="subTestSub">
              <a href="#" class="list-group-item">Morbi leo risus</a>
              <a href="#" class="list-group-item">Porta ac consectetur ac</a>
            </div>

          </div>


          <!--Normale contenuto di pagina-->
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="jumbotron">
                  <h1 class="text-center">WEB GIS</h1>
                  <div id="carbon-block"></div>
                <div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div id="mapid"></div>
          </div>
        </div>


          <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
          <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
          <script src="<?php echo base_url() ?>/assets/vendor/js/BootSideMenu.js"></script>
          <script src="<?php echo base_url() ?>/assets/vendor/leaflet/leaflet.js"></script> 


          <script type="text/javascript">
            $('#test').BootSideMenu({side:"left", autoClose:false});
        var map = L.map('mapid').setView([-3.7518489446813037, 114.76621379874221], 18);
        var base_url = "<?= base_url()?>";
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        L.marker([-3.608867,114.701415]).addTo(map)

        function groupClick(event)
        {
          console.log("Click on marker" + event.layer.id);
        }
        $.getJSON(base_url+"home/faskes", function(result){
          var iconFaskes = L.icon({
            iconUrl: base_url+'assets/images/marker/hospital-building.png',
            iconSize: [30, 30],
          });

          $.each(result, function(i, field){
            var faskes_lat = parseFloat(result[i].lat_faskes);
            var faskes_long = parseFloat(result[i].long_faskes);

            var myFeatureGroup = L.featureGroup()
            .on('click', groupClick)
            .addTo(map);

            markerFaskes = L.marker([faskes_long,faskes_lat], {icon: iconFaskes})
            .bindPopup(result[i].nama_faskes)
            .addTo(myFeatureGroup);
            markerFaskes.id = result[i].id_faskes;
          });
        });

        $.getJSON(base_url+"assets/geojson/map.geojson", function(result){
          geoLayer = L.geoJson(result, {
            style: function (feature) {
              var kategori = feature.properties.kategori;
                if (kategori == 1) {
                    return {
                      fillOpacity: 0.8,
                      weight: 1,
                      opacity: 1,
                      color: "#3dfc03"
                    };
                } else if (kategori == 2) {
                    return {
                      fillOpacity: 0.8,
                      weight: 1,
                      opacity: 1,
                      color: "#FF0000"
                    };
                } else {
                    return {
                      fillOpacity: 0.8,
                      weight: 1,
                      opacity: 1,
                      color: "#0000FF"
                    };
                }
            },
            onEachFeature: function(feature, layer){
                  var kode = feature.properties.kode;
                  var detail = feature.properties.detail;
              $.getJSON(base_url+"home/foto/"+kode, function(result){
              var info_bidang = "<h4 style='text-align:center'>Info Bidang</h4>";
                  info_bidang += "<a href='<?= base_url()?>home/detilbidang/"+kode+"'><img src='<?= base_url() ?>assets/images/"+result+"' width=100%></a>";
                  info_bidang += "<h5 style='text-align:center'><a href='<?= base_url()?>home/detilbidang/"+kode+"'>"+detail+"</a></h5>";

                layer.bindPopup(info_bidang, {
                    maxWidth: 230,
                    closeButton: true,
                    offset: L.point(0, 20)
                });
                layer.on('click', function(){
                  layer.openPopup();
                });
              });
                
              
            }
          }).addTo(map);
          
        });
          </script>

<!-- <script>
  onEachFeature: function(feature, layer){
              var lat = parseFloat(feature.properties.latitude);
              var kode = feature.properties.kode;
              var foto = feature.properties.foto;
              var detail = feature.properties.detail;
              var info_bidang = "<h4 style='text-align:center'>Info Bidang</h4>";
              info_bidang += "<a href='<?= base_url()?>home/detilbidang/"+kode+"'><img src='"+foto+"' width=100%></a>";
              info_bidang += "<h5 style='text-align:center'><a href='<?= base_url()?>home/detilbidang/"+kode+"'>"+detail+"</a></h5>";

              layer.bindPopup(info_bidang, {
                maxWidth: 230,
                closeButton: true,
                offset: L.point(0, 20)
                });

              layer.on('click', function(){
                layer.openPopup();
              });
            }
</script> -->
        </body>
        </html>

