<?php
include_once 'header.php';
include 'locations_model.php';
//get_unconfirmed_locations();exit;
?>

<style>
    #image_data img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
</style>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw">
</script>

<div id="map"></div>
<script>
    /**
     * Create new map
     */
    var infowindow;
    var map;
    var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
    var purple_icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
    var locations = <?php get_confirmed_locations() ?>;
    var centerMap = {
        lat: -6.175168397319318,
        lng: 106.8272493571782
    };
    var myOptions = {
        zoom: 15,
        center: new google.maps.LatLng(centerMap.lat, centerMap.lng),
        mapTypeId: 'roadmap'
    };
    map = new google.maps.Map(document.getElementById('map'), myOptions);
    let agenda = [];

    /**
     * Global marker object that holds all markers.
     * @type {Object.<string, google.maps.LatLng>}
     */
    var markers = {};

    /**
     * Concatenates given lat and lng with an underscore and returns it.
     * This id will be used as a key of marker to cache the marker in markers object.
     * @param {!number} lat Latitude.
     * @param {!number} lng Longitude.
     * @return {string} Concatenated marker id.
     */
    var getMarkerUniqueId = function(lat, lng) {
        return lat + '_' + lng;
    };

    /**
     * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
     * This function can be useful for getting new coordinates quickly.
     * @param {!number} lat Latitude.
     * @param {!number} lng Longitude.
     * @return {google.maps.LatLng} An instance of google.maps.LatLng object
     */
    var getLatLng = function(lat, lng) {
        return new google.maps.LatLng(lat, lng);
    };

    /**
     * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
     */
    var addMarker = google.maps.event.addListener(map, 'click', function(e) {
        var lat = e.latLng.lat(); // lat of clicked point
        var lng = e.latLng.lng(); // lng of clicked point
        var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
        var marker = new google.maps.Marker({
            position: getLatLng(lat, lng),
            map: map,
            animation: google.maps.Animation.DROP,
            id: 'marker_' + markerId,
            html: "    <div id='info_" + markerId + "'>\n" +
                "        <table class=\"map1\">\n" +
                "            <tr>\n" +
                "                <td><a>Anda yakin menambah titik ini?</a></td>\n" +
                "                      <tr><td>&nbsp;</td></tr>\n" +
                "            <tr><td><input class='btn btn-info' type='button' value='Save' onclick='saveData(" + lat + "," + lng + ")'/></td></tr>\n" +
                "        </table>\n" +
                "    </div>"
        });
        markers[markerId] = marker; // cache marker in markers object
        bindMarkerEvents(marker); // bind right click event to marker
        bindMarkerinfo(marker); // bind infowindow with click event to marker
    });

    /**
     * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
     * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
     */
    var bindMarkerinfo = function(marker) {
        google.maps.event.addListener(marker, "click", function(point) {
            var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
            var marker = markers[markerId]; // find marker
            infowindow = new google.maps.InfoWindow();
            infowindow.setContent(marker.html);
            infowindow.open(map, marker);
            // removeMarker(marker, markerId); // remove it
        });
    };

    /**
     * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
     * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
     */
    var bindMarkerEvents = function(marker) {
        google.maps.event.addListener(marker, "rightclick", function(point) {
            var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
            var marker = markers[markerId]; // find marker
            removeMarker(marker, markerId); // remove it
        });
    };

    /**
     * Removes given marker from map.
     * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
     * @param {!string} markerId Id of marker.
     */
    var removeMarker = function(marker, markerId) {
        marker.setMap(null); // set markers setMap to null to remove it from map
        delete markers[markerId]; // delete marker instance from markers object
    };



    /**
     * loop through (Mysql) dynamic locations to add markers to map.
     */
    var i;
    var confirmed = 0;
    let totalLocation = locations.length

    for (i = 0; i < locations.length; i++) {
        let id_loc = locations[i][0];
        $.ajax({
            type: "POST",
            url: 'get_agenda.php?id=' + id_loc,
            dataType: 'json',
            async: false,
            success: function(data) {
                let dataAgenda = "";

                agenda = data
                if (agenda.length > 0) {
                    for (let x = 0; x < agenda.length; x++) {
                        dataAgenda += `
                                <tr>
                                    <th scope="row">#</th>
                                    <td>${agenda[x].tanggal}</td>
                                    <td>${agenda[x].judul}</td>
                                    <td>${agenda[x].status}</td>
                                    <td>${agenda[x].hasil}</td>
                                    <td>${agenda[x].persetujuan}</td>
                                    <td> <img width="100" src="./gambar/${agenda[x].dokumentasi}"/>
                                    </td>
                                    
                                 </tr>
                                `
                    }
                }

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: locations[i][4] === '1' ? red_icon : purple_icon,
                    html: `
                <div style="" class="form" id="form">
                    <div id="image_data" class="mt-3">
                    <img src="gambar/location/${locations[i][6]}" alt="">
                    </div>
                    <div class="content_data my-4">
                        <h4 class="my-2" id="title">${locations[i][5]}</h4>
                        <p class="info-desc" id="description">
                        ${locations[i][3]}
                        </p>
                        <p class="info-kecamatan" id="kecamatan">
                        ${locations[i][7]}
                        </p>
                    </div>
                    <div id="table_test"></div>
                    <h5>TABEL HISTORI KEGIATAN</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kegiatan</th>
                            <th scope="col">Tindak Lanjut</th>
                            <th scope="col">Hasil</th>
                            <th scope="col">Persetujuan</th>
                            <th scope="col">Dokumentasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        ${dataAgenda ? dataAgenda: ""}
                            
                            <tr>
                        </tbody>
                    </table>
                    
                </div>
                
                `
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow = new google.maps.InfoWindow();
                        confirmed = locations[i][4] === '1' ? 'checked' : 0;
                        $("#confirmed").prop(confirmed, locations[i][4]);
                        $("#id").val(locations[i][0]);
                        $("#description").val(locations[i][3]);
                        $("#kecamatan").val(locations[i][5]);
                        $("#form").show();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

            }
        });




    }

    /**
     * SAVE save marker from map.
     * @param lat  A latitude of marker.
     * @param lng A longitude of marker.
     */
    function saveData(lat, lng) {
        var url = 'locations_model.php?add_location&lat=' + lat + '&lng=' + lng;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200 && data.length > 1) {
                var markerId = getMarkerUniqueId(lat, lng); // get marker id by using clicked point's coordinate
                var manual_marker = markers[markerId]; // find marker
                manual_marker.setIcon(purple_icon);
                infowindow.close();
                infowindow.setContent("<div style=' color: green; font-size: 20px;'> Berhasil ditambahkan!</div><p>Silahkan konfirmasi dengan admin agar data dapat ditampilkan</p>");
                infowindow.open(map, manual_marker);

            } else {
                console.log(responseCode);
                console.log(data);
                infowindow.setContent("<div style='color: red; font-size: 20px;'>Inserting Errors</div>");
            }
        });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request.responseText, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }
</script>





<?php
include_once 'footer.php';

?>