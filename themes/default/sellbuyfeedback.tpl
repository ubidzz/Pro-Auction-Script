<!-- INCLUDE user_menu_header.tpl -->

<div class="col-sm-9">

	  <table class="table table-bordered table-striped">

	   	<!-- IF NUM_AUCTIONS gt 0 -->

    	<tr>

      		<th> {L_458} </th>

      		<th style="min-width:100px;"> {L_25_0004} </th>

      		<th class="hidden-phone"> {L_303} </th>

      		<th> {L_25_0006} </th>

      		<th class="hidden-phone"> {L_284} </th>

    	</tr>

    	<!-- BEGIN fbs -->

    	<tr>

      		<td><b><a href="{SITEURL}products/{fbs.SEO_TITLE}-{fbs.ID}" target="_blank">{fbs.TITLE}</a></b><br>

        		<small>{fbs.CLOSINGDATE}</small> </td>

      		<td> {fbs.WINORSELLNICK}, <small><strong>{fbs.WINORSELL}</strong></small> <br>

        		<a class="btn btn-success btn-sm" href="{SITEURL}feedback.php?auction_id={fbs.ID}&wid={fbs.WINNER}&sid={fbs.SELLER}&ws={fbs.WS}"><span class="glyphicon glyphicon-star"></span> {L_207}</a> </td>

      		<td><a href="mailto:{fbs.WINORSELLEMAIL}"><small>{fbs.WINORSELLEMAIL}</small></a> </td>

      		<td> {fbs.BIDFORM} </td>

      		<td class="hidden-phone"> {fbs.QTY} </td>

   	 	</tr>

    	<!-- END fbs -->

    	<!-- ELSE -->

    	<tr>

      		<td><b>{L_30_0213}</b> </td>

    	</tr>

    	<!-- ENDIF -->

  	</table>

</div>

