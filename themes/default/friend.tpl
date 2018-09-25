<legend>{L_139} <a class="btn btn-primary btn-sm pull-right" href="{SITEURL}products/{SEO}"><span class="glyphicon glyphicon-envelope"></span> {L_138}</a>

</legend>



<!-- IF ERROR ne '' -->

<div class="alert alert-error"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->

<!-- IF EMAILSENT eq '' -->

<div align="center" class="alert alert-info"> <strong>{L_017} : {TITLE}</strong><br />

  {L_146} <strong>{FRIEND_EMAIL}</strong> <br />

  <br />

</div>

<!-- ELSE -->

<div class="col-sm-6 well col-sm-offset-3">

	<form class="form-horizontal" name="friend" action="friend.php" method="post" enctype="multipart/form-data">

      	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

      	<input type="hidden" name="id" value="{ID}">

        <input type="hidden" name="item_title" value="{TITLE}">

        <input type="hidden" name="action" value="sendmail">

      	<div class="form-group">

      		<label class="col-sm-4 control-label">{L_017}</label>

      		<div class="col-sm-7">

      			<div class="form-control">{TITLE}</div>

      		</div>

      	</div>

      	<div class="form-group">

      		<label class="col-sm-4 control-label">{L_140}</label>

      		<div class="col-sm-7">

      			<input type="text" name="friend_name" size="25" class="form-control" value="{FRIEND_NAME}">

      		</div>

      	</div>

      	<div class="form-group">

        	<label class="col-sm-4 control-label" for="inputEmail">{L_141}</label>

        	<div class="col-sm-7">

          		<input type="text" name="friend_email" class="form-control" size="25" value="{FRIEND_EMAIL}">

        	</div>

      	</div>

      	<div class="form-group">

        	<label class="col-sm-4 control-label" for="inputEmail">{L_002}</label>

        	<div class="col-sm-7">

          		<input type="text" name="sender_name" class="form-control" size="25" value="{YOUR_NAME}">

        	</div>

      	</div>

      	<div class="form-group">

        	<label class="col-sm-4 control-label" for="inputEmail">{L_143}</label>

        	<div class="col-sm-7">

          		<input type="text" name="sender_email" class="form-control" size="25" value="{YOUR_EMAIL}">

        	</div>

      	</div>

      	<div class="form-group">

        	<label class="col-sm-4 control-label" for="inputEmail">{L_144}</label>

        	<div class="col-sm-7">

          		<textarea name="sender_comment" class="form-control" cols="30" rows="6">{COMMENT}</textarea>

        	</div>

      	</div>

      	{CAPCHA}

      	<br><br>

      	<hr>

      	<div align="center">

      		<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_5201}</button>

      		<button type="reset" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> {L_035}</button>

      	</div>

  	</form>

</div>

<!-- ENDIF -->

