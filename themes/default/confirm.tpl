<legend>{L_248}</legend>
<div class="col-sm-offset-2 well col-sm-6">
	<!-- IF PAGE eq 'invalid' -->
	<div class="alert alert-info" role="alert">
		<p>{ERROR}</p>
		<hr />
		<a href="{SITEURL}/home" class="btn btn-danger">{L_166}</a>
	</div>
	<!-- ELSEIF PAGE eq 'confirm' -->
	<form name="registration" action="{SITEURL}confirm.php" method="post">
		<p>{L_267}</p>
		<input type="hidden" name="id" value="{USERID}">
		<input type="hidden" name="hash" value="{HASH}">
		<button type="submit" class="btn btn-success" name="action" value="confirm">{L_249}</button>
		<button type="submit" class="btn btn-danger" name="action" value="delete">{L_250}</button>
	</form>
	<!-- ELSEIF PAGE eq 'confirmed' -->
	{L_330}
	<!-- ELSEIF PAGE eq 'refused' -->
	{L_331}
	<!-- ENDIF -->
</div>