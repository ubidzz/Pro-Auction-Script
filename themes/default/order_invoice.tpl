<!DOCTYPE html>

<html dir="{DOCDIR}" lang="{LANGUAGE}">

	<head>
		<title>{SITENAME} - {L_text_packingslip}</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="icon" type="image/ico" href="{SITEURL}uploaded/logos/favicon/favicon.ico">
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/default/css/bootstrap.min1.css">
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/default/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/default/css/bootstrap-theme.min.css">
		
		<link type="text/css" rel="stylesheet" media="print" href="{SITEURL}themes/default/css/bootstrap.min1.css">
		<link type="text/css" rel="stylesheet" media="print" href="{SITEURL}themes/default/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="print" href="{SITEURL}themes/default/css/bootstrap-theme.min.css">
		
		<script type="text/javascript" src="{SITEURL}js/jquery.js"></script>
		<script type="text/javascript" src="{SITEURL}themes/default/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{SITEURL}themes/default/js/plugins.js"></script>
		<style>
			@media print {
				a[href]:after {
			    	content: none !important;
			  	}
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-6">{LOGO}</div>
				<div class="col-xs-6">
					<br />
					<div class="panel panel-default">
						<table class="table table-condensed table-bordered table-striped">
							<tbody>
								<tr>
									<th>{L_1041}</th>
									<td>{ID}</td>
								</tr>
								<tr>
									<th>{L_113}</th>
									<td>{AUCTION_ID}</td>
								</tr>
								<tr>
									<th>{L_1043}</th>
									<td>{INVOICE_DATE}</td>
								</tr>
								<tr>
									<th>{L_560}</th>
									<td>{STATUS}</td>
								</tr>
								<tr align="center" class="hidden-print">
									<td colspan="2" ><button id="printButton" class="btn btn-xs btn-success hidden-print" type="button" onClick="window.print()"><i class="fa fa-print" aria-hidden="true"></i> {L_3500_1016038}</button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading"><i class="fa fa-gavel" aria-hidden="true"></i> <strong>{L_431}</strong></div>
						<table class="table table-condensed table-bordered table-striped">
							<tbody>
								<tr>
									<th>{L_3500_1016036}</th>
									<th>{L_25_0012}</th>
									<th>{L_1045}</th>
									<th>{L_893}</th>
								</tr>
								<!-- BEGIN fees -->
								<tr>
									<td>{fees.FEE}</td>
									<td><b>{fees.UNIT_PRICE}</b></td>
									<td><b>{fees.UNIT_PRICE_WITH_TAX}</b></td>
									<td><b>{fees.TOTAL_WITH_TAX}</b></td>
								</tr>
								<!-- END fees -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-sm-5 pull-right">
					<div class="panel panel-default">
						<table class="table table-condensed table-bordered table-striped">
							<tbody>
								<tr>
						            <th>{L_1050}</th>
									<td>{TOTAL_SUM}</td>
						        </tr>
								<tr>
						            <th>{TAX}</th>
									<td>{VAT_TOTAL}</td>
								</tr>
						        <tr>
								    <th>{L_1053}</th>
									<td>{TOTAL}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>