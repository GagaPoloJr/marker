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
                <form action="" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" required="" value="<?= $row['id']; ?>">
                    <div class="form-group">
                        <label>judul</label>
                        <input type="text" name="title" required="" class="form-control" value="<?= $row['title']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="number" step="any" name="lat" required="" class="form-control" value="<?= $row['lat']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" step="any" name="lng" required="" class="form-control" value="<?= $row['lng']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="description"><?= $row['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Kecamatan</label>
                        <textarea class="form-control" required name="kecamatan"><?= $row['kecamatan']; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <div>
                            <?= $row['image'] ?>
                        </div>
                        <input type="file" name="image" class="form-control">
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
                    $filename = $_FILES['image']['name'];

                    // jika tidak ingin update gambar, pakai gambar lama
                    if (!$filename) {
                        $new_gambar = $row['image'];
                        $datas = mysqli_query($koneksi, "update locations set title='$title', lat='$lat', lng='$lng', description='$description', kecamatan='$kecamatan', image='$new_gambar' where id ='$id'") or die(mysqli_error($koneksi));
                        echo "<script>alert('data berhasil disimpan.'); window.location = 'index.php'</script>";
                    } else {
                        $rand = rand();
                        $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
                        $ukuran = $_FILES['image']['size'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);

                        if (!in_array($ext, $ekstensi)) {
                            // header("location:index.php?alert=gagal_ekstensi");
                            echo "<script>alert('Ekstensi gambar tidak didukung kecuali png,jpg,jpeg,gif') </script>";

                        } else {
                            if ($ukuran < 104407000) {
                                // hapus gambar sebelumnya
                                unlink('../gambar/location/' . $row['image']);

                                $new_gambar = $rand . '_' . $filename;
                                move_uploaded_file($_FILES['image']['tmp_name'], '../gambar/location/' . $rand . '_' . $filename);
                             

                                $datas = mysqli_query($koneksi, "update locations set title='$title', lat='$lat', lng='$lng', description='$description', kecamatan='$kecamatan', image='$new_gambar' where id ='$id'") or die(mysqli_error($koneksi));
                                //ini untuk menampilkan alert berhasil dan redirect ke halaman index
                                echo "<script>alert('data berhasil diupdate.');window.location='index.php';</script>";

                                // header("location:index.php?alert=berhasil");
                            } else {
                                echo "<script>alert('ukuran gambar terlalu besar silahkan input ulang') </script>";
                            }
                        }
                    }

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