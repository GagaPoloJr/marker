<?php
include('./koneksi.php');

$id =1; //mengambil id barang yang ingin diubah

//menampilkan barang berdasarkan id
$data = mysqli_query($koneksi, "select * from center where id = '$id'");
$row = mysqli_fetch_assoc($data);

?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Edit Data Zona Map</title>
</head>

<body>
    <div class="container col-md-6 mt-4">
        <h1>Edit Zona Map</h1>
        <div class="card">
            <div class="card-header bg-success text-white">
                Edit Zona Map
            </div>
            <div class="card-body">
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="number" step="any" name="lat" required="" class="form-control" value="<?= $row['lat']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" step="any" name="lng" required="" class="form-control" value="<?= $row['lng']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Zoom (jarak pandang ke layar)</label>
                        <input type="number" step="any" name="zoom" required="" class="form-control" value="<?= $row['zoom']; ?>">
                        <p style="color: gray; font-size:14px"> <i>rata rata menggunakan > 10  - < 20 </i> </p>
                    </div>
                    

                    <button type="submit" class="btn btn-warning" name="submit" value="update">Update data</button>
                </form>

                <?php
                include('./koneksi.php');

                //jika klik tombol submit maka akan melakukan perubahan
                if (isset($_POST['submit'])) {
                    //menampung data dari inputan
                    $zoom = $_POST['zoom'];
                    $lat = $_POST['lat'];
                    $lng = $_POST['lng'];
                 

                    $datas = mysqli_query($koneksi, "update center set  lat='$lat', lng='$lng', zoom='$zoom' where id ='$id'") or die(mysqli_error($koneksi));
                    echo "<script>alert('data berhasil diupdate.'); window.location = 'index.php'</script>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>