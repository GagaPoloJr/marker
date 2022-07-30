<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Data Agenda</title>
</head>

<body>
    <?php
    $previous = "javascript:history.go(-1)";
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }

    include('../../koneksi.php'); //memanggil file koneksi
    $id_location = $_GET['id_location']; //mengambil id

    $location = mysqli_query($koneksi, "select title from locations where id ='$id_location'") or die(mysqli_error($koneksi));
    $loc_data = mysqli_fetch_assoc($location);
    ?>

    <div class="container col-md-8 mt-4">
        <h1>Tabel Data Agenda Lokasi <?= $loc_data['title'] ?></h1>
        <div class="row col-12 my-4">
            <a href="<?php echo $previous ?>" class="btn btn-sm btn-primary float-right">kembali</a>
        </div>
        <div class="card">
            <div class="card-header bg-success text-white ">
                Data Agenda <a href="create.php?id_location=<?= $_GET['id_location']; ?>" class="btn btn-sm btn-primary float-right">Tambah</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Tindak Lanjut</th>
                            <th>Hasil</th>
                            <th>Persetujuan</th>
                            <th>Tanggal</th>
                            <th>Dokumentasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../../koneksi.php'); //memanggil file koneksi
                        $id_location = $_GET['id_location']; 

                        $datas = mysqli_query($koneksi, "select * from agenda where id_location= '$id_location'") or die(mysqli_error($koneksi));
                        $location = mysqli_query($koneksi, "select title from locations where id ='$id_location'") or die(mysqli_error($koneksi));
                        $loc_data = mysqli_fetch_assoc($location);

                        //script untuk menampilkan data lokasi

                        $no = 1; //untuk pengurutan nomor

                        //melakukan perulangan

                                    
                        while ($row = mysqli_fetch_assoc($datas)) {

                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $row['judul']; //untuk menampilkan nama 
                                    ?></td>
                                <td><?= $row['status']; ?></td>
                                <td><?= $row['hasil']; ?></td>
                                <td><?= $row['persetujuan']; ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                
                                <td>
                                   <?php
                                   $doc = (json_decode($row['dokumentasi'],true));
                                    if(count($doc) > 1){
                                        for($i=0; $i <1; $i++){
                                            $testing_image = $doc[$i]['dokumentasi'];
                                            echo '<img width="200" src="../../gambar/'.$testing_image.'" alt=""> ';
                                            echo '<button>lihat semua gambar</button>';
                                         }
                                    }
                                    else {
                                        for($i=0; $i <1; $i++){
                                            $testing_image = $doc[$i]['dokumentasi'];
                                            echo '<img width="200" src="../../gambar/'.$testing_image.'" alt=""> ';
                                         }
                                    }
                                
                                    
                                   ?>
                                </td>
                                <td>
                                    <a href="edit.php?id_location=<?= $row['id_location']; ?>&id_agenda=<?= $row['id_agenda']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id_location=<?= $row['id_location']; ?>&id_agenda=<?= $row['id_agenda']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin hapus?');">Hapus</a>
                                </td>
                            </tr>

                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
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