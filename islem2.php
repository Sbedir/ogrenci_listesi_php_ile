<?php  
include './baglan.php';
//öğrenci ekleme işlemi

if(isset($_POST['ogr_ekleme']))
{
    $target_file='';
   if($_FILES['resim']["tmp_name"]!==""){
    $target_dir = "images/";
    $target_file = $target_dir . time().basename($_FILES["resim"]["name"]);
   
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    
   
    $check = getimagesize($_FILES['resim']["tmp_name"]);
    if($check !== false) {
        move_uploaded_file($_FILES['resim']["tmp_name"], $target_file);
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}
    


    // print_r($_FILES);
    // print_r($_POST);
    // exit; 
    //sol tarafdakiler mysq
    $kaydet=$db->prepare("INSERT into ogrenciler set
    id=:ogr_id,
    ad=:ogr_adi,
    soyad=:ogr_soyad,
    okul_no=:ogr_okul_no,
    okul_ad=:ogr_okul_ad,
    fakulte=:ogr_fakulte,
    bolum=:ogr_bolum,
    ogr_resim=:ogr_ogr_resim,
    adres=:ogr_adres,
    telefon=:ogr_telefon,
    mail=:ogr_mail,
    okul_baslama_zaman=:ogr_okul_baslama_zaman,
    okul_bitis_zaman=:ogr_okul_bitis_zaman,
    ekleme_zamani=:ogr_ekleme_zamani,
    guncelleme_zamani=:ogr_guncelleme_zamani

	");
//sağ tarafdakiler modal input name alanları
    $insert=$kaydet->execute(array(
    'ogr_id'=>null,
    'ogr_adi'=>$_POST['ad'],
    'ogr_soyad'=>$_POST['soyad'],
    'ogr_okul_no'=>$_POST['okul_numarasi'],
    'ogr_okul_ad'=>$_POST['okul_adi'],
    'ogr_fakulte'=>$_POST['fakulte'],
    'ogr_bolum'=>$_POST['bolum'],
    'ogr_ogr_resim'=>$target_file,
    'ogr_adres'=>$_POST['adres'],
    'ogr_telefon'=>$_POST['telefon'],
    'ogr_mail'=>$_POST['mail'],
    'ogr_okul_baslama_zaman'=>$_POST['okul_baslangic_tarihi'],
    'ogr_okul_bitis_zaman'=>$_POST['okul_bitis_tarihi'],
    'ogr_ekleme_zamani'=>date('Y-m-d H:i:s'),
    'ogr_guncelleme_zamani'=>date('Y-m-d H:i:s')
    ));



if ($insert) {
	//echo "kayıt başarılı";
	header("location:ogrenciler2.php?durum=ok&type=ekleme");
	exit;
}
else{
	//echo "kayıt başarısız";
	header("location:ogrenciler2.php?durum=no&type=ekleme");
	exit;
}
}

//öğrenci güncelleme işlemi

if(isset($_POST['ogr_guncelle']))
{
    // print_r($_FILES);
   // print_r($_POST);
    //exit; 
    //sol tarafdakiler mysq
    //file_exists dosya varmı kontrolu yapar
    //unlink dosyanın icine yüklenen resmi siler
  


      $target_file='';

      if($_FILES['resim']["tmp_name"]!==""){
        if (file_exists($_POST['gresimdel'])) {
            unlink($_POST['gresimdel']);
            $uploadOk = 0;
          }

      $target_dir = "images/";
      $target_file = $target_dir . time(). basename($_FILES["resim"]["name"]);
     
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      
     
      $check = getimagesize($_FILES["resim"]["tmp_name"]);
      if($check !== false) {
          move_uploaded_file($_FILES["resim"]["tmp_name"], $target_file);
          $uploadOk = 1;
      } else {
          $uploadOk = 0;
      }
    }
    else{
        $target_file=$_POST['gresimdel'];
    }


    $kaydet=$db->prepare("UPDATE ogrenciler set
    id=:ogr_id,
    ad=:ogr_adi,
    soyad=:ogr_soyad,
    okul_no=:ogr_okul_no,
    okul_ad=:ogr_okul_ad,
    fakulte=:ogr_fakulte,
    bolum=:ogr_bolum,
    ogr_resim=:ogr_ogr_resim,
    adres=:ogr_adres,
    telefon=:ogr_telefon,
    mail=:ogr_mail,
    okul_baslama_zaman=:ogr_okul_baslama_zaman,
    okul_bitis_zaman=:ogr_okul_bitis_zaman,
   
    guncelleme_zamani=:ogr_guncelleme_zamani
    where id=".($_POST['id'])
    

	);
//sağ tarafdakiler modal input name alanları
    $update=$kaydet->execute(array(
    'ogr_id'=>$_POST['id'],
    'ogr_adi'=>$_POST['ad'],
    'ogr_soyad'=>$_POST['soyad'],
    'ogr_okul_no'=>$_POST['okul_numarasi'],
    'ogr_okul_ad'=>$_POST['okul_adi'],
    'ogr_fakulte'=>$_POST['fakulte'],
    'ogr_bolum'=>$_POST['bolum'],
    'ogr_ogr_resim'=>$target_file,
    'ogr_adres'=>$_POST['adres'],
    'ogr_telefon'=>$_POST['telefon'],
    'ogr_mail'=>$_POST['mail'],
    'ogr_okul_baslama_zaman'=>$_POST['okul_baslangic_tarihi'],
    'ogr_okul_bitis_zaman'=>$_POST['okul_bitis_tarihi'],
   
    'ogr_guncelleme_zamani'=>date('Y-m-d H:i:s')
    ));



if ($update) {
	//echo "güncelleme başarılı";
	header("location:ogrenciler2.php?durum=ok&type=güncelleme");
	exit;
}
else{
	//echo "güncelleme başarısız";
	header("location:ogrenciler2.php?durum=no&type=güncelleme");
	exit;
}
}


//öğrenci silme işlemi

if(isset($_POST['ogr_sil']))
{
    // print_r($_FILES);
   // print_r($_POST);
    //exit; 
    //sol tarafdakiler mysq
    if (file_exists($_POST['resim'])) {
        unlink($_POST['resim']);
        $uploadOk = 0;
      }

    $kaydet=$db->prepare("DELETE from ogrenciler 
   
    
    where id=".($_POST['id'])
    

	);
//sağ tarafdakiler modal input name alanları
    $delete=$kaydet->execute(
    );



if ($delete) {
	//echo "silme başarılı";
	header("location:ogrenciler2.php?durum=ok&type=silme");
	exit;
}
else{
	//echo "silme başarısız";
	header("location:ogrenciler2.php?durum=no&type=silme");
	exit;
}
}
?>