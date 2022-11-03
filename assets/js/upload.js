// berkas
function upload_berkas(kontrol) {
	let cek;

	$('#kontrol').val(kontrol);

	switch (kontrol) {
		case "izinusaha":
		case "aktapendirian":
			cek = $('#npwp').val();

			if(cek != ''){
				$("#pilih-berkas").click();
			} else {
				alert('Isi NPWP terlebih dahulu !!!');
				$('#npwp').focus();
			}
			break;
		case "ktp":
			cek = $('#nik').val();

			if(cek != ''){
				$("#pilih-berkas").click();
			} else {
				alert('Isi No. KTP terlebih dahulu !!!');
				$('#nik').focus();
			}
			break;
		case "uttppeserta":		
			$("#pilih-berkas").click();
			break
		default:
			alert("Kelompok proses belum ada !!!");
			break;
	}
}

$("#pilih-berkas").change(function () {
	let kontrol = $('#kontrol').val();
	let nama_file;
	let target_proses;
	let maks = 2000000;
	let alert_maks = "Ukuran file melebihi 2 Mb!";

	if (this.files[0] != "") {
		if (this.files[0].size > maks) {
			alert(alert_maks);
		} else {
			switch(kontrol){
				case "izinusaha":
					nama_file = "izinusaha_" + $('#npwp').val();

					$('#npwp').attr("readonly",true);

					$(".span-lihat").addClass('sr-only');
					$(".btn-lihat").attr("href", '#');
					$(".btn-batal").addClass('sr-only');
					$(".btn-pilih").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/upload/" + nama_file;
					break;
				case "aktapendirian":
					nama_file = "aktapendirian_" + $('#npwp').val();

					$('#npwp').attr("readonly",true);

					$(".span-lihat2").addClass('sr-only');
					$(".btn-lihat2").attr("href", '#');
					$(".btn-batal2").addClass('sr-only');
					$(".btn-pilih2").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/upload/" + nama_file;
					break;
				case "ktp":
					nama_file = "ktp_" + $('#nik').val();

					$('#nik').attr("readonly",true);

					$(".span-lihat3").addClass('sr-only');
					$(".btn-lihat3").attr("href", '#');
					$(".btn-batal3").addClass('sr-only');
					$(".btn-pilih3").removeClass('sr-only');

					target_proses = serverloc + "/pelayanan/upload/" + nama_file;
					break;
				case "uttppeserta":
					nama_file = $('#namafile').val();

					$(".btn-area").addClass('sr-only');
					$(".btn-lihat").attr("href", '#');

					target_proses = serverloc + "/pelayanan/uploaduttp/" + nama_file;
					break;
			}
			
			$(".btn-simpan").hide();
			$(".btn-simpan").attr("disabled", "disabled");

			$(".overlay").removeClass('sr-only');

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

function progressHandler(event) {
	// let percent = (event.loaded / event.total) * 100;
	// $("#progress_bar").css("width", Math.round(percent) + "%");
	$(".overlay").removeClass('sr-only');
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
		$(".overlay").addClass('sr-only');

		switch (kontrol) {
			case "izinusaha":
				$(".span-lihat").addClass('sr-only');
				$(".btn-lihat").attr("href", '#');
				$(".btn-batal").addClass('sr-only');
				$(".btn-pilih").removeClass('sr-only');

				if($("#berkas").val() == "" && $("#berkas2").val() == ""){
					$('#npwp').removeAttr("readonly");
				}
				break;
			case "aktapendirian":
				$(".span-lihat2").addClass('sr-only');
				$(".btn-lihat2").attr("href", '#');
				$(".btn-batal2").addClass('sr-only');
				$(".btn-pilih2").removeClass('sr-only');

				if($("#berkas").val() == "" && $("#berkas2").val() == ""){
					$('#npwp').removeAttr("readonly");
				}
				break;
			case "ktp":
				$(".span-lihat3").addClass('sr-only');
				$(".btn-lihat3").attr("href", '#');
				$(".btn-batal3").addClass('sr-only');
				$(".btn-pilih3").removeClass('sr-only');
				break;
			case "uttppeserta":
				$(".btn-area").addClass('sr-only');
				$(".btn-lihat").attr("href", '#');
				break;
		}

		$(".btn-simpan").show();
		$(".btn-simpan").removeAttr("disabled");

		alert(" Gagal upload file, silakan coba upload ulang");
	} else {
		$(".overlay").addClass('sr-only');

		switch (kontrol) {
			case "izinusaha":
				$("#berkas").val(nama_file);
				$(".span-lihat").removeClass('sr-only');
				$(".btn-lihat").attr("href", serverloc + "/pelayanan/viewPdf/" + nama_file);
				$(".btn-batal").removeClass('sr-only');
				$(".btn-pilih").addClass('sr-only');
				break;
			case "aktapendirian":
				$("#berkas2").val(nama_file);
				$(".span-lihat2").removeClass('sr-only');
				$(".btn-lihat2").attr("href", serverloc + "/pelayanan/viewPdf/" + nama_file);
				$(".btn-batal2").removeClass('sr-only');
				$(".btn-pilih2").addClass('sr-only');
				break;
			case "ktp":
				$("#berkas3").val(nama_file);
				$(".span-lihat3").removeClass('sr-only');
				$(".btn-lihat3").attr("href", serverloc + "/pelayanan/viewPdf/" + nama_file);
				$(".btn-batal3").removeClass('sr-only');
				$(".btn-pilih3").addClass('sr-only');
				break;
			case "uttppeserta":
				$("#namafile").val(nama_file);
				$("#foto").attr("src", serverloc + "/upload/uttppeserta/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
				$(".btn-lihat").attr("href", serverloc + "/upload/uttppeserta/" + nama_file + "?" + Math.floor((Math.random() * 100) + 1));
				$(".btn-area").removeClass('sr-only');
				break;
		}

		$(".btn-simpan").show();
		$(".btn-simpan").removeAttr("disabled");
	}

	console.log(nama_file);
}

function batal_berkas(kontrol) {
	let namafile; 
	let url;

	if(confirm('Hapus file upload ?') == true){
		switch (kontrol) {
			case "izinusaha":
				namafile = $("#berkas").val();
				url = serverloc + "/pelayanan/batalberkas/" + namafile;

				$("#berkas").val('');
				$(".span-lihat").addClass('sr-only');
				$(".btn-lihat").attr("href", '#');
				$(".btn-batal").addClass('sr-only');
				$(".btn-pilih").removeClass('sr-only');

				if($("#berkas").val() == "" && $("#berkas2").val() == ""){
					$('#npwp').removeAttr("readonly");
				}
				break;
			case "aktapendirian":
				namafile = $("#berkas2").val();
				url = serverloc + "/pelayanan/batalberkas/" + namafile;

				$("#berkas2").val('');
				$(".span-lihat2").addClass('sr-only');
				$(".btn-lihat2").attr("href", '#');
				$(".btn-batal2").addClass('sr-only');
				$(".btn-pilih2").removeClass('sr-only');

				if($("#berkas").val() == "" && $("#berkas2").val() == ""){
					$('#npwp').removeAttr("readonly");
				}
				break;
			case "ktp":
				namafile = $("#berkas3").val();
				url = serverloc + "/pelayanan/batalberkas/" + namafile;

				$('#nik').removeAttr("readonly");
				$("#berkas3").val('');
				$(".span-lihat3").addClass('sr-only');
				$(".btn-lihat3").attr("href", '#');
				$(".btn-batal3").addClass('sr-only');
				$(".btn-pilih3").removeClass('sr-only');
				break;
			case "uttppeserta":
				namafile = $("#namafile").val();
				url = serverloc + "/pelayanan/batalberkasuttp/" + namafile;

				$(".btn-area").addClass('sr-only');
				$(".btn-lihat").attr("href", '#');
				$("#foto").attr("src", serverloc + "/upload/no-image.png?" + Math.floor((Math.random() * 100) + 1));
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