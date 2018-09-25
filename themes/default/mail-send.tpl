<script type="text/JavaScript">
$(".form1").submit(function () {
    if ($(".to").val() == "") {
        return false;
    }
    if ($(".subject").val() == "") {
        return false;
    }
    if ($(".message").val() == "") {
        return false;
    }
    return true;
});
</script>
<!-- IF B_CONVO -->
<div style="text-align:left;">
  <!-- BEGIN convo -->
  <div style="margin-bottom:10px;" class="{convo.BGCOLOR}"> {convo.MSG} </div>
  <!-- END convo -->
</div>
<legend> {L_349} </legend>
<!-- ENDIF -->
<form name="form1" id="form1" method="post" class="form-horizontal" action="mail.php">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<input type="hidden" name="hash" value="{HASH}">
	<input type="hidden" name="sendto" value="{REPLY_TO}">
	<input type="hidden" name="subject" value="{REPLY_SUBJECT}">
  	<!-- IF B_QMKPUBLIC -->
    <div class="form-group">
      	<label class="checkbox">
      	<input type="checkbox" name="public"{REPLY_PUBLIC}>{L_543} </label>
      	<input type="hidden" name="is_question" value="0">
    </div>
    <!-- ENDIF -->
    <div class="form-group">
      	<label class="col-sm-2 control-label" for="to">{L_241}:</label>
      	<div class="col-sm-10">
        	<p class="form-control-static">{REPLY_TO}</p>
      	</div>
    </div>
    <div class="form-group">
      	<label class="col-sm-2 control-label" for="subject">{L_332}:</label>
      	<div class="col-sm-10">
        	<p class="form-control-static">{REPLY_SUBJECT}</p>
      	</div>
    </div>
    <div class="form-group">
      	<label class="col-sm-2 control-label" for="message">{L_333}:</label>
      	<div class="col-sm-10">
        	{REPLYBX}
      	</div>
    </div>
   	<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-envelope"></span> {L_3500_1015942}</button>
</form>
<hr>
