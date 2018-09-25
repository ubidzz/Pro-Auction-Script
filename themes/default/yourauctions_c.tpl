<!-- INCLUDE user_menu_header.tpl -->
<script type="text/javascript">
$(document).ready(function() {
	
	var relist_fee = {RELIST_FEE_NO};
	
	$("#sellall").click(function() {
		var checked_status = this.checked;
        $("input[id=sellitem]").each(function()
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
	
	$("#relistall").click(function() {
		var checked_status = this.checked;
        $("input[id=relistid]").each(function()
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

	$("#deleteall").click(function() {
		var checked_status = this.checked;
		$("input[id=deleteitem]").each(function()
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

	$("#processdel").submit(function() {
		if (confirm('{L_30_0087}')){
			return true;
		} else {
			return false;
		}
	});

	$(".relistid").click(function(){
		var n = $(".relistid:checked").length;
		$("#to_pay").text(parseFloat(n * relist_fee));
	});
});
</script>
<div class="col-sm-9">
	<legend>{L_204}</legend>
  	<form name="closed" method="post" action="" id="processdel" class="table-responsive">
    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
    	<input type="hidden" name="action" value="update">
    	<!-- IF B_RELIST_FEE -->
    	{L_437}: {RELIST_FEE} - {L_189}: <span id="to_pay">0.00</span>
    	<!-- ENDIF -->
    	<small>{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</small>
    	<table class="table table-bordered table-striped">
      		<tr>
        		<td><a href="yourauctions_c.php?ca_ord=title&ca_type={ORDERNEXT}">{L_624}</a>
          			<!-- IF ORDERCOL eq 'title' -->
          			<a href="yourauctions_c.php?ca_ord=title&ca_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
          			<!-- ENDIF -->
        		</td>
	        	<td><a href="yourauctions_c.php?ca_ord=starts&ca_type={ORDERNEXT}">{L_625}</a>
	          		<!-- IF ORDERCOL eq 'starts' -->
	          		<a href="yourauctions_c.php?ca_ord=starts&ca_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td><a href="yourauctions_c.php?ca_ord=ends&ca_type={ORDERNEXT}">{L_626}</a>
	          		<!-- IF ORDERCOL eq 'ends' -->
	          		<a href="yourauctions_c.php?ca_ord=ends&ca_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td><a href="yourauctions_c.php?ca_ord=num_bids&ca_type={ORDERNEXT}">{L_627}</a>
	          		<!-- IF ORDERCOL eq 'num_bids' -->
	          		<a href="yourauctions_c.php?ca_ord=num_bids&ca_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td><a href="yourauctions_c.php?ca_ord=current_bid&ca_type={ORDERNEXT}">{L_628}</a>
	          		<!-- IF ORDERCOL eq 'current_bid' -->
	          		<a href="yourauctions_c.php?ca_ord=current_bid&ca_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td>{L_3500_1015825}</td>
	      	</tr>
	      	<!-- BEGIN items -->
	      	<tr>
	        	<td><a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">{items.TITLE}</a> </td>
	        	<td>{items.STARTS}</td>
	        	<td>{items.ENDS}</td>
	        	<td>{items.BIDS}</td>
	        	<td>{items.BID}</td>
	        	<td>
	        		<!-- IF items.B_CANSSELL -->
	        		<div class="checkbox">
	          			<input type="checkbox" name="sell[]" value="{items.ID}" id="sellitem"> {L_25_0209}
	          		</div>
	          		<!-- ENDIF -->
	        		<!-- IF items.B_HASNOBIDS -->
	        		<div class="checkbox">
	          			<label><input type="checkbox" name="delete[]" value="{items.ID}" id="deleteitem"> {L_008}</label>
	          		</div>
	          		<!-- ENDIF -->
	          		<div class="checkbox">
	          			<!-- IF items.B_CANRELIST and B_AUTORELIST -->
	          			<label><input type="checkbox" name="relist[]" value="{items.ID}" id="relistid"> {L_630}</label>
	          			<!-- ELSE -->
	          			<!-- IF items.B_CANRELIST -->
	          			<label><a class="btn btn-success btn-xs" href="sellsimilar.php?id={items.ID}&relist=1">{L_2__0051}</a></label>
	          			<!-- ELSE -->
	          			<label><a class="btn btn-success btn-xs" href="sellsimilar.php?id={items.ID}">{L_2__0050}</a></label>
	          			<!-- ENDIF -->
	          			<!-- ENDIF -->
	          		</div>
	        	</td>
	      	</tr>
	      	<!-- END items -->
	      	<tr>
	        	<td colspan="3" style="text-align:right"><span class="muted"><small>{L_30_0102}</small></span></td>
	        	<td colspan="4" align="center-inline">
	        		<div class="checkbox-inline">
	        			<label><input type="checkbox" id="deleteall">{L_008}</label>
	        		</div>
	        		<div class="checkbox-inline">
	        			<label><input type="checkbox" id="relistall">{L_630}</label>
	        		</div>
	        		<div class="checkbox-inline">
	        			<label><input type="checkbox" id="sellall">{L_25_0209}</label>
	        		</div>
	        	</td>
	      	</tr>
	      	<tr>
	        	<td colspan="6" style="text-align:center">
	          		<input type="submit" name="Submit" value="{L_631}" class="btn btn-success btn-sm">
	        	</td>
	      	</tr>
	    </table>
	</form>
	<ul class="pagination">
	  	<li>{PREV}</li>
	 	<!-- BEGIN pages -->
	  	<li>{pages.PAGE}</li>
	   	<!-- END pages -->
	  	<li>{NEXT}</li>
	</ul>
</div>