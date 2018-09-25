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
	<div class="container-fluid">
	  	<div class="row-fluid">
			<table class="table table-condensed table-striped table-bordered">
				<tbody>
					<!-- BEGIN conditions -->
				  	<tr>    
				      	<td><b>{conditions.ITEM_CONDITION}</b></td>
				     	<td>{conditions.CONDITION_DESC}</td>
					</tr>
					<!-- END conditions -->   
				</tbody>
			</table>
			<div style="text-align:center">
				<button class="btn btn-primary" data-dismiss="modal" onClick="javascript:parent.$.fancybox.close();">{L_678}</button>
			</div>
		</div>
	</div>
	</body>
</html>
