const serverloc =  "http://"+window.location.hostname+":8080/metrologibpp";

function formatNumber(num) {
	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
}

function fnBrowserDetect(){
	let userAgent = navigator.userAgent;
	let browserName;
	
	if(userAgent.match(/chrome|chromium|crios/i)){
		browserName = "chrome";
	}else if(userAgent.match(/firefox|fxios/i)){
		browserName = "firefox";
	}  else if(userAgent.match(/safari/i)){
		browserName = "safari";
	}else if(userAgent.match(/opr\//i)){
		browserName = "opera";
	} else if(userAgent.match(/edg/i)){
		browserName = "edge";
	}else{
		browserName="No browser detection";
	}
	
	return browserName;        
}

$(document).ready(function() {
	let cekbrowser = fnBrowserDetect();

	if (cekbrowser == 'firefox') {
		alert('Komponen web ini tidak di support oleh browser Firefox');
		window.open(serverloc + '/login/logout','_self');
	}
});

//lihat password
function lihatpassword() {
	var x = document.getElementById("password");
	if (x.type === "password") {
		x.type = "text";
		$("#iconlihat").removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	} else {
		x.type = "password";
		$("#iconlihat").removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}
}

function lihatpasswordlama() {
	var x = document.getElementById("passwordlama");
	if (x.type === "password") {
		x.type = "text";
		$("#iconlihatlama").removeClass('fa fa-eye').addClass('fa fa-eye-slash');
	} else {
		x.type = "password";
		$("#iconlihatlama").removeClass('fa fa-eye-slash').addClass('fa fa-eye');
	}
}

$(document).on('click','.table tbody tr', function(event) {
    console.log('pilih baris');
    if($(".table tbody tr").hasClass('selected')){
        $(".table tbody tr").removeClass('selected');
    } else {
        $(this).addClass('selected');
    }
    
});

//generate password
function genpass() {
	let stringInclude = '';
        stringInclude += "@_.";
        stringInclude += '0123456789';
        stringInclude += 'abcdefghijklmnopqrstuvwxyz';
        stringInclude += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	let password ='';
	for (let i = 0; i < 8; i++) {
		password += stringInclude.charAt(Math.floor(Math.random() * stringInclude.length));
	}

	$("#password").val(password);
}

$('.block-specialchar').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$(".block-input").on('input', function () {
	$(".block-input").val('');
});

// enter not allowed in textarea
$('.textarea').bind('keypress', function(e) {
	if ((e.keyCode || e.which) == 13) {
		$(this).parents('form').submit();
		return false;
	}
});

//tampilkan loading indikator
function showloading() {
	$("#dvloading").show();
}

$(".password-input").on('input', function () {
	alert('Silakan generate password');

	$(".password-input").val('');
});

//pesan proses input edit masih aktif
function pesanprosesdata() {
	alert("Anda masih dalam proses penginputan/perubahan data\nSelesaikan proses tersebut dengan mengklik tombol Simpan/Selesai/Batal (untuk membatalkan penginputan)");
}

function recaptcha() {
    let url = serverloc + '/login/recaptcha';
		$.getJSON(url, function (result) {
			console.log(result);
			$.each(result, function (i, field) {
                $(".captcha").html(field.captchaview);
			});
		});

    $("#btn-login").attr("disabled",true);
    $("#btn-login").attr("type","button");
}

$("#cekcaptcha").on('input', function () {
	let cekcaptcha = $(this).val();
	
	if (cekcaptcha != "") {
		let url = serverloc + '/login/cek/' + cekcaptcha;
		$.getJSON(url, function (result) {
			console.log(result);
			$.each(result, function (i, field) {
				if (field.jml == 0) {
                    if(cekcaptcha.length >= 4){					
						alert("Captcha yg Anda masukkan tidak sama");
                        $("#cekcaptcha").val("");
                    }

                    $("#btn-login").attr("disabled",true);
                    $("#btn-login").attr("type","button");
				} else {
                    $("#btn-login").removeAttr("disabled");
                    $("#btn-login").attr("type","submit");
                }
			});
		});
	}  else {
		$("#btn-login").attr("disabled",true);
		$("#btn-login").attr("type","button");
	}
});

$('#kecamatan').change(function(){
	let kecamatan = $(this).val();

    $('#kelurahan').empty();
    $('#kelurahan').append('<option value="">Pilih</option>');

    $.ajax({
        url: serverloc + "/peserta/kelurahan/" + kecamatan,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $('#kelurahan').append('<option value="'+field.kdkelurahan+'">'+field.nama+'</option>');
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            // $('#rekap .overlay').hide();
        }
    });
})


$('#npwp').change(function(){
	let npwp = $(this).val();
	let awal = $('#npwp_awal').val();

	if(npwp != awal){
		let url = serverloc + "/peserta/cek/npwp/" + npwp;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('NPWP sudah terdaftar !!!');
				$('#npwp').val('');
				$('#npwp').focus();
			}
		})
	}
})

$('#npwppelanggan').on('input',function(){
	let npwp = $(this).val();
	let proses = $('#proses').val();
	let awal = $('#npwp_awal').val();
	
	if(proses == 2){
		if(npwp != awal){
			$('#npwp').attr('readonly',true);
			$('#nama').attr('readonly',true);
			$('#telp').attr('readonly',true);
			$('#email').attr('readonly',true);
			$('#kecamatan').attr('disabled','disabled');
			$('#kelurahan').attr('disabled','disabled');
			$('#alamat').attr('readonly',true);

			$('.btn-cek').removeAttr('disabled');
		} else {
			$('#npwp').removeAttr('readonly');
			$('#nama').removeAttr('readonly');
			$('#telp').removeAttr('readonly');
			$('#email').removeAttr('readonly');
			$('#kecamatan').removeAttr('disabled');
			$('#kelurahan').removeAttr('disabled');
			$('#alamat').removeAttr('readonly');

			$('.btn-cek').attr('disabled','disabled');
		}
	}
})

$('#nama').change(function(){
	let nama = $(this).val();
	let awal = $('#nama_awal').val();
	let uppernama = nama.toUpperCase();
	let adaPT = uppernama.indexOf('PT');
	let adaCV = uppernama.indexOf('CV');

	if(nama != awal){
		let url = serverloc + "/peserta/cek/nama/" + nama;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Nama usaha sudah terdaftar !!!');
				$('#nama').val('');
				$('#nama').focus();
			}
		})
	}

	console.log('adaPT/CV: '+adaPT);

	if(adaPT == 0 || adaCV == 0){
		$('#berkas').attr('required',true);
		$('#berkas2').attr('required',true);
	} else {
		$('#berkas').removeAttr('required');
		$('#berkas2').removeAttr('required');
	}
})

$('#telp').change(function(){
	let telp = $(this).val();
	let awal = $('#telp_awal').val();

	if(telp != awal){
		let url = serverloc + "/peserta/cek/telp/" + telp;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('No. Telp usaha sudah terdaftar !!!');
				$('#telp').val('');
				$('#telp').focus();
			}
		})
	}
})

$('#email').change(function(){
	let email = $(this).val();
	let awal = $('#email_awal').val();

	if(email != awal){
		let url = serverloc + "/peserta/cek/email/" + email;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Email usaha sudah terdaftar !!!');
				$('#email').val('');
				$('#email').focus();
			}
		})
	}
})

$('#nik').change(function(){
	let nik = $(this).val();
	let awal = $('#nik_awal').val();

	if(nik != awal){
		let url = serverloc + "/peserta/cek/nik/" + nik;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('No. KTP PIC sudah terdaftar !!!');
				$('#nik').val('');
				$('#nik').focus();
			}
		})
	}
})

$('#telppic').change(function(){
	let telppic = $(this).val();
	let awal = $('#telppic_awal').val();

	if(telppic != awal){
		let url = serverloc + "/peserta/cek/telppic/" + telppic;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('No. Telp PIC sudah terdaftar !!!');
				$('#telppic').val('');
				$('#telppic').focus();
			}
		})
	}
})

$('#emailpic').change(function(){
	let emailpic = $(this).val();
	let awal = $('#emailpic_awal').val();

	if(emailpic != awal){
		let url = serverloc + "/peserta/cek/emailpic/" + emailpic;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('Email PIC sudah terdaftar !!!');
				$('#emailpic').val('');
				$('#emailpic').focus();
			}
		})
	}
})

$('#wa').change(function(){
	let wa = $(this).val();
	let awal = $('#wa_awal').val();

	if(wa != awal){
		let url = serverloc + "/peserta/cek/wa/" + wa;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('WhatsApp PIC sudah terdaftar !!!');
				$('#wa').val('');
				$('#wa').focus();
			}
		})
	}
})

$('#jadwal').change(function (){
	let pilih = $(this).val();
	console.log(pilih);
	if(pilih != ''){
		$('.pilihan-jadwal input').attr('disabled',true);
	} else {
		$('.pilihan-jadwal input').removeAttr('disabled');
	}
})

$('#kategori').change(function (){
	let pilih = $(this).val();

	switch(pilih){
		case 'tgldaftar' :
			$('#cari').attr('type','date');

			$('#cari').attr('required',true);
			$('#statuscari').removeAttr('required');

			$('#cari').removeClass('sr-only');
			$('#statuscari').addClass('sr-only');
			$('#peneracari').addClass('sr-only');
			break;
		case 'status' :
			$('#cari').attr('type','text');

			$('#statuscari').attr('required',true);
			$('#cari').removeAttr('required');

			$('#cari').addClass('sr-only');
			$('#statuscari').removeClass('sr-only');
			$('#peneracari').addClass('sr-only');
			break;
		case 'a.tglpengajuan' :
			$('#cari').attr('type','date');

			$('#cari').attr('required',true);
			$('#statuscari').removeAttr('required');

			$('#cari').removeClass('sr-only');
			$('#statuscari').addClass('sr-only');
			$('#peneracari').addClass('sr-only');
			break;
		case 'a.status' :
			$('#cari').attr('type','text');

			$('#statuscari').attr('required',true);
			$('#cari').removeAttr('required');

			$('#cari').addClass('sr-only');
			$('#statuscari').removeClass('sr-only');
			$('#peneracari').addClass('sr-only');
			break;
		case 'a.kdpegawai' :
			$('#cari').attr('type','text');

			$('#statuscari').attr('required',true);
			$('#cari').removeAttr('required');

			$('#cari').addClass('sr-only');
			$('#statuscari').addClass('sr-only');
			$('#peneracari').removeClass('sr-only');
			break;
		default:
			$('#cari').attr('type','text');

			$('#cari').attr('required',true);
			$('#statuscari').removeAttr('required');

			$('#cari').removeClass('sr-only');
			$('#statuscari').addClass('sr-only');
			$('#peneracari').addClass('sr-only');
			break;
	}
})

$('#layanan').change(function(){
    let layanan = $("option:selected",this).text();
    
    console.log(layanan);

	$('#namalayanan').val(layanan);

	$('#noskhplama').val('');
	$('#tglskhplama').val('');
	$('#berlakuskhplama').val('');
	$('#lokasisebelumnya').val('');

    switch(layanan){
        case "Tera":
			$('.div-skhplama1').addClass('sr-only');
			$('.div-skhplama2').addClass('sr-only');

			$('#dokumenskhplama').removeAttr('required',true);
			$('#noskhplama').removeAttr('required');
			$('#tglskhplama').removeAttr('required');
			$('#berlakuskhplama').removeAttr('required');
			$('#lokasisebelumnya').removeAttr('required');

            $('.namaberkas').html('Izin Persetujuan Tipe');
            break;
        case "Tera Ulang":
			$('.div-skhplama1').removeClass('sr-only');
			$('.div-skhplama2').removeClass('sr-only');

			$('#dokumenskhplama').attr('required',true);
			$('#noskhplama').attr('required',true);
			$('#tglskhplama').attr('required',true);
			$('#berlakuskhplama').attr('required',true);
			$('#lokasisebelumnya').attr('required',true);

            $('.namaberkas').html('SKHP Lama');
            break;
    }
})

$('#dokumenskhplama').change(function (){
	let pilih = $(this).val();
	let noskhp = $('#noskhp').val();

	$('#noskhplama').val('');
	$('#tglskhplama').val('');
	$('#berlakuskhplama').val('');
	$('#lokasisebelumnya').val('');

	switch(pilih){
		case '0' :
			$('#noskhplama').removeAttr('required');
			$('#tglskhplama').removeAttr('required');
			$('#berlakuskhplama').removeAttr('required');
			$('#lokasisebelumnya').removeAttr('required');

			$('#noskhplama').attr('readonly',true);
			$('#tglskhplama').attr('readonly',true);
			$('#berlakuskhplama').attr('readonly',true);
			$('#lokasisebelumnya').attr('readonly',true);

			$('.namaberkas').html('Surat Kehilangan');
			break;
		case '1' :
			$('#noskhplama').attr('required',true);
			$('#tglskhplama').attr('required',true);
			$('#berlakuskhplama').attr('required',true);
			$('#lokasisebelumnya').attr('required',true);

			$('#noskhplama').removeAttr('readonly');
			$('#tglskhplama').removeAttr('readonly');
			$('#berlakuskhplama').removeAttr('readonly');
			$('#lokasisebelumnya').removeAttr('readonly');

			$('.namaberkas').html('SKHP Lama');

			$('#noskhplama').val(noskhp);
			$('#noskhplama').change();
			break;
		case '2' :
			$('#noskhplama').attr('required',true);
			$('#tglskhplama').attr('required',true);
			$('#berlakuskhplama').attr('required',true);
			$('#lokasisebelumnya').attr('required',true);

			$('#noskhplama').removeAttr('readonly');
			$('#tglskhplama').removeAttr('readonly');
			$('#berlakuskhplama').removeAttr('readonly');
			$('#lokasisebelumnya').removeAttr('readonly');

			$('.namaberkas').html('SKHP Lama');
			break;
	}
})

$('#ditetapkan').click(function (){
	$('#tgltetapan').removeAttr('disabled');
	$('#tgltetapan').attr('required');
	$('#pegawaitetapan').removeAttr('disabled');
	$('#pegawaitetapan').attr('required');

	$('#tgl1').removeAttr('required');
	$('#tgl1').attr('disabled','disabled');
	$('#pegawai1').attr('disabled','disabled');
	$('#tgl2').removeAttr('required');
	$('#tgl2').attr('disabled','disabled');
	$('#pegawai2').attr('disabled','disabled');
	$('#tgl3').attr('disabled','disabled');
	$('#pegawai3').attr('disabled','disabled');
	$('#tgl4').attr('disabled','disabled');
	$('#pegawai4').attr('disabled','disabled');

	$('#tgltetapan').val('');
	$('#pegawaitetapan').val('');
	$('#tgl1').val('');
	$('#pegawai1').val('');
	$('#tgl2').val('');
	$('#pegawai2').val('');
	$('#tgl3').val('');
	$('#pegawai3').val('');
	$('#tgl4').val('');
	$('#pegawai4').val('');

	console.log('ditetapkan');
})

$('#pilihan').click(function (){
	$('#tgltetapan').removeAttr('required');
	$('#tgltetapan').attr('disabled','disabled');
	$('#pegawaitetapan').attr('disabled','disabled');
	$('#pegawaitetapan').removeAttr('required');

	$('#tgl1').removeAttr('disabled');
	$('#tgl1').attr('required');
	$('#pegawai1').removeAttr('disabled');
	$('#pegawai1').attr('required',true);
	$('#tgl2').removeAttr('disabled');
	$('#tgl2').attr('required');
	$('#pegawai2').removeAttr('disabled');
	$('#pegawai2').attr('required',true);
	$('#tgl3').removeAttr('disabled');
	$('#pegawai3').removeAttr('disabled');
	$('#tgl4').removeAttr('disabled');
	$('#pegawai4').removeAttr('disabled');

	$('#tgltetapan').val('');
	$('#pegawaitetapan').val('');
	$('#tgl1').val('');
	$('#pegawai1').val('');
	$('#tgl2').val('');
	$('#pegawai2').val('');
	$('#tgl3').val('');
	$('#pegawai3').val('');
	$('#tgl4').val('');
	$('#pegawai4').val('');

	console.log('pilihan');
})

$('#hasil').change(function (){
	let pilih = $(this).val();
	// let cerapan = $('#berkas_cerapan').val();

	// if(cerapan != ""){
	// 	alert('Berkas Cerapan sudah diupload\nSilakan dibatalkan terlebih dahulu untuk mengubah hasil !!!');
	// } else {
		// $('#berkas_cerapan').val('');
		$('#keterangan').val('');

		switch(pilih){
			case "0" :
				$('.btn-pilih5').attr('disabled','disabled');
				$('#keterangan').attr('disabled','disabled');

				// $('#berkas_cerapan').removeAttr('required');
				$('#keterangan').removeAttr('required');

				$('.btn-simpan').html('Update Layanan');

				$('#tgltetapan').removeAttr('readonly');
				break;
			case "1" :
				$('.btn-pilih5').attr('disabled','disabled');
				$('#keterangan').removeAttr('disabled');

				// $('#berkas_cerapan').removeAttr('required');
				$('#keterangan').attr('required',true);

				$('#tgltetapan').attr('readonly',true);

				$('.btn-simpan').html('Layanan Selesai');

				$('#keterangan').focus();
				break;
			case "2" :
				$('.btn-pilih5').removeAttr('disabled');
				$('#keterangan').attr('disabled','disabled');

				// $('#berkas_cerapan').attr('required',true);
				$('#keterangan').removeAttr('required');

				$('#tgltetapan').attr('readonly',true);

				$('.btn-simpan').html('Update Layanan');

				$('.btn-pilih5').focus();
				break;
		}
	// }
})

function ceknpwp() {
	let proses = $('#proses').val();
	let npwp = $('#npwppelanggan').val();

	$.ajax({
        url: serverloc + "/peserta/ceknpwp/" + npwp,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ''){
                $.each(response, function (i, field) {
					switch(field.ada){
						case 0 :
							switch(proses)
							{
								case "1":
									$('#kode').val('');
									$('#npwp_awal').val('');
									$('#npwp').val('');
									$('#nama_awal').val('');
									$('#nama').val('');
									$('#telp_awal').val('');
									$('#telp').val('');
									$('#email_awal').val('');
									$('#email').val('');
									$('#adaplg').val(field.ada);
									$('#kecamatan').val('');
									$('#kelurahan').empty();
									$('#kelurahan').val('');
									$('#alamat').val('');

									$('#npwp').removeAttr('readonly');
									$('#nama').removeAttr('readonly');
									$('#telp').removeAttr('readonly');
									$('#email').removeAttr('readonly');
									$('#kecamatan').removeAttr('disabled');
									$('#kelurahan').removeAttr('disabled');
									$('#alamat').removeAttr('readonly');

									$('.btn-cek').attr('disabled','disabled');
									break;
								case "2":
									$('#npwp').removeAttr('readonly');
									$('#nama').removeAttr('readonly');
									$('#telp').removeAttr('readonly');
									$('#email').removeAttr('readonly');
									$('#kecamatan').removeAttr('disabled');
									$('#kelurahan').removeAttr('disabled');
									$('#alamat').removeAttr('readonly');

									$('.btn-cek').attr('disabled','disabled');
									break;
							}
							break;
						case 1 :
							switch(proses)
							{
								case "1":
									$('#kode').val(field.kdpeserta);
									$('#npwp_awal').val(field.npwp);
									$('#npwp').val(field.npwp);
									$('#nama_awal').val(field.nama);
									$('#nama').val(field.nama);
									$('#telp_awal').val(field.telp);
									$('#telp').val(field.telp);
									$('#email_awal').val(field.email);
									$('#email').val(field.email);
									$('#adaplg').val(field.ada);
									$('#kecamatan').val(field.kdkecamatan);

									
									$('#kelurahan').empty();
									$('#kelurahan').append('<option value="'+field.kdkelurahan+'">'+field.namakelurahan+'</option>');

									$('#alamat').val(field.alamat);

									$('#npwp').attr('readonly',true);
									$('#nama').attr('readonly',true);
									$('#telp').attr('readonly',true);
									$('#email').attr('readonly',true);
									$('#kecamatan').attr('disabled','disabled');
									$('#kelurahan').attr('disabled','disabled');
									$('#alamat').attr('readonly',true);

									$('.btn-cek').attr('disabled','disabled');
									break;
								case "2":
									alert('NPWP tersebut sudah terdaftar');
									break;
							}
							break;
						case 2 :
							$('#kode').val('');
							$('#npwp_awal').val('');
							$('#npwp').val('');
							$('#nama_awal').val('');
							$('#nama').val('');
							$('#telp_awal').val('');
							$('#telp').val('');
							$('#email_awal').val('');
							$('#email').val('');
							$('#adaplg').val('');
							$('#kecamatan').val('');
							$('#kelurahan').empty();
							$('#kelurahan').val('');
							$('#alamat').val('');

							$('#npwp').removeAttr('readonly');
							$('#nama').attr('readonly',true);
							$('#telp').attr('readonly',true);
							$('#email').attr('readonly',true);
							$('#kecamatan').attr('disabled','disabled');
							$('#kelurahan').attr('disabled','disabled');
							$('#alamat').attr('readonly',true);

							$('.btn-cek').removeAttr('disabled');

							alert('Sudah ada di dalam daftar pelanggan peserta\nSilakan dicek!!!');
							break;
					}
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            // $('#rekap .overlay').hide();
        }
    });
}

$('#kelompoklaporan').change(function(){
	let pilih = $(this).val();

	$('.div-dokskhplama').addClass('sr-only');
	$('.div-berlakuskhplama').addClass('sr-only');

	$('#status').val('');
	$('#layananlaporan').val('');
	$('#adaskhplama').val('');
	$('#berlakuskhplama').val('');
	$('#peserta').val('');
	$('#dari').val('');
	$('#sampai').val('');

	switch(pilih){
		case '1':
			$('.div-status').addClass('sr-only');
			$('.div-layanan').addClass('sr-only');
			$('.div-peserta').addClass('sr-only');
			$('.div-tgllaporan').removeClass('sr-only');

			$('#status').removeAttr('required');
			$('#peserta').removeAttr('required');
			$('#dari').attr('required',true);
			$('#sampai').attr('required',true);

			$('.tgl').html('(Tanggal Daftar)');
			break;
		case '2':
			$('.div-status').removeClass('sr-only');
			$('.div-layanan').removeClass('sr-only');
			$('.div-peserta').removeClass('sr-only');
			$('.div-tgllaporan').removeClass('sr-only');

			$('#status').attr('required',true);
			$('#peserta').attr('required',true);
			$('#dari').attr('required',true);
			$('#sampai').attr('required',true);

			$('#peserta').select2().show();

			$('.tgl').html('(Tanggal Pengajuan)');
			break;
		case '3':
			$('.div-status').addClass('sr-only');
			$('.div-layanan').addClass('sr-only');
			$('.div-peserta').removeClass('sr-only');
			$('.div-tgllaporan').addClass('sr-only');

			$('#peserta').select2().show();

			$('#status').removeAttr('required');
			$('#peserta').attr('required',true);
			$('#dari').removeAttr('required');
			$('#sampai').removeAttr('required');
			break;
	}
})

$('#layananlaporan').change(function(){
	let layanan = $("option:selected",this).text();

	$('#adaskhplama').val('');
	$('#berlakuskhplama').val('');

	switch(layanan){
		case 'Tera':
			$('.div-dokskhplama').addClass('sr-only');
			$('.div-berlakuskhplama').addClass('sr-only');
			break;
		case 'Tera Ulang':
			$('.div-dokskhplama').removeClass('sr-only');
			$('.div-berlakuskhplama').removeClass('sr-only');
			break;
	}
})

function cekbatasjadwal(jadwal,pegawai,id_tgl,id_pegawai){
	$.ajax({
		url: serverloc + '/permintaan/cekbatasjadwal/' + jadwal + '/' + pegawai,
		type: 'get',
		dataType: 'JSON',
		success: function (response) {
			console.log(response);
			if(response == '0'){
				alert('Jadwal penera untuk tanggal tersebut sudah mencapai batas');

				$('#'+id_tgl).val('');
				$('#'+id_pegawai).val('');
			} else {
				console.log('allow');
			}
		},
		complete: function(){
			// $('#rekap .overlay').hide();
		}
	});
}

$('#pegawaitetapan').change(function (){
	let pilih = $(this).val();
	let tgl = $('#tgltetapan').val();

	if(tgl == ''){
		alert('Pilih tanggal terlebih dahulu !!!');

		$(this).val('');
		$('#tgltetapan').focus();
	} else {
		cekbatasjadwal(tgl,pilih,'tgltetapan','pegawaitetapan');
	}
})

$('#pegawai1').change(function (){
	let pilih = $(this).val();
	let tgl = $('#tgl1').val();

	if(tgl == ''){
		alert('Pilih tanggal terlebih dahulu !!!');

		$(this).val('');
		$('#tgl1').focus();
	} else {
		cekbatasjadwal(tgl,pilih,'tgl1','pegawai1');
	}
})

$('#pegawai2').change(function (){
	let pilih = $(this).val();
	let tgl = $('#tgl2').val();

	if(tgl == ''){
		alert('Pilih tanggal terlebih dahulu !!!');

		$(this).val('');
		$('#tgl2').focus();
	} else {
		cekbatasjadwal(tgl,pilih,'tgl2','pegawai2');
	}
})

$('#pegawai3').change(function (){
	let pilih = $(this).val();
	let tgl = $('#tgl3').val();

	if(tgl == ''){
		alert('Pilih tanggal terlebih dahulu !!!');

		$(this).val('');
		$('#tgl3').focus();
	} else {
		cekbatasjadwal(tgl,pilih,'tgl3','pegawai3');
	}
})

$('#pegawai4').change(function (){
	let pilih = $(this).val();
	let tgl = $('#tgl4').val();

	if(tgl == ''){
		alert('Pilih tanggal terlebih dahulu !!!');

		$(this).val('');
		$('#tgl4').focus();
	} else {
		cekbatasjadwal(tgl,pilih,'tgl4','pegawai4');
	}
})

$('#uttp').change(function(){
	let pilih = $(this).val();

	console.log(pilih);

	$('.tambahan').html('');

	$.ajax({
		url: serverloc + '/uttppeserta/cekinfotambahan/' + pilih,
		type: 'get',
		dataType: 'JSON',
		success: function (response) {
			console.log(response);
			if(response != ''){
				$.each(response, function (i, field) {
					let namainfo = field.info;
					let label =namainfo.toLowerCase().replace(" ", "_");
					console.log(label);

					$('.tambahan').append('<div class="form-group">'+
												'<label class="col-sm-3 control-label">'+field.info+'</label>'+
												'<div class="col-sm-5">'+
													'<input type="text" class="form-control" name="info[]" id="'+label+'" value="" maxlength=150 autocomplete="off" required />'+
												'</div>'+
											'</div>');
				})
			}
		},
		complete: function(){
			// $('#rekap .overlay').hide();
		}
	});
})

$('#noskhplama').change(function (){
	let kduttppeserta = $('#kduttppeserta').val();
	let noskhplama = $(this).val();

	if(noskhplama != ''){
		$.ajax({
			url: serverloc + '/permintaan/cekskhplama/' + kduttppeserta + '/' + noskhplama,
			type: 'get',
			dataType: 'JSON',
			success: function (response) {
				console.log(response);
				if(response != ''){
					$.each(response, function (i, field) {
						$('#tglskhplama').val(field.tglsuratskhp);
						$('#berlakuskhplama').val(field.berlakuskhp);
						$('#lokasisebelumnya').val(field.lokasi);

						$('#lokasisebelumnya').attr('readonly',true);
					})
				} else {
					$('#tglskhplama').val('');
					$('#berlakuskhplama').val('');
					$('#lokasisebelumnya').val('');

					$('#lokasisebelumnya').removeAttr('readonly');
				}
			},
			complete: function(){
				// $('#rekap .overlay').hide();
			}
		});
	}else{
		$('#tglskhplama').val('');
		$('#berlakuskhplama').val('');
		$('#lokasisebelumnya').val('');

		$('#lokasisebelumnya').removeAttr('readonly');
	}
})

$('#nosuratskrd').change(function (){
	let nosuratskrd = $(this).val();

	if(nosuratskrd != ''){
		let url = serverloc + "/permintaan/cek/nosuratskrd/" + nosuratskrd;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('No SKRD sudah terdaftar !!!');
				$('#nosuratskrd').val('');
				$('#nosuratskrd').focus();

				$('#tglsuratskrd').val('');
				$('#tglsuratskrd').attr('readonly',true);
			} else {
				$('#tglsuratskrd').removeAttr('readonly');
				$('#tglsuratskrd').val('');
				$('#tglsuratskrd').focus();
			}
		})
	} else{
		$('#tglsuratskrd').val('');
		$('#tglsuratskrd').attr('readonly',true);
	}
})

$('#nosuratskhp').change(function (){
	let nosuratskhp = $(this).val();

	if(nosuratskhp != ''){
		let url = serverloc + "/permintaan/cek/nosuratskhp/" + nosuratskhp;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result != 0){
				alert('No SKHP sudah terdaftar !!!');
				$('#nosuratskhp').val('');
				$('#nosuratskhp').focus();

				$('#tglsuratskhp').val('')
				$('#tglsuratskhp').attr('readonly',true);
				$('#berlakuskhp').val('')
				$('#berlakuskhp').attr('readonly',true);
			} else {
				$('#tglsuratskhp').val('')
				$('#tglsuratskhp').removeAttr('readonly');
				$('#tglsuratskhp').focus();
				$('#berlakuskhp').val('')
				$('#berlakuskhp').removeAttr('readonly');
			}
		})
	} else {
		$('#tglsuratskhp').val('')
		$('#tglsuratskhp').attr('readonly',true);
		$('#berlakuskhp').val('')
		$('#berlakuskhp').attr('readonly',true);
	}
})

$('#tgltetapan').change(function (){
	let tgl = $(this).val();
	let uttp = $('#kduttp').val();

	cekwaktu(tgl,uttp,'tgltetapan');
})

$('#tgl1').change(function (){
	let tgl = $(this).val();
	let uttp = $('#kduttp').val();

	cekwaktu(tgl,uttp,'tgl1');
})

$('#tgl2').change(function (){
	let tgl = $(this).val();
	let uttp = $('#kduttp').val();

	cekwaktu(tgl,uttp,'tgl2');
})

$('#tgl3').change(function (){
	let tgl = $(this).val();
	let uttp = $('#kduttp').val();

	cekwaktu(tgl,uttp,'tgl3');
})

$('#tgl4').change(function (){
	let tgl = $(this).val();
	let uttp = $('#kduttp').val();

	cekwaktu(tgl,uttp,'tgl4');
})

function cekwaktu(tgl,uttp,komponen) {
	let url = serverloc + "/permintaan/cekwaktu/" + tgl + '/' + uttp;
		$.getJSON(url, function (result) {
			console.log(result);
			if(result == 0){
				alert('Waktu kerja tidak mencukupi\nSilakan pilih tanggal lain');
				
				$('#'+komponen).val('');
				$('#'+komponen).focus();
			}
		})
}


