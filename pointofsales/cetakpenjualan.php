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
echo "<html><head><title>Laporan Penjualan </title>";
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
echo'<tr><td colspan="7"><h4>Laporan Penjualan, Dari '.$tglmulai.', Sampai '.$tglakhir.'</h4></td></tr>';
echo '
<tr class="border">
<td>No</td>
<td>No.Faktur</td>
<td>Tanggal</td>
<td>Customer</td>
<td>Cara Bayar</td>
<td>Total</td>
<td>Discount</td>
<td>Netto</td>
</tr>';
$no =1;
$s = mysql_query ("SELECT * FROM `pos_penjualan` where tgl >= '$tglmulai' and tgl <= '$tglakhir' $wherestatus order by tgl asc");	
while($datas = mysql_fetch_array($s)){
$id = $datas['id'];
$nofaktur = $datas['nofaktur'];
$tgl = $datas['tgl'];
$kodecustomer = $datas['kodecustomer'];
$carabayar = $datas['carabayar'];
$total = $datas['total'];
$discount = $datas['discount'];
$netto = $datas['netto'];
$bayar = $datas['bayar'];
$user = $datas['user'];
$urutan = $no + 1;
echo '
<tr class="border">
<td class="text-center">'.$no.'</td>
<td>'.$nofaktur.'</td>
<td>'.$tgl.'</td>
<td>'.getnamacustomer($kodecustomer).'</td>
<td>'.$carabayar.'</td>
<td>'.$total.'</td>
<td>'.$discount.'</td>
<td>'.$netto.'</td>
</tr>';
$no++;
$tnetto+=$netto;
}
echo '
<tr class="border" align="right">
<td colspan="7"><b>Grand Total :</b></td>
<td>'.$tnetto.'</td>
</tr>';
echo '</table>';
}else{
echo'<tr><td colspan="8"><h4>Laporan Penjualan, Dari '.$tglmulai.', Sampai '.$tglakhir.'</h4></td></tr>';
echo '
<tr class="border">
<td>No</td>
<td>No.Faktur</td>
<td>Tanggal</td>
<td>Customer</td>
<td>Kode Barang</td>
<td>Nama Barang</td>
<td>Harga</td>
<td>Jumlah</td>
<td>Total</td>
</tr>';
$no =1;
$s = mysql_query ("SELECT * FROM `pos_penjualan` where tgl >= '$tglmulai' and tgl <= '$tglakhir' $wherestatus order by tgl asc");	
while($datas = mysql_fetch_array($s)){
$id = $datas['id'];
$nofaktur = $datas['nofaktur'];
$tgl = $datas['tgl'];
$kodecustomer = $datas['kodecustomer'];
$carabayar = $datas['carabayar'];
$user = $datas['user'];
$discount = $datas['discount'];
$totaldiscount += $discount;
$urutan = $no + 1;
$s2 = mysql_query ("SELECT * FROM `pos_penjualandetail` where nofaktur = '$nofaktur'order by id asc");	
while($datas2 = mysql_fetch_array($s2)){
$kodebarang = $datas2['kodebarang'];
$jumlah = $datas2['jumlah'];
$harga = $datas2['harga'];

$subtotal = $harga*$jumlah;
echo '
<tr class="border">
<td class="text-center">'.$no.'</td>
<td>'.$nofaktur.'</td>
<td>'.$tgl.'</td>
<td>'.getnamacustomer($kodecustomer).'</td>
<td>'.$kodebarang.'</td>
<td>'.getnamabarang($kodebarang).'</td>
<td>'.$harga.'</td>
<td>'.$jumlah.'</td>
<td>'.$subtotal.'</td>
</tr>';
$no++;
$grandtotal+=$subtotal;
}
}
echo '
<tr class="border" align="right">
<td colspan="8"><b>Grand Total :</b></td>
<td>'.$grandtotal.'</td>
</tr>';
echo '
<tr class="border" align="right">
<td colspan="8"><b>Grand Discount :</b></td>
<td>'.$totaldiscount.'</td>
</tr>';
$totalnetto = $grandtotal-$totaldiscount;
echo '
<tr class="border" align="right">
<td colspan="8"><b>Grand Netto :</b></td>
<td>'.$totalnetto.'</td>
</tr>';
echo '</table>';
}
/****************************/
echo "</body</html>";

if (isset($_GET['tglmulai'])){
echo "<script language=javascript>
window.print();
</script>";
}
?>
