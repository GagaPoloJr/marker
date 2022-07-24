<?php
include('../koneksi.php');

$id = $_GET['id']; //mengambil id barang yang ingin diubah

//menampilkan barang berdasarkan id
$data = mysqli_query($koneksi, "select * from locations where id = '$id'");
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

    <title>Edit Data Lokasi</title>
</head>

<body>
    <div class="container col-md-6 mt-4">
        <h1>Edit Lokasi</h1>
        <div class="card">
            <div class="card-header bg-success text-white">
                Edit Lokasi
            </div>
            <div class="card-body">
                <form action="" method="post" role="form">
                <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
                    <div class="form-group">
                        <label>judul</label>
                        <input type="text" name="title" required="" class="form-control"  value="<?= $row['title']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="number" step="any" name="lat" required="" class="form-control"  value="<?= $row['lat']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" step="any" name="lng" required="" class="form-control"  value="<?= $row['lng']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="description"><?= $row['description']; ?>
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <textarea class="form-control" name="kecamatan"><?= $row['kecamatan']; ?>
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-warning" name="submit" value="update">Update data</button>
                </form>

                <?php
                include('../koneksi.php');

                //jika klik tombol submit maka akan melakukan perubahan
                if (isset($_POST['submit'])) {
                    //menampung data dari inputan
                    $title = $_POST['title'];
                    $lat = $_POST['lat'];
                    $lng = $_POST['lng'];
                    $description = $_POST['description'];
                    $kecamatan = $_POST['kecamatan'];

                    //query untuk menambahkan barang ke database, pastikan urutan nya sama dengan di database
                    // $datas = mysqli_query($koneksi, "insert into locations (title,lat,lng,description,kecamatan)values('$title', '$lat', '$lng', '$description', '$kecamatan')") or die(mysqli_error($koneksi));
                   //query mengubah barang
					mysqli_query($koneksi, "update locations set title='$title', lat='$lat', lng='$lng', description='$description', kecamatan='$kecamatan' where id ='$id'") or die(mysqli_error($koneksi));

                    //ini untuk menampilkan alert berhasil dan redirect ke halaman index
                    echo "<script>alert('data berhasil diupdate.');window.location='index.php';</script>";
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