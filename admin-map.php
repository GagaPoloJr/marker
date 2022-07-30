<?php
include_once 'header.php';
include_once 'locations_model.php';


session_start();

// function prompt($prompt_msg){
//     echo("<script type='text/javascript'> var new_pass = prompt('".$prompt_msg."'); </script>");
//     return($prompt_msg);
// }
if(!$_SESSION['password']){
    header("location:access.php");
}

// session_destroy()

?>
<style>
    #image_data img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }
</style>

<div id="map"></div>

<!------ Include the above in your HEAD tag ---------->
<script>
    var map;
    var marker;
    var infowindow;
    var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
    var purple_icon = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
    var locations = <?php get_all_locations() ?>;
    var getDataCenterMap = <?php get_center_map() ?>;
    var dataCenter = getDataCenterMap[0];

    function initMap() {
        // -6.175168397319318, 106.8272493571782
        var centerMap = {
            // lat: -6.175168397319318,
            // lng: 106.8272493571782,
            lat: parseFloat(dataCenter.lat),
            lng: parseFloat(dataCenter.lng),
        };
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: centerMap,
            zoom: parseFloat(dataCenter.zoom)
        });


        var i;
        var x;
        var confirmed = 0;
        let totalLocation = locations.length
        for (i = 0; i < locations.length; i++) {
            let id_loc = locations[i][0];
            // get data agenda
            $.ajax({
                type: "POST",
                url: 'get_agenda.php?id=' + id_loc,
                dataType: 'json',
                async: false,
                success: function(data) {
                    let dataAgenda = "";
                    if (data.length > 0) {
                        for (x = 0; x < data.length; x++) {
                            dataAgenda += `
                                <tr>
                                    <th scope="row">#</th>
                                    <td>${data[x].tanggal}</td>
                                    <td>${data[x].judul}</td>
                                    <td>${data[x].status}</td>
                                    <td>${data[x].hasil}</td>
                                    <td>${data[x].persetujuan}</td>
                                    <td> <img width="100" src="./gambar/${data[x].dokumentasi}"/>
                                    </td>
                                    
                                 </tr>
                                `
                        }
                    }

                        confirmed = locations[i][4] === '1' ? 'checked' : 0;
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map,
                            get_id: locations[i][0],
                            icon: locations[i][4] === '1' ? red_icon : purple_icon,
                            html: `
                                ${!locations[i][5] && !locations[i][7] && !locations[i][3] ? `<div class="mt-3 text-center"><p>
                                    Data Belum ditambahkan
                                    </p>
                                    <a target="_blank" href="map/edit.php?id=${locations[i][0]}" class="btn btn-info">Menuju Link</a>
                                    </div>` : `
                                    
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
                                        </tbody>
                                    </table>
                                    <table class="map1">
                                        <tr>
                                            <input name="id" type='hidden' id='id' value="${locations[i][0]}" />
                                        </tr>
                                        <tr>
                                            <td><b>Confirm Location ?:</b></td>
                                            <td><input id='confirmed' type='checkbox' ${confirmed} value="${locations[i][4]}" name='confirmed'></td>
                                            <td><input class="btn btn-info" type='button' value='Save' onclick='saveData()' /></td>
                                        </tr>
                                    </table>
                                </div>
                                    `}
                                `
                        });

                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {

                                confirmed = locations[i][4] === '1' ? 'checked' : 0;
                                $("#confirmed").prop(confirmed, locations[i][4]);
                                $("#id").val(locations[i][0]);
                                $("#description").html(locations[i][3]);
                                $("#title").html(locations[i][5]);
                                $("#kecamatan").html(locations[i][7]);
                                $("#bisaga").html(locations[i][5]);
                                $("#image_data").html(`<img src="gambar/location/${locations[i][6]}" alt="">`)
                                infowindow.setContent(marker.html);
                                infowindow.open(map, marker);
                            }
                        })(marker, i));
                }
            });

        }
    }

    function saveData() {
        var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
        var id = document.getElementById('id').value;
        var url = 'locations_model.php?confirm_location&id=' + id + '&confirmed=' + confirmed;
        downloadUrl(url, function(data, responseCode) {
            if (responseCode === 200 && data.length > 1) {
                infowindow.close();
                window.location.reload(true);
                
                (confirmed ==1 ? alert("Data berhasil dikonfirmasi!") : alert("Data berhasil disembunyikan!") )
            } else {
                infowindow.setContent("<div style='color: green; font-size: 25px;'>Inserting Errors</div>");
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



<div style="display: none" class="form" id="form">
    <div id="image_data" class="mt-3">
    </div>
    <div class="content_data">
        <h4 id="title"></h4>
        <p class="info-desc" id="description">

        </p>
        <p class="info-kecamatan" id="kecamatan">

        </p>
    </div>
    <div class="data_table">

    </div>
    <table class="map1">
        <tr>
            <input name="id" type='hidden' id='id' />
        </tr>
        <tr>
            <td><b>Confirm Location ?:</b></td>
            <td><input id='confirmed' type='checkbox' name='confirmed'></td>

            <td><input class="btn btn-info" type='button' value='Save' onclick='saveData()' /></td>

        </tr>
    </table>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw&callback=initMap">
</script>