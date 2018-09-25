<html>

<head>

<title>{SITENAME}</title>

<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/bootstrap.min1.css">

<script type="text/javascript" src="{SITEURL}loader.php?js={JSFILES}"></script>

<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>

<script type="text/javascript" src="{SITEURL}js/google_converter.js"></script>

</head>

<body>

<div class="container-fluid">

  	<legend> {L_085}</legend>

  	<form name="form1" method="post" action="" class="form-horizontal">

    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

    	<div id="results" class="alert alert-info">{CONVERSION}</div>

    	<div class="form-group">

    		<label for="amount" class="col-sm-2 col-xs-2 control-label">{L_082}</label>

    		<div class="col-sm-10 col-xs-4">

    			<input type="text" class="form-control" name="amount" id="amount" value="{AMOUNT}">

    		</div>

    	</div>

    	<div class="form-group">

    		<label for="fromCurrency" class="col-sm-2 col-xs-4 control-label">{L_083}</label>

    		<div class="col-sm-10 col-xs-8">

	    		<select name="fromCurrency" class="form-control" id="fromCurrency">

	      			<!-- BEGIN from -->

	      			<option value="{from.VALUE}"<!-- IF from.B_SELECTED -->selected="true"<!-- ENDIF -->>({from.VALUE}) {from.NAME}    </option>

	      			<!-- END from -->

	    		</select>

    		</div>

    	</div>

    	<div class="form-group">

    	<label for="toCurrency" class="col-sm-2 col-xs-4 control-label">{L_088}</label>

    		<div class="col-sm-10 col-xs-8">

	    		<select name="toCurrency" class="form-control" id="toCurrency">

	      			<!-- BEGIN to -->

	      			<option value="{to.VALUE}"<!-- IF to.B_SELECTED -->selected="true"<!-- ENDIF -->>({to.VALUE}) {to.NAME}</option>

	      			<!-- END to -->

	    		</select>

    		</div>

    	</div>

    	<hr>

    	<button type="button" class="btn btn-success btn-sm" name="convert" id="convert"><span class="glyphicon glyphicon-search"></span> {L_25_0176}</button>

    	<button type="button" onClick="parent.jQuery.fancybox.close();" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> {L_678}</button>

	</form>

</div>

</body>

</html>

