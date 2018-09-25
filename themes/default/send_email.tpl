<script type="text/javascript">

function SubmitFriendForm() {

    document.friend.submit();

}



function ResetFriendForm() {

    document.friend.reset();

}

</script>

<legend> {L_645} <span class="pull-right"><a class="btn btn-primary btn-sm" href="{SITEURL}products/{SEOLINK}-{AUCT_ID}"><span class="glyphicon glyphicon-arrow-left"></span> {L_138}</a></span></legend>

<!-- IF MESSAGE ne '' -->

<div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-ok"></span> {MESSAGE}</div>

<!-- ELSE -->

<!-- IF ERROR ne '' -->

<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->

<form class="form-horizontal" name="sendemail" action="{SITEURL}question/{SEOLINK}-{AUCT_ID}" method="post">

   	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

    <input type="hidden" name="id" value="{AUCT_ID}">

    <input type="hidden" name="action" value="{L_106}">

    <input type="hidden" name="seller_nick" value="{SELLER_NICK}">

    <input type="hidden" name="item_title" value="{ITEM_TITLE}">

 	<div class="form-group">

      	<label for="sellerNick" class="col-sm-2 control-label">{L_125}</label>

    	<div class="col-sm-6">

         	<p id="sellerNick" class="form-control-static">{SELLER_NICK}</p>

     	</div>

   	</div>

  	<div class="form-group">

     	<label for="itemTitle" class="col-sm-2 control-label">{L_017}</label>

     	<div class="col-sm-6">

         	<p id="itemTitle" class="form-control-static">{ITEM_TITLE}</p> 

      	</div>

 	</div>

  	<div class="form-group">

   		<label for="senderName" class="col-sm-2 control-label">{L_002}</label>

  		<div class="col-sm-6">

    	  	<input id="senderName" type="text" class="form-control" name="senderName" value="{YOURUSERNAME}">

  		</div>

   	</div>

   	<!-- IF B_LOGGED_IN eq false -->

 	<div class="form-group">

      	<label for="senderEmail" class="col-sm-2 control-label">{L_006}</label>

        <div class="col-sm-6">

        	<input id="senderEmail" type="text" class="form-control" name="senderEmail" value="">

     	</div>

   	</div>

  	<!-- ENDIF -->

   	<div class="form-group">

      	<label for="senderQuestion" class="col-sm-2 control-label">{L_650}</label>

        <div class="col-sm-6">

          	<textarea id="senderQuestion" class="form-control" name="senderQuestion" cols="35" rows="6">{SELLER_QUESTION}</textarea>

     	</div>

  	</div>

  	<div class="form-group">

  		<div class="col-sm-offset-2 col-sm-10">

  			<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_5201}</button>

  			<button type="reset" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> {L_035}</button>

  		</div>

  	</div>

</form>

<!-- ENDIF -->