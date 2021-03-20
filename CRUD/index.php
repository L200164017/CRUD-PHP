<?php

// Setting Koneksi ke database
$server = "localhost";
$user = "root";
$pass = "";
$database = "dblatihan";

$koneksi = mysqli_connect($server,$user,$pass,$database) or die(mysqli_error($koneksi));

// Jika tombol simpan diklik
if(isset($_POST['bsimpan']))
{

    
    //Pengujian apakah data akan diedit atau disimpan baru
    if($_GET['hal'] == "edit")
    {
      //Data akan di edit


      $edit = mysqli_query($koneksi,"UPDATE mhs
      set
      nim = '$_POST[tnim]',
      nama = '$_POST[tnama]',
      alamat = '$_POST[talamat]',
      prodi = '$_POST[tprodi]'
      WHERE id_mhs = '$_GET[id]'");

        if($edit)
        {
          echo "<script>alert('Edit data sukses');
                              document.location='index.php';
                </script>;";
        }
        else{
          echo "<script>alert('Edit gagal');
          document.location='index.php';
          </script>;";
        }



    }else {
      //Data akan disimpan baru

      $simpan = mysqli_query($koneksi, "INSERT into mhs(nim,nama,alamat,prodi) values('$_POST[tnim]',
                                                                                  '$_POST[tnama]',
                                                                                  '$_POST[talamat]',
                                                                                  '$_POST[tprodi]')");
        if($simpan)
        {
          echo "<script>alert('simpan sukses');
                              document.location='index.php';
                </script>;";
        }
        else{
          echo "<script>alert('simpan gagal');
          document.location='index.php';
          </script>;";
        }

      }
  
}

// Pengujian jika tombol Edit atau hapus di klik
if(isset($_GET['hal'])){


  //Tampilkan jika edit data
  if($_GET['hal'] == "edit")
  {

    //Tampilkan data yang akan di edit
    $tampil = mysqli_query($koneksi,"SELECT * from mhs WHERE id_mhs = '$_GET[id]'");
    $data = mysqli_fetch_array($tampil);
    if($data)
    {
      //JIka data di temukan maka data ditamping dulu ke dalam variabel

      $vnim = $data['nim'];
      $vnama = $data['nama'];
      $valamat =  $data['alamat'];
      $vprodi = $data['prodi'];
    }

  }

  //Tampilkan jika ingin menghapus data
  else if($_GET['hal'] == "hapus")
  {

    $hapus = mysqli_query($koneksi,"DELETE from mhs where id_mhs = '$_GET[id]'");
    if($hapus)
    {
      echo "<script>alert('Data berhasil dihapus');
                              document.location='index.php';
                </script>;";
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
</head>
<body>
<div class="container">


    <h1 class="text-center">Refreshing My Knowledge on PHP</h1>
    <h2 class="text-center">CRUD Tutorial</h2>

    <!-- Awal Card -->
    <div class="card mt-3">
  <div class="card-header bg-primary text-white">
    Input Data
  </div>



  <div class="card-body">
    <form method="post" action="">
        <div class="mb-3">
            <label class="form-label">Nim</label>
            <input type="text" name="tnim" value="<?= @$vnim ?>" class="form-control" placeholder="insert your nim" required>
        </div>
        

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" placeholder="insert your name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="talamat" class="form-control" placeholder="insert your address"><?= @$valamat ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Program Studi</label>
            <select name="tprodi" class="form-control">
                <option value="<?= @$vprodi ?>"><?=@$vprodi ?></option>
                <option value="D3-MI">D3-MI</option>
                <option value="S1-SI">S1-SI</option>
                <option value="S1-TI">S1-TI</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

    </form>
  </div>
</div>
<!-- Akhir dari card -->


<!-- Awal Tabel -->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    Tabel Data
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
    <tr><th>No</th>
        <th>Nim</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Program Studi</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $tampil = mysqli_query($koneksi,"SELECT * from mhs order by id_mhs desc");
    while($data = mysqli_fetch_array($tampil)):


    ?>

    <tr>

    <td><?= $no++; ?></td>
    <td><?= $data['nim']; ?></td>
    <td><?= $data['nama'];?></td>
    <td><?=$data['alamat']; ?></td>
    <td><?=$data['prodi']; ?></td>
    <td><a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
        <a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data')">Hapus</a>
    </td>

    </tr>

    <?php endwhile; ?>
        
    </table>
  </div>
</div>

<!-- Akhir tabel -->





</div>

<script type="text/javascript" src="js/bootstrap.min.css"></script>
<script>
  const theader = document.getElementsByTagName('th');
  theader.classList.add('text-center');
</script>
    
</body>
</html>