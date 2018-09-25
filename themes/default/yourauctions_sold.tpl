<!-- INCLUDE user_menu_header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
	var relist_fee = '{RELIST_FEE}';
	$("#processrelist").submit(function() {
		if (confirm('{L_30_0087}')){
			return true;
		} else {
			return false;
		}
	});
	$("#relistid").click(function(){
		if (this.is(':checked'))
			$("#to_pay").text(parseFloat($("#to_pay").text()) - relist_fee);
		else
			$("#to_pay").text(parseFloat($("#to_pay").text()) + relist_fee);
	});
});
</script>
<div class="col-sm-9">
	<legend>{L_25_0119}</legend>
  	<div><small>{L_5117} {PAGE} {L_5118} {PAGES}</small></div>
	<table class="table table-bordered table-condensed table-striped">
    	<tr>
      		<td>
      			<a href="yourauctions_sold.php?solda_ord=title&solda_type={ORDERNEXT}">{L_624}</a>
        		<!-- IF ORDERCOL eq 'title' -->
        		<a href="yourauctions_sold.php?solda_ord=title&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
        		<!-- ENDIF -->
	      	</td>
	      	<td>
	      		<a href="yourauctions_sold.php?solda_ord=starts&solda_type={ORDERNEXT}">{L_625}</a>
	        	<!-- IF ORDERCOL eq 'starts' -->
	        	<a href="yourauctions_sold.php?solda_ord=starts&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	        	<!-- ENDIF -->
	      	</td>
	      	<td>
	      		<a href="yourauctions_sold.php?solda_ord=ends&solda_type={ORDERNEXT}">{L_626}</a>
	        	<!-- IF ORDERCOL eq 'ends' -->
	        	<a href="yourauctions_sold.php?solda_ord=ends&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	        	<!-- ENDIF -->
	      	</td>
	      	<td>
	      		<a href="yourauctions_sold.php?solda_ord=num_bids&solda_type={ORDERNEXT}">{L_627}</a>
	        	<!-- IF ORDERCOL eq 'num_bids' -->
	        	<a href="yourauctions_sold.php?solda_ord=num_bids&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	        	<!-- ENDIF -->
	      	</td>
      		<td>
      			<a href="yourauctions_sold.php?solda_ord=current_bid&solda_type={ORDERNEXT}">{L_628}</a>
        		<!-- IF ORDERCOL eq 'current_bid' -->
        		<a href="yourauctions_sold.php?solda_ord=current_bid&solda_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
        		<!-- ENDIF -->
      		</td>
    	</tr>
    	<!-- BEGIN items -->
    	<tr>
      		<td>
      			<a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">{items.TITLE}</a><br>
        		{items.ITEM_SOLD}{items.NO_PAYMENT}{items.PAID}<br><br>
        		<a class="btn btn-small btn-info btn-sm" href="selling.php?id={items.ID}"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> {L_900}</a>
        		<!-- IF items.B_CLOSED -->
        		<a class="btn btn-success btn-sm" href="sellsimilar.php?id={items.ID}"><span class="glyphicon glyphicon-duplicate"></span> {L_2__0050}</a>
        		<!-- ENDIF -->
      		</td>
      		<td>{items.STARTS}</td>
      		<td>{items.ENDS}</td>
      		<td>{items.BIDS}</td>
      		<td>
      			<!-- IF items.B_HASNOBIDS -->
      	  		-
        		<!-- ELSE -->
        		{items.BID}
        		<!-- ENDIF -->
      		</td>        		-
    	</tr>
    	<!-- END items -->
  	</table>
   	<ul class="pagination">
      	{PREV}
      	<!-- BEGIN pages -->
      	{pages.PAGE}
      	<!-- END pages -->
      	{NEXT}
    </ul>
</div>