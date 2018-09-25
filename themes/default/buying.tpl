<!-- INCLUDE user_menu_header.tpl -->

<!-- BEGIN items -->

<!-- IF items.B_SHIPPER -->

<div class="modal fade" id="trackinginfo{items.AUC_ID}" tabindex="-1" role="dialog" aria-labelledby="trackinginfo">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" id="myModalLabel">{L_3500_1015910}</h4>

			</div>

			<div class="modal-body">

				<!-- IF items.B_SHIPPERURL -->

				<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {L_3500_1015914}</div>

				<!-- ELSE -->

					<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> {L_3500_1015915}</div>

				<!-- ENDIF -->

				<table class="table table-bordered table-striped table-condensed">

					<tbody>

						<tr>

							<td><b>{L_3500_1015911}</b></td>

							<td><!-- IF items.B_SHIPPERURL -->{items.SHIPPER}<!-- ELSE --><a href="{items.SHIPPERURL}" target="_blank">{items.SHIPPER}</a><!-- ENDIF --></td>

						</tr>

						<tr>

							<td><b>{L_3500_1015913}</b></td>

							<td>{items.TRACKINGNUMBER}</td>

						</tr>

					</tbody>

				</table>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-info btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> {L_678}</button>

			</div>

		</div>

	</div>

</div>

<!-- ENDIF -->

<!-- END items -->

<div class="col-sm-9 table-responsive">

	<legend> {L_454}</legend>

  	<table class="table table-bordered table-striped table-condensed">

    	<tr>

      		<th> {L_125} </th>

      		<th> {L_461} </th>

      		<th> {L_284} </th>

      		<th> {L_column_shipping} </th>

      		<th> {L_189} </th>

      		<th>{L_350_10018} </th>

    	</tr>

    	<!-- BEGIN items -->

    	<tr>

    		<td colspan="7"> {L_458} <b><a href="{SITEURL}products/{items.SEO_TITLE}-{items.AUC_ID}" target="_blank">{items.TITLE}</a></b> (ID: <a href="{SITEURL}products/{items.SEO_TITLE}-{items.AUC_ID}" target="_blank">{items.AUC_ID}</a> - {L_25_0121}: {items.ENDS})</td>

    	</tr>

    	<tr valign="top">

      		<td>

      			{L_125}: {items.SELLNICK}

      			<span class="label label-success pull-right">{L_898}</span><br>

      			{L_460}: <small><a href="mailto:{items.SELLEMAIL}">{items.SELLEMAIL}</a></small><br><br>

      			<div class="form-inline">

      				<div class="form-group">

      					<!-- IF items.FB_LINK -->

        				<a class="btn btn-success btn-xs" href="{SITEURL}feedback.php?auction_id={items.AUC_ID}&wid={items.BUYER_ID}&sid={items.SELLID}"><span class="glyphicon glyphicon-star"></span> {L_207}</a>

      					<!-- ENDIF -->

      				</div>

      				<div class="form-group">

      					<form name="" method="post" action="{SITEURL}order_packingslip.php" id="fees" enctype="multipart/form-data" target="_blank">

							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

							<input type="hidden" name="pfval" value="{items.AUC_ID}">

							<input type="hidden" name="pfwon" value="{items.ID}">

							<input type="hidden" name="user_id" value="{items.SELLID}">

							<button type="submit" name="submit" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-file"></span> {L_text_packingslip}</button>

						</form>

      				</div>

      				<div class="form-group">

      					<!-- IF items.B_SHIPPED_1 -->

      					<form name="shipped" action="" method="post" enctype="multipart/form-data" id="process_shipped_{a.COUNTER}">

							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">

							<input type="hidden" name="update" value="shipped">

							<input type="hidden" name="shipped" value="{items.ID}">

							<input type="hidden" name="user_id" value="{items.WINNERID}">

							<button type="submit" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-ok"></span> {L_350_10021}</button>

						</form>

      					<!-- ENDIF -->

      				</div>

      				<!-- IF items.B_SHIPPER -->

      				<div class="form-group">

      					<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#trackinginfo{items.AUC_ID}"><span class="glyphicon glyphicon-info-sign"></span> {L_3500_1015910}</button>

      				</div>

      				<!-- ENDIF -->

      			</div>

      		</td>

      		<td> {items.FBID} </td>

      		<td> {items.QTY} </td>

      		<td>{items.SHIPPINGCOST}</td>

      		<td> {items.TOTAL} </td>

      		<td align="center">

        	<!-- IF items.B_DIGITAL_ITEM -->

      			<!-- IF items.B_PAID -->

    			<a class="btn btn-primary btn-sm" href="{SITEURL}my_downloads.php?diupload=3&fromfile={items.DIGITAL_ITEMS}">{L_350_10177}</a>

    			<!-- ELSE -->

    			{L_350_10024}

    			<!-- ENDIF -->

       		<!-- ELSE -->

    			<!-- IF items.B_SHIPPED_0 -->

		    	<img src="{SITEURL}images/Box-Empty.png" border="0"><br><strong>{L_350_10020}</strong>

				<!-- ENDIF -->

				<!-- IF items.B_SHIPPED_1 -->

		    	<img src="{SITEURL}images/Shipped.png" border="0"><br><strong>{L_350_10017}</strong>

				<!-- ENDIF -->

				<!-- IF items.B_SHIPPED_2 -->

		    	<img src="{SITEURL}images/delivery.png" border="0"><br><strong>{L_350_10022}</strong>

				<!-- ENDIF --> 

	   		<!-- ENDIF -->

      		</td>

    	</tr>

    <!-- END items -->

  </table>

    <ul class="pagination">

      <li>{PREV}</li>

      <!-- BEGIN pages -->

      <li>{pages.PAGE}</li>

      <!-- END pages -->

      <li>{NEXT}</li>

    </ul>

</div>