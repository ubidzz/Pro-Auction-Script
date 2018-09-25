<legend>{L_496}</legend>

<!-- IF ERROR ne '' -->

<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->

<div class="form-horizontal">

<!-- IF B_NOTBOUGHT -->

<form action="{SITEURL}buy_now.php?id={ID}" method="post">

  	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

  	<!-- ENDIF -->

  	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_017}:</label>

  		<div class="col-sm-10">

  			<p class="form-control-static">{TITLE}</p>

  		</div>

  	</div>

  	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_125}:</label>

  		<div class="col-sm-10">

  			<p class="form-control-static">{SELLER} {SELLERNUMFBS} {FBICON}</p>

  		</div>

  	</div>

  	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_497}:</label>

  		<div class="col-sm-10">

  			<p class="form-control-static"><!-- IF B_DIGITAL_ITEM -->{BN_PRICE}<!-- ELSE -->{DIGITAL_ITEM_TOTAL}<!-- ENDIF --></p>

  		</div>

  	</div>

  	<!-- IF B_NOTBOUGHT -->

  	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_284}:</label>

  		<div class="col-sm-10">

  			<!-- IF B_QTY -->

  			<input type="text" name="qty" maxlength="15" class="form-control col-sm-4">

  			<span class="input-group-addon">{LEFT} {L_5408}</span>

  			<!-- ELSE -->

  			<p class="form-control-static">1</p>

  			<input type="hidden" name="qty" value="1">

  			<!-- ENDIF -->

  		</div>

  	</div>

  	<!-- IF B_SHIPPING -->

	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_column_shipping}:</label>

  		<div class="col-sm-10">

  			<p class="form-control-static">{SHIPPING}</p>

  		</div>

  	</div>

	<!-- ENDIF -->

	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_003}:</label>

  		<div class="col-sm-10">

  			<p class="form-control-static">{YOURUSERNAME}</p>

  		</div>

  	</div>

  	<!-- IF B_USERAUTH -->

  	<div class="form-group">

  		<label class="col-sm-2 control-label">{L_004}:</label>

  		<div class="col-sm-4">

  			<input type="password" name="password" class="form-control" maxlength="65">

  		</div>

  	</div>

  	<!-- ENDIF -->

  	<div class="form-actions">

    	<input type="hidden" name="action" value="buy">

    	<button type="submit" class="btn btn-success btn-sm col-sm-offset-2"><span class="glyphicon glyphicon-ok"></span> <!-- IF B_FREEITEMS -->{L_3500_1015747}<!-- ELSE -->{L_496}<!-- ENDIF --></button>

  	</div>

</form>

<!-- ELSE -->

	<!-- IF B_FREEITEMS -->

		<!-- IF B_DIGITAL_ITEM_TOTAL -->

			<a class="btn btn-success btn-sm col-sm-offset-2" href="{SITEURL}my_downloads.php"><span class="glyphicon glyphicon-ok"></span> {L_3500_1015750}</a>

		<!-- ELSE -->

			<a href="{SITEURL}buying.php" class="btn btn-success btn-sm col-sm-offset-2"><span class="glyphicon glyphicon-ok"></span> {L_3500_1015749}</a>

		<!-- ENDIF -->

	<!-- ELSE -->

		  <form method="post" action="{SITEURL}{PAY_LINK}">

		    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

		    <input type="hidden" name="pfval" value="{WINID}">

		    <button type="submit" class="btn btn-success btn-sm col-sm-offset-2"><span class="glyphicon glyphicon-ok"></span> {L_756}</button>

		  </form>

	<!-- ENDIF -->

<!-- ENDIF -->

</div>

