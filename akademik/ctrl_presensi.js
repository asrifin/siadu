function presensi_get(){
	var d=['departemen','tahunajaran','tingkat','kelas','tanggal'];
	gPage("presensi",gpage_purl(d));
}
function presensi_form(o,cid,g){
	fcb = typeof fcb !== 'undefined'?fcb:0;
	var d=['departemen','tahunajaran','tingkat','kelas','tanggal'];
	var s=fform_purl(d);
	var f=[];
	if(o=='a'||o=='u'){
		var ds=E("xtable2_allid").value;
		s+="&data="+ds;
		var id=ds.split(",");
		for(var i=0;i<id.length;i++){
			s+="&absen_"+id[i]+"="+E("absen_"+id[i]).value;
			s+="&keterangan_"+id[i]+"="+E("keterangan_"+id[i]).value;
		}
	}
	fform_std(o,cid,g,"presensi",presensi_get,f,s);
}

function presensi_list_get_setabsen(id,a){
	E("presensi_btn_H_"+id).className="presensi_btn";
	E("presensi_btn_S_"+id).className="presensi_btn";
	E("presensi_btn_I_"+id).className="presensi_btn";
	E("presensi_btn_A_"+id).className="presensi_btn";
	E("presensi_btn_"+a+"_"+id).className="presensi_btn_"+a;
	E("absen_"+id).value=a;
}

function presensi_list_get_setabsen_sel(a){
	var d=E("xtable2_selectedid").value;
	var id=d.split(",");
	for(var i=0;i<id.length;i++){
		presensi_list_get_setabsen(id[i],a);
	}
}