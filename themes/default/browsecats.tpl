<ol class="breadcrumb">

	<li>{L_287} </li>

    {CAT_STRING}

</ol>



<div class="col-sm-3" id="main-cats"> 

	<div class="panel panel-primary">

		<div class="panel-heading">{L_276}

			<button type="button" class="pull-right collapsed btn btn-success btn-xs" data-parent="#main-cats" data-toggle="collapse" data-target="#show-main-cats" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

		</div>

		<div id="show-main-cats" class="panel-collapse collapse in">

			<div class="panel-body">

				<ul class="nav nav-list cat-list">

		          	<li><a href="{SITEURL}cat/{L_277_1}-0"><i class="icon-tags"></i> {L_277}</a></li>

		          	<li class="divider"></li>

		         	<!-- BEGIN cat_list_drop_down -->

		          	<li> <a href="{SITEURL}cat/{cat_list_drop_down.SEO_NAME}-{cat_list_drop_down.ID}">{cat_list_drop_down.IMAGE} {cat_list_drop_down.NAME}</a></li>

		          	<!-- END cat_list_drop_down -->

		      	</ul>

			</div>

		</div>

	</div>

	<!-- IF B_BROWSE_ADSENSE_1 -->

	<div class="panel panel-primary hidden-xs">

		<div class="panel-heading">{L_25_0011}</div>

		<div class="panel-body">

			<div align="center">

		  		{BROWSE_ADSENSE_1}

		  	</div>

		  </div>

	  </div>

	  <!-- ENDIF -->

</div>



<div class="col-sm-9" id="sub-cats">

	<div class="panel panel-primary">

		<div class="panel-heading">{L_276} / {CUR_CAT} 

			<button type="button" class="pull-right collapsed btn btn-success btn-xs" data-parent="#sub-cats" data-toggle="collapse" data-target="#show-sub-cats" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

		</div>

		<div id="show-sub-cats" class="panel-collapse collapse in">

			<div class="panel-body">

	   			<!-- IF NUM_AUCTIONS eq 0 -->

	  			<div class="alert alert-danger"><strong>{L_198}</strong></div>

	  			<!-- ENDIF -->

	   			<!-- IF TOP_HTML ne '' -->

	  				{TOP_HTML}

	   			<!-- ELSE  IF TOP_HTML e '' -->

	    		<!-- ENDIF -->

			</div>

			<!-- IF ID gt 0 && NUM_AUCTIONS gt 0 -->

			<div class="panel-footer">

				<form class="form-inline" name="catsearch" action="" method="post" >

			    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

			     	<div class="form-group">

			          	<label for="InputNameKeyWord">{L_302}</label>

			          	<input type="text" placeholder="{L_287}: {CUR_CAT}" id="InputNameKeyWord" class="form-control" name="catkeyword">

			      	</div>

			      	<button type="submit" class="btn btn-sm btn-success" name="submit"><span class="glyphicon glyphicon-search"></span> {L_103}</button>

			     	<a class="btn btn-sm btn-primary" href="{SITEURL}adsearch.php">{L_464}</a>

					<br />

					<div class="form-group">

			          	<label for="InputNameKeyWord">{L_1014}</label>

						<select id="InputNameKeyWord" name="sortAuctions" class="form-control">

							<option value="low" {SORTLOW}>{L_3500_1015971}</option>

							<option value="high" {SORTHIGH}>{L_3500_1015972}</option>

							<option value="lowBuyNow" {SORTLOWBUYNOW}>{L_3500_1015973}</option>

							<option value="highBuyNow" {SORTHIGHBUYNOW}>{L_3500_1015974}</option>

							<option value="mostBids" {SORTBIDS}>{L_3500_1015975}</option>

							<option value="newAuctions" {SORTNEW}>{L_3500_1015976}</option>

							<option value="closingAuctions" {SORTEND}>{L_3500_1015977}</option>

							<option value="lowShipping" {SORTLOWESTSHIPPING}>{L_3500_1015978}</option>

							<option value="highShipping" {SORTHIGHESTSHIPPING}>{L_3500_1015979}</option>



						</select>

					</div>

					<div class="form-group">

						<label for="InputNameKeyWord">{L_3500_1015982}</label>

						<select id="InputNameKeyWord" name="filterAuctions" class="form-control">

							<option value="filterAll" {FILTERALL}>{L_2__0027}</option>

							<option value="filterBuyNow" {FILTERBUYNOW}>{L_496}</option>

							<option value="filterFreeShipping" {FILTERFREESHIPPING}>{L_3500_1015980}</option>

							<!-- IF B_STANDARDAUCTION-->

							<option value="filterstandard" {FILTERSTANDARD}>{L_1021}</option>

							<!-- ENDIF -->

							<!-- IF B_DUTCHAUCTION-->

							<option value="filterdutch" {FILTERDUTCH}>{L_1020}</option>

							<!-- ENDIF -->

							<!-- IF B_DIGITALITEM -->

							<option value="filterDigitalItem" {FILTERDIGITALITEM}>{L_3500_1015981}</option>

							<!-- ENDIF -->

						</select>

					  	<button type="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-th-list"></span> {L_1014a}</button>

					</div>

				</form>

			</div>

			<!-- ENDIF -->

		</div>

	</div>

	<!-- IF NUM_AUCTIONS gt 0 -->

	<!-- INCLUDE browse.tpl -->

	<!-- ENDIF -->

</div>



