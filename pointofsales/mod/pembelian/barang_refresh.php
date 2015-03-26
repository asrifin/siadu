<?php
// PDO connect *********
function connect() {
    return new PDO('mysql:host=localhost;dbname=pointofsales', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM pos_produk WHERE kode LIKE (:keyword)or nama LIKE (:keyword) ORDER BY nama ASC LIMIT 0, 20";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$kode = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['kode']);
	// add new option
    echo '<li onclick="set_item2(\''.str_replace("'", "\'", $rs['kode']).'\')">'.$kode.' - '.$rs['nama'].'</li>';
}
?>