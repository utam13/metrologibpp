const serverloc = "https://"+window.location.hostname;

jQuery.ajaxSetup({
    cache: false
});

//tampilkan loading indikator
$(document).ajaxStart(function () {
    $("#preloader").css("display", "block");
});

$(document).ajaxComplete(function () {
    $("#preloader").css("display", "none");
});

$(document).on('click','.table tbody tr', function(event) {
    console.log('pilih baris');
    if($(".table tbody tr").hasClass('selected')){
        $(".table tbody tr").removeClass('selected');
    } else {
        $(this).addClass('selected');
    }
    
});

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

function recaptcha() {
    let url = serverloc + '/pelayanan/recaptcha';
		$.getJSON(url, function (result) {
			console.log(result);
			$.each(result, function (i, field) {
                $(".captcha").html(field.captchaview);
			});
		});

    $(".btn-login").attr("disabled",true);
    $(".btn-login").attr("type","button");
}

$("#cekcaptcha").on('input', function () {
	let cekcaptcha = $(this).val();
	
	if (cekcaptcha != "") {
		let url = serverloc + '/pelayanan/cekcaptcha/' + cekcaptcha;
		$.getJSON(url, function (result) {
			console.log(result);
			$.each(result, function (i, field) {
				if (field.jml == 0) {
                    if(cekcaptcha.length >= 4){					
					    alert("Captcha yg Anda masukkan tidak sama");
                        $("#cekcaptcha").val("");
                    }

                    $(".btn-login").attr("disabled",true);
                    $(".btn-login").attr("type","button");
				} else {
                    $(".btn-login").removeAttr("disabled");
                    $(".btn-login").attr("type","submit");
                }
			});
		});
	}  else {
		$(".btn-login").attr("disabled",true);
		$(".btn-login").attr("type","button");
	}
});


$(document).on('click','.table tbody tr', function(event) {
    console.log('pilih baris');
    if($(".table tbody tr").hasClass('pilih_baris')){
        $(".table tbody tr").removeClass('pilih_baris');
    } else {
        $(this).addClass('pilih_baris');
    }
    
});

$('.pop').popover({
    trigger: "manual",
    html: true,
    content: function() {
        return $('#popover-content').html();
    }
})
.on("mouseenter", function() {
    var _this = this;
    $(this).popover("show");
    $(".popover").on("mouseleave", function() {
        $(_this).popover('hide');
    });
})
    .on("mouseleave", function() {
    var _this = this;
    setTimeout(function() {
        if (!$(".popover:hover").length) {
        $(_this).popover("hide");
        }
    }, 300);
});

$('.btn-registrasi').click(function (){
    $('.judul-page').html('Registrasi Pelayanan');
    $('.login-notes').addClass('sr-only');
    $('.login').addClass('sr-only');
    $('.registrasi').removeClass('sr-only');

    $('.judul-page').attr("tabindex",-1).focus();
})

$('#kecamatan').change(function(){
	let kecamatan = $(this).val();

    $('#kelurahan').empty();
    $('#kelurahan').append('<option value="">Pilih</option>');

    $.ajax({
        url: serverloc + "/pelayanan/kelurahan/" + kecamatan,
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
            $('#rekap .overlay').hide();
        }
    });
})


$('#npwp').change(function(){
	let npwp = $(this).val();

    let url = serverloc + "/pelayanan/cek/npwp/" + npwp;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('NPWP sudah terdaftar !!!');
            $('#npwp').val('');
            $('#npwp').focus();
        }
    })
})

$('#nama').change(function(){
	let nama = $(this).val();
    let uppernama = nama.toUpperCase();
	// let adaPT = uppernama.indexOf('PT');
	// let adaCV = uppernama.indexOf('CV');

    let url = serverloc + "/pelayanan/cek/nama/" + nama;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('Nama usaha sudah terdaftar !!!');
            $('#nama').val('');
            $('#nama').focus();
        }
    })

    // console.log('adaPT/CV: '+adaPT);

	// if(adaPT == 0 || adaCV == 0){
	// 	$('#berkas').attr('required',true);
	// 	$('#berkas2').attr('required',true);
	// } else {
	// 	$('#berkas').removeAttr('required');
	// 	$('#berkas2').removeAttr('required');
	// }
})

$('#telp').change(function(){
	let telp = $(this).val();

    let url = serverloc + "/pelayanan/cek/telp/" + telp;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('No. Telp usaha sudah terdaftar !!!');
            $('#telp').val('');
            $('#telp').focus();
        }
    })
})

$('#email').change(function(){
	let email = $(this).val();

    let url = serverloc + "/pelayanan/cek/email/" + email;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('Email usaha sudah terdaftar !!!');
            $('#email').val('');
            $('#email').focus();
        }
    })
})

$('#nik').change(function(){
	let nik = $(this).val();

    let url = serverloc + "/pelayanan/cek/nik/" + nik;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('No. KTP PIC sudah terdaftar !!!');
            $('#nik').val('');
            $('#nik').focus();
        }
    })
})

$('#telppic').change(function(){
	let telppic = $(this).val();

    let url = serverloc + "/pelayanan/cek/telppic/" + telppic;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('No. Telp PIC sudah terdaftar !!!');
            $('#telppic').val('');
            $('#telppic').focus();
        }
    })
})

$('#emailpic').change(function(){
	let emailpic = $(this).val();

    let url = serverloc + "/pelayanan/cek/emailpic/" + emailpic;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('Email PIC sudah terdaftar !!!');
            $('#emailpic').val('');
            $('#emailpic').focus();
        }
    })
})

$('#wa').change(function(){
	let wa = $(this).val();

    let url = serverloc + "/pelayanan/cek/wa/" + wa;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('WhatsApp PIC sudah terdaftar !!!');
            $('#wa').val('');
            $('#wa').focus();
        }
    })
})

$('#username').change(function(){
	let username = $(this).val();
    
    let url = serverloc + "/pelayanan/cek/nik/" + username;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result == 0){
            alert('No. KTP tidak terdaftar !!!');
            $('#username').val('');
            $('#username').focus();
        }
    })
})

$('#uttp').change(function(){
	let kdpeserta = $("#kdpeserta").val();
    let uttp = $(this).val();
    
    let url = serverloc + "/pelayanan/cekuttppeserta/" + kdpeserta + "/" + uttp;
    $.getJSON(url, function (result) {
        console.log(result);
        if(result != 0){
            alert('Jenis UTTP yang dipilih sudah Anda daftarkan\nSilakan dicek pada tabel daftar UTTP Anda !!!');
            $('#uttp').val('');
            $('#uttp').focus();
        }
    })
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

function ceknpwp() {
	let proses = $('#proses').val();
	let npwp = $('#npwppelanggan').val();

	$.ajax({
        url: serverloc + "/pelayanan/ceknpwp/" + npwp,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
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