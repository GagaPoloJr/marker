<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<title>Data Lokasi</title>
</head>

<body>

	<div class="container col-md-8 mt-4">
		<h1>Tabel Data lokasi</h1>

		<div class="card">
			<div class="card-header bg-success text-white ">
				Data Lokasi <a href="create.php" class="btn btn-sm btn-primary float-right">Tambah</a>
			</div>
			<div class="card-body table-responsive">
				<table class="table table-bordered ">
					<thead>
						<tr>
							<th>No</th>
							<th>Judul</th>
							<th>Gambar</th>
							<th>Deskripsi</th>
							<th>Kecamatan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include('../koneksi.php'); //memanggil file koneksi
						$datas = mysqli_query($koneksi, "select * from locations") or die(mysqli_error($koneksi));
						//script untuk menampilkan data lokasi

						$no = 1; //untuk pengurutan nomor

						//melakukan perulangan
						while ($row = mysqli_fetch_assoc($datas)) {
						?>

							<tr>
								<td><?= $no; ?></td>
								<td><?= $row['title']; //untuk menampilkan nama 
									?></td>
								<td>
									<img width="200" src="../gambar/location/<?= $row['image']?>"/>
								</td>
								<td><?= $row['description']; ?></td>
								<td><?= $row['kecamatan']; ?></td>
								<td>
									<a href="agenda/index.php?id_location=<?= $row['id']; ?>" class="btn btn-sm btn-info">Agenda</a>
									<a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
									<a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('anda yakin ingin hapus?');">Hapus</a>
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