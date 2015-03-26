<!-------------------------------->
<link rel="stylesheet" media="screen" href="../../includes/media/css/jquery.dataTables.css" />
<script language="javascript" type="text/javascript" src="../../includes/media/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../../includes/media/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="../../includes/bootstrap/css/bootstrap.css" type="text/css">
<!-------------------------------->
<?php
include '../../includes/config.php';
include '../../includes/fungsi.php';
include '../../includes/mysql.php';
?>
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable({
    "iDisplayLength":50});
} );
</script>
<script>
  function simpansupplier($id) {
       window.opener.document.getElementById('idsupplier').value=$id;
    this.window.close();
  }
  function tutup() {
    this.window.close();
  }
</script>

<?php
/*
$db = "perpustakaan"; // nama database
$host = "localhost";  //tempat database berada, kalau di komputer local diisi localhost/127.0.0.1 atau bisa juga IP
$user = "root"; // username database
$pwd = ""; //passwors databas
@mysql_connect($host,$user,$pwd) or die ("Error Connect to Database");  // proses koneksi ke database
@mysql_select_db($db) or die ("Database not found"); // proses pemilihan database
*/


//$sql = "SELECT * FROM perpus_buku";
//$runsql = mysql_query($sql);
echo '<table class="table table-striped table-hover" id="example">
<thead><tr>
<th>No</th>
<th>Kode</th>
<th>Nama</th>
<th>Alamat</th>
<th>Telepon</th>
<th width="180px">Aksi</th>
</tr></thead><tbody>';
$no=1;
$hasil = $koneksi_db->sql_query( "SELECT * FROM pos_supplier order by nama asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
//while($data=mysql_fetch_array($runsql)){ // while digunakan untuk melakukan perulangan. 
$id=$data['id'];
$kodesupplier=$data['kode'];
$nama=$data['nama'];
$alamat=$data['alamat'];
$telepon=$data['telepon'];
echo'<tr>
<td><b>'.$no.'</b></td>
<td>'.$kodesupplier.'</td>
<td>'.$nama.'</td>
<td>'.$alamat.'</td>
<td>'.$telepon.'</td>';
echo "
<td><input class='btn btn-success' type='button' value='PILIH' onclick='simpansupplier($id)'></td>
</tr>";
$no++;
}
echo '</tbody></table>';
echo '<div align="center"><input type="button" value="BATAL" onclick="tutup()"class="btn btn-warning"></div>';
?>