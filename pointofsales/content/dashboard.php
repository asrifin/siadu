<?php
	include "includes/libchart/libchart/classes/libchart.php";
	
	///////////////////////////
if (!defined('AURACMS_CONTENT')) {
	Header("Location: ../index.php");
	exit;
}

global $koneksi_db;
$style_include[] = '
<style type="text/css">
/*<![CDATA[*/
    .box{
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
/*]]>*/
</style>';
$script_include[] = $JS_SCRIPT;
$tengah .='<legend>Dashboard</legend>';

if ($_SESSION['LevelAkses']){
$username = $_SESSION['UserName'];
$query =  $koneksi_db->sql_query( "SELECT * FROM useraura where user = '$username'" );
$data = $koneksi_db->sql_fetchrow( $query );
$last_ping = datetimes($data['last_ping'],true);

#####################################
# Administrator
#####################################
if ($_SESSION['LevelAkses']){

$tengah .='<div class="border"><font style="color:#21759B;"><b>Last Login :</b> '.$last_ping.'</font></div>';

$tengah .='<div class="row">';
/////////////////////////////////////////////////////////////////////////////////////////////
$tengah .='<div class="col-xs-6">';
/////////////////////////////////////////////////////////////////////////////////////////////
$tengah .='</div>';
$tengah .='</div>';
}
}
echo $tengah;
?>