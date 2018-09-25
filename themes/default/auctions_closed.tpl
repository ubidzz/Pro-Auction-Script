<legend>{L_220}<a href="{SITEURL}profile.php?user_id={USER_ID}">{USERNAME}</a></legend>
<small>{L_5117} {PAGE} {L_5118} {PAGES}</small>
<div class="table-responsive">
	<table class="table table-bordered table-condensed table-hover table-striped">
    	<tr>
      		<th width="10%">{L_167}</th>
      		<th>{L_168}</th>
      		<th>{L_169}</th>
      		<th>{L_170}</th>
      		<th>{L_171a}</th>
    	</tr>
    	<!-- BEGIN auctions -->
    	<tr>
      		<td><a href="{SITEURL}products/{auctions.SEO_TITLE}-{auctions.ID}">
      			<img src="{auctions.PIC_URL}" style="max-width:{MAXIMAGESIZE}px; max-height:{MAXIMAGESIZE}px; width: auto; height: auto;"></a>
      		</td>
      		<td><a href="{SITEURL}products/{auctions.SEO_TITLE}-{auctions.ID}">{auctions.TITLE}</a>
        		<!-- IF auctions.B_BUY_NOW and not auctions.B_BNONLY -->
        		&nbsp;&nbsp;(<a href="{SITEURL}buy_now.php?id={auctions.ID}"><img align="middle" src="{auctions.BNIMG}" border="0"></a> {auctions.BNFORMAT})
        		<!-- ENDIF -->
      		</td>
      		<td><!-- IF auctions.B_BNONLY -->
        		<a href="{SITEURL}buy_now.php?id={auctions.ID}">
        		<img src="{auctions.BNIMG}"></a> {auctions.BNFORMAT}
        		<!-- ELSE -->
        		{auctions.BIDFORMAT}
        		<!-- ENDIF -->
        	</td>
      		<td>{auctions.NUM_BIDS}</td>
      		<td>{auctions.TIMELEFT}</td>
    	</tr>
    	<!-- END auctions -->
    	<!-- BEGIN no_auctions -->
    	<tr>
      		<td colspan="5">{L_910}</td>
    	</tr>
    	<!-- END no_auctions -->
  	</table>
</div>
<!-- IF B_MULPAG -->
<ul class="pagination ">
 	<!-- IF B_NOTLAST -->
    <li><a href="{SITEURL}active_auctions.php?PAGE={PREV}&user_id={USER_ID}">{L_5119}</a></li>
    <!-- ENDIF -->
    {PAGENA}
    <!-- IF B_NOTLAST -->
    <li><a href="{SITEURL}active_auctions.php?PAGE={NEXT}&user_id={USER_ID}">{L_5120}</a></li>
    <!-- ENDIF -->
</ul>
<!-- ENDIF -->
