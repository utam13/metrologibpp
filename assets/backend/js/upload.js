// logo aplikasi
function upload_logo() {
	$("#pilih_logo").click();
}

$("#pilih_logo").change(function () {
	let target_proses = serverloc + "/kantor/upload";

	if (this.files[0] != "") {
		if (this.files[0].size > 100000) {
			alert("Ukuran file melebihi 100 kb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_kantor, false);
			ajax.addEventListener("load", completeHandler_kantor, false);
			ajax.addEventListener("error", errorHandler_kantor, false);
			ajax.addEventListener("abort", abortHandler_kantor, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

function progressHandler_kantor(event) {
	var percent = (event.loaded / event.total) * 100;
	$(".progress-bar").css("width", Math.round(percent) + "%");
}

function errorHandler_kantor(event) {
	alert("Upload Gagal");
}

function abortHandler_kantor(event) {
	alert("Upload Dibatalkan");
}

function completeHandler_kantor(event) {
	const nama_file = event.target.responseText;
	let berkas;

	$("#progress_div").hide();
	console.log(nama_file);
	if (nama_file == "gagal") {
		alert("Gagal upload file, coba upload ulang !!!");
	} else {
		berkas = serverloc + "/upload/logo/" + nama_file + "?" + Math.random();

		$("#logo_app").attr("src", berkas);
	}
}

// slide
function upload_slide(nomor) {
	$("#pilih-"+nomor).click();
	console.log(nomor);
}

$("#pilih-1").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 1;
	
	if (this.files[0] != "") {
		if (this.files[0].size > 3000000) {
			alert("Ukuran file melebihi 3 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-2").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 2;

	if (this.files[0] != "") {
		if (this.files[0].size > 3000000) {
			alert("Ukuran file melebihi 3 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-3").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 3;

	if (this.files[0] != "") {
		if (this.files[0].size > 3000000) {
			alert("Ukuran file melebihi 3 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

$("#pilih-4").change(function () {
	let target_proses = serverloc + "/slide/upload/" + 4;

	if (this.files[0] != "") {
		if (this.files[0].size > 3000000) {
			alert("Ukuran file melebihi 3 Mb!");
		} else {
			$("#progress_div").show();
			$("#progress_bar").attr("aria-valuenow", 0);

			var formdata = new FormData();
			formdata.append("berkas", this.files[0]);
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler_slide, false);
			ajax.addEventListener("load", completeHandler_slide, false);
			ajax.addEventListener("error", errorHandler_slide, false);
			ajax.addEventListener("abort", abortHandler_slide, false);
			ajax.open("POST", target_proses);
			ajax.send(formdata);
		}
	}
});

function progressHandler_slide(event) {
	var percent = (event.loaded / event.total) * 100;
	$(".progress-bar").css("width", Math.round(percent) + "%");
}

function errorHandler_slide(event) {
	alert("Upload Gagal");
}

function abortHandler_slide(event) {
	alert("Upload Dibatalkan");
}

function completeHandler_slide(event) {
	const nama_file = event.target.responseText;
	let berkas;

	$("#progress_div").hide();
	console.log(nama_file);
	if (nama_file == "gagal") {
		alert("Gagal upload file, coba upload ulang !!!");
	} else {
		berkas = serverloc + "/upload/slide/" + nama_file + "?" + Math.random();
		console.log(berkas);

		if(nama_file.includes("slide_1") == true){
			$("#slide-1").attr("src", berkas);
		}

		if(nama_file.includes("slide_2") == true){
			$("#slide-2").attr("src", berkas);
		}
		
		if(nama_file.includes("slide_3") == true){
			$("#slide-3").attr("src", berkas);
		}

		if(nama_file.includes("slide_4") == true){
			$("#slide-4").attr("src", berkas);
		}
	}
}

// berkas
function upload_berkas() {
	let kontrol = $("#kontrol").val();

	switch (kontrol) {
		case "regulasi":
		case "sop":
		case "struktur":
		case "uttp":
		case "galeri":
		case "dokumen":
			$("#pilih-berkas").click();
			break;
		default:
			alert("Kelompok proses belum ada !!!");
			break;
	}
}

$("#pilih-berkas").change(function () {
	let kontrol = $("#kontrol").val();
	let nama_file = $("#nama-file").val();
	let target_proses;
	let maks = 0;
	let alert_maks = "";

	switch (kontrol) {
		case "regulasi":
		case "sop":
			target_proses = serverloc + "/" + kontrol + "/upload/" + nama_file;

			maks = 30000000;
			alert_maks = "Ukuran file melebihi 3 Mb!";
			break;
		case "struktur":
			target_proses = serverloc + "/pegawai/upload";

			maks = 2000000;
			alert_maks = "Ukuran file melebihi 2 Mb!";
			break;
		case "uttp":
			target_proses = serverloc + "/" + kontrol + "/upload/" + nama_file;

			maks = 100000;
			alert_maks = "Ukuran file melebihi 100 Kb!";
			break;
		case "dokumen":
			let nama = $('#nama').val();
			nama_file = nama.replace(' ','_');

			target_proses = serverloc + "/uttp/uploaddokumen/" + nama_file;
			
			maks = 2000000;
			alert_maks = "Ukuran file melebihi 2 Mb!";
			break;
		case "galeri":
			target_proses = serverloc + "/galeriberita/upload/";

			maks = 2000000;
			alert_maks = "Ukuran file melebihi 2 Mb!";
			break;
	}

	if (this.files[0] != "") {
		if (this.files[0].size > maks) {
			alert(alert_maks);
		} else {
			switch (kontrol) {
				case "regulasi":
				case "sop":
				case "galeri":
				case "dokumen":
					$(".span-lihat").addClass('sr-only');
					$(".btn-lihat").attr("href", '#');
					$(".btn-batal").addClass('sr-only');
					$(".btn-batal").attr("href", '#');
					$(".btn-pilih").removeClass('sr-only');
					$(".btn-simpan").hide();
					$(".btn-simpan").attr("disabled", "disabled");
					break;
				case "uttp":
					$(".btn-area").addClass('sr-only');
					$(".btn-lihat").attr("href", '#');
					break;
			}

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
	let berkas = serverloc + "/upload/" + kontrol + "/" + nama_file + "?" + Math.random();
	let kdberita = $('#kdberita').val();
	let proses = $('#proses').val();
	let kode = $('#kode').val();
	
	if (nama_file == "gagal") {
		$("#progress_div").hide();

		switch (kontrol) {
			case "regulasi":
			case "sop":
			case "galeri":
			case "dokumen":
				$(".span-lihat").addClass('sr-only');
				$(".btn-lihat").attr("href", '#');
				$(".btn-batal").addClass('sr-only');
				$(".btn-batal").attr("href", '#');
				$(".btn-pilih").removeClass('sr-only');
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
			case "uttp":
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
		}

		alert(" Gagal upload file, silakan coba upload ulang");
	} else {
		$("#progress_div").hide();

		switch (kontrol) {
			case "regulasi":
				$("#berkas").val(nama_file);
				$(".span-lihat").removeClass('sr-only');
				$(".btn-lihat").attr("href", serverloc + "/regulasi/viewPdf/" + nama_file);
				$(".btn-batal").removeClass('sr-only');
				$(".btn-batal").attr("href", serverloc + "/regulasi/batalberkas/" + nama_file + "/"  + proses + "/" + kode);
				$(".btn-pilih").addClass('sr-only');
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
			case "sop":
				$("#berkas").val(nama_file);
				$(".span-lihat").removeClass('sr-only');
				$(".btn-lihat").attr("href", serverloc + "/sop/viewPdf/" + nama_file);
				$(".btn-batal").removeClass('sr-only');
				$(".btn-batal").attr("href", serverloc + "/sop/batalberkas/" + nama_file + "/"  + proses + "/" + kode);
				$(".btn-pilih").addClass('sr-only');
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
			case "galeri":
				$("#berkas").val(nama_file);
				$(".span-lihat").removeClass('sr-only');
				$(".btn-lihat").attr("href", berkas);
				$(".btn-batal").removeClass('sr-only');
				$(".btn-batal").attr("href", serverloc + "/galeriberita/batalberkas/" + kdberita + "/" + nama_file);
				$(".btn-pilih").addClass('sr-only');
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
			case "dokumen":
				berkas = serverloc + "/upload/doktambahan/" + nama_file;

				$("#berkas").val(nama_file);
				$(".span-lihat").removeClass('sr-only');
				$(".btn-lihat").attr("href", berkas);
				$(".btn-batal").removeClass('sr-only');
				$(".btn-pilih").addClass('sr-only');
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
			case "struktur":
				$("#berkas").attr("src", berkas);
				break;
			case "uttp":
				$("#nama-file").val(nama_file);
				$("#gambar").attr("src", berkas);
				$(".btn-simpan").show();
				$(".btn-simpan").removeAttr("disabled");
				break;
			default:
				$("#berkas").val("");
				alert("Kelompok proses belum ada !!!");
				break;
		}
	}

	console.log(nama_file);
}

function batal_berkas(kontrol) {
	let namafile; 
    let url;

    if(confirm('Hapus file upload ?') == true){
        switch (kontrol) {
            case "dokumen":
                namafile = $("#berkas").val();

                $("#berkas").val('');
                $(".span-lihat").addClass('sr-only');
                $(".btn-lihat").attr("href", '#');
                $(".btn-batal").addClass('sr-only');
                $(".btn-pilih").removeClass('sr-only');

                url = serverloc + "/uttp/batalberkas/" + namafile;
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