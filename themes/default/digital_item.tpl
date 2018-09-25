
<script type="text/javascript">

$(document).ready(function() {

	$('#hidden').hide();

});

function _(el){

	return document.getElementById(el);

}

function uploadFile(){

	var file = _("file_up[]").files[0];

	//alert(file.name+" | "+file.size+" | "+file.type);

	var formdata = new FormData();

	formdata.append("file_up[]", file);
	formdata.append('csrftoken', '{_CSRFTOKEN}');

	var ajax = new XMLHttpRequest();

	ajax.upload.addEventListener("progress", progressHandler, false);

	ajax.addEventListener("load", completeHandler, false);

	ajax.addEventListener("error", errorHandler, false);

	ajax.addEventListener("abort", abortHandler, false);

	ajax.open("POST", "{SITEURL}digital_item.php?diupload=1");

	ajax.send(formdata);

}

function progressHandler(event){

	var percent = (event.loaded / event.total) * 100;

	$("#progressBar").width(Math.round(percent) + '%');

	_("loaded_n_total").innerHTML = "{L_3500_1015578} "+event.loaded+" {L_3500_1015579} "+event.total;

	_("status").innerHTML = Math.round(percent)+"{L_3500_1015575}";

	$('#hidden').show();

}

function completeHandler(event){

	_("status").innerHTML = event.target.responseText;

	$("#progressBar").width(100 + '%');

	_("completed").innerHTML = "<div class='alert alert-success' role='alert'><span class='glyphicon glyphicon-ok'></span> {L_3500_1015574}</div>";

	$(".value").val('');

}

function errorHandler(event){

	_("status").innerHTML = "{L_3500_1015576}";

}

function abortHandler(event){

	_("status").innerHTML = "{L_3500_1015577}";

}

</script>  

<div id="uploadFile" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"><h4>{L_350_10171} <button class="btn btn-danger btn-xs pull-right" data-dismiss="modal">{L_678}</button></h4></div>
			<div class="modal-body">

				<div id="hidden">

					<h3 id="status"></h3>

					<div class="progress">

						<div class="progress-bar progress-bar-success progress-bar-striped active" id="progressBar" style="width:0%;"><span id="loaded_n_total"></span></div>

					</div>

					<div id="completed"></div>

				</div>

				<div class="alert alert-success">{TYPES}</div>

				<div class="alert alert-success">{SIZE}</div>


				<div class="alert alert-info">{L_3500_1015580}</div>

				<div class="well well-sm">

			 		<b>{L_350_10172}</b>{STORED}<br>
			 		<b>{L_350_10173}</b>{FILE_UPLOADED}

				</div>

			</div>
			<div class="modal-footer">
				<form id="upload_form" enctype="multipart/form-data" method="post" class="form-inline">

			   		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

			 		<input type="file" class="btn btn-primary btn-sm col-xs-3 col-sm-6 value" name="file_up[]" id="file_up[]">

			 		<button type="button" class="btn btn-success btn-sm" onclick="uploadFile()"><i class="fa fa-upload" aria-hidden="true"></i> {L_681}</button>

				</form>

			</div>

		</div>
	</div>
</div>
