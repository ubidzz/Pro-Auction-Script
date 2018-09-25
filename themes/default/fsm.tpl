<!-- INCLUDE user_menu_header.tpl -->
<script type="text/javascript"> 
$(document).ready(function() { 
    $("#processdel").submit(function() { 
        if (confirm('{L_30_0087a}')){ 
            return true; 
        } else { 
            return false; 
        } 
    }); 
}); 
</script> 
<div class="col-sm-9">
	<legend>{L_FSM6}</legend>
	<form name="delfave" method="post" action="" id="processdel" class="table-responsive"> 
		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}"> 
		<input type="hidden" name="action" value="delfaveseller">
		<table class="table table-bordered table-condense table-striped" align='center' cellspacing="1" cellpadding="4">
			<tr>
				<th>{L_125}</th>
				<th>{L_3500_1015525}</th>
				<th>{L_008}</th> 
			</tr>
			<!-- BEGIN sellers -->
			<tr valign="top">
				<td>
					<a href='{SITEURL}profile.php?user_id={sellers.ID}'>{sellers.NICK}</a>&nbsp;(<a href='{SITEURL}feedback.php?id={sellers.ID}&faction=show'>{sellers.FB}</a>)
				</td>
				<td>
					<a href='{SITEURL}active_auctions.php?user_id={sellers.ID}'>{L_3500_1015526}</a>
				</td>
				<td align="center"> 
        		    <input type="checkbox" name="O_delete[]" value="{sellers.ID}"> 
    			</td>
			</tr>
			<!-- END sellers -->
			<tr> 
        		<td colspan="9" align="center"> 
        			<button type="submit" name="Submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_631a}</button>
        		</td> 
    		</tr> 
		</table>
	</form> 
</div>