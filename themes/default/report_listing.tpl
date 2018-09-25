<legend>{L_3500_1015938} <span class="pull-right"><a class="btn btn-primary btn-sm" href="{SITEURL}products/{SEO_TITLE}-{ID}"><span class="glyphicon glyphicon-arrow-left"></span> {L_138}</a></span></legend>

<!-- IF EMAILSENT eq '' -->

<div class="alert alert-success" role="alert">

  	<p><b>{L_059} </b></p>

 	<p><b>{L_3500_1015939}</b></p>

</div>

<!-- ELSE -->

<form class="form-horizontal" name="adminmail" action="report_listing.php" method="post">

 	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

 	<input type="hidden" name="id" value="{ID}"> 

    <input type="hidden" name="action" value="sendmail">

   	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}"> 

	<!-- IF CANT_REPORT eq 0 -->

	<div class="alert alert-danger" role="alert"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {L_3500_1015887}</strong> {L_1437}

		<p>{L_REQUIRED}</p>

	</div>

	<!-- IF ERROR ne '' -->

	<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

	<!-- ENDIF -->

	<div class="form-group">

		<label class="col-sm-2 control-label">{L_1431}</label>

		<div class="col-sm-10">

			<p class="form-control-static">{TITLE} - ({L_1432} {ID})</p>

			<input type="hidden" name="title" size="50" value="{TITLE}">

            <input type="hidden" name="id" size="50" value="{ID}">

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-2 control-label"><img src="{PIC_URL1}" align="center"></label>

		<div class="col-sm-10">

			<p class="form-control-static">

				<b>{L_1415} </b>{SELLER_NICK} <br /><br />

            	<input type="hidden" name="seller_nick" size="50" value="{SELLER_NICK}">

            	<input type="hidden" name="seller_id" size="50" value="{SELLER_ID}">

            	<b>{L_1414}{SELLER_ID}</b>

			</p>

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-2 control-label">{L_1416}</label>

		<div class="col-sm-10">

			<p class="form-control-static">{SENDER_NICK}</p>

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-2 control-label">{L_ASTERIX} {L_1428}</label>

		<div class="col-sm-10">

			<div data-content="{L_1430}" data-original-title="{L_1428}" data-trigger="hover" rel="popover" class="input-group">{REPORT_REASONS_LIST}</div>

		</div>

	</div>

	<div class="form-group">

		<label class="col-sm-2 control-label">{L_ASTERIX} {L_1429}</label>

		<div class="col-sm-10">

			<textarea name="sender_comment" rows="5" class="form-control">{COMMENT}</textarea>

		</div>

	</div>

	<div align="center">{CAPCHA}</div><br>

	<hr>

	<div align="center">

		<button type="submit" class="btn btn-success btn-sm">{L_1410}</button>

       	<button type="reset" class="btn btn-success btn-sm">{L_5190}</button>

     </div>

     <!-- ENDIF -->

</form>

 <!-- ENDIF -->





