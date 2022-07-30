<?php
include('../../koneksi.php');

$id_agenda = $_GET['id_agenda']; //mengambil id 

//menampilkan barang berdasarkan id
$data = mysqli_query($koneksi, "select * from agenda where id_agenda = '$id_agenda'");
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

    <title>Tambah Data Lokasi</title>
</head>

<body>
    <div class="container col-md-6 mt-4">
        <h1>Data <?= $row['judul'] ?></h1>
        <div class="card">
            <div class="card-header bg-success text-white">
                Edit Agenda
            </div>
            <div class="card-body">
                <form action="" method="post" role="form"  enctype="multipart/form-data">
                    <input type="hidden" name="id_agenda" required="" value="<?= $row['id_agenda']; ?>">

                    <div class="form-group">
                        <label>Kegiatan</label>
                        <input type="text" name="judul" required="" class="form-control" value="<?= $row['judul']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Tindak Lanjut</label>
                        <input type="text" name="status" required="" class="form-control" value="<?= $row['status']; ?>">
                    </div>
                    <div class="form-group">
                        <label>hasil</label>
                        <textarea class="form-control" name="hasil"><?= $row['hasil']; ?></textarea>
                    </div>


                    <div class="form-group">
                        <label>Persetujuan</label>
                        <input type="text" name="persetujuan" required="" class="form-control" value="<?= $row['persetujuan']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required="" class="form-control" value="<?= $row['tanggal']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Dokumentasi</label>
                        <div>
                        <?php
                                   $doc = (json_decode($row['dokumentasi'],true));
                                    if(count($doc) > 1){
                                        $result =array();

                                        foreach($doc as $index => $value){
                                            print_r($value) ;
                                            // echo $value[0]->dokumentasi;
                                        }
                                        // for($i=0; $i <count($doc); $i++){
                                            
                                            
                                        //     $testing_image = $doc[$i]['dokumentasi'];
                                        //     echo '<img width="200" src="../../gambar/'.$testing_image.'" alt=""> ';
                                        //     echo '<input type="submit" name="delete'.$i.'" value="delete"/> ';
                                        //     // print_r($_POST['delete']);
                                        //     // print_r($doc[$i]);
                                        //     if(isset($_POST['delete'.$i])){
                                        //         unset($doc[$i]);
                                        //         // echo '<script>alert("berhasil delete'.$testing_image.'")</script>';
                                        //         // $datas = mysqli_query($koneksi, "update agenda set  dokumentasi ='$doc' where id_agenda ='$id_agenda'") or die(mysqli_error($koneksi));
                                        //         // echo "berhasil";
                                                
                                        //     }
                                        //     array_push($result,$doc[$i]);
                                        //  }

                                        
                                    }
                                    else {
                                        for($i=0; $i <1; $i++){
                                            $testing_image = $doc[$i]['dokumentasi'];
                                            echo '<img width="200" src="../../gambar/'.$testing_image.'" alt=""> ';
                                         }
                                    }
                            ?>
                        </div>
                        <input type="file" name="dokumentasi" class="form-control">
                    </div>


                    <button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan data</button>
                </form>

                <?php
                include('../../koneksi.php');

                //melakukan pengecekan jika button submit diklik maka akan menjalankan perintah simpan dibawah ini
                if (isset($_POST['submit'])) {
                    //menampung data dari inputan
                    $id_location = $_GET['id_location'];
                    $id_agenda = $_GET['id_agenda'];
                    $judul = $_POST['judul'];
                    $status = $_POST['status'];
                    $hasil = $_POST['hasil'];
                    $persetujuan = $_POST['persetujuan'];
                    $tanggal = $_POST['tanggal'];

                    $filename = $_FILES['dokumentasi']['name'];

                    // jika tidak ingin update gambar, pakai gambar lama
                    if (!$filename) {
                        $new_gambar = $row['dokumentasi'];
                        $datas = mysqli_query($koneksi, "update agenda set judul='$judul', status='$status', hasil='$hasil', persetujuan='$persetujuan', tanggal='$tanggal', dokumentasi='$new_gambar' where id_agenda ='$id_agenda'") or die(mysqli_error($koneksi));
                        echo "<script>alert('data berhasil disimpan.'); window.location = 'index.php?id_location=$id_location'</script>";
                    } else {
                        $rand = rand();
                        $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
                        // $ukuran = $_FILES['dokumentasi']['size'];
                        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        
                        $limit = 10 * 1024 * 1024; //10 foto 1 mb
                        $jumlahFile = count($_FILES['dokumentasi']['name']);
                        $current_doc = json_decode($row['dokumentasi'], true);

                        for ($x = 0; $x < $jumlahFile; $x++) {
                            $nama_file = $_FILES['dokumentasi']['name'][$x];
                            $tmp = $_FILES['dokumentasi']['tmp_name'][$x];
                            $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
                            $ukuran = $_FILES['dokumentasi']['size'][$x];	
                            if($ukuran > $limit){
                                header("location:index.php?id_location=$id_location&alert=gagal_ukuran");		
                            }
                            else {
                                if(!in_array($ext, $ekstensi)){
                                    header("location:index.php?id_location=$id_location&alert=gagal_ektensi");			
                                }
                                else {
                                    $new_gambar = $rand.'_'.$filename;
                                    move_uploaded_file($tmp, '../../gambar/'.$new_gambar);
                                    $new_array[] = array(
                                        "dokumentasi" =>  $new_gambar
                                    );
                                }
                            }

						


                        }















                        if (!in_array($ext, $ekstensi)) {
                            header("location:index.php?alert=gagal_ekstensi");
                        } else {
                            if ($ukuran < 104407000) {
                                // hapus gambar sebelumnya
                                unlink('../../gambar/'.$row['dokumentasi']);
                                
                                $new_gambar = $rand . '_' . $filename;
                                move_uploaded_file($_FILES['dokumentasi']['tmp_name'], '../../gambar/' . $rand . '_' . $filename);
                                $datas = mysqli_query($koneksi, "update agenda set judul='$judul', status='$status', hasil='$hasil', persetujuan='$persetujuan', tanggal='$tanggal', dokumentasi='$new_gambar' where id_agenda ='$id_agenda'") or die(mysqli_error($koneksi));

                                echo "<script>alert('data berhasil diupdate.'); window.location = 'index.php?id_location=$id_location'</script>";

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