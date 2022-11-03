// berkas
function upload_berkas(kontrol) {
	let cek;

	$('#kontrol').val(kontrol);

	switch (kontrol) {
		case "fotokondisi":			
		case "buktibayar":					
		case "suratpermohonan":			
		case "cerapan":	
			$("#pilih-berkas").click();
			break;
		case "izinskhplama":	
			let layanan = $("#layanan option:selected").text();
			
			console.log(layanan);

			if(layanan != "" && layanan != "Pilih"){
				$("#pilih-berkas").click();
			} else {
				alert('Pilih jenis layanan terlebih dahulu');
				$('#layanan').focus();
			}
			break;
		default:
			alert("Kelompok proses belum ada !!!");
			break;
	}
}

function upload_tambahan(berkas) {
	$('#kontrol').val(berkas);
	$("#pilih-tambahan").click();
}

$("#pilih-berkas").change(function () {
	let kontrol = $('#kontrol').val();
	let target_proses;
	let maks = 2000000;
	let alert_maks = "Ukuran file melebihi 2 Mb!";

	if (this.files[0] != "") {
		if (this.files[0].size > maks) {
			alert(alert_maks);
		} else {
			switch(kontrol){
				case "fotokondisi":
					$(".span-lihat").addClass('sr-only');
					$(".btn-lihat").attr("href", '#');
					$(".btn-batal").addClass('sr-only');
					$(".btn-pilih").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/uploadberkas/fotokondisi";
					break;
				case "buktibayar":
					$(".span-lihat2").addClass('sr-only');
					$(".btn-lihat2").attr("href", '#');
					$(".btn-batal2").addClass('sr-only');
					$(".btn-pilih2").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/uploadberkas/buktibayar";
					break;
				case "izinskhplama":
					$(".span-lihat3").addClass('sr-only');
					$(".btn-lihat3").attr("href", '#');
					$(".btn-batal3").addClass('sr-only');
					$(".btn-pilih3").removeClass('sr-only');

					let layanan = $("#layanan option:selected").text();

					target_proses = serverloc + "/pelayanan/uploadberkas/"+layanan;
					break;
				case "suratpermohonan":
					$(".span-lihat4").addClass('sr-only');
					$(".btn-lihat4").attr("href", '#');
					$(".btn-batal4").addClass('sr-only');
					$(".btn-pilih4").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/uploadberkas/suratpermohonan";
					break;
				case "cerapan":
					$(".span-lihat5").addClass('sr-only');
					$(".btn-lihat5").attr("href", '#');
					$(".btn-batal5").addClass('sr-only');
					$(".btn-pilih5").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/uploadberkas/cerapan";
					break;
			}
			
			$(".btn-simpan").hide();
			$(".btn-simpan").attr("disabled", "disabled");

			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-tambahan").change(function () {
	let kontrol = $('#kontrol').val();
	let target_proses = serverloc + "/pelayanan/uploadtambahan/"+kontrol;
	let maks = 2000000;
	let alert_maks = "Ukuran file melebihi 2 Mb!";

	if (this.files[0] != "") {
		if (this.files[0].size > maks) {
			alert(alert_maks);
		} else {
			$(".span-lihat_"+kontrol).addClass('sr-only');
			$(".btn-lihat_"+kontrol).attr("href", '#');
			$(".btn-batal_"+kontrol).addClass('sr-only');
			$(".btn-pilih_"+kontrol).removeClass('sr-only');
			
			$(".btn-simpan").hide();
			$(".btn-simpan").attr("disabled", "disabled");

			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler_tambahan, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

function progressHandler(event) {
	let percent = (event.loaded / event.total) * 100;
	$("#progress_bar").css("width", Math.round(percent) + "%");
}

function errorHandler(event) {
	alert("Upload Failed");
}

function abortHandler(event) {
	alert("Upload Aborted");
}

function completeHandler(event) {
	let nama_file = event.target.responseText;
	let kontrol = $("#kontrol").val();
	let pdflow = nama_file.includes('pdf');
	let pdfup = nama_file.includes('PDF');
	
	if (nama_file == "gagal") {
		$("#progress_div").hide();

		switch (kontrol) {
			case "fotokondisi":
				$("#berkas").val('');
				$(".span-lihat").addClass('sr-only');
				$(".btn-lihat").attr("href", '#');
				$(".btn-batal").addClass('sr-only');
				$(".btn-pilih").removeClass('sr-only');
				break;
			case "buktibayar":
				$("#berkas2").val('');
				$(".span-lihat2").addClass('sr-only');
				$(".btn-lihat2").attr("href", '#');
				$(".btn-batal2").addClass('sr-only');
				$(".btn-pilih2").removeClass('sr-only');
				break;
			case "izinskhplama":
				$("#berkas_izinskhplama").val('');
				$(".span-lihat3").addClass('sr-only');
				$(".btn-lihat3").attr("href", '#');
				$(".btn-batal3").addClass('sr-only');
				$(".btn-pilih3").removeClass('sr-only');
				break;
			case "suratpermohonan":
				$("#berkas_suratpermohonan").val('');
				$(".span-lihat4").addClass('sr-only');
				$(".btn-lihat4").attr("href", '#');
				$(".btn-batal4").addClass('sr-only');
				$(".btn-pilih4").removeClass('sr-only');
				break;
			case "cerapan":
				$("#berkas_cerapan").val('');
				$(".span-lihat5").addClass('sr-only');
				$(".btn-lihat5").attr("href", '#');
				$(".btn-batal5").addClass('sr-only');
				$(".btn-pilih5").removeClass('sr-only');
				break;
		}

		$(".btn-simpan").show();
		$(".btn-simpan").removeAttr("disabled");

		alert(" Gagal upload file, silakan coba upload ulang");
	} else {
		$("#progress_div").hide();

		switch (kontrol) {
			case "fotokondisi":
				$("#berkas").val(nama_file);
				$(".span-lihat").removeClass('sr-only');
				if(pdflow == true || pdfup == true){
					$(".btn-lihat").attr("href", serverloc + "/pelayanan/viewPdf2/" + nama_file + "/" + kontrol);
				} else {
					$(".btn-lihat").attr("href", serverloc + "/upload/fotokondisi/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
				}
				$(".btn-batal").removeClass('sr-only');
				$(".btn-pilih").addClass('sr-only');
				break;
			case "buktibayar":
				$("#berkas2").val(nama_file);
				$(".span-lihat2").removeClass('sr-only');
				if(pdflow == true || pdfup == true){
					$(".btn-lihat2").attr("href", serverloc + "/pelayanan/viewPdf2/" + nama_file + "/" + kontrol);
				} else {
					$(".btn-lihat2").attr("href", serverloc + "/upload/buktibayar/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
				}
				$(".btn-batal2").removeClass('sr-only');
				$(".btn-pilih2").addClass('sr-only');
				break;
			case "izinskhplama":
				let layanan = $("#layanan option:selected").text();

				$("#berkas_izinskhplama").val(nama_file);
				$(".span-lihat3").removeClass('sr-only');
				if(pdflow == true || pdfup == true){
					$(".btn-lihat3").attr("href", serverloc + "/pelayanan/viewPdf2/" + nama_file + "/" + layanan);
				} else {
					switch(layanan){
						case "Tera":
							$(".btn-lihat3").attr("href", serverloc + "/upload/izinpersetujuantipe/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
							break;
						case "Tera Ulang":
							$(".btn-lihat3").attr("href", serverloc + "/upload/skhplama/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
							break;
					}
				}
				$(".btn-batal3").removeClass('sr-only');
				$(".btn-pilih3").addClass('sr-only');
				break;
			case "suratpermohonan":
				$("#berkas_suratpermohonan").val(nama_file);
				$(".span-lihat4").removeClass('sr-only');
				if(pdflow == true || pdfup == true){
					$(".btn-lihat4").attr("href", serverloc + "/pelayanan/viewPdf2/" + nama_file + "/" + kontrol);
				} else {
					$(".btn-lihat4").attr("href", serverloc + "/upload/suratpermohonan/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
				}
				$(".btn-batal4").removeClass('sr-only');
				$(".btn-pilih4").addClass('sr-only');
				break;
			case "cerapan":
				$("#berkas_cerapan").val(nama_file);
				$(".span-lihat5").removeClass('sr-only');
				if(pdflow == true || pdfup == true){
					$(".btn-lihat5").attr("href", serverloc + "/pelayanan/viewPdf2/" + nama_file + "/" + kontrol);
				} else {
					$(".btn-lihat5").attr("href", serverloc + "/upload/cerapan/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
				}
				$(".btn-batal5").removeClass('sr-only');
				$(".btn-pilih5").addClass('sr-only');
				break;
		}

		$(".btn-simpan").show();
		$(".btn-simpan").removeAttr("disabled");
	}

	console.log(nama_file);
}

function completeHandler_tambahan(event) {
	let nama_file = event.target.responseText;
	let kontrol = $("#kontrol").val();
	let pdflow = nama_file.includes('pdf');
	let pdfup = nama_file.includes('PDF');
	if (nama_file == "gagal") {
		$("#progress_div").hide();

		$("#berkas_"+kontrol).val('');
		$(".span-lihat_"+kontrol).addClass('sr-only');
		$(".btn-lihat_"+kontrol).attr("href", '#');
		$(".btn-batal_"+kontrol).addClass('sr-only');
		$(".btn-pilih_"+kontrol).removeClass('sr-only');

		$(".btn-simpan").show();
		$(".btn-simpan").removeAttr("disabled");

		alert(" Gagal upload file, silakan coba upload ulang");
	} else {
		$("#progress_div").hide();

		$("#berkas_"+kontrol).val(nama_file);
		$(".span-lihat_"+kontrol).removeClass('sr-only');
		if(pdflow == true || pdfup == true){
			$(".btn-lihat_"+kontrol).attr("href", serverloc + "/pelayanan/viewPdftambahan/" + nama_file);
		} else {
			$(".btn-lihat_"+kontrol).attr("href", serverloc + "/upload/doktambahanpengajuan/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
		}
		$(".btn-batal_"+kontrol).removeClass('sr-only');
		$(".btn-pilih_"+kontrol).addClass('sr-only');

		$(".btn-simpan").show();
		$(".btn-simpan").removeAttr("disabled");
	}

	console.log(nama_file);
}

function batal_berkas(kontrol) {
	let namafile; 
	let url;
	let namakontrol;

	switch (kontrol) {
		case "fotokondisi":
			namakontrol = "Foto Kondisi Alat";
			break;
		case "buktibayar":
			namakontrol = "Bukti Pembayaran Retribusi";
			break;
		case "izinskhplama":
			let layanan = $("#layanan option:selected").text();

			namafile = $("#berkas_izinskhplama").val();

			switch(layanan){
				case "Tera":
					namakontrol = "Dokumen Izin Persetujuan Tera";
					break;
				case "Tera Ulang":
					namakontrol = "Dokumen SKHP Lama atau Surat Keterangan Kehilangan";
					break;
			}
			break;
		case "suratpermohonan":
			namakontrol = "Dokumen Surat Permohonan";
			break;
		case "cerapan":
			namakontrol = "Dokumen Cerapan";
			break;
		default:
			namakontrol = "Dokumen tersebut";
			break;
	}

    if(confirm('Hapus file upload ' + namakontrol + '?') == true){
        switch (kontrol) {
            case "fotokondisi":
                namafile = $("#berkas").val();
                url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/fotokondisi";

                $("#berkas").val('');
                $(".span-lihat").addClass('sr-only');
                $(".btn-lihat").attr("href", '#');
                $(".btn-batal").addClass('sr-only');
                $(".btn-pilih").removeClass('sr-only');
                break;
            case "buktibayar":
                namafile = $("#berkas2").val();
                url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/buktibayar";

                $("#berkas2").val('');
                $(".span-lihat2").addClass('sr-only');
                $(".btn-lihat2").attr("href", '#');
                $(".btn-batal2").addClass('sr-only');
                $(".btn-pilih2").removeClass('sr-only');
                break;
			case "izinskhplama":
				let layanan = $("#layanan option:selected").text();

				namafile = $("#berkas_izinskhplama").val();

				switch(layanan){
					case "Tera":
						url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/izinpersetujuantipe";
						break;
					case "Tera Ulang":
						url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/skhplama";
						break;
				}

				$("#berkas_izinskhplama").val('');
				$(".span-lihat3").addClass('sr-only');
				$(".btn-lihat3").attr("href", '#');
				$(".btn-batal3").addClass('sr-only');
				$(".btn-pilih3").removeClass('sr-only');
				break;
			case "suratpermohonan":
				namafile = $("#berkas_suratpermohonan").val();
				url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/suratpermohonan";

				$("#berkas_suratpermohonan").val('');
				$(".span-lihat4").addClass('sr-only');
				$(".btn-lihat4").attr("href", '#');
				$(".btn-batal4").addClass('sr-only');
				$(".btn-pilih4").removeClass('sr-only');
				break;
			case "cerapan":
				namafile = $("#berkas_cerapan").val();
				url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/cerapan";

				$("#berkas_cerapan").val('');
				$(".span-lihat5").addClass('sr-only');
				$(".btn-lihat5").attr("href", '#');
				$(".btn-batal5").addClass('sr-only');
				$(".btn-pilih5").removeClass('sr-only');
				break;
			default:
				namafile = $("#berkas_"+kontrol).val();
				url = serverloc + "/pelayanan/batalberkas2/" + namafile + "/doktambahanpengajuan";
				console.log(namafile);
				$("#berkas_"+kontrol).val('');
				$(".span-lihat_"+kontrol).addClass('sr-only');
				$(".btn-lihat_"+kontrol).attr("href", '#');
				$(".btn-batal_"+kontrol).addClass('sr-only');
				$(".btn-pilih_"+kontrol).removeClass('sr-only');
				break;
        }

        $.getJSON(url, function (result) {
            console.log(result);
            if(result != 0){
                alert('Berkas telah dibatalkan !!!');
            }
        })
    } else {
        // do nothing
    }
}
