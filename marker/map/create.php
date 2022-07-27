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
						<label>judul</label>
						<input type="text" name="title" required="" class="form-control">
					</div>
					<div class="form-group">
						<label>Latitude</label>
						<input type="number" step="any" name="lat" required="" class="form-control">
					</div>
					<div class="form-group">
						<label>Longitude</label>
						<input type="number" step="any" name="lng" required="" class="form-control">
					</div>

					<div class="form-group">
						<label>Deskripsi</label>
						<textarea class="form-control" name="description"></textarea>
					</div>

					<div class="form-group">
						<label>Kecamatan</label>
						<textarea class="form-control" name="kecamatan"></textarea>
					</div>

					<div class="form-group">
						<label>Image</label>
						<input type="file"  name="image"  class="form-control">
					</div>


					<button type="submit" class="btn btn-primary" name="submit" value="simpan">Simpan data</button>
				</form>

				<?php
				include('../koneksi.php');

				//melakukan pengecekan jika button submit diklik maka akan menjalankan perintah simpan dibawah ini
				if (isset($_POST['submit'])) {
					//menampung data dari inputan
					$title = $_POST['title'];
					$lat = $_POST['lat'];
					$lng = $_POST['lng'];
					$description = $_POST['description'];
					$kecamatan = $_POST['kecamatan'];

					$rand = rand();
					$ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
					$filename = $_FILES['image']['name'];
					$ukuran = $_FILES['image']['size'];
					$ext = pathinfo($filename, PATHINFO_EXTENSION);

					if (!in_array($ext, $ekstensi)) {
						header("location:index.php?alert=gagal_ekstensi");
					} else {
						if ($ukuran < 104407000) {
							$new_gambar = $rand . '_' . $filename;
							move_uploaded_file($_FILES['image']['tmp_name'], '../gambar/location/' . $rand . '_' . $filename);
						
							//query untuk menambahkan barang ke database, pastikan urutan nya sama dengan di database
							$datas = mysqli_query($koneksi, "insert into locations (title,lat,lng,description,kecamatan, image)values('$title', '$lat', '$lng', '$description', '$kecamatan', '$new_gambar')") or die(mysqli_error($koneksi));

							//ini untuk menampilkan alert berhasil dan redirect ke halaman index
							echo "<script>alert('data berhasil disimpan.');window.location='index.php';</script>";
							// header("location:index.php?alert=berhasil");
						} else {
							echo "<script>alert('ukuran gambar terlalu besar silahkan input ulang') </script>";
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