<!-- INCLUDE user_menu_header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
	$("#deleteall").click(function() {
		var checked_status = this.checked;
        $("input[id=delete]").each(function()
        { 
        	this.checked = checked_status;
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

	$("#processdel").submit(function() {
		if (confirm('{L_30_0087}')){
			return true;
		} else {
			return false;
		}
	});
});
</script>
<div class="col-sm-9">
	<legend>{L_2__0056}</legend>
	<form name="open" method="post" action="" id="processdel" class="table-responsive">
  		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
  		<input type="hidden" name="action" value="delopenauctions">
  		<small><span class="muted">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</span></small>
  		<table class="table table-bordered table-striped table-condensed">
    		<tr>
      			<td>
      				<a href="yourauctions_s.php?sa_ord=title&sa_type={ORDERNEXT}">{L_624}</a>
        			<!-- IF ORDERCOL eq 'title' -->
        			<a href="yourauctions_s.php?sa_ord=title&sa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
        			<!-- ENDIF -->
      			</td>
      			<td>
      				<a href="yourauctions_s.php?sa_ord=num_bids&sa_type={ORDERNEXT}">{L_627}</a>
        			<!-- IF ORDERCOL eq 'num_bids' -->
        			<a href="yourauctions_s.php?sa_ord=num_bids&sa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
        			<!-- ENDIF -->
      			</td>
      			<td>
      				<a href="yourauctions_s.php?sa_ord=current_bid&sa_type={ORDERNEXT}">{L_628}</a>
        			<!-- IF ORDERCOL eq 'current_bid' -->
        			<a href="yourauctions_s.php?sa_ord=current_bid&sa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
        			<!-- ENDIF -->
      			</td>
      			<td>{L_3500_1015825} </td>
    		</tr>
    		<!-- IF B_AREITEMS -->
    		<!-- BEGIN items -->
    		<tr>
      			<td><a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">{items.TITLE}</a><br><br>
      				{L__0153}: 
      				<!-- IF items.RELIST eq 0 -->
        			0
        			<!-- ELSE -->
        			{items.RELIST} / {items.RELISTED}
        			<!-- ENDIF -->
      			</td>
      			<td> {items.BIDS} </td>
      			<td>
      				<!-- IF items.B_HASNOBIDS -->
        			--
        			<!-- ELSE -->
        			{items.BID}
        			<!-- ENDIF -->
      			</td>
      			<td>
      				<!-- IF items.B_HASNOBIDS -->
      				<div class="checkbox">
        				<label><input type="checkbox" name="O_delete[]" value="{items.ID}">{L_008}</label>
        			</div>
        			<!-- ENDIF -->
        			<!-- IF items.B_HASNOBIDS -->
        			<label><a href="edit_active_auction.php?id={items.ID}" class="btn btn-success btn-sm">{L_512}</a></label>
        			<!-- ENDIF -->
        			<!-- IF items.SUSPENDED eq 9 -->
        			<label><a href="{SITEURL}pay.php?a=4&auction_id={items.ID}" class="btn btn-danger btn-sm">{L_769}</a></label>
        			<!-- ELSEIF items.SUSPENDED eq 8 -->
        			<label><a href="{SITEURL}pay.php?a=5" class="btn btn-danger btn-sm">{L_770}</a></label>
        			<!-- ENDIF -->
      			</td>
    		</tr>
    		<!-- END items -->
    		<!-- ENDIF -->
    		<tr>
      			<td align="right" colspan="3">{L_30_0102}</td>
      			<td>
      				<div class="checkbox-inline">
      					<label><input type="checkbox" id="deleteall"> {L_008}</label>
      				</div>
      			</td>
    		</tr>
    		<tr>
      			<td colspan="4" style="text-align:center">
        			<input type="submit" name="Submit" value="{L_631}" class="btn btn-success btn-sm">
      			</td>
    		</tr>
  		</table>
	</form>
  	<ul class="pagination">
    	{PREV}
    	<!-- BEGIN pages -->
    	{pages.PAGE}
    	<!-- END pages -->
    	{NEXT}
  </ul>
</div>