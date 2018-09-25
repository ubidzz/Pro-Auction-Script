<!-- INCLUDE user_menu_header.tpl -->

<script type="text/javascript">

$(document).ready(function() {

	$("#closeall").click(function() {

		var checked_status = this.checked;

        $("input[id=close]").each(function()

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

		} 

		else 

		{

			return false;

		}

	});

});

</script>

<!-- IF ERROR ne '' -->

<div class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {ERROR}</div>

<!-- ENDIF -->

<div class="col-sm-9">

	<legend>{L_203}</legend>

  	<form name="auctions" method="post" action="" id="processdel" class="table-responsive">

    	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

    	<input type="hidden" name="action" value="delopenauctions">

    	<small>{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}</small>

    	<table class="table table-bordered table-condensed table-striped">

      		<tr>

        		<td>

        			<a href="yourauctions.php?oa_ord=title&oa_type={ORDERNEXT}"><small>{L_624}</small></a>

          			<!-- IF ORDERCOL eq 'title' -->

          			<a href="yourauctions.php?oa_ord=title&oa_type={ORDERNEXT}"><small>{ORDERTYPEIMG}</small></a>

          			<!-- ENDIF -->

        		</td>

        		<td>

        			<a href="yourauctions.php?oa_ord=starts&oa_type={ORDERNEXT}"><small>{L_625}</small></a>

          			<!-- IF ORDERCOL eq 'starts' -->

          			<a href="yourauctions.php?oa_ord=starts&oa_type={ORDERNEXT}"><small>{ORDERTYPEIMG}</small></a>

          			<!-- ENDIF -->

        		</td>

        		<td>

        			<a href="yourauctions.php?oa_ord=ends&oa_type={ORDERNEXT}"><small>{L_626}</small></a>

		          	<!-- IF ORDERCOL eq 'ends' -->

		          	<a href="yourauctions.php?oa_ord=ends&oa_type={ORDERNEXT}"><small>{ORDERTYPEIMG}</small></a>

		          	<!-- ENDIF -->

        		</td>

        		<td>

        			<a href="yourauctions.php?oa_ord=num_bids&oa_type={ORDERNEXT}"><small>{L_627}</small></a>

          			<!-- IF ORDERCOL eq 'num_bids' -->

          			<a href="yourauctions.php?oa_ord=num_bids&oa_type={ORDERNEXT}"><small>{ORDERTYPEIMG}</small></a>

          			<!-- ENDIF -->

        		</td>

        		<td>

        			<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}"><small>{L_628}</small></a>

          			<!-- IF ORDERCOL eq 'current_bid' -->

          			<a href="yourauctions.php?oa_ord=current_bid&oa_type={ORDERNEXT}"><small>{ORDERTYPEIMG}</small></a>

          			<!-- ENDIF -->

        		</td>

        		<td>{L_3500_1015825}</td>

      		</tr>

      		<!-- IF B_AREITEMS -->

      		<!-- BEGIN items -->

      		<tr>

      	 	 	<td>

      	 	 		<a href="{SITEURL}products/{items.SEO_TITLE}-{items.ID}">{items.TITLE}</a> <br><br>

      	 	 		<small>{L_30_0081}{items.COUNTER}{L__0151}</small><br>

      	 	 		<small>{L__0153}: 

      	 	 			<!-- IF items.RELISTED eq 0 -->

          				0

          				<!-- ELSE -->

          				{items.RELISTED}

          				<!-- ENDIF -->

      	 	 		</small>

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

          		</td>

        		<td>

        			<!-- IF items.B_HASNOBIDS -->

        			<div class="checkbox">

          				<label><input type="checkbox" name="O_delete[]" value="{items.ID}" id="delete"> {L_008}</label>

          			</div>

          			<!-- ENDIF -->

          			<div class="checkbox">

          				<label><input type="checkbox" name="closenow[]" value="{items.ID}" id="close"> {L_2__0048}</label>

          			</div>

          			<!-- IF items.B_HASNOBIDS -->

          			<label><a href="edit_active_auction.php?id={items.ID}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-cog"></span> {L_512}</a></label>

          			<!-- ENDIF -->

        		</td>

      		</tr>

      		<!-- END items -->

      		<!-- ENDIF -->

      		<tr>

        		<td colspan="4" align="right">{L_30_0102}</td>

        		<td colspan="2">

        			<div class="checkbox-inline">

        				<label><input type="checkbox" id="deleteall">{L_008}</label>

        			</div>

        			<div class="checkbox-inline">

        				<label><input type="checkbox" id="closeall">{L_2__0048}</label>

        			</div>

        		</td>

      		</tr>

      		<tr>

        		<td colspan="6" style="text-align:center">

        			<button type="submit" name="Submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_631}</button>

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