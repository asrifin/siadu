<?php
error_reporting(1);
$folder='pointofsales';
$link = mysql_connect('localhost', 'root','');
$database="pointofsales";
$dB_sel=mysql_select_db($database);
$tengah .="";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css/login.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css">
<link rel="shortcut icon" href="favicon.ico" >
<title>Install Process</title>
</head>
<body>
<center>
<?php
if (!$link) {
$tengah ='
<div id="ctr" align="center">
<center>
<div class="login">
<div class="login-form">
<form action="" method="post" name="login" id="loginForm">
<div class="form-block">
<p>MySql Anda <strong>"Belum Terkoneksi"</strong>, Silahkan Koneksikan MySql Anda</p>
<br>
<div align="right"><a href="#"><span class="btn btn-danger"/>NEXT</span></a></div>
</div>
</form>
</div>
<div class="login-text">
<div class="ctr"><img src="images/mysql.png" width="100" height="100"/></div>
<div class="footer">

</div>
</div>
<div class="clr"></div>
</div>
</center>
</div>
';
}else if (!$dB_sel) {
$tengah ='

<div id="ctr" align="center">
<center>
<div class="login">
<div class="login-form">
<form action="" method="post" name="login" id="loginForm">
<div class="form-block">
<p>MySql Anda <br><strong>"Telah Terkoneksi"</strong>, <br>Klik untuk melanjutkan Installasi <b>Buat Database "'.$database.'"</b></p>
<br>
<div align="right"><a href="index.php?mod=createdatabase"><span class="btn btn-warning"/>NEXT</span></a></div>
</div>
</form>
</div>
<div class="login-text">
<div class="ctr"><img src="images/xampp-logo.png" width="100" height="100"/></div>
<div class="footer">

</div>
</div>
<div class="clr"></div>
</div>
</center>
</div>

';
}else{
$tengah ='

<div id="ctr" align="center">
<center>
<div class="login">
<div class="login-form">
<form action="" method="post" name="login" id="loginForm">
<div class="form-block">
<p>Database Anda <br><strong>"'.$database.', Telah Terbentuk"</strong>, <br>Klik untuk melanjutkan Installasi <b>Tahap 1</b></p>
<br>
<div align="right"><a href="bigdump.php"><span class="btn btn-success"/>NEXT</span></a></div>
</div>
</form>
</div>
<div class="login-text">
<div class="ctr"><img src="images/insertdata.png" width="100" height="100"/></div>
<div class="footer">

</div>
</div>
<div class="clr"></div>
</div>
</center>
</div>

';
}
if($_GET['mod']=="createdatabase"){
$sql = "CREATE DATABASE $database";
if (mysql_query($sql, $link)) {
$tengah ='

<div id="ctr" align="center">
<center>
<div class="login">
<div class="login-form">
<form action="" method="post" name="login" id="loginForm">
<div class="form-block">
<br>Klik untuk melanjutkan Installasi Pembentukan Database<b>Tahap 1</b></p>
<br>
<div align="right"><a href="bigdump.php"><span class="btn btn-success"/>NEXT</span></a></div>
</div>
</form>
</div>
<div class="login-text">
<div class="ctr"><img src="images/database.png" width="100" height="100"/></div>
<div class="footer">

</div>
</div>
<div class="clr"></div>
</div>
</center>
</div>
';

}
}
if($_GET['mod']=="selesai"){
if (!$dB_sel){
echo '<meta http-equiv="refresh" content="1; url=./" />';    
}
$tengah ='

<div id="ctr" align="center">
<center>
<div class="login">
<div class="login-form">
<form action="" method="post" name="login" id="loginForm">
<div class="form-block">
<p>Proses Telah <b>SELESAI</b>, Klik untuk menuju <b>Website Utama</b></p>
<br>
<div align="right"><a href="../"><span class="btn btn-primary"/>KE WEBSITE UTAMA</span></a></div>
</div>
</form>
</div>
<div class="login-text">
<div class="ctr"><img src="images/install.png" width="100" height="100"/></div>
<div class="footer">

</div>
</div>
<div class="clr"></div>
</div>
</center>
</div>
';
}
?>
</center>
</body>
</html>
<?php
echo $tengah;
exit;
?>