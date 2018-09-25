<!DOCTYPE html>

<html dir="{DOCDIR}" lang="{LANGUAGE}">

	<head>
	
		<title>{L_text_packingslip}</title>
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="icon" type="image/ico" href="{SITEURL}uploaded/logos/favicon/{FAVICON}">
		
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/{THEME}/css/bootstrap.min1.css">
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/default/css/font-awesome.min.css">
		<link type="text/css" rel="stylesheet" media="screen" href="{SITEURL}themes/{THEME}/css/bootstrap-theme.min.css">
		
		<link rel="stylesheet" type="text/css" media="print" href="{SITEURL}themes/{THEME}/css/bootstrap-theme.min.css">
		<link type="text/css" rel="stylesheet" media="print" href="{SITEURL}themes/default/css/font-awesome.min.css">
		
		<script type="text/javascript" src="{SITEURL}loader.php?js={JSFILES}"></script>
		<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/plugins.js"></script>
		<script type="text/javascript" src="{SITEURL}js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
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
		
				<div class="col-sm-12">
		
					{LOGO}
		
					<legend>{L_text_packingslip}</legend>
					<div class="alert alert-success" role="alert"><i class="fa fa-handshake-o" aria-hidden="true"></i> {L_entry_thankyou}</div>
		
				</div>
		
				<div class="col-sm-6 col-xs-6">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>{L_text_to}</strong></div>				
						<table class="table table-condensed table-bordered table-striped">
							<tbody>
								<!-- BEGIN seller -->
									<tr>
										<th>{L_302}</th>
										<td>{seller.NAME}</td>
									</tr>
									<tr>
										<th>{L_009}</th>
										<td>{seller.ADDRESS}</td>
									</tr>
									<tr>
										<th>{L_010}</th>
										<td>{seller.CITY}</td>
									</tr>
									<tr>
										<th>{L_011}</th>
										<td>{seller.PROV}</td>
									</tr>
									<tr>
										<th>{L_012}</th>
										<td>{seller.POSTCODE}</td>
									</tr>
									<tr>
										<th>{L_014}</th>
										<td>{seller.COUNTRY}</td>
									</tr>
									<tr>
										<th>{L_3500_1015907}</th>
										<td>{seller.EMAIL}</td>
									</tr>
								<!-- END seller -->
							</tbody>
						</table>
					</div>
				</div>
		
				<div class="col-sm-6 col-xs-6">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>{L_text_ship_to}</strong></div>				
						<table class="table table-condensed table-bordered table-striped">
							<tbody>
								<!-- BEGIN winner -->
									<tr>
										<th>{L_302}</th>
										<td>{winner.NAME}</td>
									</tr>
									<tr>
										<th>{L_009}</th>
										<td>{winner.ADDRESS}</td>
									</tr>
									<tr>
										<th>{L_010}</th>
										<td>{winner.CITY}</td>
									</tr>
									<tr>
										<th>{L_011}</th>
										<td>{winner.PROV}</td>
									</tr>
									<tr>
										<th>{L_012}</th>
										<td>{winner.POSTCODE}</td>
									</tr>
									<tr>
										<th>{L_014}</th>
										<td>{winner.COUNTRY}</td>
									</tr>
									<tr>
										<th>{L_3500_1015907}</th>
										<td>{winner.EMAIL}</td>
									</tr>
								<!-- END winner -->
							</tbody>
						</table>
					</div>
				</div>
		
				<div class="col-sm-12 table-responsive">
		
					<table class="table table-striped table-bordered">
		
						<tbody>
		
							<tr>
		
								<th>{L_text_auction_id}</th>
		
								<th>{L_text_date_added}</th>
		
								<th>{L_entry_shipping_method}</th>
		
								<th>{L_entry_payment_method}</th>
		
								<th>{L_3500_1015908}</th>
		
							</tr>
		
							<tr>
		
								<td>{AUCTION_ID}</td>
		
								<td>{CLOSING_DATE}</td>
		
								<td>{SHIPPING_METHOD}</td>
		
								<td>{PAYMENT_METHOD}</td>
		
								<td>{PAYMENTSTATUS}</td>
		
							</tr>
		
						</tbody>
		
					</table>
		
					<table class="table table-striped table-bordered">
		
						<tbody>
		
							<tr>
		
								<th colspan="5">
		
									{L_column_product}
		
									<!-- IF B_DIGITAL -->
		
									<a href="{DOWNLOAD}" class="btn btn-info btn-xs pull-right hidden-print"><span class="glyphicon glyphicon-download"></span> {L_350_10177}</a>
		
									<!-- ENDIF -->
		
									<button name="print" class="btn btn-success btn-xs pull-right hidden-print" onClick="window.print()"><span class="glyphicon glyphicon-print"></span> {L_3500_1015822}</button>
		
								</th>
		
							</tr>
		
							<tr>
		
								<th>{L_624}</th>
		
								<th>{L_284}</th>
		
								<th>{L_457}</th>
		
								<th>{L_30_0110}</th>
		
								<th>{L_893}</th>
		
							</tr>
		
							<tr>
		
								<td>{AUCTION_TITLE}<br>{SUBTITLE}</td>
		
								<td>
		
							        {ITEM_QUANTITY}&nbsp;x
		
								</td>
		
								<td>{BIDF}</td>
		
								<td>
		
									{SHIPPING}
		
									<br>{ADDITIONAL_SHIPPING_COST}
		
								</td>
		
								<td>
		
									<!-- IF B_DUCH-->
		
									{L_350_562}: {DTOTAL}
		
									<!-- ENDIF -->
		
									<!-- IF B_STANDARD -->
		
									<!-- IF B_BUY_NOW_ONLY -->
		
									{L_350_562}: {ATOTAL}
		
									<!-- ELSE -->
		
									{L_350_562}: {TOTAL}
		
									<!-- ENDIF -->
		
									<!-- ENDIF -->
		
									<!-- IF B_DIGITAL -->
		
									{L_350_562}: {BIDF}
		
									<!-- ENDIF -->
		
								</td>
		
							</tr>
		
						</tbody>
		
					</table>
		
				</div>
		
			</div>
		
		</div>
	
	</body>

</html>