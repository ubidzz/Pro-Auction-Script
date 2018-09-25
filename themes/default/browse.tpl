	<ul class="nav nav-tabs">
		<!-- IF B_FEATURED_ITEMS -->
		<li class="active"><a href="#featured-item" data-toggle="tab">{L_350_10206}</a></li>
		<!-- ENDIF -->
		<li <!-- IF B_FEATURED_ITEMS --><!-- ELSE -->class="active"<!-- ENDIF -->><a href="#standard-auction" data-toggle="tab">{L_1021}</a></li>
	</ul>
	<div class="tab-content">
	<!-- IF B_FEATURED_ITEMS -->
		<div class="tab-pane fade in active table-responsive" id="featured-item">
			<table class="table table-condensed table-striped table-bordered table-hover">
			  <tr>
			    <th>{L_741}</th>
			    <th>{L_017}</th>
			    <th>{L_169}</th>
			    <th class="hidden-xs">{L_319}</th>
			  </tr>
			  <!-- BEGIN featured_items -->
			  <tr class="{featured_items.ROWCOLOR}"<!-- IF featured_items.B_BOLD -->style="font-weight: bold;"<!-- ENDIF -->>
			  	<td>
			  		<a href="{SITEURL}products/{featured_items.SEO_TITLE}-{featured_items.ID}">
			  			<img src="{featured_items.IMAGE}">
			  		</a>
			  	</td>
			    <td>
			    	<a href="{SITEURL}products/{featured_items.SEO_TITLE}-{featured_items.ID}">{featured_items.TITLE}</a>
			      	<!-- IF B_SUBTITLE && featured_items.SUBTITLE ne '' -->
			      	<br>
			      	{featured_items.SUBTITLE}
			      	<!-- ENDIF -->
			      	<br><br><span class="badge">{L_171}: {featured_items.TIMELEFT}</span> 
			      	<span class="badge">{L_170} {featured_items.NUMBIDS}</span> 
			      	{featured_items.BUYNOWLOGO}
			    </td>
			    <td> {featured_items.BIDFORM} {featured_items.BUY_NOW}</td>
			    <td class="hidden-xs">{featured_items.SHIPPING_COST}</td>
			  </tr>
			  <!-- END featured_items -->
			</table>
		</div>
		<!-- ENDIF -->
		<div class=" table-responsive tab-pane fade in <!-- IF B_FEATURED_ITEMS --><!-- ELSE -->active<!-- ENDIF -->" id="standard-auction">
			<table  class="table table-condensed table-striped table-bordered table-hover">
			  <tr>
			    <th>{L_741}</th>
			    <th>{L_017}</th>
			    <th>{L_169}</th>
			    <th class="hidden-xs">{L_319}</th>
			  </tr>
			  <!-- BEGIN items -->
			  <tr class="{items.ROWCOLOR}"  <!-- IF items.B_BOLD -->style="font-weight: bold;"<!-- ENDIF -->>
			  	<td>
			  		<a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">
			  			<img src="{items.IMAGE}">
			  		</a>
			  	</td>
			    <td>
			    	<a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">{items.TITLE}</a>
			      	<!-- IF B_SUBTITLE && items.SUBTITLE ne '' -->
			      	<br>
			      	{items.SUBTITLE}
			      	<!-- ENDIF -->
			      	<br><br><span class="badge">{L_171}: {items.TIMELEFT}</span> 
			      	<span class="badge">{L_170} {items.NUMBIDS}</span> 
			      	{items.BUYNOWLOGO}
			    </td>
			    <td> {items.BIDFORM} {items.BUY_NOW}</td>
			    <td class="hidden-xs"><small>{items.SHIPPING_COST}</small> </td>
			  </tr>
			  <!-- END items -->
			</table>
		</div>
	</div>
  	<ul class="pagination">
    	<li>{PREV}</li>
    	<!-- BEGIN pages -->
    	<li>{pages.PAGE}</li>
    	<!-- END pages -->
    	<li>{NEXT}</li>
  	</ul>
