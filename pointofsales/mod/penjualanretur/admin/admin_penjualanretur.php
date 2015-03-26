<?php
if (!defined('AURACMS_admin')) {
    Header("Location: ../index.php");
    exit;
}

if (!cek_login()){
    header("location: index.php");
    exit;
} else{

$JS_SCRIPT.= <<<js
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable({
    "iDisplayLength":50});
} );
</script>
js;
$style_include[] .= '<link rel="stylesheet" media="screen" href="mod/calendar/css/dynCalendar.css" />
<link rel="stylesheet" href="mod/penjualan/style.css" />
';
$admin .= '

<script type="text/javascript" src="mod/penjualan/script.js"></script>
<script language="javascript" type="text/javascript" src="mod/calendar/js/browserSniffer.js"></script>
<script language="javascript" type="text/javascript" src="mod/calendar/js/dynCalendar.js"></script>';
$wkt = <<<eof
<script language="JavaScript" type="text/javascript">
    
    /**
    * Example callback function
    */
    /*<![CDATA[*/
    function exampleCallback_ISO3(date, month, year)
    {
        if (String(month).length == 1) {
            month = '0' + month;
        }
    
        if (String(date).length == 1) {
            date = '0' + date;
        }    
        document.forms['posts'].tgl.value = year + '-' + month + '-' + date;
    }
    calendar3 = new dynCalendar('calendar3', 'exampleCallback_ISO3');
    calendar3.setMonthCombo(true);
    calendar3.setYearCombo(true);
/*]]>*/     
</script>
eof;
$script_include[] = $JS_SCRIPT;
	
//$index_hal=1;	
	$admin  .='<legend>RETUR PENJUALAN</legend>';
$admin .='<div class="panel panel-info">';
$admin .= '<script type="text/javascript" language="javascript">
   function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
</script>';
if ($_GET['aksi'] == ''){

if(isset($_POST['tambah'])){
$kodecari 		= $_POST['kode'];
$totalbeli = $_SESSION["total"];
$jumlah 		= '1';
$hasil =  $koneksi_db->sql_query( "SELECT * FROM pos_produk WHERE kode='$kodecari'" );
$data = $koneksi_db->sql_fetchrow($hasil);
$id=$data['id'];
$kode=$data['kode'];
$stok=$data['jumlah'];
$error 	= '';
//$cekjumlahbeli = cekjumlahbeli($kode);
if (!$kode)  	$error .= "Error:  Kode Barang Tidak di Temukan<br />";
if ($error){
$admin .= '<div class="error">'.$error.'</div>';
}else{
$admin .= '<div class="sukses">Kode Barang di Temukan </div>';
$PRODUCTID = array ();
foreach ($_SESSION['product_id'] as $k=>$v){
$PRODUCTID[] = $_SESSION['product_id'][$k]['kode'];
}
if (!in_array ($kodebuku, $PRODUCTID)){
$_SESSION['product_id'][] = array ('id' => $id,'kode' => $kode, 'jumlah' => $jumlah);
}else{
foreach ($_SESSION['product_id'] as $k=>$v){
    if($kode == $_SESSION['product_id'][$k]['kode'])
	{
$_SESSION['product_id'][$k]['jumlah'] = $_SESSION['product_id'][$k]['jumlah']+1;
    }
}
		
}
}
}

if(isset($_POST['submitpenjualanretur'])){
$noretur 		= $_POST['noretur'];
$tgl 		= $_POST['tgl'];
$kodecustomer		= $_SESSION["kodecustomer"];
$total 		= $_POST['total'];
$user 		= $_POST['user'];
if (!$_SESSION["kodecustomer"])  	$error .= "Error:  Kode Customer harus ada <br />";
if (!$_SESSION["product_id"])  	$error .= "Error:  Kode Barang harus ada <br />";
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT noretur FROM pos_penjualanretur WHERE noretur='$noretur'")) > 0) $error .= "Error: Nomor Retur ".$noretur." sudah terdaftar<br />";

if ($error){
$admin .= '<div class="error">'.$error.'</div>';
}else{
$hasil  = mysql_query( "INSERT INTO `pos_penjualanretur` VALUES ('','$noretur','$tgl','$kodecustomer','$total','$user')" );
$idpembelian = mysql_insert_id();
foreach ($_SESSION["product_id"] as $cart_itm)
{
$kode = $cart_itm["kode"];
$jumlah = $cart_itm["jumlah"];
$harga = $cart_itm["harga"];
$hasil  = mysql_query( "INSERT INTO `pos_penjualanreturdetail` VALUES ('','$noretur','$kode','$jumlah','$harga')" );
updatestokjualretur($kode,$jumlah);
}
if($hasil){
$admin .= '<div class="sukses"><b>Berhasil Menambah Retur Penjualan.</b></div>';
penjualanreturrefresh();
$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=penjualanretur&mod=yes" />';
}else{
$admin .= '<div class="error"><b>Gagal Menambah Retur Penjualan.</b></div>';
		}		
}	
}

if(isset($_POST['tambahcustomer'])){
$_SESSION['kodecustomer'] = $_POST['kodecustomer'];
}

if($_SESSION["kodecustomer"]!=''){
$customer = '
		<td>Nama Customer</td>
		<td>:</td>
		<td>'.getnamacustomer($_SESSION['kodecustomer']).'</td>';
}else{
$customer = '
		<td></td>
		<td></td>
		<td></td>';	
	
}

if(isset($_POST['hapusbarang'])){
$kode 		= $_POST['kode'];
foreach ($_SESSION['product_id'] as $k=>$v){
    if($kode == $_SESSION['product_id'][$k]['kode'])
	{
unset($_SESSION['product_id'][$k]);
    }
}
}

if(isset($_POST['editjumlah'])){
$kode 		= $_POST['kode'];
$jumlahbeli = $_POST['jumlahbeli'];
foreach ($_SESSION['product_id'] as $k=>$v){
    if($kode == $_SESSION['product_id'][$k]['kode'])
	{
		$_SESSION['product_id'][$k]['jumlah']=$jumlahbeli;
    }
}
}

if(isset($_POST['tambahbarang'])){
$kodebarang 		= $_POST['kodebarang'];
$jumlah 		= '1';
$hasil =  $koneksi_db->sql_query( "SELECT * FROM pos_produk WHERE kode='$kodebarang'" );
$data = $koneksi_db->sql_fetchrow($hasil);
$id=$data['id'];
$kode=$data['kode'];
$stok=$data['jumlah'];
$harga=$data['hargajual'];
$error 	= '';
if (!$kode)  	$error .= "Error:  Kode Barang Tidak di Temukan<br />";
if ($error){
$admin .= '<div class="error">'.$error.'</div>';
}else{

$PRODUCTID = array ();
foreach ($_SESSION['product_id'] as $k=>$v){
$PRODUCTID[] = $_SESSION['product_id'][$k]['kode'];
}
if (!in_array ($kode, $PRODUCTID)){
$_SESSION['product_id'][] = array ('id' => $id,'kode' => $kode, 'jumlah' => $jumlah, 'harga' => $harga);
}else{
foreach ($_SESSION['product_id'] as $k=>$v){
    if($kode == $_SESSION['product_id'][$k]['kode'])
	{
$_SESSION['product_id'][$k]['jumlah'] = $_SESSION['product_id'][$k]['jumlah']+1;
    }
}
		
}
}
}

if(isset($_POST['bataljualretur'])){
penjualanreturrefresh();
}

$user = $_SESSION['UserName'];
$tglnow = date("Y-m-d");
$noretur = generatereturjual();
$tgl 		= !isset($tgl) ? $tglnow : $tgl;
$kodecustomer 		= !isset($kodecustomer) ? $_SESSION['kodecustomer'] : $kodecustomer;

$admin .= '
<div class="panel-heading"><b>Transaksi Retur Penjualan</b></div>';	
$admin .= '
<form method="post" action="" class="form-inline"id="posts">
<table class="table table-striped table-hover">';
$admin .= '
	<tr>
		<td>Nomor Retur</td>
		<td>:</td>
		<td><input type="text" name="noretur" value="'.$noretur.'" class="form-control"></td>
'.$customer.'
	</tr>';
$admin .= '
	<tr>
		<td>Tanggal</td>
		<td>:</td>
		<td><input type="text" name="tgl" value="'.$tgl.'" class="form-control">&nbsp;'.$wkt.'</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>';
$admin .= '
	<tr>
		<td>Kode Customer</td>
		<td>:</td>
		<td><div class="input_container">
                    <input type="text" id="country_id"  name="kodecustomer" value="'.$kodecustomer.'" onkeyup="autocomplet()"class="form-control" >
					<input type="submit" value="Tambah Customer" name="tambahcustomer"class="btn btn-success" >&nbsp;
                    <ul id="country_list_id"></ul>
                </div>
				</td>
		<td></td>
		<td></td>
		<td></td>
		</tr>';


$admin .= '
	<tr>
		<td>Kode Barang</td>
		<td>:</td>
		<td>
                <div class="input_container">
                    <input type="text" id="barang_id"  name="kodebarang" value="'.$kodebarang.'" onkeyup="autocomplet2()"class="form-control" >
					<input type="submit" value="Tambah Barang" name="tambahbarang"class="btn btn-success" >&nbsp;
                    <ul id="barang_list_id"></ul>
                </div>
				</td>
	<td></td>
	<td></td>
	<td></td>
		</tr>
				';
$admin .= '	
	<tr><td colspan="5"><div id="Tbayar"></div></td>
		<td>
		</td>
	</tr>
</table>';	
if(($_SESSION["product_id"])!=""){
$no=1;
$admin .= '
<div class="panel-heading"><b>Detail Retur</b></div>';	
$admin .= '
<table class="table table-striped table-hover">';
$admin .= '	
	<tr>
			<th><b>No</b></</th>
		<th><b>Kode</b></</th>
		<th><b>Nama</b></td>
		<th><b>Jumlah</b></</td>
		<th><b>Harga</b></</th>
		<th><b>Jumlah</b></</th>
		<th><b>Aksi</b></</th>
	</tr>';
foreach ($_SESSION["product_id"] as $cart_itm)
        {
$subtotal = $cart_itm["jumlah"]*$cart_itm["harga"];
$admin .= '	
<form method="post" action=""id="posts">
	<tr>
			<td>'.$no.'</td>
		<td>'.$cart_itm["kode"].'</td>
		<td>'.getnamabarang($cart_itm["kode"]).'</td>
		<td><input align="right" type="text" name="jumlahjual" value="'.$cart_itm["jumlah"].'"class="form-control"></td>
		<td>'.$cart_itm["harga"].'</td>
		<td>'.$subtotal.'</td>
		<td>
		
		<input type="hidden" name="kode" value="'.$cart_itm["kode"].'">
		<input type="submit" value="EDIT" name="editjumlah"class="btn btn-warning" >
		<input type="submit" value="HAPUS" name="hapusbarang"class="btn btn-danger"></form></td>
	</tr>';
	$total +=$subtotal;
	$no++;
		}
$admin .= '	
	<tr>
		<td></td>
		<td></td>		
		<td colspan="3" align="right"><b>Total</b></td>
		<td ><input type="text" name="total" id="total"   class="form-control"  value="'.$total.'"/></td>
		<td></td>
	</tr>';
$admin .= '<tr><td colspan="4"></td><td align="right"></td>
		<td><input type="hidden" name="user" value="'.$user.'">
		<input type="submit" value="Batal" name="bataljualretur"class="btn btn-danger" >
		<input type="submit" value="Simpan" name="submitpenjualanretur"class="btn btn-success" >
		</td>
		<td></td></tr>';
$admin .= '</table></form>';	
	}
}

$admin .='</div>';
}
echo $admin;
?>
