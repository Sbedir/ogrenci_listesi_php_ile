<?php
include './baglan.php';
$ogrencisor=$db->prepare("SELECT * FROM ogrenciler");
$ogrencisor->execute();


$veriler='';
while ($ogrencicek=$ogrencisor->fetch(PDO::FETCH_ASSOC)) {
  $veriler.='<tr>';
    
  $veriler.='<td colspan="1">'.$ogrencicek['ad'].'</td>';
  $veriler.='<td colspan="1">'.$ogrencicek['soyad'].'</td>';
  $veriler.='<td colspan="1">'.$ogrencicek['okul_no'].'</td>';
  $veriler.='<td colspan="1">'.$ogrencicek['okul_ad'].'</td>';
  $veriler.='<td colspan="1">'.$ogrencicek['fakulte'].'</td>';
    $veriler.='<td colspan="1">'.$ogrencicek['bolum'].'</td>';
    $veriler.='<td colspan="1">'.$ogrencicek['adres'].'</td>';
    $veriler.='<td colspan="1">'.$ogrencicek['telefon'].'</td>';
    $veriler.='<td colspan="1">'.$ogrencicek['mail'].'</td>';
    $veriler.='<td colspan="1">'.$ogrencicek['okul_baslama_zaman'].'</td>';
    $veriler.='<td colspan="1">'.$ogrencicek['okul_bitis_zaman'].'</td>';
    
    $veriler.='</tr>';
 } 


 function exportExcel($filename,$html){
    header('Content-Encoding: UTF-8');// header fonksiyon içinde dönüştürdüğümüz sayfa ne sayfasıysa onun özelliklerini aldırır.
    header('Content-Type: text/plain; charset=utf-8');
    header("Content-disposition: attachment; filename=".$filename.".xls");//xls/xlsx excel uzantısıdır .Sayfayı excel dosyası yapar 
    echo "\xEF\xBB\xBF"; // UTF-8 BOM

   echo $html;


}

$html='<!-- saved from url=(0049)https://account.insectram.co.uk/musteri-rapor-pdf -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body><style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
font-size:12pt;
}
td {
font-family:Arial;
font-size:10pt;
}
</style>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<thead>

	<tr>
		<th colspan="11"><b>Öğrenci Listesi</b></th>
	</tr>
	
	<tr>
        <th colspan="1">Ad</th>
        <th colspan="1">Soyad</th>
        <th colspan="1">Okul Numarası</th>
        <th colspan="1">Okul Adı</th>
        <th colspan="1">Fakülte</th>
        <th colspan="1">Bölümü</th>
        <th colspan="1">Adres</th>
        <th colspan="1">Telefon</th>
        <th colspan="1">Email</th>
        <th colspan="1">Okula Başlangıç Tarihi</th>
        <th colspan="1">Okul Bitiş Tarihi</th>
		
	</tr>
</thead>
	<tbody>
   
        '.$veriler.'
    </tbody>
	</table></body></html>';




  exportExcel('Öğrenci Listesi',$html);

?>