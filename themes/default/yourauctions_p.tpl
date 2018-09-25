<!-- INCLUDE user_menu_header.tpl -->
<script type="text/javascript">
$(document).ready(function() {

	$("#startall").click(function() {
		var checked_status = this.checked;
        $("input[id=start]").each(function()
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
        $("input[id=delete]").each(function()
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
});
</script>
<div class="col-sm-9">
	<legend>{L_25_0115}</legend>
  	<form name="open" method="post" action="" id="processdel" class="table-responsive">
	    <input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	    <input type="hidden" name="action" value="delopenauctions">
	    <small><span class="muted">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</span></small>
	    <table class="table table-bordered table-condensed table-striped">
	      	<tr>
	        	<td>
	        		<a href="yourauctions_p.php?pa_ord=title&pa_type={ORDERNEXT}">{L_624}</a>
	          		<!-- IF ORDERCOL eq 'title' -->
	          		<a href="yourauctions_p.php?pa_ord=title&pa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td>
	        		<a href="yourauctions_p.php?pa_ord=starts&pa_type={ORDERNEXT}">{L_25_0116}</a>
	          		<!-- IF ORDERCOL eq 'starts' -->
	          		<a href="yourauctions_p.php?pa_ord=starts&pa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td>
	        		<a href="yourauctions_p.php?pa_ord=ends&pa_type={ORDERNEXT}">{L_25_0117}</a>
	          		<!-- IF ORDERCOL eq 'ends' -->
	          		<a href="yourauctions_p.php?pa_ord=ends&pa_type={ORDERNEXT}">{ORDERTYPEIMG}</a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td> {L_298} </td>
	        	<td> {L_008} </td>
	        	<td> {L_25_0118} </td>
	      	</tr>
	      	<!-- IF B_AREITEMS -->
	      	<!-- BEGIN items -->
	      	<tr>
	        	<td><a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">{items.TITLE}</a></td>
	        	<td>{items.STARTS}</td>
	        	<td>{items.ENDS}</td>
	        	<td><!-- IF items.B_HASNOBIDS -->
	        	  	<a href="edit_active_auction.php?id={items.ID}"><img src="images/edititem.gif" width="13" height="17" alt="{L_512}" border="0"></a>
	          		<!-- ENDIF -->
	        	</td>
	        	<td><!-- IF items.B_HASNOBIDS -->
	          		<input type="checkbox" name="O_delete[]" value="{items.ID}" id="delete">
	          		<!-- ENDIF -->
	        	</td>
	        	<td><input type="checkbox" name="startnow[]" value="{items.ID}" id="start">
	        	</td>
	      	</tr>
	      	<!-- END items -->
	      	<!-- ENDIF -->
	      	<tr>
	        	<td colspan="4" style="text-align:right;"><span class="muted">{L_30_0102}</span></td>
	        	<td><input type="checkbox" id="deleteall"></td>
	        	<td><input type="checkbox" id="startall"></td>
	      	</tr>
	      	<tr>
	        	<td colspan="10">
	          		<input type="submit" name="Submit" value="{L_631}" class="btn btn-primary">
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