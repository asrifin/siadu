<?php
if (!defined('AURACMS_admin')) {
	Header("Location: ../index.php");
	exit;
}

//$index_hal = 1;
if (!cek_login ()){   
	
$admin .='<p class="judul">Access Denied !!!!!!</p>';
}else{

$JS_SCRIPT= <<<js
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable();
} );
</script>
js;
$script_include[] = $JS_SCRIPT;
$admin  .='<legend>SUPPLIER</legend>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `pos_supplier` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Supplier berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=supplier&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$kode 		= $_POST['kode'];
$nama 		= $_POST['nama'];
$alamat 		= $_POST['alamat'];
$telepon 		= $_POST['telepon'];
	
	$error 	= '';
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT kode FROM pos_supplier WHERE kode='$kode'")) > 1) $error .= "Error: Kode ".$kode." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `pos_supplier` SET `kode`='$kode',`nama`='$nama',`alamat`='$alamat',`telepon`='$telepon' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=supplier&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `pos_supplier` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$kode 		= $data['kode'];
$nama 		= $data['nama'];
$alamat 		= $data['alamat'];
$telepon 		= $data['telepon'];
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit Supplier</h3></div>';
$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table INFO">
	<tr>
		<td>Kode</td>
		<td>:</td>
		<td><input type="text" name="kode" size="25"class="form-control" required value="'.$kode.'"></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="nama" size="25"class="form-control" required value="'.$nama.'"></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><input type="text" name="alamat" size="25"class="form-control" required value="'.$alamat.'"></td>
	</tr>
	<tr>
		<td>Telepon</td>
		<td>:</td>
		<td><input type="text" name="telepon" size="25"class="form-control" required value="'.$telepon.'"></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success"></td>
	</tr>
</table>
</form></div>';
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
$kode 		= $_POST['kode'];
$nama 		= $_POST['nama'];
$alamat 		= $_POST['alamat'];
$telepon 		= $_POST['telepon'];
	$error 	= '';
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT kode FROM pos_supplier WHERE kode='$kode'")) > 0) $error .= "Error: Kode ".$kode." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `pos_supplier` VALUES ('','$kode','$nama','$alamat','$telepon')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($kode);
		unset($alamat);
		unset($telepon);
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$kode     		= !isset($kode) ? '' : $kode;
$alamat     		= !isset($alamat) ? '' : $alamat;
$telepon     		= !isset($telepon) ? '' : $telepon;

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah Supplier</h3></div>';

$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table table-condensed">
	<tr>
		<td>Kode</td>
		<td>:</td>
		<td><input type="text" name="kode" size="25"class="form-control" required></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="nama" size="25"class="form-control" required></td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><input type="text" name="alamat" size="25"class="form-control" required></td>
	</tr>
	<tr>
		<td>Telepon</td>
		<td>:</td>
		<td><input type="text" name="telepon" size="25"class="form-control" required></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success"></td>
	</tr>
</table>
</form>';
$admin .= '</div>';

}

if (in_array($_GET['aksi'],array('edit','del',''))){

$admin.='
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th width="30%">Aksi</th>
        </tr>
    </thead>';
	$admin.='<tbody>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM pos_supplier" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) { 
$kode=$data['kode'];
$nama=$data['nama'];
$alamat=$data['alamat'];
$telepon=$data['telepon'];
$admin.='<tr>
            <td>'.$kode.'</td>
            <td>'.$nama.'</td>
            <td>'.$alamat.'</td>
            <td>'.$telepon.'</td>
            <td><a href="?pilih=supplier&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=supplier&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
        </tr>';
}   
$admin.='</tbody>
</table>';
}

}
echo $admin;
?>