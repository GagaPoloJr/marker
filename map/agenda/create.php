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
		<h1>Table Lokasi</h1>
		<div class="card">
			<div class="card-header bg-success text-white">
				Tambah Lokasi
			</div>
			<div class="card-body">
				<form action="" method="post" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label>Kegiatan</label>
						<input type="text" name="judul" required="" class="form-control">
					</div>
					<div class="form-group">
						<label>Tindak Lanjut</label>
						<input type="text" name="status" required="" class="form-control">
					</div>
					<div class="form-group">
						<label>hasil</label>
						<textarea class="form-control" name="hasil"></textarea>
					</div>


					<div class="form-group">
						<label>Persetujuan</label>
						<input type="text" name="persetujuan" required="" class="form-control">
					</div>

					<div class="form-group">
						<label>Tanggal</label>
						<input type="date" name="tanggal" required="" class="form-control">
					</div>

					<div class="form-group">
						<label>Dokumentasi</label>
						<input required type="file" name="dokumentasi[]" class="form-control" multiple>
						<p style="color: red">Ekstensi yang diperbolehkan .png | .jpg | .jpeg | .gif</p>
					</div>


					<button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan data</button>
				</form>

				<?php
				include('../../koneksi.php');

				//melakukan pengecekan jika button submit diklik maka akan menjalankan perintah simpan dibawah ini
				if (isset($_POST['submit'])) {
					//menampung data dari inputan
					$id_location = $_GET['id_location'];
					$judul = $_POST['judul'];
					$status = $_POST['status'];
					$hasil = $_POST['hasil'];
					$persetujuan = $_POST['persetujuan'];
					$tanggal = $_POST['tanggal'];

					$rand = rand();
					$ekstensi =  array('png', 'jpg', 'jpeg', 'gif');

					$jumlahFile = count($_FILES['dokumentasi']['name']);
					$limit = 10 * 1024 * 1024; //10 foto 1 mb
					
					for ($x = 0; $x < $jumlahFile; $x++) {
						$filename = $_FILES['dokumentasi']['name'][$x];
						$tmp = $_FILES['dokumentasi']['tmp_name'][$x];
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
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
					$new_doc = json_encode($new_array);
					$datas = mysqli_query($koneksi, "insert into agenda (id_location, judul,status, hasil,persetujuan,tanggal,dokumentasi)values('$id_location', '$judul', '$status', '$hasil', '$persetujuan', '$tanggal', '$new_doc')") or die(mysqli_error($koneksi));
					echo "<script>alert('data berhasil disimpan.'); window.location = 'index.php?id_location=$id_location'</script>";
					
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