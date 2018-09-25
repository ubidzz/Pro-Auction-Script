<legend>{L_3500_1015999}</legend>

<!-- IF B_FIRST -->

<!-- IF ERROR ne '' -->

<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {L_3500_1015887}</strong> {ERROR}</div>

<!-- ENDIF -->

<form name="user_login" action="" method="post" class="form-inline">

    <input type="hidden" name="action" value="ok">

    {L_3500_1016000}

	<hr />

	<div align="center">

		<div class="form-group">

	    	<div class="input-group">

	    	 	<span class="input-group-addon">{L_003}</span>

	    	    <input type="text" name="username" class="form-control" value="{USERNAME}">

	    	</div>

	    </div>

	    <div class="form-group">

	    	<div class="input-group">

	    	  	<span class="input-group-addon">{L_3500_1015907}</span>

	    	    <input type="text" name="email" class="form-control" value="{EMAIL}">

	    	</div>

	    </div>

    	<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-envelope"></span> {L_3500_1016002}</button>

    </div>

</form>

<!-- ELSE -->

<div class="alert alert-success" role="alert">{L_3500_1016001}</div>

<!-- ENDIF -->

