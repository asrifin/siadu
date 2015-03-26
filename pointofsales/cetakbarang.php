<?php

include 'includes/config.php';
include 'includes/mysql.php';
include 'includes/configsitus.php';
global $koneksi_db,$url_situs;
$tglmulai 		= $_GET['tglmulai'];
$tglakhir 		= $_GET['tglakhir'];
$carabayar 		= $_GET['carabayar'];
$detail 		= $_GET['detail'];
switch ($carabayar) {
   case 'Semua':
         $wherestatus="";
         break;
   case 'Tunai':
         $wherestatus="and carabayar='Tunai'";
         break;
   case 'Kredit':
         $wherestatus="and carabayar='Kredit'";
         break;
}
echo "<html><head><title>Laporan Pembelian </title>";
echo '<style type="text/css">
   table { page-break-inside:auto; 
    font-size: 0.8em; /* 14px/16=0.875em */
font-family: "Times New Roman", Times, serif;
   }
   tr    { page-break-inside:avoid; page-break-after:auto }
	table {
    border-collapse: collapse;}
	
	th,td {
    padding: 5px;
}
.border{
	border: 1px solid black;
}
.border td{
	border: 1px solid black;
}
body {
	margin		: 0;
	padding		: 0;
    font-size: 1em; /* 14px/16=0.875em */
font-family: "Times New Roman", Times, serif;
    margin			: 2px 0 5px 0;
}
</style>';
echo "</head><body>";
echo'
<table align="center">
<tr><td colspan="7"><img style="margin-right:5px; margin-top:5px; padding:1px; background:#ffffff; float:left;" src="images/logo.png" height="70px"><br><br>
<b>Elyon Christian School</b><br>
Raya Sukomanunggal Jaya 33A, Surabaya 60187</td></tr>';

if(!$detail){
echo'<tr><td colspan="7"><h4>Laporan Barang</h4></td></tr>';
echo '
<tr class="border">
<td >No</td>
<td>Kode</td>
<td>Nama</td>
<td>Jenis</td>
<td>Harga Beli</td>
<td>Harga Jual</td>
<td>Stok</td>
</tr>';
$no =1;
$s = mysql_query ("SELECT * FROM `pos_produk` order by kode asc");	
while($datas = mysql_fetch_array($s)){
$id = $datas['id'];
$jenis = $datas['jenis'];
$kode = $datas['kode'];
$nama = $datas['nama'];
$jumlah = $datas['jumlah'];
$hargabeli = $datas['hargabeli'];
$hargajual = $datas['hargajual'];
$urutan = $no + 1;
echo '
<tr class="border">
<td class="text-center">'.$no.'</td>
<td>'.$kode.'</td>
<td>'.$nama.'</td>
<td>'.getjenis($jenis).'</td>
<td>'.$hargabeli.'</td>
<td>'.$hargajual.'</td>
<td>'.$jumlah.'</td>
</tr>';
$no++;
}
echo '</table>';
}else{

}
echo '</table>';
/****************************/
echo "</body</html>";

if (!isset($_GET['detail'])){
echo "<script language=javascript>
window.print();
</script>";
}
?>
