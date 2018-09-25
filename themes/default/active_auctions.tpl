<legend>{L_219}<a href="{SITEURL}profile.php?user_id={USER_ID}">{USERNAME}</a> 
	<a href="{SITEURL}rss.php?feed=9&user_id={USER_ID}">
		<img src="{SITEURL}images/rss.png" alt="RSS" border="0">
	</a>
</legend>
	
<small><span class="muted">{L_5117} {PAGE} {L_5118} {PAGES}</span></small>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr>
	      	<th width="10%">{L_167}</th>
	      	<th>{L_168}</th>
	     	<th>{L_169}</th>
	      	<th>{L_170}</th>
	      	<th>{L_171}</th>
	    </tr>
	    <!-- BEGIN auctions -->
	    <tr>
	      	<td align="center">
	      		<a href="{SITEURL}products/{auctions.SEO_TITLE}-{auctions.ID}">
	      			<img src="{auctions.PIC_URL}">
	      		</a>
	      	</td>
	      	<td>
	      		<a href="{SITEURL}products/{auctions.SEO_TITLE}-{auctions.ID}">{auctions.TITLE}</a>
	      		<!-- IF auctions.B_BNONLY -->
	      		<!-- IF auctions.B_FREEITEM -->
				<br><br><div class="badge badge-warning">{L_3500_1015748}</div>
				<!-- ELSE -->
	      		<br><br><div class="badge badge-warning">{L_933}</div>
	        	<!-- ENDIF -->
	        	<!-- ENDIF -->
	      	</td>
	      	<td>
	      		<!-- IF auctions.B_BNONLY -->
	      		<!-- IF auctions.B_FREEITEM -->
				<a class="btn btn-success btn-sm" href="{SITEURL}buy_now.php?id={auctions.ID}"><span class="glyphicon glyphicon-save"></span> {L_3500_1015747}</a>
				<!-- ELSE -->
	        	{auctions.BNFORMAT}<br /><a class="btn btn-success btn-sm" href="{SITEURL}buy_now.php?id={auctions.ID}"><span class="glyphicon glyphicon-shopping-cart"></span> {L_350_1015402}</a>
	        	<!-- ENDIF -->
	        	<!-- ELSE -->
	        	{L_116}: {auctions.BIDFORMAT}<br /><a class="btn btn-success btn-sm" href="{SITEURL}products/{auctions.SEO_TITLE}-{auctions.ID}"><span class="glyphicon glyphicon-ok"></span> {L_350_1015403}</a>
	        	<!-- IF auctions.B_BUY_NOW and not auctions.B_BNONLY -->
	        	<br><br>{auctions.BNFORMAT}<br /><a class="btn btn-success btn-sm" href="{SITEURL}buy_now.php?id={auctions.ID}"><span class="glyphicon glyphicon-shopping-cart"></span> {L_350_1015402}</a>
	        	<!-- ENDIF -->
	        	<!-- ENDIF -->
	      	</td>
	      	<td>{auctions.NUM_BIDS}</td>
	      	<td>{auctions.TIMELEFT}</td>
		</tr>
	    <!-- BEGINELSE -->
	    <tr align="center">
	      	<td colspan="5">{L_910}</td>
	    </tr>
	    <!-- END auctions -->
	</table>
</div>
<!-- IF B_MULPAG -->
 	<ul class="pagination">
   		<!-- IF B_NOTLAST -->
      	<li><a href="active_auctions.php?PAGE={PREV}&user_id={USER_ID}">{L_5119}</a></li>
      	<!-- ENDIF -->
      	{PAGENA}
      	<!-- IF B_NOTLAST -->
      	<li><a href="active_auctions.php?PAGE={NEXT}&user_id={USER_ID}">{L_5120}</a></li>
      	<!-- ENDIF -->
 	</ul>
<!-- ENDIF -->