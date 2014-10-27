<?php
/* Pre Data Processing */
$loan_limit=dbFetch("val","mstr_setting","W/dcid=5");

require_once(MODDIR.'pagelink.php');
$nid=getsx('nid');
$t=mysql_query("SELECT * FROM ".DB_HRD." WHERE nip='$nid' LIMIT 0,1");
$f=dbFAx($t);
$member=dbFAx($t);
// Show
$show=gets('show')=='all'?'1':'0';
// Sorting:
$sortby=getsx('sortby');
$sortmode=getsx('mode');
$sf=false;
$sm=($sortmode=='1')?" DESC":"";
if($sortby=='shelf'){
	$sql="SELECT t1.* FROM book t1 JOIN mstr_shelf t2 ON t1.shelf = t2.dcid WHERE catalog='$nid' ORDER BY t2.name".$sm;
	$sf=true;
} else {
	// Sorting fields
	$sfa=Array('date2','status');
	foreach($sfa as $k=>$v){
		if($sortby==$v) $sf=true;
	}
	if($sf){
		$sfi=$sortby;
	} else {
		$sfi=$sfa[0]; $sortby="";
	}
	if($show!='1'){
		$sql="SELECT * FROM loan WHERE member='$nid' AND status='1' ORDER BY ".$sfi.$sm;
		$stablew='850px';
	} else {
		$sql="SELECT * FROM loan WHERE member='$nid' ORDER BY date1 DESC,date2 DESC";
		$stablew='1000px';
	}
}
if($sf){
	if($sortmode!='1') $smode='1';
	else $smode='0';
}

// Queries:
$t=mysql_query($sql);
$ndata=mysql_num_rows($t);

// Paging:
$page_link=RLNK."members.php?tab=staff&act=view&nid=".$f['nip'];
$page=1; // force page to 1 (no-pagging)

// find item update location
$l=-1;
if($opt=='a' || $opt=='u'){
	$l=1;
	while($k=mysql_fetch_array($t)){
		if($cid==$k['dcid']){ // found!
			// Re-Calculate page:
			$page=ceil(($l)/$npp);
			$nps = $npp*($page-1);
			$npl = $nps+$npp;
			break;
		}
		$l++;
	}
	// Re-Queries:
	$t=mysql_query($sql);
	$ndata=mysql_num_rows($t);
}

// Stats
$nloan=mysql_num_rows(mysql_query("SELECT * FROM loan WHERE member='$nid' AND status='1'"));
$nlate=mysql_num_rows(mysql_query("SELECT * FROM loan WHERE member='$nid' AND status='2'"));
$intime=mysql_num_rows(mysql_query("SELECT * FROM loan WHERE member='$nid' AND status='0'"));
$fine=0.0;
$tfine=mysql_query("SELECT fine FROM loan WHERE member='$nid' AND status!='1'");
while($rf=mysql_fetch_array($tfine)){
$fine+=$rf['fine'];
}
$status=Array('1'=>'In loan','0'=>'Return in time','2'=>'Return late');
?>
<table cellspacing="0" cellpadding="0" width="" style="margin-bottom:2px"><tr height="30px">
<td>
<button class="btn" style="float:left;margin-right:4px;width:104px" onclick="jumpTo('<?=RLNK?>members.php?tab=staff')" style="margin-right:6px">
	<div class="bi_arrow">View all staff</div>
</button>
<button class="btn" style="float:left;margin-right:4px;width:110px" onclick="jumpTo('<?=RLNK?>circulation.php?tab=loan&act=loan&nid=<?=$nid?>')">
	<div class="bi_out">Borrow books</div>
</button>
<?php if($ndata>0){?>
<!--button class="btn" style="float:left;margin-right:4px;width:107px" onclick="jumpTo('<?=RLNK?>members.php?tab=staff&act=loan&nid=<?=$nid?>')">
	<div class="bi_in">Return books</div>
</button-->
<?php if($show!='1'){?>
<button class="btn" style="float:left;margin-right:4px;width:146px" onclick="jumpTo('<?=RLNK?>members.php?tab=staff&act=view&nid=<?=$nid?>&show=all')">
	<div class="bi_lis">View all loan history</div>
</button>
<?php }else{?>
<button class="btn" style="float:left;margin-right:4px;width:131px" onclick="jumpTo('<?=RLNK?>members.php?tab=staff&act=view&nid=<?=$nid?>')">
	<div class="bi_lis">View book in loan</div>
</button>
<?php }}?>
</td></tr></table>
<table class="stable2" cellspacing="0" cellpadding="5px" width="500px" style="margin-top:0px">
<tr valign="top" style="height:130px">
	<td width="60px" style="padding-top:10px">
		<?php 
		$np=mysql_num_rows(mysql_query("SELECT * FROM ".DB_HRD_PHOTO." WHERE empid='".$f['dcid']."'"));
		if($np>0){ ?>
			<div id="pf_photo"><img src="<?=HRD_RLNK?>photo.php?id=<?=$f['dcid']?>" width="60px"/></div><br/>
		<?php } else {?>
			<div id="pf_photo"><img src="<?=HRD_IMGR?>nophoto.png" width="60px"/></div><br/>
		<?php } ?>
	</td>
	<td style="padding-left:10px">
		<div style="font:15px <?=SFONT?>;color:<?=CDARK?>"><b><?=$f['name']?></b></div>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:6px">NIP: <?=$f['nip']?></div>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px">Member type: Staff</div>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px">Address: <?=$f['address']?></div>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px">Phone: <?=$f['phonefax']?></div>
	</td>
	<td>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:24px">Total book in loan: <?=$nloan." book".($nloan>1?"s":"")?></div>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px">Loan limit: <?=$loan_limit." book".($loan_limit>1?"s":"")?></div>
		<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px">Total fine: Rp <?=number_format($fine,2,',','.')?></div>
	</td>
</tr>
</table>	
	<?php 
	if($act=='loan'){
		require_once(VWDIR.'v_staff_loan.php');
	} else {
	if($ndata>0){
	if($show!='1'){
	?>
	<div class="hl2" style="margin-bottom:2px">Books in loan:</div>
	<?php }else{?>
	<div class="hl2" style="margin-bottom:0px">All loan history:</div>
	<div style="width:850px;height:26px">
	<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px;float:left;margin-right:40px">Total loan: <?=$ndata." book".($ndata>1?"s":"")?></div>
	<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px;float:left;margin-right:40px">Total book in loan: <?=$nloan." book".($nloan>1?"s":"")?></div>
	<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px;float:left;margin-right:40px">Book Return in time: <?=$intime." book".($intime>1?"s":"")?></div>
	<div style="font:12px <?=SFONT?>;color:<?=CDARK?>;margin-top:4px;float:left;margin-right:20px">Book Return late: <?=$nlate." book".($nlate>1?"s":"")?></div>
	</div>
	<?php }?>
	<input type="hidden" id="redir" value="&nid=<?=$nid?>"/>
	<table class="xtable" border="0" cellspacing="1px" width="<?=$stablew?>">
		<tr>
			<td class="xtdh">Title</td>
			<td class="xtdh">Book number</td>
			<td class="xtdh">Call number</td>
			<td class="xtdh">Loan date</td>
			<td class="xtdh">Due date</td>
			<?php if($show!='1'){?>
			<td class="xtdh">Options</td>
			<?php }else{?>
			<td class="xtdh">Return date</td>
			<td class="xtdh">Status</td>
			<?php }?>
		</tr>
	<?php
	$n=0; $rc=1; $k=1;
	while($h=mysql_fetch_array($t)){if($rc==0){$rc=1;}else{$rc=0;};
		$r=mysql_fetch_array(mysql_query("SELECT * FROM book WHERE dcid='".$h['book']."' LIMIT 0,1"));
		$y=mysql_query("SELECT * FROM catalog WHERE dcid='".$r['catalog']."' LIMIT 0,1");
		$f=mysql_fetch_array($y);
		$day=diffDay($h['date2']);
		if($day<0){
			$cl='style="color:#ff0000"';
		} else if($day<1){
			$cl='style="color:#0000ff"';
		} else {
			$cl="";
		}
		if($show=='1') $cl='';
		$dtt=fftgl($h['date2']);
		if($day==0) $dd="Today";
		else if($day==-1) $dd="Yesterday";
		else {$dd=$dtt; $dtt='';}
		?>
		<tr id="xrow<?=$r['dcid']?>" class="xxr<?=$rc?>">
			<td width="*" <?=$cl?> ><?=$f['title']?></td>
			<td width="120px" <?=$cl?> ><?=$r['nid']?></td>
			<td width="120px" <?=$cl?> ><?=$r['callnumber']?></td>
			<td width="100px" <?=$cl?> ><?=fftgl($h['date1'])?></td>
			<?php if($show!='1'){?>
			<td width="100px" <?=$cl?> title="<?=$dtt?>" ><?=$dd?></td>
			<td width="70px">
				<button class="btn" style="float:left;width:70px" onclick="bookreturn('uf',<?=$h['dcid']?>)">
					<div class="bi_in">Return</div>
				</button>
			</td>
			<?php }else{?>
			<td width="100px" <?=$cl?> ><?=fftgl($h['date2'])?></td>
			<td width="100px" <?=$cl?> ><?=fftgl($h['dater'])?></td>
			<td width="80px" <?=$cl?> ><?=$status[$h['status']]?></td>
			<?php }?>
		</tr>
	<?php $k++;} ?>
	</table>
	<input type="hidden" id="xnrow" value="<?=$k?>"/>
	<?php } else {?>
	<div class="sfont" style="maring-top:20px"><i><?=$f['fname']?> does not borrow any books yet.</i></div>
	<?php } }?>
</div>
<script type="text/javascript" language="javascript">
<?php if($act=='loan'){?>
$('document').ready(function(){
	 pqueue('cq',0);
	 E('keyw').focus();
});
<?php }?>
</script>