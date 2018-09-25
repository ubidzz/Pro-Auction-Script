<legend>{L_215}</legend>

<!-- IF B_FIRST -->

<!-- IF ERROR ne '' -->

<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {L_3500_1015887}</strong> {ERROR}</div>

<!-- ENDIF -->

<form name="user_login" action="" method="post" class="form-horizontal">

    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

    {L_2__0039}

	<hr />

	<div class="col-sm-6">

    	<div class="input-group">

    	 	<span class="input-group-addon">{L_003}</span>

    	    <input type="text" name="TPL_username" class="form-control" size="25" value="{USERNAME}">

    	</div>

    	<div class="input-group">

    	  	<span class="input-group-addon">{L_006}</span>

    	    <input type="text" name="TPL_email" class="form-control" size="25" value="{EMAIL}">

    	</div>

    	<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-envelope"></span> {L_5431}</button>

    	<input type="hidden" name="action" value="ok">

 	</div>

</form>

<!-- ELSE -->

<div class="alert alert-success" role="alert">{L_217}</div>

<!-- ENDIF -->

