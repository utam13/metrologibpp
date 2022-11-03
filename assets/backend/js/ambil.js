function ambil_linkapp(a, kode, nama, url, slide, icon, fileslide, fileicon) {
	$("#frm_linkapp").attr("action", a);

	$("#kode").val(kode);
    $("#nama_awal").val(nama);
	$("#nama").val(nama);
	$("#url_awal").val(url);
	$("#urlapp").val(url);
	$("#slide").val(slide);
	$("#icon").val(icon);

	$("#slide-app").attr("src", serverloc + "/" + fileslide + "?" + Math.random());
	$("#icon-app").attr("src", serverloc + "/" + fileicon + "?" + Math.random());
}

$('#frm_linkapp').on('shown.bs.modal', function () {
	$('#nama').focus();
})

function ambil_pegawai(url,kode,nip,nama,jabatan,satker,email,sk_pegawai,sk_role,tgl_awal,tgl_akhir,ppk,pokja,pengadaan,levelakses,username,password) {
    $("#frmpegawai").attr("action", url);

	$("#kode").val(kode);
    $("#nip_awal").val(nip);
	$("#nip").val(nip);
	$("#nama").val(nama);
	$("#jabatan").val(jabatan);
	$("#satker").val(satker);    
    $("#email").val(email);
    $("#sk_pegawai").val(sk_pegawai);
    $("#sk_role").val(sk_role);
    $("#tgl_awal").val(tgl_awal);
    $("#tgl_akhir").val(tgl_akhir);

    if (ppk == "ya") {
        $("#role_ppk").attr("checked", true);
    }else{
        $("#role_ppk").attr("checked", false);
    }

    if (pokja == "ya") {
        $("#role_pokja").attr("checked", true);
    }else{
        $("#role_pokja").attr("checked", false);
    }

    if (pengadaan == "ya") {
        $("#role_pengadaan").attr("checked", true);
    }else{
        $("#role_pengadaan").attr("checked", false);
    }

    if(levelakses == "-"){
        $("#levelakses").val("");
    } else {
        $("#levelakses").val(levelakses);
    }

    if(username == "-"){
		$("#username_awal").val("");
        $("#userakses").val("");
        $("#userpass").val("");
    } else {
        $("#username_awal").val(username);
		$("#userakses").val(username);
        $("#userpass").val(password);
    }

	if(levelakses == "1" || levelakses == "2"){
		$("#userakses").attr("required", true);
        $("#userpass").attr("required", true);
	} else {
		$("#userakses").removeAttr("required");
        $("#userpass").removeAttr("required");
	}
}

$('#formpegawai').on('shown.bs.modal', function () {
	$('#kode').focus();
})

function ambil_penyedia(url,kd_penyedia,nama_penyedia,bentuk_usaha,user_lpse,
                        npwp_penyedia,alamat_penyedia,kabupaten_kota,provinsi,
                        email,no_telp,no_pkp,lpse_terdaftar,status_aktif_agregasi) {
    $("#frmpenyedia").attr("action", url);

	$("#kd_penyedia").val(kd_penyedia);
    $("#nama_awal").val(nama_penyedia);
	$("#nama_penyedia").val(nama_penyedia);
	$("#bentuk_usaha").val(bentuk_usaha);
	$("#user_lpse").val(user_lpse);
	$("#npwp_awal").val(npwp_penyedia);
	$("#npwp_penyedia").val(npwp_penyedia);
    $("#alamat_penyedia").val(alamat_penyedia);
    $("#kabupaten_kota").val(kabupaten_kota);
    $("#provinsi").val(provinsi);
	$("#email_awal").val(email);
    $("#email").val(email);
    $("#no_telp").val(no_telp);
    $("#no_pkp").val(no_pkp);
    $("#lpse_terdaftar").val(lpse_terdaftar);
    // $("#tgl_terdaftar").val(tgl_terdaftar);
    // $("#tgl_verifikasi").val(tgl_verifikasi);
    $("#status_aktif_agregasi").val(status_aktif_agregasi);

	if(email == "-"){
		console.log(email);
		$("#email").removeAttr("required");
	} else {
		$("#email").attr("required",true);
	}
}

$('#formpenyedia').on('shown.bs.modal', function () {
	$('#kd_penyedia').focus();
})

function ambil_satker(url,kd_satker,kdunit_satker,nama,singkatan,npwp,alamat,telp,email,kota,provinsi) {
    $("#frmsatker").attr("action", url);

    if(kd_satker == ""){
        $("#kd_satker").removeAttr("readonly");
    } else {
        $("#kd_satker").attr("readonly",true);
    }
    $("#kd_satker").val(kd_satker);
    $("#kdunit_satker").val(kdunit_satker);
    $("#nama_awal").val(nama);
    $("#nama_satker").val(nama);
    $("#singkatan_awal").val(singkatan);
    $("#singkatan").val(singkatan);
    $("#npwp_satker").val(npwp);
    $("#alamat_satker").val(alamat);
    $("#telp").val(telp);
    $("#email").val(email);
    $("#kota").val(kota);
    $("#provinsi").val(provinsi);
}

$('#formsatker').on('shown.bs.modal', function () {
    $('#kd_satker').focus();
})