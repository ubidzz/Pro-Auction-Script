<div class="col-xs col-sm-9">
	<!-- IF B_INDEX_ADSENSE_2 -->
	<div class="hidden-xs">
		<div class="row">
  			<div class="panel panel-primary">
				<div class="panel-heading">{L_25_0011}</div>
				<div class="panel-body">
					<div align="center">
						{INDEX_ADSENSE_2}
					</div>
				</div>
			</div>
  		</div>
  	</div>
  	<!-- ENDIF -->
	<!-- IF B_FEATU_ITEMS -->
   	<legend>{L_350_10206}</legend>
	<div class="row">
		<!-- BEGIN featured -->
		<div class="col-xs col-sm-3" align="center"> 
			<div class="thumbnail" style="height:320px">
				<a class="thumbnail" href="{SITEURL}products/{featured.SEO_TITLE}-{featured.ID}">
			   		<img class="img-responsive" src="{featured.IMAGE}" alt="{featured.TITLE}">
			   	</a>
			    <div class="caption">
			    	<h5><a href="{SITEURL}products/{featured.SEO_TITLE}-{featured.ID}">{featured.TITLE}</a></h5>
			    	<small>{featured.BID} <br />{L_171}<br>{featured.ENDS}</small>
			    </div>
			</div>
		</div>
		<!-- END featured -->
	</div>
	<!-- ENDIF -->
	<!-- IF B_HOT_ITEMS -->
	<legend>{L_279}</legend>
	<div class="row">
		<!-- BEGIN hotitems -->
		<div class="col-xs col-sm-3" align="center"> 
			<div class="thumbnail" style="height:320px">
			 	<a href="{SITEURL}products/{hotitems.SEO_TITLE}-{hotitems.ID}" class="thumbnail">
			 		<img class="img-responsive" src="{hotitems.IMAGE}" alt="{hotitems.TITLE}">
			 	</a>
			 	<div class="caption">
      				<h5><a href="{SITEURL}products/{hotitems.SEO_TITLE}-{hotitems.ID}">{hotitems.TITLE}</a></h5>
         			<p><small>{hotitems.BID} <br />{L_171}<br>{hotitems.ENDS}</small></p>
         		</div>
			</div>
		</div>
		<!-- END hotitems -->
	</div>
	<!-- ENDIF -->
	<!-- IF B_AUC_LAST -->
	<div class="row">
		<div class="col-sm-6">
			<legend>{L_278}</legend>
			<div class="table-responsive">
				<table class="table table-striped table-condensed table-bordered table-hover">
					<!-- BEGIN auc_last -->
					<tr>
						<td class="col-sm-4">
							<a class="thumbnail" href="{SITEURL}products/{auc_last.SEO_TITLE}-{auc_last.ID}"> 
								<img class="img-responsive" src="{auc_last.IMAGE}" alt="{auc_last.TITLE}">
							</a>
						</td>
						<td>
							<a href="{SITEURL}products/{auc_last.SEO_TITLE}-{auc_last.ID}">{auc_last.TITLE}</a><br />
		            		<small>{auc_last.DATE}</small>
		            	</td>
					</tr>
					<!-- END auc_last -->
				</table>
			</div>
		</div>
	<!-- ENDIF -->
	<!-- IF B_AUC_ENDSOON -->
		<div class="col-sm-6">
			<legend>{L_280}</legend>
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<!-- BEGIN end_soon -->
					<tr>
						<td class="col-sm-4">
							<a class="thumbnail" href="{SITEURL}products/{end_soon.SEO_TITLE}-{end_soon.ID}"> 
								<img class="img-responsive" src="{end_soon.IMAGE}" alt="{end_soon.TITLE}">
							</a>
						</td>
		          		<td>
		          			<a href="{SITEURL}products/{end_soon.SEO_TITLE}-{end_soon.ID}">{end_soon.TITLE}</a><br />
		            		<small>{end_soon.DATE}</small>
		            	</td>
					</tr>
					<!-- END end_soon -->
				</table>
			</div>
		</div>
		<!-- ENDIF -->
	</div>
</div>
<!-- IF B_NEWS_BOX -->
<div class="col-xs col-sm-3">
	<div class="panel panel-primary">
		<div class="panel-heading">{L_282}</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
			  	<!-- BEGIN newsbox -->
			 	<li><a href="{SITEURL}news/{newsbox.SEO_TITLE}-{newsbox.ID}">{newsbox.TITLE} <span class="label label-success pull-right">{newsbox.DATE}</span></a> </li>
			  	<!-- END newsbox -->
			</ul>
		</div>
	</div>
</div>
<!-- ENDIF -->
<div class="col-xs col-sm-3">
	<!-- IF B_HELPBOX -->
	<div class="panel panel-primary">
		<div class="panel-heading">{L_281}</div>
		<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
			  	<li class="divider"></li>
			  	<!-- IF B_BOARDS -->
			  	<li><a href="{SITEURL}boards.php">{L_5030}</a></li>
				<!-- ENDIF -->
			   	<!-- IF B_FEES -->
			  	<li><a href="{SITEURL}fees.php">{L_25_0012}</a></li>
			  	<!-- ENDIF -->
			  	<li><a href="{SITEURL}email_request_support.php">{L_350_10207}</a></li>
			 	<!-- BEGIN helpbox -->
			 	<li><a href="{SITEURL}viewhelp.php?cat={helpbox.ID}" alt="faqs" data-fancybox-type="iframe" class="infoboxs">{helpbox.TITLE}</a></li>
				<!-- END helpbox -->
			</ul>
		</div>
	</div>
	<!-- ENDIF -->
	<!-- IF B_INDEX_ADSENSE_1 -->
	<div class="panel panel-primary hidden-xs">
		<div class="panel-heading">{L_25_0011}</div>
		<div class="panel-body">
			<div align="center">
	  			{INDEX_ADSENSE_1}
	  		</div>
	  	</div>
  	</div>
  	<!-- ENDIF -->
	<!-- IF B_INDEX_ADSENSE_3 -->
	<div class="panel panel-primary hidden-xs">
		<div class="panel-heading">{L_25_0011}</div>
		<div class="panel-body">
			<div align="center">
	  			{INDEX_ADSENSE_3}
	  		</div>
	  	</div>
  	</div>
  	<!-- ENDIF -->
</div>
