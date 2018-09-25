<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend>{L_207}</legend>
  	<!-- IF ERROR ne '' -->
  	<div class="alert"> {ERROR} </div>
  	<!-- ENDIF -->
  	<form name="addfeedback" action="{SITEURL}feedback.php?wid={WID}&sid={SID}&ws={WS}" method="post" class="form-horizontal">
    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
    	<input type="hidden" name="TPL_nick_hidden" value="{USERNICK}">
    	<input type="hidden" name="addfeedback" value="true">
    	<input type="hidden" name="auction_id" value="{AUCT_ID}">
    	<div class="form-group">
    		<label class="col-sm-2 control-label">{L_168}</label>
    		<div class="col-sm-10">
    			<p class="form-control-static"><a href="{SITEURL}products/{SEO_TITLE}-{AUCT_ID}">{AUCT_TITLE}</a></p>
    		</div>
    	</div>
    	<div class="form-group">
    		<label class="col-sm-2 control-label">{SBMSG}:</label>
    		<div class="col-sm-10">
    			<p class="form-control-static"><a href="{SITEURL}profile.php?user_id={THEM}&auction_id={AUCT_ID}">{USERNICK}</a> (<a href="{SITEURL}feedback.php?id={THEM}&faction=show">{USERFB}</a>) {USERFBIMG}</p>
    		</div>
    	</div>
    	<div class="form-group">
    		<label class="col-sm-2 control-label">{L_503}:</label>
    		<div class="col-sm-10">
	    		<div class="radio-inline">
	    			<input type="radio" name="TPL_rate" value="1" {RATE1}> <img src="{SITEURL}images/positive.png"border="0" alt="+1">   
	    		</div>
	    		<div class="radio-inline">
	    			<input type="radio" name="TPL_rate" value="0" {RATE2}> <img src="{SITEURL}images/neutral.png" border="0" alt="0">   
	    		</div>
	    		<div class="radio-inline">
					<input type="radio" name="TPL_rate" value="-1" {RATE3}> <img src="{SITEURL}images/negative.png" border="0" alt="-1">
				</div>
			</div>
    	</div>
    	<div class="form-group">
    		<label class="col-sm-2 control-label">{L_227}:</label>
    		<div class="col-sm-10">
    			<input name="TPL_feedback" type="text" class="form-control" value="{CFEEDBACK}">
    		</div>
    	</div>
    	<!-- IF B_USERAUTH -->
    	<div class="form-group">
    		<label class="col-sm-2 control-label">{L_188}:</label>
    		<div class="col-sm-10">
    			<input type="password" name="TPL_password" value="" class="form-control">
    		</div>
    	</div>
		<!-- ENDIF -->
		<hr>
    	<div class="form-group">
    		<div class="col-sm-12">
    			<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-star"></span> {L_207}</button>
    			<button type="reset" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> {L_5190}</button>
    		</div>
    	</div>
  	</form>
</div>