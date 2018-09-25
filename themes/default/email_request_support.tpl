<legend>{PAGE_TITLE}</legend>
<!-- IF ERROR ne '' -->
<div class="alert alert-error">{ERROR}</div>
<!-- ENDIF -->
<!-- IF MESSAGE ne '' -->
<div class="alert alert-success">{MESSAGE}</div>
<!-- ELSE -->
<form class="form-horizontal" name="sendemail" action="email_request_support.php" method="post">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<div class="form-group">
		<label class="col-sm-2 control-label">{L_3500_1015441}</label>
		<div class="col-sm-10">
			<button type="button" onclick="$('#support').val('{L_3500_1015442}');" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-question-sign"></span> {L_3500_1015442}</button>
       		<button type="button" onclick="$('#support').val('{L_3500_1015443}');" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-question-sign"></span> {L_3500_1015443}</button>
        	<button type="button" onclick="$('#support').val('{L_3500_1015444}');" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-info-sign"></span> {L_3500_1015444}</button>
        	<button type="button" onclick="$('#support').val('{L_3500_1015445}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-warning-sign"></span> {L_3500_1015445}</button>
		</div>
	</div>
	<!-- IF B_LOGGED_IN eq false -->
	<div class="form-group">
		<label class="col-sm-2 control-label">{L_006}:</label>
		<div class="col-sm-5">
			<input type="text" name="sender_email" class="form-control" maxlength="150" value="{SENDER_EMAIL}">
		</div>
	</div>
	<!-- ENDIF -->
	<!-- your email -->
	<div class="form-group">
		<label class="col-sm-2 control-label">{L_002}:</label>
		<div class="col-sm-5">
			<input type="text" name="sender_name" class="form-control" maxlength="65" value="{SENDER_NAME}">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">{L_3500_1015446}:</label>
		<div class="col-sm-5">
			<input type="text" id="support" name="subject" class="form-control" maxlength="60" value="{SUBJECT}">
		</div>
	</div>
	<!-- comment -->
	<div class="form-group">
		<label class="col-sm-2 control-label">{L_650}</label>
		<div class="col-sm-7">
			{SELLER_QUESTION}
		</div>
	</div>
	{CAPCHA}<br><hr>
	<div align="center">
		<input type="hidden" name="admin_email" value="{ADMIN_EMAIL}"> 
		<input type="hidden" name="action" value="{L_106}">					
		<button type="submit" name="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_5201}</button>
		<!-- IF B_LOGGED_IN -->
		<input type="hidden" name="sender_email" value="{EMAIL}">
		<!-- ENDIF -->
	</div>
</form>
<!-- ENDIF -->
