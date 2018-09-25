<legend>{L_334} {USERNAME}
	<span class="pull-right">
		<a class="btn btn-primary btn-sm" href="{SITEURL}profile.php?user_id={USERID}"><span class="glyphicon glyphicon-user"></span> {L_206}</a> 
		<!-- IF B_AUCTION_ID -->
		<a class="btn btn-info btn-sm" href="{SITEURL}products/{AUCTION_ID}"><span class="glyphicon glyphicon-arrow-left"></span> {L_138}</a>
		<!-- ENDIF -->
	</span>
</legend>
<!-- IF B_SENT -->
<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> {L_337} {USERNAME}</div>
<!-- ELSE -->
<!-- IF ERROR ne '' -->
<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> {ERROR}</div>
<!-- ENDIF -->
<form name="seller" action="email_request.php?user_id={USERID}&username={USERNAME}{AUCTION_ID}" method="post" class="col-sm-offset-1 col-sm-8">
    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign"></span> {L_149} <span class="pull-right"><button type="submit" name="Submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_3500_1015920}</button></span></div>
	{MSG_TEXT}
	<input type="hidden" name="user_id" value="{USERID}">
	<input type="hidden" name="username" value="{USERNAME}">
	<input type="hidden" name="action" value="proceed">
</form>
<!-- ENDIF -->