<html>
	<head>
		<title>{SITENAME}</title>
		<link rel="stylesheet" type="text/css" href="themes/{THEME}/css/bootstrap.min1.css">
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/{THEME}/css/bootstrap-theme.min.css">
		<script type="text/javascript" src="{SITEURL}loader.php?js={JSFILES}"></script>
		<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="container-fluid" style="padding-top:10px">
		  	<div class="row">
		  		<div class="col-sm-12">
			  		<div class="pull-right"><a class="btn btn-danger btn-sm" href="javascript:parent.$.fancybox.close();"><span class="glyphicon glyphicon-remove"></span> {L_678}</a></div>
			    	<h2>{L_5236}</h2>
			    	<ul class="nav nav-pills nav-inline">
			      		<!-- BEGIN cats -->
			      		<li><a href="viewhelp.php?cat={cats.ID}"><span class="glyphicon glyphicon-search"></span> {cats.CAT}</a></li>
			      		<!-- END cats -->
			    	</ul>
			    </div>
		  	</div>
		</div>
	</body>
</html>

