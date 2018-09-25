function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	var fileArray = _("file_up[]").files;
	var formdata = new FormData();
	for (var i = 0; i < fileArray.length; i++) {
		var file = fileArray[i];
		formdata.append("file_up[]", file, file.name);
	}
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "{SITEURL}uploaded/index.php?action=1");
	ajax.send(formdata);
}
function progressHandler(event){
	_("loaded_n_total").innerHTML = "{L_3500_1015578} "+event.loaded+" {L_3500_1015579} "+event.total;
	var percent = (event.loaded / event.total) * 100;
	$("#progressBar").css("width", Math.round(percent)+'%');
	_("uploadStatus").innerHTML = Math.round(percent)+"%";
}
function completeHandler(event){
	$('#images').load('{SITEURL}uploaded/index.php?action=3 #displayImages').fadeIn("slow");
	_("progressBar").value = 100;
	_("completed").innerHTML = "<b>{L_3500_1015895}</b>";
}
function errorHandler(event){
	_("uploadStatus").innerHTML = "{L_3500_1015576}";
}
function abortHandler(event){
	_("uploadStatus").innerHTML = "{L_3500_1015577}";
}

function sendFileToServer(formData,status){
	var uploadURL ="{SITEURL}uploaded/index.php?action=2"; //Upload URL
	var extraData ={}; //Extra Data.
	var jqXHR=$.ajax({
		xhr: function() {
			var xhrobj = $.ajaxSettings.xhr();
			if (xhrobj.upload) {
				xhrobj.upload.addEventListener('progress', function(event) {
					var percent = 0;
					var position = event.loaded || event.position;
					var total = event.total;
					if (event.lengthComputable) {
						percent = Math.ceil(position / total * 100);
					}
					//Set progress
					status.setProgress(percent);
				}, false);
			}
			return xhrobj;
		},
		url: uploadURL,
		type: "POST",
		contentType:false,
		processData: false,
		cache: false,
		data: formData,
		success: function(data){
            status.setProgress(100);
            $('#images').load('{SITEURL}uploaded/index.php?action=3 #displayImages').fadeIn("slow");
        }
	}); 
	status.setAbort(jqXHR);
}
var rowCount=0;
function createStatusbar(obj){
	rowCount++;
	var row="odd";
	if(rowCount %2 ==0) row ="even";
	this.statusbar = $("<div class='statusbar "+row+"'></div>");
	this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
	this.size = $("<span class='filesize'></span>").appendTo(this.statusbar);
	this.progressBar = $('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '+row+'%"></div></div>').appendTo(this.statusbar);
	this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
	obj.after(this.statusbar);
	this.setFileNameSize = function(name,size){
		var sizeStr="";
		var sizeKB = size/1024;
		if(parseInt(sizeKB) > 1024){
			var sizeMB = sizeKB/1024;
			sizeStr = sizeMB.toFixed(2)+" MB";
		}else{
			sizeStr = sizeKB.toFixed(2)+" KB";
		}
		this.filename.html(name);
		this.size.html(sizeStr);
	}
	this.setProgress = function(progress){
		var progressBarWidth =progress*this.progressBar.width()/ 100;
		this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "%");
		if(parseInt(progress) >= 100){
			this.abort.hide();
		}
	}
	this.setAbort = function(jqxhr){
		var sb = this.statusbar;
		this.abort.click(function(){
			jqxhr.abort();
			sb.hide();
		});
	}
}
function handleFileUpload(files,obj){
	for (var i = 0; i < files.length; i++) {
		var fd = new FormData();
		fd.append('file', files[i]);
		var status = new createStatusbar(obj); //Using this we can set progress.
		status.setFileNameSize(files[i].name,files[i].size);
		sendFileToServer(fd,status);
	}
}
$(document).ready(function(){
	var obj = $("#dragandrophandler");
	obj.on('dragenter', function (e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).css('border', '2px dotted #0B85A1');
	});
	obj.on('dragover', function (e) {
		e.stopPropagation();
		e.preventDefault();
	});
	obj.on('drop', function (e) {
		$(this).css('border', '2px dotted #0B85A1');
		e.preventDefault();
		var files = e.originalEvent.dataTransfer.files;
		//We need to send dropped files to Server
		handleFileUpload(files,obj);
	});
	$(document).on('dragenter', function (e) {
		e.stopPropagation();
		e.preventDefault();
	});
	$(document).on('dragover', function (e) {
		e.stopPropagation();
		e.preventDefault();
		obj.css('border', '2px solid #0B85A1');
	});
	$(document).on('drop', function (e) {
		e.stopPropagation();
		e.preventDefault();
		obj.css('border', '2px solid #0B85A1');
	});
	obj.css('border', '2px solid #0B85A1');
});
$(_('images')).click(function()
{
	$('span').click(function()
	{
		var formdata = new FormData();
		var imageName = $('img',this).attr('title');
		formdata.append("setDefaultImage", imageName);
		var ajax = new XMLHttpRequest();
		ajax.addEventListener("load", imageHandler, false);
		ajax.addEventListener("error", imageRrrorHandler, false);
		ajax.open("POST", "{SITEURL}uploaded/index.php?action=4");
		ajax.send(formdata);
	});
	function imageHandler(event){
		_("setdefaultimg").innerHTML = event.target.responseText;
	}
	function imageRrrorHandler(event){
		_("setdefaultimg").innerHTML = "Didn't set the default image";
	}
});

