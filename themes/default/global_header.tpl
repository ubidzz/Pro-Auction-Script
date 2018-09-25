<!DOCTYPE html>
<html dir="{DOCDIR}" lang="{LANGUAGE}">
<!-- INCLUDE headerJS.tpl -->
<body>
<div class="container-fluid">
	<div class="row">
		<!-- INCLUDE global_modals.tpl -->
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#headerMenu" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				     </button>
				    <a class="navbar-brand hidden-sm hidden-md hidden-lg" href="{SITEURL}home">{SITENAME}</a>
				</div>
	    		<div class="collapse navbar-collapse" id="headerMenu">
					<ul class="nav navbar-nav mobileScroll">
						<li class="hidden-xs"><a href="{SITEURL}home"><i class="fa fa-home" aria-hidden="true"></i> </a></li>
						<li><a href="{SITEURL}cat/{BROWSE_SEO}-0"><i class="fa fa-eye" aria-hidden="true"></i> {L_104}</a></li>
						<!-- IF B_LOGGED_IN -->
						<!-- IF B_CAN_SELL -->
						<li><a href="{SITEURL}select_category.php?"><i class="fa fa-plus" aria-hidden="true"></i> {L_028}</a></li>
						<!-- ENDIF -->
						<!-- ELSE -->
						<li><a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in" aria-hidden="true"></i> {L_052}</a></li>
						<!-- ENDIF -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="submenu1"><i class="fa fa-list-ul" aria-hidden="true"></i> {L_276} <span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="submenu1">
								<li><a href="{SITEURL}cat/{L_277_1}-0">{L_277}</a></li>
								<!-- BEGIN cat_list_drop_down -->
									<li><a href="{SITEURL}cat/{cat_list_drop_down.SEO_NAME}-{cat_list_drop_down.ID}">{cat_list_drop_down.IMAGE}{cat_list_drop_down.NAME}</a></li>
								<!-- END cat_list_drop_down -->
							</ul>
						</li>
						<form class="navbar-form navbar-left" action="{SITEURL}search.php" method="get" role="search">
							<input type="text" class="form-control" placeholder="{L_103}" name="q" value="{Q}">
							<button type="submit" class="btn btn-success" name="sub" value="{L_399}"><i class="fa fa-search" aria-hidden="true"></i> {L_199}</button>
						</form>
						<li><a href="{SITEURL}adsearch.php"><i class="fa fa-search" aria-hidden="true"></i> {L_464}</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-question-circle" aria-hidden="true"></i> {L_5236} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<!-- BEGIN helpbox -->
					     		<li><a href="{SITEURL}viewhelp.php?cat={helpbox.ID}" alt="faqs" data-fancybox-type="iframe" class="infoboxs">{helpbox.TITLE}</a></li>
					     		<!-- END helpbox -->
 							</ul>
						</li>
						<!-- IF B_LOGGED_IN -->
						<li><a href="{SITEURL}user_menu.php">{L_622}</a></li>
						<!-- ENDIF -->
					</ul>
				</div>
		    </div>
		</nav>
		<div class="col-xs col-sm-4 hidden-xs">
			{LOGO}
		</div>
		<div class="col-xs col-sm-8 hidden-xs">
			<div class="pull-right">
			{BANNER}{HEADER_ADSENSE}
		</div></div>
		<div class="col-xs col-sm-12">
			<div class="well well-sm text-right"><small>{HEADERCOUNTER}</small></div>