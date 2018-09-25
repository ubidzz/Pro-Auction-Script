<!-- INCLUDE user_menu_header.tpl -->

<div class="col-sm-9">

	<table class="table table-bordered table-condensed table-striped" width="100%" cellspacing="3" cellpadding="4">

		<tr>

			<th>{L_1041}</th>

			<th>{L_1053}</th>

			<th>{L_560}</th>

		</tr>

		<!-- BEGIN topay -->

		<tr>

			<td>

				<span>{L_1041}: {topay.ID}</span>

				<p>{topay.DATE}</p>

			</td>

			<td>{topay.TOTAL}</td>

			<td align="center">

				<!-- IF topay.PAID -->
				<div class="label label-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> {L_898}</div>
				<!-- ELSE -->
				<div class="label label-danger"><i class="fa fa-times" aria-hidden="true"></i> {L_3500_1016037}</div>
				<!-- ENDIF -->
				
				<p><br /><a class="btn btn-sm btn-info" href="{SITEURL}order_print.php?id={topay.INVOICE}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> {L_1058}</a></p>

			</td>

		</tr>

		<!-- END topay -->

	</table> 

	<ul class="pagination">

    	<li>{PREV}</li>

    	<!-- BEGIN pages -->

		{pages.PAGE}

		<!-- END pages -->

        <li>{NEXT}</li>

	</ul>

</div>