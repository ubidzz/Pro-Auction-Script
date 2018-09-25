<link rel="stylesheet" type="text/css" href="{SITEURL}themes/{THEME}/css/elastislide.css">

<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/gallery.js"></script>

<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/jquery.tmpl.min.js"></script>

<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="{SITEURL}themes/{THEME}/js/jquery.elastislide.js"></script>



<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	

	<div class="rg-image-wrapper">

		{{if itemsCount > 1}}

			<div class="rg-image-nav">

				<a href="#" class="rg-image-nav-prev">Previous Image</a>

				<a href="#" class="rg-image-nav-next">Next Image</a>

			</div>

		{{/if}}

		<div class="rg-image"></div>

		<div class="rg-loading"></div>

		<div class="rg-caption-wrapper">

			<div class="rg-caption" style="display:none;">

				<p></p>

			</div>

		</div>

	</div>

</script>

<script type="text/javascript">

$(document).ready(function(){

	var deadline = '{ENDS_IN}';

	var ServerTime = '{SERVERTIME}';

	function updateServerTime()

	{

		var startTime = new Date(ServerTime);

		ServerTime = new Date(startTime.setSeconds(startTime.getSeconds() + 1));

	}

	function initializeClock(id, endtime){

  		var clock = document.getElementById(id);

  		var daysSpan = clock.querySelector('.days');

		var hoursSpan = clock.querySelector('.hours');

		var minutesSpan = clock.querySelector('.minutes');

		var secondsSpan = clock.querySelector('.seconds');

  		

  		function updateClock(){

  			var t = getTimeRemaining(endtime);

  			var alert1 = '<div class="col-xs-4 col-sm-5 col-md-3 alert alert-xs alert-danger">';

  			var alert2 = '<div class="col-xs-4 col-sm-5 col-md-3 alert alert-xs alert-success">';

  			var alertEnd = '</div>';

  			daysSpan.innerHTML = t.days;

		    hoursSpan.innerHTML = t.hours;

		    minutesSpan.innerHTML = t.minutes;

		    secondsSpan.innerHTML = t.seconds;

  		 	if(t.days == 0) {

  				div1 = alert1 + t.days + '<br><b>{L_097}</b>' + alertEnd;

  			}else{

  				div1 = alert2 + t.days + '<br><b>{L_097}</b>' + alertEnd;

  			}

  			if(t.days == 0 & t.hours == 0) {

  				div2 = alert1 + t.hours + '<br><b>{L_25_0037}</b>' + alertEnd;

  			}else{

          		div2 = alert2 + t.hours + '<br><b>{L_25_0037}</b>' + alertEnd;

          	}

          	if(t.days == 0 & t.hours == 0 & t.minutes == 0) {

          		div3 = alert1 + t.minutes + '<br><b>{L_25_0032}</b>' + alertEnd;

          	}else{

          		div3 = alert2 + t.minutes + '<br><b>{L_25_0032}</b>' + alertEnd;

          	}

          	if(t.days == 0 & t.hours == 0 & t.minutes == 0 & t.seconds == 0) {

          		div4 = alert1 + t.seconds + '<br><b>{L_25_0033}</b>' + alertEnd;

          	}else{

          		div4 = alert2 + t.seconds + '<br><b>{L_25_0033}</b>' + alertEnd;

          	}

  			if(t.total<=0){

    			clearInterval(timeinterval);

    			clock.innerHTML = '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span> {L_30_0177}</div>';

  			}else{

  				clock.innerHTML = div1 + div2 + div3 + div4;

  			}

		}

		updateClock(); // run function once at first to avoid delay

		var timeinterval = setInterval(updateClock,1000);

	}

	

	function getTimeRemaining(endtime){

		updateServerTime();

  		var t = Date.parse(endtime) - Date.parse(ServerTime);

  		var seconds = Math.floor( (t/1000) % 60 );

  		var minutes = Math.floor( (t/1000/60) % 60 );

  		var hours = Math.floor( (t/(1000*60*60)) % 24 );

  		var days = Math.floor( t/(1000*60*60*24) );

  		return {

    		'total': t,

    		'days': days,

    		'hours': hours,

    		'minutes': minutes,

    		'seconds': seconds

 	 	};

	}

	initializeClock('clockdiv', deadline);

});

</script>

<!-- IF TQTY gt 1 -->

<script type="text/javascript">

$(document).ready(function(){

	$("#qty").keydown(function(){

		$("#bidcost").text(($("#qty").val())*($("#bid").val()) + ' {CURRENCY}');

	});

	$("#bid").keydown(function(){

		$("#bidcost").text(($("#qty").val())*($("#bid").val()) + ' {CURRENCY}');

	});

});

</script>

<!-- ENDIF -->

<div class="breadcrumb">{L_041}: {CATSPATH}</div>

<!-- IF SECCATSPATH ne '' -->

<div class="breadcrumb">{L_814}: {SECCATSPATH}</div>

<!-- ENDIF -->

<!-- IF B_USERBID -->

<div id="bid_message"> {YOURBIDMSG} </div>

<!-- ELSE -->

<div id="bid_message"></div>

<!-- ENDIF -->



<div class="pull-right">

	<!-- IF B_CANEDIT -->

	<a class="btn btn-sm btn-warning" href="{SITEURL}edit_active_auction.php?id={ID}"><span class="glyphicon glyphicon-pencil"></span> {L_30_0069}</a>

	<!-- ENDIF -->

	<!-- IF B_CANCONTACTSELLER -->

	<a class="btn btn-sm btn-success" href="{SITEURL}question/{SEO_TITLE}-{ID}"><span class="glyphicon glyphicon-question-sign"></span> {L_922}</a>

	<!-- ENDIF -->

	<!-- IF B_LOGGED_IN -->

	<a class="btn btn-sm btn-success" href="{SITEURL}item_watch.php?{WATCH_VAR}={ID}"><span class="glyphicon glyphicon-eye-open"></span> {WATCH_STRING}</a>

	<!-- ELSE -->

	<a class="btn btn-sm btn-success" href="{SITEURL}user_login.php?"><span class="glyphicon glyphicon-eye-open"></span> {L_5202}</a>

	<!-- ENDIF -->

	<a class="btn btn-sm btn-success" href="{SITEURL}friend.php?id={ID}"><span class="glyphicon glyphicon-user"></span> {L_106}</a>

	<a class="new-window btn btn-sm btn-success" href="https://www.facebook.com/sharer.php?u={FB_URL}&amp;t={FB_TITLE}{FB_PRICE}" title="{L_350_10167}"><span class="glyphicon glyphicon-bullhorn"></span> {L_350_10167}</a>

	<a class="new-window btn btn-sm btn-success" href="https://twitter.com/home?status={FB_TITLE}-{FB_URL}" title="{L_350_10168}" rel="nofollow" target="_blank"><span class="glyphicon glyphicon-bullhorn"></span> {L_350_10168}</a>

	<a class="new-window btn btn-sm btn-success" href="https://plus.google.com/share?url={FB_URL}" title="{L_350_10169}" target="_blank"><span class="glyphicon glyphicon-bullhorn"></span> {L_350_10169}</a>

</div>

<br /><br /><br />

<div class="col-sm-8">

	<div class="col-xs col-sm-4">

		<img class="img-responsive thumbnail" src="{SITEURL}{PIC_URL}">

		<!-- IF B_GOOGLE_MAP -->

		<br />

		<script src="https://maps.google.com/maps/api/js?key={MAPKEY}"></script>

		<script type="text/javascript">

			var sellZip = '{ZIP}';

			var sellcountry = '{COUNTRY}';

			function initialize() {

			 	geocoder = new google.maps.Geocoder();

			 	var latlng = new google.maps.LatLng(53.3496, -6.3263);

				var mapOptions = { zoom: 9, center: latlng }

				map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

				sellerGeocode();

			}

			function sellerGeocode() {

				geocoder.geocode( { 'address': sellZip, 'country': sellcountry}, function(results, status) 

				{

      				if (status == 'OK') {

        				map.setCenter(results[0].geometry.location);

        				var marker = new google.maps.Marker({

            				map: map,

            				position: results[0].geometry.location

        				});

      				} else {

        					alert('Geocode was not successful for the following reason: ' + status);

      				}

    			});

  			}

    		google.maps.event.addDomListener(window, "load", initialize);

		</script>



		<b>{L_3500_1015810}</b><br>

		<div align="center" id="googleMap" style="width:100%;height:230px;"></div><br>

		<!-- ENDIF -->

	</div>

	<div class="col-xs col-sm-8">

	  	<h3> {TITLE} </h3>

	  	<!-- IF SUBTITLE ne '' -->

	  	<h5>{SUBTITLE}</h5>

	  	<!-- ENDIF -->

		<ul class="nav nav-tabs">

			<li class="active"><a href="#details" data-toggle="tab">{L_3500_1015484}</a></li>

			<li><a href="#shipping" data-toggle="tab" >{L_3500_1015485}</a></li>

			<li><a href="#seller" data-toggle="tab">{L_3500_1015486}</a></li>

			<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">{L_3500_1015487} <b class="caret"></b></a>

				<ul class="dropdown-menu">

					<li><a href="#adi" data-toggle="tab">{L_3500_1015491}</a></li>

					<!-- IF B_SHOWHISTORY -->

					<li><a href="#history" data-toggle="tab">{L_3500_1015490}</a></li>

					<!-- ENDIF -->

					<!-- IF B_CONDITION -->

					<li><a href="#Item_Condition" data-toggle="tab">{L_3500_1015488}</a></li>

					<!-- ENDIF -->

				</ul>

			</li>

		</ul>

		<div class="tab-content">

			<div class="tab-pane fade in active" id="details">

				<div class="panel panel-primary">

					<div class="panel-heading">{L_3500_1015484}</div>

					<div class="panel-body">

						<!-- IF B_FREE_ITEM eq ''-->

						<!-- IF B_NOTBNONLY -->

				  		<div class="alert alert-success" role="alert">

				  			<div id="current_bid"><span class="glyphicon glyphicon-ok"></span> <b>{L_116}:</b> {MAXBID} <!-- IF B_HASRESERVE -->({L_514})<!-- ENDIF --></div>

				  			<small id="no_of_bids">{L_119}: {NUMBIDS} {VIEW_HISTORY2}</small></div>

						<!-- ENDIF -->

						<!-- ENDIF -->

						<!-- IF B_HASENDED eq false -->

						<!-- IF B_FREE_ITEM -->

						<div class="alert alert-success" role="alert">

							<span class="glyphicon glyphicon-save"></span> <b>{L_3500_1015745}:</b> <a style="cursor:pointer" class="btn btn-success btn-xs" href="{SITEURL}buy_now.php?id={ID}"><span class="glyphicon glyphicon-save"></span> {L_3500_1015747}!</a>

				  		</div>

				  		<!-- ENDIF -->

				  		<!-- IF B_BUY_NOW -->

				  		<div class="alert alert-success" role="alert">

							<span class="glyphicon glyphicon-shopping-cart"></span> <b>{L_496}:</b> {BUYNOW} <a style="cursor:pointer" class="btn btn-success btn-xs" href="{SITEURL}buy_now.php?id={ID}"><span class="glyphicon glyphicon-shopping-cart"></span> {L_350_1015402}!</a>

				  		</div>

				  		<!-- ENDIF -->

				  		<!-- ENDIF -->

				  		<!-- IF B_NOTBNONLY -->

				  		<!-- IF ATYPE eq 2 -->

				  		<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> {L_038}: {MINBID}</div>

				  		<!-- ENDIF -->

				 	 	<!-- ENDIF -->

				  		<!-- IF B_HASBUYER -->

				  		{L_117}:

				  		<!-- BEGIN high_bidders -->

				  		<!-- IF B_BIDDERPRIV -->

				  		<b>{high_bidders.BUYER_NAME}</b>

				  		<!-- ELSE -->

				  		<a href="{SITEURL}profile.php?user_id={high_bidders.BUYER_ID}&auction_id={ID}"><b>{high_bidders.BUYER_NAME}</b></a> <b>(<a href="{SITEURL}feedback.php?id={high_bidders.BUYER_ID}&faction=show">{high_bidders.BUYER_FB}</a>)</b>

				  		<!-- ENDIF -->

				  		{high_bidders.BUYER_FB_ICON}<br />

				  		<!-- END high_bidders -->

				  		<!-- ENDIF -->

				  		{L_023}: {SHIPPING_COST}<br />

				  		{L_026}: {PAYMENTS} <br />

				  		{L_611} {AUCTION_VIEWS} {L_612}<br />

				  		<div align="center">

				  			<!-- IF B_HASENDED -->

				  			<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {L_30_0177}</div>

				  			<!-- ELSE -->

				  			<span style="color:red"><b>{L_118}:</b></span><br />

				  			<div id="clockdiv">

				  				<span class="days"></span> 

							    <span class="hours"></span> 

							    <span class="minutes"></span> 

							    <span class="seconds"></span> 

							</div>

				  			<!-- ENDIF -->

				  		</div>

			  		</div>

			  	</div>

			</div>

		  	<div class="tab-pane fade in" id="shipping">

		  		<div class="panel panel-primary">

  					<div class="panel-heading">{L_3500_1015485}</div>

						<table class="table table-condensed table-striped table-bordered">

					  		<tr>

					  			<td width="30%">{L_023}:</td>

					  			<td>{SHIPPING_COST}</td>

					  		</tr>

					  		<!-- IF B_ADDITIONAL_SHIPPING_COST or B_BUY_NOW_ONLY-->

					  		<tr>

					  			<td width="30%">{L_350_1008}:</td>

					  			<td>{ADDITIONAL_SHIPPING_COST}</td>

					  		</tr>

					  		<!-- ENDIF -->

					  		<!-- IF CITY ne '' -->

					  		<tr>

					  			<td width="30%">{L_010}:</td>

					  			<td>{CITY}</td>

					  		</tr>

							<!-- ENDIF -->

					  		<!-- IF COUNTRY ne '' or ZIP ne '' -->

					  		<tr>

					  			<td width="30%">{L_014}:</td>

					  			<td>{COUNTRY} ({ZIP})</td>

					  		</tr>

							<!-- ENDIF -->

							<!-- IF B_SHIPPING_CONDITIONS -->

							<tr>

					  			<td width="30%">{L_025}:</td>

					  			<td>{SHIPPING}, {INTERNATIONAL}</td>

					  		</tr>

					  		<!-- ENDIF -->

					  		<!-- IF B_SHIPPING_TERMS -->

						  		<!-- IF SHIPPINGTERMS ne '' -->

						  		<tr>

						  			<td width="30%">{L_25_0215}:</td>

						  			<td>{SHIPPINGTERMS}</td>

						  		</tr>

						  		<!-- ENDIF -->

					  		<!-- ENDIF -->

					  		<tr>

					  			<td width="30%">{L_025_C}:</td>

					  			<td>{RETURNS}</td>

					  		</tr>

					  	</table>

				</div>

			</div>

		  	<div class="tab-pane fade in" id="adi">

		  		<div class="panel panel-primary">

  					<div class="panel-heading">{L_3500_1015491}</div>

				  		<table class="table table-condensed table-striped table-bordered">

				  			<tr>

				  				<td>{L_113}:</td>

				  				<td>{ID}</td>

				  			</tr>

				  			<!-- auction type -->

				  			<tr>

				  				<td>{L_261}:</td>

				  				<td>{AUCTION_TYPE}</td>

				  			</tr>

				  			<!-- higher bidder -->

				  			<tr>

				  				<td><!-- IF ATYPE eq 1 -->{L_127}<!-- ELSE -->{L_038}<!-- ENDIF -->:</td>

				  				<td>{MINBID}</td>

				  			</tr>

							<tr>

				  				<td>{L_111}:</td>

				  				<td>{STARTTIME}</td>

				  			</tr>

				  			<tr>

				  				<td>{L_112}:</td>

				  				<td>{ENDTIME}</td>

				  			</tr>

				  			<!-- IF QTY gt 1 -->

				  			<tr>

				  				<td>{L_901}:</td>

				  				<td>{QTY}</td>

				  			</tr>

				  			<!-- ENDIF -->

				  			<!-- IF B_HASENDED -->

				  			<tr>

				  				<td>{L_904}</td>

				  				<td>&nbsp;</td>

				  			</tr>

				  			<!-- ENDIF -->

						</table>

				</div>

	  		</div>

			<div class="tab-pane fade in" id="seller">

				<div class="panel panel-primary">

  					<div class="panel-heading">{L_3500_1015485}</div>

  					<div class="panel-body">

						<!-- IF B_SETFSM -->

						<!-- ELSE -->

						<div class="col-sm-12">

							{FSM}

						</div>

						<!-- ENDIF -->

						<div class="col-sm-3 col-xs-4">

							<!-- IF AVATAR ne '' -->

							<img src="{AVATAR}" class="img-responsive">

							<!-- ELSE -->

							<img src="{SITEURL}/uploaded/avatar/default.png" class="img-responsive thumbnail">

							<!-- ENDIF -->

						</div>

						<div class="col-sm-9 col-xs-8">

							<ul class="list-group">

								<li class="list-group-item">

									<a href='{SITEURL}profile.php?user_id={SELLER_ID}&auction_id={ID}'><b>{SELLER_NICK}</b></a> 

				    				 {SELLER_FBICON} 

				    				<!-- IF IS_ONLINE -->

									<img src="{SITEURL}images/online.png">{L_350_10111}

									<!-- ELSE -->

									<img src="{SITEURL}images/offline.png">{L_350_10112}

									<!-- ENDIF -->

								</li>

								<li class="list-group-item"><b>{L_5506}</b> <span class="label label-success">{SELLER_FBPOS}</span></li>

								<li class="list-group-item">

									<b>{L_5509}</b> 

									<a href='{SITEURL}feedback.php?id={SELLER_ID}&faction=show'>

										<span class="label label-success"><u>{SELLER_NUMFB}{L__0151}</u></span>

									</a>

								</li>

								<!-- IF SELLER_FBNEG ne 0 -->

								<li class="list-group-item"><span class="label label-info">{SELLER_FBNEG}</span></li>

								<!-- ENDIF -->

								<li class="list-group-item"><b>{L_5508}</b> {SELLER_REG}</li>

							</ul>

						</div>

						<div class="col-sm-12">

							<div class="form-inline">

								<!-- IF B_CANCONTACTSELLER -->

								<!-- IF B_SETFSM -->

								<div class="form-group">

									<form name="fav" action="{SITEURL}products/{SEO_TITLE}-{ID}" method="post" enctype="multipart/form-data">

								  		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">       	

										<input type="hidden" name="faveseller" value="yes">

										<button type="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> {L_FSM1}</button>

									</form>

								</div>

								<!-- ENDIF -->

								<!-- ENDIF -->

								<div class="form-group">

									<a class="btn btn-sm btn-info" href="{SITEURL}active_auctions.php?user_id={SELLER_ID}"><span class="glyphicon glyphicon-search"></span> {L_213}</a>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="tab-pane fade in" id="history">

	    		<!-- IF B_SHOWHISTORY -->

	    		<div class="panel panel-primary">

  					<div class="panel-heading">{L_3500_1015490}</div>

			      		<table class="table table-condensed table-striped table-bordered">

			        		<tr>

			          			<th width="33%" align="center"><small>{L_176}</small></th>

			          			<th width="33%" align="center"><small>{L_130}</small></th>

			          			<th width="33%" align="center"><small>{L_175}</small></th>

			          			<!-- IF ATYPE eq 2 -->

			          			<th width="33%" align="center"><small>{L_284}</small></th>

			          			<!-- ENDIF -->

			        		</tr>

			        		<!-- BEGIN bidhistory -->

			        		<tr valign="top" {bidhistory.BGCOLOR}>

			          			<td>

			          				<!-- IF B_BIDDERPRIV -->

			            			<small>{bidhistory.NAME}</small>

			            			<!-- ELSE -->

			            			<a href="{SITEURL}profile.php?user_id={bidhistory.ID}"><small>{bidhistory.NAME}</small></a>

			            			<!-- ENDIF -->

			          			</td>

			          			<td align="center"><small>{bidhistory.BID}</small> </td>

			          			<td align="center"><small>{bidhistory.WHEN}</small> </td>

			          			<!-- IF ATYPE eq 2 -->

			          			<td align="center"><small>{bidhistory.QTY}</small> </td>

			          			<!-- ENDIF -->

			        		</tr>

			        		<!-- END bidhistory -->

			      		</table>

			  	</div>

	    		<!-- ENDIF -->

	    	</div>

		</div>

	</div>

</div>

<!-- INCLUDE bid.tpl -->

<div class="col-xs col-sm-12">

	<hr />

	<ul class="nav nav-tabs">

		<li class="active"><a href="#description" data-toggle="tab">{L_018}</a></li>

		<!-- IF B_HASGALELRY -->

		<li><a href="#Photo_Gallery" data-toggle="tab">{L_663}</a></li>

		<!-- IF B_HAS_QUESTIONS -->

		<li><a href="#question" data-toggle="tab">{L_3500_1015489}</a></li>

		<!-- ENDIF -->

		<!-- ENDIF -->

	</ul>

	<div class="tab-content">

		<div class="tab-pane fade in active" id="description">

			<div class="well">

				<h3>{L_018}</h3>

				{AUCTION_DESCRIPTION}

			</div>

		</div>

		<div class="tab-pane tab-pane fade in" id="question">

			<!-- IF B_HAS_QUESTIONS -->

		  	<!-- BEGIN questions -->

		  	<table class="table table-condensed table-striped table-bordered">

		  	<tr>

		  		<td><strong>{L_5239}</strong></td>

		  	</tr>

		  	<!-- BEGIN conv -->

		  	<tr>

		   		<td><strong>{questions.conv.BY_WHO}:</strong> <small>{questions.conv.MESSAGE}</small></td>

		   	</tr>

		   	<!-- END conv -->

		   	</table>

		  	<!-- END questions -->

			<!-- ENDIF -->

		</div>



		<!-- IF B_HASGALELRY -->

		<div class="tab-pane fade in" id="Photo_Gallery">

			<div id="rg-gallery" class="rg-gallery">

				<div class="rg-thumbs">

					<div class="es-carousel-wrapper">

						<div class="es-nav">

							<span class="es-nav-prev">{L_3500_1015527}</span>

							<span class="es-nav-next">{L_3500_1015528}</span>

						</div>

						<div class="es-carousel">

							<ul>

							<!-- BEGIN gallery -->

								<li><a href="#"><img class="img-responsive" src="{gallery.THUMB_V}" data-large="{gallery.V}" data-description="{gallery.NAME}" alt="{gallery.COUNT}"></a></li>

							<!-- END gallery -->

							</ul>

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- ENDIF -->  	

	</div>

</div>

<script type="text/javascript">

setInterval(UpdateBid, 1000);

function UpdateBid()

{

	$('#bid_message').load('{SITEURL}item.php?id={ID}&live=update #bid_message').fadeIn("slow");

	$('#current_bid').load('{SITEURL}item.php?id={ID}&live=update #current_bid').fadeIn("slow");

	$('#current_bid_box').load('{SITEURL}item.php?id={ID}&live=update #current_bid_box').fadeIn("slow");

	$('#next_bid').load('{SITEURL}item.php?id={ID}&live=update #next_bid').fadeIn("slow");

	$('#no_of_bids').load('{SITEURL}item.php?id={ID}&live=update #no_of_bids').fadeIn("slow");

}

</script>