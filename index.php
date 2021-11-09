<?php


// Koneksi Database
$server = "localhost";
$user = "root";
$pass = "";
$database = "crudnelayan";

$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

// Jika tombol submit diklik
if(isset($_POST['bsimpan']))
{ 
  $simpan = mysqli_query($koneksi, "INSERT INTO tnelayan (nama_perusahaan, jenis_perairan, NIK, Sarana, Jumlah
                                    VALUES ('$_POST[nama_usaha]',
                                            '$_POST[jenis]',
                                            '$_POST[nik]',
                                            '$_POST[sarana]',
                                            '$_POST[jumlah]')
                                      ");
                              
  if ($simpan) //Jika simpan sukses
  {
    echo "<script>
          alert ('Identitas data nelayan Berhasil disimpan!');
          document.location='form.php';  
          </script>";
  }
  else
  {
    echo "<script>
          alert ('Identitas data nelayan Gagal disimpan!');
          document.location='form.php';  
          </script>";
  }

}

//Pengujian Apakah data akan diedit atau disimpan baru
if($_GET['hal'] == "edit")
{
  //Data akan di edit
  $edit = mysqli_query($koneksi, "UPDATE tnelayan set
                     nama_usaha = '$_POST[namaPer]',
                     jenis = '$_POST[jp]',
                      nik = '$_POST[nik]',
                     sarana = '$_POST[sarana]'
                     jumlah = '$_POST[jumlah]'
                   WHERE id_usaha = '$_GET[id]'
                   ");

  if($edit) //jika edit sukses
  {
    echo "<script>
        alert('Edit data suksess!');
        document.location='index.php';
         </script>";
  }
  else
  {
    echo "<script>
        alert('Edit data GAGAL!!');
        document.location='index.php';
         </script>";
  }
}

else
{
  //Data akan disimpan Baru
  $simpan = mysqli_query($koneksi, "INSERT INTO tnelayan (nama_usaha, jenis, nik, sarana, jumlah)
                  VALUES ('$_POST[namaPer]',
                          '$_POST[jp]',
                          '$_POST[nik]',
                          '$_POST[sarana]',
                          '$_POST[jumlah]')
                 ");

  if($simpan) //jika simpan sukses
  {
    echo "<script>
        alert('Simpan data suksess!');
        document.location='index.php';
         </script>";
  }
  else
  {
    echo "<script>
        alert('Simpan data GAGAL!!');
        document.location='index.php';
         </script>";
  }
}


//Pengujian jika tombol Edit / Hapus di klik
  if(isset($_GET['hal']))
  {
  //Pengujian jika edit Data
  if($_GET['hal'] == "edit")
  {
    //Tampilkan Data yang akan diedit
    $tampil = mysqli_query($koneksi, "SELECT * FROM tnelayan WHERE id_usaha = '$_GET[id]' ");
    $data = mysqli_fetch_array($tampil);
    if($data)
    {
      //Jika data ditemukan, maka data ditampung ke dalam variabel
      $vnama = $data['nama_usaha'];
      $vjenis= $data['jenis'];
      $vnik = $data['nik'];
      $vsarana = $data['sarana'];
      $vjumlah = $data['jumlah'];
    }
  }
  else if ($_GET['hal'] == "hapus")
  {
    //Persiapan hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM tnelayan WHERE id_usaha = '$_GET[id]' ");
    if($hapus){
      echo "<script>
          alert('Hapus Data Suksess!!');
          document.location='index.php';
           </script>";
    }
  }
  
  }


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">


    <title>Identitas Usaha</title>
  </head>
  <body>
 <form action="form.php" method ="POST">
   
    <header class="py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="gambar/nelayan.png" width="50" height="32" alt="">
        <span class="fs-4"> Identitas Usaha Nelayan</span>
      </a>

    </header>

    <div>
        <div class="bd-example px-3">
        <form class="row g-3">
          <div class="col-md-4">
            <label for="validationServer01" class="form-label">Nama Perusahaan Perikanan</label>
            <input type="text" class="form-control is-valid shadow" name="namaPer" id="validationServer01" value="<?=@$vnama?>" required>
            <div class="valid-feedback">
              Nama siap dipakai!
            </div>
          </div>
          <br>

    <fieldset class="row mb-3" value="<?=$vjenis?>">
    <legend class="col-form-label col-sm-2 pt-0">Jenis Perairan</legend>
    <div class="col-sm-10">

      <div class="form-check">
        <input class="form-check-input" type="radio" name="jp" value="sungai" checked>
        <label class="form-check-label" for="gridRadios1">
          Sungai
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="jp" value="danau">
        <label class="form-check-label" for="gridRadios2">
          Danau
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="radio" name="jp" value="waduk">
        <label class="form-check-label" for="gridRadios2">
          waduk
        </label>
      </div>

    </div>
    </fieldset>
    <br>

          <div class="col-md-4">
            <label for="validationServerUsername" class="form-label">Nomor Induk Kependudukan</label>
            <div class="input-group has-validation">
              <span class="input-group-text" id="inputGroupPrepend3">NIK</span>
              <input type="text" class="form-control is-invalid shadow" name="nik" value="<?=@$vnik?>" aria-describedby="inputGroupPrepend3" required>
              <div class="invalid-feedback">
                Tulis NIK Anda disini.
              </div>
            </div>
          </div>
          <br>

          <div class="col-md-3">
            <label for="validationServer04" class="form-label">Sarana Penangkapan</label>
            <select class="form-select is-invalid shadow" id="validationServer04" value="<?=@$vsarana?>" name="sarana" required>
              <option selected disabled value="">Sarana Penangkapan</option>
              <option value="Tanpa Perahu">Tanpa Perahu</option>
              <option value="Perahu Tanpa Motor">Perahu tanpa motor</option>
              <option value="Perahu motor tempel">Perahu motor tempel</option>
              <option value="kapal">kapal</option>
            </select>
            <div class="invalid-feedback">
              Pilih sarana kendaraan anda.
            </div>
          </div>
          <br>


          <div class="col-md-3">
            <label for="validationServer05" class="form-label">Jumlah Alat Tangkap Utama</label>
            <input type="text" class="form-control is-invalid shadow" name="jumlah" value="<?=@$vjumlah?>" id="validationServer05" required>
            <div class="invalid-feedback">
              Data inputan berupa angka.
            </div>
          </div>
          <br>

          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
              <label class="form-check-label" for="invalidCheck3">
                Setuju dengan syarat dan ketentuan.
              </label>
              <div class="invalid-feedback">
                Anda harus centang sebelum submit.
              </div>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-2">
              <button class="btn btn-warning shadow" type="submit" value="simpan" name="bsimpan">Submit Identitas</button>
            </div>

            <div class="col-1">
              <button  class="btn btn-danger shadow" type="reset" name="breset">Reset</button>
            </div>
          </div>

        </form>
        </div>
        
      
    </article>
  </section>
  </form>
  <br>
  <br>

  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top bg-dark ">
    <p class="col-md-4 mb-0 text-light ">&copy; Muhammad Ukasah (2007253)</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <img src="gambar/nelayan.png" width="40" height="32"></a>
    </a>

    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href="form.php" class="nav-link px-8 text-light bold">Form</a></li>
      <li class="nav-item"><a href="https://www.kkp.go.id/" class="nav-link text-light bold">KKP</a></li>
      
    </ul>
  </footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>