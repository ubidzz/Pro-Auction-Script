<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<table class="table table-bordered table-center table-striped">
    	<tr>
      		<th> {L_168} </th>
      		<th> {L_461} </th>
      	<th> {L_171} </th>
    	</tr>
    	<!-- BEGIN bids -->
    	<tr>
      		<td><a href="{SITEURL}products/{bids.SEO_TITLE}-{bids.ID}">{bids.TITLE}</a> </td>
      		<td> 
      			{bids.BID}
        		<!-- IF bids.QTY gt 1 -->
        		(x {bids.QTY} {L_5492})
        		<!-- ENDIF -->
        		<!-- IF bids.PROXYBID ne '' -->
        		<p><small>{bids.PROXYBID}</small></p>
        		<!-- ENDIF -->
      		</td>
      		<td> {bids.TIMELEFT} </td>
    	</tr>
    	<!-- END bids -->
    	<!-- IF NUM_BIDS eq 0 -->
    	<tr>
      		<td colspan="3">{L_3500_1015547}</td>
    	</tr>
    	<!-- ENDIF -->
  	</table>
  	<div class="alert">{L_30_0098}</div>
</div>