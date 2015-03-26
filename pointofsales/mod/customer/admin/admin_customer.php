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
$admin  .='<legend>CUSTOMER</legend>';

$admin  .= '<div class="border2">
<table  width="25%"><tr align="center">
<td>
<a href="admin.php?pilih=customer&mod=yes&aksi=jenjang">JENJANG</a>&nbsp;&nbsp;
</td>
<td>
<a href="admin.php?pilih=customer&mod=yes&aksi=kelas">KELAS</a>&nbsp;&nbsp;
</td>
<td>
<a href="admin.php?pilih=customer&mod=yes">CUSTOMER</a>&nbsp;&nbsp;
</td>
</tr></table>
</div>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `pos_customer` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Customer berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=customer&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$nama 		= $_POST['nama'];
$nis 		= $_POST['nis'];
$kelas 		= $_POST['kelas'];
	
	$error 	= '';
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `pos_customer` SET `nis`='$nis',`nama`='$nama',`kelas`='$kelas'WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=customer&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `pos_customer` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$nama  			= $data['nama'];
$nis  			= $data['nis'];
$kelas  			= $data['kelas'];
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit Customer</h3></div>';
$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table INFO">
<tr>
	<td>Kelas</td>
		<td>:</td>
	<td><select name="kelas" class="form-control" required>';
$hasil = $koneksi_db->sql_query("SELECT * FROM pos_kelas ORDER BY nama asc");
$admin .= '<option value="">Jenjang >> Kelas</option>';
while ($datas =  $koneksi_db->sql_fetchrow ($hasil)){
$pilihan = ($datas['id']==$kelas)?"selected":'';	
$admin .= '<option value="'.$datas['id'].'"'.$pilihan.'>'.getjenjang($datas['jenjang']).' >> '.$datas['nama'].'</option>';
}
$admin .='</select></td>
</tr>
<tr>
		<td>No Induk</td>
		<td>:</td>
		<td><input type="text" name="nis" size="25"class="form-control" value ="'.$nis.'" required></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="nama" size="25"class="form-control"  value ="'.$nama.'" required></td>
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
$nama 		= $_POST['nama'];
$nis 		= $_POST['nis'];
$kelas 		= $_POST['kelas'];
	$error 	= '';
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT nis FROM pos_customer WHERE nis='$nis'")) > 0) $error .= "Error: Nomor Induk ".$nis." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `pos_customer` VALUES ('','$nis','$nama','$kelas')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($nis);
		unset($kelas);
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$nis     		= !isset($nis) ? '' : $nis;
$kelas     		= !isset($kelas) ? '' : $kelas;


$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah Customer</h3></div>';

$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table table-condensed">
<tr>
	<td>Kelas</td>
		<td>:</td>
	<td><select name="kelas" class="form-control" required>';
$hasil = $koneksi_db->sql_query("SELECT * FROM pos_kelas ORDER BY nama asc");
$admin .= '<option value="">Jenjang >> Kelas</option>';
while ($datas =  $koneksi_db->sql_fetchrow ($hasil)){
	
$admin .= '<option value="'.$datas['id'].'">'.getjenjang($datas['jenjang']).' >> '.$datas['nama'].'</option>';
}
$admin .='</select></td>
</tr>
	<tr>
		<td>No Induk</td>
		<td>:</td>
		<td><input type="text" name="nis" size="25"class="form-control" required></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="nama" size="25"class="form-control" required></td>
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
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th width="30%">Aksi</th>
        </tr>
    </thead>';
	$admin.='<tbody>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM pos_customer" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) { 
$nis=$data['nis'];
$nama=$data['nama'];
$kelas=$data['kelas'];
$admin.='<tr>
            <td>'.$nis.'</td>
            <td>'.$nama.'</td>
            <td>'.getkelas($kelas).'</td>
            <td><a href="?pilih=customer&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=customer&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
        </tr>';
}   
$admin.='</tbody>
</table>';
}

if($_GET['aksi']== 'deljenjang'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `pos_jenjang` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Jenjang berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=customer&mod=yes&aksi=jenjang" />';    
	}
}

if($_GET['aksi'] == 'editjenjang'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$error 	= '';
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `pos_jenjang` SET `nama`='$nama' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=customer&amp;mod=yes&aksi=jenjang" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `pos_jenisproduk` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit Jenjang</h3></div>';
$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table INFO">
	<tr>
		<td>Nama Jenis</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$data['nama'].'" size="25"class="form-control" required></td>
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

if($_GET['aksi']=="jenjang"){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$error 	= '';
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `pos_jenjang` (`nama`) VALUES ('$nama')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
	}

}
$nama     		= !isset($nama) ? '' : $nama;


$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah Jenjang</h3></div>';

$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table table-condensed">
	<tr>
		<td>Nama Jenjang</td>
		<td>:</td>
		<td><input type="text" name="nama" size="25"class="form-control" required></td>
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

if (in_array($_GET['aksi'],array('editjenjang','deljenjang','jenjang'))){

$admin.='
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Jenjang</th>
            <th width="30%">Aksi</th>
        </tr>
    </thead>';
	$admin.='<tbody>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM pos_jenjang" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) { 

$nama=$data['nama'];
$admin.='<tr>
            <td>'.$nama.'</td>
            <td><a href="?pilih=customer&amp;mod=yes&amp;aksi=deljenjang&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=customer&amp;mod=yes&amp;aksi=editjenjang&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
        </tr>';
}   
$admin.='</tbody>
</table>';
}

if($_GET['aksi']== 'delkelas'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `pos_kelas` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Kelas berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=customer&mod=yes&aksi=kelas" />';    
	}
}

if($_GET['aksi'] == 'editkelas'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$jenjang 		= $_POST['jenjang'];
	$error 	= '';
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `pos_kelas` SET `nama`='$nama',`jenjang`='$jenjang' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=customer&amp;mod=yes&aksi=kelas" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `pos_kelas` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$jenjang  			= $data['jenjang'];
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit Kelas</h3></div>';
$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table INFO">
<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" required>';
$hasil = $koneksi_db->sql_query("SELECT * FROM pos_jenjang ORDER BY nama asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datas =  $koneksi_db->sql_fetchrow ($hasil)){
$pilihan = ($datas['id']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datas['id'].'"'.$pilihan.'>'.$datas['nama'].'</option>';
}
$admin .='</select></td>
</tr>
	<tr>
		<td>Nama Kelas</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$data['nama'].'" size="25"class="form-control" required></td>
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

if($_GET['aksi']=="kelas"){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$jenjang 		= $_POST['jenjang'];
	$error 	= '';
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `pos_kelas` (`nama`,`jenjang`) VALUES ('$nama','$jenjang')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($jenjang);
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah Kelas</h3></div>';

$admin .= '
<form method="post" action="">
<table border="0" cellspacing="0" cellpadding="0"class="table table-condensed">
<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" required>';
$hasil = $koneksi_db->sql_query("SELECT * FROM pos_jenjang ORDER BY nama asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datas =  $koneksi_db->sql_fetchrow ($hasil)){
$admin .= '<option value="'.$datas['id'].'">'.$datas['nama'].'</option>';
}
$admin .='</select></td>
</tr>
	<tr>
		<td>Nama Kelas</td>
		<td>:</td>
		<td><input type="text" name="nama" size="25"class="form-control" required></td>
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

if (in_array($_GET['aksi'],array('editkelas','delkelas','kelas'))){

$admin.='
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Kelas</th>
            <th>Jenjang</th>
            <th width="30%">Aksi</th>
        </tr>
    </thead>';
	$admin.='<tbody>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM pos_kelas" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) { 

$nama=$data['nama'];
$jenjang=$data['jenjang'];
$admin.='<tr>
            <td>'.$nama.'</td>
            <td>'.getjenjang($jenjang).'</td>
            <td><a href="?pilih=customer&amp;mod=yes&amp;aksi=delkelas&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=customer&amp;mod=yes&amp;aksi=editkelas&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
        </tr>';
}   
$admin.='</tbody>
</table>';
}

}
echo $admin;
?>