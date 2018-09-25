<!-- IF B_LOGGED_IN -->

<div class="col-sm-3">

	<ul class="nav nav-tabs nav-inline">

		<li {ACTIVEACCOUNTTAB}><a href="#UserAccount" data-toggle="tab">{L_25_0081}</a></li>

		<!-- IF B_CAN_SELL -->

		<li {ACTIVESELLINGTAB}><a href="#UserSeller" data-toggle="tab" >{L_25_0082}</a></li>

		<!-- ENDIF -->

		<li {ACTIVEBUYINGTAB}><a href="#UserBuyer" data-toggle="tab" >{L_25_0083}</a></li>

	 </ul>

	<div class="tab-content">

	  	<div class="tab-pane tab-pane fade in {ACTIVEACCOUNTPANEL}" id="UserAccount">

			<div class="panel panel-primary">

				<div class="panel-heading">{L_25_0081} 

					<button type="button" class="pull-right collapsed btn btn-success btn-xs" data-parent="#main-cats" data-toggle="collapse" data-target="#show-my-account" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

				</div>

				<div id="show-my-account" class="panel-body panel-collapse collapse in">

					<ul class="nav nav-pills nav-stacked">

				        <li {ACTIVESUMMARY}><a href="{SITEURL}user_menu.php?cptab=summary"><i class="fa fa-info-circle" aria-hidden="true"></i> {L_25_0080}</a></li>

				        <li {ACTIVEMYSUPPORT}><a href="{SITEURL}support"><i class="fa fa-envelope" aria-hidden="true"></i> {L_3500_1015432} {SUPPORT}</a></li>

				        <li {ACTIVEEDITACCOUNT}><a href="{SITEURL}edit_data.php"><i class="fa fa-user" aria-hidden="true"></i> {L_621}</a></li>

				        <li {ACTIVEVIEWFEEDBACK}><a href="{SITEURL}yourfeedback.php"><i class="fa fa-comments-o" aria-hidden="true"></i> {L_208} {FEEDBACK}</a></li>

				        <li {ACTIVELEAVEFEEDBACK}><a href="{SITEURL}buysellnofeedback.php"><i class="fa fa-commenting" aria-hidden="true"></i> {L_207} {FBTOLEAVE2}</a></li>

				        <li {ACTIVEVIEWMESSAGES}><a href="{SITEURL}mail.php"><i class="fa fa-envelope-o" aria-hidden="true"></i> {L_623} {NEW_MESSAGES2}</a></li>

				        <li {ACTIVEOUTSTANDING}><a href="{SITEURL}outstanding.php"><i class="fa fa-trophy" aria-hidden="true"></i> {L_422} {OUTSTANDING}</a></li>

				        <!-- IF B_BANNERMANAGER -->

				        <li {ACTIVEMYADVERTISMENT}><a href="{SITEURL}managebanners.php"><i class="fa fa-bullhorn" aria-hidden="true"></i> {L_350_1012111} {BANNER_ACC}</a></li>

				        <!-- ENDIF -->

				        <!-- IF B_BOARDS -->

				        <li {ACTIVEBOARDS}><a href="{SITEURL}boards.php"><i class="fa fa-comments" aria-hidden="true"></i> {L_5030}</a></li>

				        <!-- ENDIF -->

				   	</ul>

				</div>

			</div>

		</div>

		<!-- IF B_CAN_SELL -->

		<div class="tab-pane tab-pane fade in {ACTIVESELLINGPANEL}" id="UserSeller">

			<div class="panel panel-primary">

				<div class="panel-heading">{L_25_0082}

					<button type="button" class="pull-right collapsed btn btn-success btn-xs" data-parent="#main-cats" data-toggle="collapse" data-target="#show-selling" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

				</div>

				<div id="show-selling" class="panel-collapse collapse in panel-body">

					<ul class="nav nav-pills nav-stacked">

				        <li><a href="{SITEURL}select_category.php"><i class="fa fa-comments" aria-hidden="true"></i> {L_028}</a></li>

				        <li {ACTIVEEMAILSETTINGS}><a href="{SITEURL}selleremails.php"><i class="fa fa-envelope" aria-hidden="true"></i> {L_25_0188}</a></li>

				        <li {ACTIVEPENDINGAUCTIONS}><a href="{SITEURL}yourauctions_p.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> {L_25_0115} {PENDING_AUCTIONS}</a></li>

				        <li {ACTIVEACTIVATEDAUCTIONS}><a href="{SITEURL}yourauctions.php"><i class="fa fa-check-circle-o" aria-hidden="true"></i> {L_203} {ACTIVE_AUCTIONS}</a></li>

				        <li {ACTIVECLOSEDAUCTIONS}><a href="{SITEURL}yourauctions_c.php"><i class="fa fa-times-circle-o" aria-hidden="true"></i> {L_204} {CLOSED_AUCTIONS}</a></li>

				        <li {ACTIVESUSPENDEDAUCTIONS}><a href="{SITEURL}yourauctions_s.php"><i class="fa fa-ban" aria-hidden="true"></i> {L_2__0056} {SUSPENDED_AUCTIONS}</a></li>

				        <li {ACTIVESOLDAUCTIONS}><a href="{SITEURL}yourauctions_sold.php"><i class="fa fa-trophy" aria-hidden="true"></i> {L_25_0119} {SOLD_ITEM4}</a></li>

					</ul>

				</div>

			</div>

		</div>

		<!-- ENDIF -->

		<div class="tab-pane tab-pane fade in {ACTIVEBUYINGPANEL}" id="UserBuyer">

			<div class="panel panel-primary">

				<div class="panel-heading">{L_25_0083}

					<button type="button" class="pull-right collapsed in btn btn-success btn-xs" data-parent="#main-cats" data-toggle="collapse" data-target="#show-buying" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

				</div>

				<div id="show-buying" class="panel-body panel-collapse collapse in">

					<ul class="nav nav-pills nav-stacked">

					   	<!-- IF B_DIGITAL_ITEM_ON -->

					   	<li {ACTIVEMYDOWNLOADS}><a href="{SITEURL}my_downloads.php"><i class="fa fa-download" aria-hidden="true"></i> {L_3500_1015430} {MY_DOWNLOADS}</a></li>

					  	<!-- ENDIF -->

					  	<li {ACTIVEAUCTIONWATCH}><a href="{SITEURL}auction_watch.php"><i class="fa fa-bell-o" aria-hidden="true"></i> {L_471} {AUC_KEYWORDS}</a></li>

					  	<li {ACTIVEWATCHLIST}><a href="{SITEURL}item_watch.php"><i class="fa fa-eye" aria-hidden="true"></i> {L_472} {BENDING_SOON}</a></li>

					  	<li {ACTIVEYOURBIDS}><a href="{SITEURL}yourbids.php"><i class="fa fa-gavel" aria-hidden="true"></i> {L_620} {BOUTBID}</a></li>

					 	<li {ACTIVEAUCTIONSWON}><a href="{SITEURL}buying.php"><i class="fa fa-trophy" aria-hidden="true"></i> {L_454} {ITEMS_WON}</a></li>

						<li {ACTIVEFSM}><a href='{SITEURL}fsm.php'><i class="fa fa-thumbs-up" aria-hidden="true"></i> {L_FSM7} {FAVSELLER}</a></li>

					</ul>

				</div>

			</div>

		</div>

	</div>

	<!-- IF B_USER_MENU_ADSENSE -->

	<div class="panel panel-primary hidden-xs">

		<div class="panel-heading">{L_25_0011}</div>

		<div class="panel-body">

			<div align="center">

				{USER_MENU_ADSENSE_1}

			</div>

		</div>

	</div>

	<!-- ENDIF -->

</div>

<!-- ENDIF -->