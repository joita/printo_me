(function () {
	var filesUpload = document.getElementById("files-upload"),
		dropArea 	= document.getElementById("drop-area"),
		fileList 	= document.getElementById("dag-files-images"),
		fileType 	= ["png", "gif", "jpg", "jpeg"],
		maxsize		= uploadSize['max'];

	function check_file(file) {
		var ext = file.name.substr(file.name.lastIndexOf('.') + 1).toLowerCase();
		var check = fileType.indexOf(ext);//alert(file.type);
		if(check == -1)
		{
			alert(lang.upload.fileType);
			return false;
		}

		if(file.size > 1048576 * maxsize){	//1048576 = 1MB
			alert(lang.upload.maxSize + maxsize+'MB');
			return false;
		}

		var _URL = window.URL || window.webkitURL;
		var fil, imagen;

		if ((fil = filesUpload.files[0])) {
			imagen = new Image();
			imagen.src = _URL.createObjectURL(file);
			imagen.onload = function () {
				if(this.width * this.height < 1000000) {
					alert('El archivo es muy chico para impresión, tiene que ser al menos de 1000x1000 pixeles.');
					return false;
				} else {
					uploadFile(file);
				}
			};
		}
	}


	function uploadFile (file) {

		var span = document.createElement("span"),
			img,
			progressBarContainer = document.createElement("div"),
			progressBar = document.createElement("div"),
			reader,
			xhr,
			fileInfo;
		span.className = 'view-thumb column';

		if (jQuery('#remove-bg').is(':checked') == true) var remove = 1;
		else var remove = 0;
		var url = baseURL + 'ajax/upload/'+remove;

		jQuery("#dg-myclipart .modal-content .loading").show();

		/*
			If the file is an image and the web browser supports FileReader,
			present a preview in the file list
		*/
		if (typeof window.FileReader !== "undefined" && (file.type == 'image/png' || file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/gif')) {
			img = document.createElement("img");
			img.className = 'img-responsive img-thumbnail';
			span.appendChild(img);
			reader = new FileReader();
			reader.onload = (function (theImg) {
				return function (evt) {
					theImg.src = evt.target.result;
					if (/MSIE/.test(navigator.userAgent))
					{
						jQuery(progressBar).html('uploading...').css('width', '100%');
						jQuery.ajax({
							type: "POST",
							url:  baseURL + 'ajax/uploadIE',
							data: { myfile: evt.target.result}
						}).done(function( content ) {
							var media 	= eval('('+content+')');
							if (media.status == '')
							{
								img.setAttribute('src', media.msg.thumb);
								span.item = media.msg;
								jQuery(span).bind('click', function(){
									design.myart.create(span);
								});
								jQuery(progressBarContainer).addClass('uploaded');
								jQuery(progressBar).html('Uploaded').css('width', '100%');
							}
							else
							{
								alert(media.msg);
							}
							jQuery('#upload-copyright').attr('checked', false);
							jQuery('#remove-bg').attr('checked', false);
							jQuery('#files-upload').val('');
							jQuery("#big-file-dude").html('<i class="fa fa-file-image-o"></i> Seleccionar archivo').removeClass("archivo-seleccionado");
						});
					}
				};
			}(img));
			reader.readAsDataURL(file);
		}
		else
		{
			img = document.createElement("img");
			img.className = 'img-responsive img-thumbnail';
			img.setAttribute('src', baseURL + 'assets/images/photo.png');
			span.appendChild(img);
		}

		//jQuery('#upload-tabs a[href="#uploaded-art"]').tab('show');

		progressBarContainer.className = "progress progress-bar-container";
		progressBar.className = "progress-bar";
		progressBarContainer.appendChild(progressBar);
		span.appendChild(progressBarContainer);

		// Uploading - for Firefox, Google Chrome and Safari
		xhr = new XMLHttpRequest();

		// Update progress bar
		xhr.upload.addEventListener("progress", function (evt) {
			if (evt.lengthComputable) {
				var completed = (evt.loaded / evt.total) * 100;
				progressBar.style.width = completed + '%';
				progressBar.innerHTML = completed.toFixed(0) + '%';
			}
			else {
				// No data to calculate on
			}
		}, false);

		//var spanload = document.createElement('span');
		//spanload.className = 'view-thumb column loader';
		//spanload.innerHTML = '<img class="img-responsive img-thumbnail" src="'+baseURL+'assets/images/trans.png" style="background:url('+baseURL+'assets/images/loading_32x32.gif) no-repeat center center;">';
		//fileList.append(spanload);


		// File uploaded
		xhr.addEventListener("load", function () {
			progressBarContainer.className += " uploaded";
			progressBar.innerHTML = "<i class='fa fa-check'></i> Procesando imagen.";
			setTimeout(function() {
				progressBar.innerHTML = "Listo. Haz clic para colocar.";
				//jQuery(progressBarContainer).fadeOut(200);
			},300);
		}, false);

		if (/MSIE/.test(navigator.userAgent) == false)
		{
			xhr.open("post", url, true);

			xhr.onload = function() {
				if(this.responseText == ''){
					alert('Ha ocurrido algún error al subir el archivo, verifique su archivo, si persisten los detalles comuniquese a soporte de printome para orientarla(o).');
					setTimeout(function() {
						jQuery(".view-thumb.column.loader").remove();
						//fileList.appendChild(span);

						jQuery("#dg-myclipart .modal-content .loading").hide();
					}, 300);
				}else if (xhr.status === 200) {
					var media 					= eval('('+this.responseText+')');
					console.log(media);
					if (media.status == '')
					{
						img.setAttribute('src', media.msg.thumb);
						span.item = media.msg;
						jQuery(span).bind('click', function(){
							design.myart.create(span);
						});
						setTimeout(function() {
							jQuery(".view-thumb.column.loader").remove();
							//fileList.appendChild(span);

							jQuery("#dg-myclipart .modal-content .loading").hide();
						}, 300);
						setTimeout(function() {
							jQuery(span).click();
						}, 500);

						if(jQuery(".modal-backdrop.in").is(":visible")) {
							jQuery(".modal-backdrop.in").fadeOut(250);
						}
					}
				} else {
					alert('Ha ocurrido algún error al subir el archivo, por favor intenta nuevamente.');
					setTimeout(function() {
						jQuery(".view-thumb.column.loader").remove();
						//fileList.appendChild(span);

						jQuery("#dg-myclipart .modal-content .loading").hide();
					}, 300);
				}
				//jQuery('#upload-copyright').attr('checked', false);
				//jQuery('#remove-bg').attr('checked', false);
				jQuery('#files-upload').val('');
				jQuery("#big-file-dude").html('<i class="fa fa-file-image-o"></i> Seleccionar archivo').removeClass("archivo-seleccionado");
			};

			var formData = new FormData();
			formData.append('myfile', file);
			xhr.send(formData);

		}
	}

	function traverseFiles (files) {
		if (typeof files !== "undefined") {
			for (var i=0, l=files.length; i<l; i++) {
				check_file(files[i]);
			}
		}
		else {
			fileList.innerHTML = "No support for the File API in this web browser";
		}
	}

	document.getElementById('action-upload').addEventListener("click", function () {
		var check = design.upload.computer();
		if (check == true) traverseFiles(filesUpload.files);
	}, false);

	dropArea.addEventListener("dragleave", function (evt) {
		var target = evt.target;

		if (target && target === dropArea) {
			this.className = "";
		}
		evt.preventDefault();
		evt.stopPropagation();
	}, false);

	dropArea.addEventListener("dragenter", function (evt) {
		this.className = "over";
		evt.preventDefault();
		evt.stopPropagation();
	}, false);

	dropArea.addEventListener("dragover", function (evt) {
		evt.preventDefault();
		evt.stopPropagation();
	}, false);

	dropArea.addEventListener("drop", function (evt) {
		traverseFiles(evt.dataTransfer.files);
		this.className = "";
		evt.preventDefault();
		evt.stopPropagation();
	}, false);
})();
