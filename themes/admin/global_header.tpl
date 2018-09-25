<!DOCTYPE html>

<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->

<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->

<!--[if IE 8]>    <html class="lt-ie9" lang="{LANGUAGE}" dir="{DOCDIR}"> <![endif]-->

<!--[if gt IE 8]><!--><html lang="{LANGUAGE}" dir="{DOCDIR}"><!--<![endif]-->

<head>

	<meta charset="{CHARSET}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{L_3500_1015826} - {PAGETITLE}</title>

    <link rel="icon" type="image/ico" href="{SITEURL}{FAVICON}"/>

    <link href="{SITEURL}themes/{ADMIN_THEME}/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

	<link rel="stylesheet" href="{SITEURL}themes/{ADMIN_THEME}/css/AdminLTE.min.css">

	<link rel="stylesheet" href="{SITEURL}themes/{ADMIN_THEME}/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="{SITEURL}themes/{ADMIN_THEME}/css/morris.css">

    <script type="text/javascript" src="{SITEURL}loader.php?js=js/jquery.js{EXTRAJS}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

	<!--[if lt IE 9]>

		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

	  	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->

    <script src="{SITEURL}themes/{ADMIN_THEME}/js/morris.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>

	<script src="{SITEURL}themes/{ADMIN_THEME}/js/jquery.min.js"></script>

	<script src="{SITEURL}themes/{ADMIN_THEME}/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="{SITEURL}includes/plugins/ckeditor/ckeditor.js"></script>

	<script src="{SITEURL}themes/{ADMIN_THEME}/js/app.min.js"></script>

	<script src="{SITEURL}themes/{ADMIN_THEME}/js/slimscroll.min.js"></script>

	<script src="{SITEURL}themes/{ADMIN_THEME}/js/demo.js"></script>

	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

	<script type="text/javascript">

	    jQuery(document).ready(function() {

	        jQuery('[rel=popover]').popover();

	    });

	</script>

	<script>

	  	$.widget.bridge('uibutton', $.ui.button);

	</script>

	<script type="text/javascript">

		$(document).ready(function() {

			$("#deleteall").click(function() {

				var checked_status = this.checked;

		        $("input[id=delete]").each(function()

		        { 

		        	this.checked = checked_status;

		        	if($(this).is(':checked'))

		        	{

		        		$(this).attr('checked',true)

		        	}

		        	else

		        	{

		            	$(this).attr('checked',false)

		            }

		        });	

			});

			$("#yesall").click(function() {

				var checked_status = this.checked;

		        $("input[id=yes]").each(function()

		        { 

		        	this.checked = checked_status;

		        	if($(this).is(':checked'))

		        	{

		        		$(this).attr('checked',true)

		        	}

		        });	

			});

			$("#noall").click(function() {

				var checked_status = this.checked;

		        $("input[id=no]").each(function()

		 		{ 

		    		this.checked = checked_status;

		      		if($(this).is(':checked'))

		       		{

		       			$(this).attr('checked',true)

		 	   		}

				});	

			});

		});

	</script>

</head>

<body class="skin-blue fixed sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

	    	<a href="{SITEURL}{ADMIN_FOLDER}/index.php" class="logo">

		      	<span class="logo-mini"><b>ACP</b></span>

		      	<span class="logo-lg">{L_3500_1015826}</span>

		    </a>

			<nav class="navbar navbar-static-top" role="navigation">

	      		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

	        		<span class="sr-only">Toggle navigation</span>

	      		</a>

			  	<div class="navbar-custom-menu">	        

				 	<ul class="nav navbar-nav">

				    	<li class="dropdown notifications-menu">

							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-warning"></i></a>

							<ul class="dropdown-menu">

								<li class="header">{L_3500_1015842}</li>

								<li>

									<ul class="menu">

										<li><a href="{SITEURL}{ADMIN_FOLDER}/errorlog.php"><i class="fa fa-warning text-red"></i> {L_891}</a></li>

										<li><a href="{SITEURL}{ADMIN_FOLDER}/cronlog.php"><i class="fa fa-warning text-yellow"></i> {L_3500_1015588}</a></li>

									</ul>

								</li>

							</ul>

						</li>

						<li><a href="{SITEURL}" target="_blank"><i class="fa fa-eye"></i> {L_3500_1015516}</a></li>

						<li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>

					</ul>

				</div>

			</nav>

		</header>

	  	<aside class="main-sidebar">

	    	<section class="sidebar">

			    <div class="user-panel">

			    	<div class="pull-left image">

			    		<img src="{SITEURL}themes/{ADMIN_THEME}/images/administrator.png" class="img-circle" alt="User Image">

			    	</div>

			        <div class="pull-left info">

			          <p>{L_200}</p>

			          <p>{ADMIN_USER}</p>

			        </div>

			 	</div>

				<ul class="sidebar-menu">

					<li class="header">{L_3500_1015839}</li>

					<li><a href="{SITEURL}{ADMIN_FOLDER}/index.php"><i class="fa fa-home"></i><span>{L_166}</span></a></li>

					<li class="treeview">

						<a href="#"><i class="fa fa-gears"></i><span>{L_5139}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/settings.php"> {L_526}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/auctions.php">{L_5087}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/minetype.php">{L_3500_1015778}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/displaysettings.php">{L_788}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/usersettings.php">{L_894}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/errorhandling.php">{L_409}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/countries.php">{L_081}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/payments.php">{L_075}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/durations.php">{L_069}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/increments.php">{L_128}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/membertypes.php">{L_25_0169}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/currency.php">{L_5004}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/time.php">{L_344}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/buyitnow.php">{L_3500_1015728}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/defaultcountry.php">{L_5322}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/counters.php">{L_2__0057}</a></li>

					    	<li><a href="{SITEURL}{ADMIN_FOLDER}/metatags.php">{L_25_0178}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/contactseller.php">{L_25_0216}</a></li>

					    	<li><a href="{SITEURL}{ADMIN_FOLDER}/buyerprivacy.php">{L_236}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-flag"></i><span>{L_3500_1016014}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/newlanguage.php">{L_3500_1016009}</a></li>

							<li><a href="{SITEURL}{ADMIN_FOLDER}/editlangemails.php">{L_3500_1016017}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/translatelanguage.php">{L_3500_1016008}</a></li>

					       	<li><a href="{SITEURL}{ADMIN_FOLDER}/multilingual.php">{L_2__0002}</a></li>

						</ul>

					</li>



					<li class="treeview">

						<a href="#"><i class="fa fa-bars"></i><span>{L_3500_1015421}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/catsorting.php">{L_25_0146}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/categories.php">{L_078}</a></li>

					       	<li><a href="{SITEURL}{ADMIN_FOLDER}/categoriestrans.php">{L_132}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-bank"></i><span>{L_25_0012}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/fees.php">{L_25_0012}</a></li>

				         	<li><a href="{SITEURL}{ADMIN_FOLDER}/fee_gateways.php">{L_445}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/enablefees.php">{L_395}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/accounts.php">{L_854}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/invoice_settings.php">{L_1094}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/invoice.php">{L_766}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/tax.php">{L_1088}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/tax_levels.php">{L_1083}</a></li>

						</ul>

					</li>

					<li><a href="{SITEURL}{ADMIN_FOLDER}/theme.php"><i class="fa fa-image"></i>{L_26_0002}</a></li>
					
					<li class="treeview">

						<a href="#"><i class="fa fa-fa fa-bullhorn"></i><span>{L_25_0011}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/banners.php">{L_5205}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/managebanners.php">{L__0008}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-question"></i><span>{L_3500_1015963}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/admin_support.php">{L_3500_1015432}</a></li>

				         	<li><a href="{SITEURL}{ADMIN_FOLDER}/live_chat.php">{L_3500_1015949}</a></li>

						</ul>

					</li>



					<li class="treeview">

						<a href="#"><i class="fa fa-user"></i><span>{L_25_0010}</span></a>

						<ul class="treeview-menu">

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/listusers.php">{L_045}</a></li>

					       	<li><a href="{SITEURL}{ADMIN_FOLDER}/useractivity.php">{L_350_10210}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/usergroups.php">{L_448}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/profile.php">{L_048}</a></li>

					       	<li><a href="{SITEURL}{ADMIN_FOLDER}/activatenewsletter.php">{L_25_0079}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/newsletter.php">{L_607}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/banips.php">{L_2_0017}</a></li>

					  		<li><a href="{SITEURL}{ADMIN_FOLDER}/newadminuser.php">{L_367}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/adminusers.php">{L_525}</a></li>

						</ul>

					</li>

					<li><a href="{SITEURL}{ADMIN_FOLDER}/security.php"><i class="fa fa-lock"></i><span>{L_3500_1015543}</span></a></li>

					<li class="treeview">

						<a href="#"><i class="fa fa-bug"></i><span>{L_3500_1015418}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/spam.php">{L_749}</a></li>

				     		<li><a href="{SITEURL}{ADMIN_FOLDER}/email_block.php">{L_3500_1015416}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-commenting-o"></i><span>{L_5030}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/boardsettings.php">{L_5047}</a></li>

							<li><a href="{SITEURL}{ADMIN_FOLDER}/newboard.php">{L_5031}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/boards.php">{L_5032}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-legal"></i><span>{L_239}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/listauctions.php">{L_067}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/listclosedauctions.php">{L_214}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/listsuspendedauctions.php">{L_5227}</a></li>

					    	<li><a href="{SITEURL}{ADMIN_FOLDER}/reportreasons.php">{L_1406}</a></li>

					  		<li><a href="{SITEURL}{ADMIN_FOLDER}/listreportedauctions.php">{L_1400}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-info-circle"></i><span>{L_5236}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/faqscategories.php">{L_5230}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/newfaq.php">{L_5231}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/faqs.php">{L_5232}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-info"></i><span>{L_25_0018}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/news.php">{L_516}</a></li>

					       	<li><a href="{SITEURL}{ADMIN_FOLDER}/aboutus.php">{L_5074}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/terms.php">{L_5075}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/privacypolicy.php">{L_402}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/cookiespolicy.php">{L_30_0233}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-line-chart"></i><span>{L_25_0023}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/stats_settings.php">{L_3500_1015768}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/viewaccessstats.php">{L_5143}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/viewbrowserstats.php">{L_5165}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/viewplatformstats.php">{L_5318}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/viewbotstats.php">{L_3500_1015742}</a></li>

						</ul>

					</li>

					<li class="treeview">

						<a href="#"><i class="fa fa-wrench"></i><span>{L_5436}</span></a>

						<ul class="treeview-menu">

							<li><a href="{SITEURL}{ADMIN_FOLDER}/checkversion.php">{L_25_0169a}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/maintainance.php">{L__0001}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/wordsfilter.php">{L_5068}</a></li>

					       	<li><a href="{SITEURL}{ADMIN_FOLDER}/errorlog.php">{L_891}</a></li>

					      	<li><a href="{SITEURL}{ADMIN_FOLDER}/cronlog.php">{L_3500_1015588}</a></li>

					     	<li><a href="{SITEURL}{ADMIN_FOLDER}/help.php">{L_148}</a></li>

						</ul>

					</li>

				</ul>

			</section>

		</aside>

		<div class="content-wrapper">

			<section class="content">

				<div class="row">

					<div class="col-sm-12">

						<!-- IF SUPPORTMESSAGE -->

						<div class="alert alert-warning alert-dismissible">

							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

							<h4><i class="icon fa fa-warning"></i>{MESSAGES} <a href="{SITEURL}{ADMIN_FOLDER}/admin_support.php">{L_3500_1015439p}</a></h4>

						</div>

						<!-- ENDIF -->
						
						<div class="alert alert-warning alert-dismissible">

							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

							<h4><i class="icon fa fa-warning"></i>{DONATE}</h4>

						</div>

						<!-- IF WARNINGREPORT -->

						<div class="alert alert-danger alert-dismissible">

							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

							<h4><i class="icon fa fa-ban"></i>

								{L_3500_1015581}

						        <ul>

						            <li>{WARNINGMESSAGE}</li>

						        </ul>

					        </h4>

				     	</div>

						<!-- ENDIF -->

						<!-- IF THIS_VERSION eq REALVERSION -->

						<div class="alert alert-success alert-dismissible">

							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

							<h4><i class="icon fa fa-check"></i>{L_30_0212}</h4>

						</div>

						<!-- ELSE -->

						<div class="alert alert-danger alert-dismissible">

							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

							<h4><i class="icon fa fa-ban"></i>{L_30_0211}</h4>

						</div>

						<!-- ENDIF -->
						