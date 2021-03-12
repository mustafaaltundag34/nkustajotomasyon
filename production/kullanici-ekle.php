<!-- header -->
<?php require_once "component/header.php"; ?>
<!-- header -->

<?php
//url'den giriş yapılınca admin değilse direk main sayfasına yönlendirme yapılıyor.
if ($data["kullanicituru"]!="Ogruyesi") { 
  echo "<script type=\"text/javascript\" charset=\"utf-8\">window.self.close()</script>"; 
}

 

 
?>



<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kullanıcı Ekle
              <?php
                // Eğer güncelleme başarılı olursa mesaj göstertme alanı
              if (isset($_GET["durum"]) && $_GET["durum"]=="ok") { ?>

                <b class="alert alert-success small" style="color:white;">Ekleme Başarılı.</b>
                <script type="text/javascript">
                  swal("Başarılı","Kullanici Eklendi","success");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="no") { ?>

                <b class="alert alert-danger small" style="color:white;">Hata. Ekleme yapılmadı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Kullanici Eklenemedi","error");
                </script>

              <?php } elseif (isset($_GET["durum"]) && $_GET["durum"]=="firmaadihata") { ?>

                <b class="alert alert-warning small" style="color:white;">Kullanici kayıtlı.</b>
                <script type="text/javascript">
                  swal("Başarısız","Kullanici  kayıtlı.","warning");
                </script>

              <?php } ?>
            </h2>
            <div class="clearfix"></div>
            <div align="right">
              <a href="javascript:window.close();"><button class="btn btn-success btn-xs">Geri Dön</button></a>
            </div>
          </div>
          <div class="x_content">
            <br />
            <form action="../netting/admin-islemler.php" enctype="multipart/form-data"  method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciamail">Mail Adresi<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanicimail" id="kullanicimail" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciadisoyadi">Adi Soyadi<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullaniciadisoyadi" id="kullaniciadisoyadi" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicino">No<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanicino" id="kullanicino" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>


                  <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicisehir">Kullanici Sehir<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullanicisehir" class="form-control" name="kullanicisehir" required>
                      <option value="Istanbul">Istanbul</option>
                      <option value="ankara">Ankara</option>
                      <option value="Izmir">Izmir</option>
                      <option value="Bursa">Bursa</option>
                    </select>
                  </div>
                </div>  
              
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciuniversite">Universite<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullaniciuniversite" class="form-control" name="kullaniciuniversite" required>
                      <option value="Namık Kemal Universitesi">Namık Kemal Universitesi</option>
                      <option value="Trakya Universitesi">Trakya Universitesi</option>
                      <option value="Kirklareli Universitesi">Kirklareli Universitesi</option>
                      <option value="Istanbul Universitesi" >Istanbul Universitesi</option>
                      <option value="Marmara Universitesi" >Marmara Universitesi</option>
                      <option value="Yildiz Teknik Universitesi" >Yildiz Teknik Universitesi</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicibolum">Bölüm<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullanicibolum" class="form-control" name="kullanicibolum" required>
                      <option value="Bilgisayar Mühendisliği" >Bilgisayar Mühendisliği</option>
                      <option value="Elektronik Mühendisliği" >Elektronik Mühendisliği</option>
                      <option value="İnşaat Mühendisliği" >İnşaat Mühendisliği</option>
                      <option value="Çevre Mühendisliği" >Çevre Mühendisliği</option>
                      <option value="Endustri Mühendisliği">Endustri Mühendisliği</option>
                      <option value="Tekstil Mühendisliği" >Tekstil Mühendisliği</option>
                    </select>
                  </div>
                </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciteltel">Kullanici Telefon<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanicitel" id="kullanicitel" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicilog">Kullanici Aciklama<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="kullanicilog" id="kullanicilog" required="required" class="form-control col-md-7 col-xs-12"  >
                </div>
              </div>

                              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanicituru">Kullanici Turu<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="kullanicituru" class="form-control" name="kullanicituru" required>
                      <option value="Ogrenci" >Ogrenci</option>
                      <option value="Ogruyesi" >Ogruyesi</option>
                    </select>
                  </div>
                </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullaniciaktif">Aktiflik<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullaniciaktif" class="form-control" name="kullaniciaktif" required <?php echo $_SESSION["kullanicituru"] !='Ogruyesi' ? 'disabled' :";"?>>
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>


              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button name="kullaniciekle" type="submit" class="btn btn-success">Kaydet</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- /page content -->





<!-- footer -->
<?php require_once "component/footer.php"; ?>
<!-- footer -->








