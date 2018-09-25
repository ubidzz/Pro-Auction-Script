<legend> {L_206}</legend>
<div class="col-sm-4">
	<div class="well">
  		<div align="center">
	  		<!-- IF AVATAR ne '' -->
		  	<img width="220px" height="120px" src="{AVATAR}" border="0">
		  	<!-- ELSE -->
		  	<img style="max-height:220px; max-width:220px" src="{SITEURL}/uploaded/avatar/default.png" border="0">
		  	<!-- ENDIF -->
	  	</div>
	  	<div align="center"><b>{USER} ({SUM_FB})</b> {RATE_VAL}</div>
   		<div align="center"><!-- IF IS_ONLINE --><img src="{SITEURL}images/online.png">{L_350_10111}<!-- ELSE --><img src="{SITEURL}images/offline.png">{L_350_10112}<!-- ENDIF --></div>
		<br>
  		<b>{L_209}</b> {REGSINCE}<br>
  		<b>{L_240}:</b> {COUNTRY}<br><br>
  		<b>{L_502}</b> {NUM_FB}<br>
  		{FB_POS}
  		{FB_NEUT}
  		{FB_NEG} 
  	</div>
</div>
<!-- IF B_VIEW -->
<div class="col-sm-8">
	<div class="well form-inline">
		<!-- IF B_AUCID -->
		<div class="form-group">
			<a class="btn btn-danger btn-sm" href="{BACK_TO_AUCTION}"><span class="glyphicon glyphicon-arrow-left"></span> {L_138}</a>
		</div>
		<!-- ENDIF -->
		<div class="form-group">
      		<a href="{SITEURL}active_auctions.php?user_id={USER_ID}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span> {L_213}</a>
      	</div>
      	<div class="form-group">
      		<a href="{SITEURL}closed_auctions.php?user_id={USER_ID}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span> {L_214}</a>
      	</div>
      	<!-- IF B_CONTACT -->
      	<div class="form-group">
      		<a href="{SITEURL}email_request.php?user_id={USER_ID}&amp;username={USER}" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-envelope"></span> {L_210}{USER}</a>
      	</div>
      	<!-- ENDIF -->
      	<div class="form-group">
      		<a href="{SITEURL}feedback.php?id={USER_ID}&amp;faction=show"  class="btn btn-success btn-sm"><span class="glyphicon glyphicon-star"></span> {L_208}</a>
      	</div>
  	</div>
	<div class="well">
		<legend>{L_385}</legend>
	 	<table class="table table-condensed">
	    	<tr style="border:none">
	      		<td style="text-align:center" width="25%">&nbsp;</td>
	      		<td style="text-align:center" width="25%"><img src="{SITEURL}images/positive.png"></td>
	      		<td style="text-align:center" width="25%"><img src="{SITEURL}images/neutral.png"></td>
	      		<td style="text-align:center" width="25%"><img src="{SITEURL}images/negative.png"></td>
	   	 	</tr>
	    	<tr>
	      		<td>{L_386}</td>
	      		<td style="text-align:center; color:#009933">{FB_LASTMONTH_POS}</td>
	      		<td style="text-align:center">{FB_LASTMONTH_NEUT}</td>
	      		<td style="text-align:center;color:#FF0000">{FB_LASTMONTH_NEG}</td>
	    	</tr>
	    	<tr>
	      		<td>{L_387}</td>
	      		<td style="text-align:center; color:#009933">{FB_LAST3MONTH_POS}</td>
	      		<td style="text-align:center">{FB_LAST3MONTH_NEUT}</td>
	      		<td style="text-align:center; color:#FF0000" style="">
	      		{FB_LAST3MONTH_NEG}
	      		</td>
	    	</tr>
	    	<tr>
	      		<td>{L_388}</td>
	      		<td style="text-align:center; color:#009933">{FB_LASTYEAR_POS}</td>
	      		<td style="text-align:center">{FB_LASTYEAR_NEUT}</td>
	      		<td style="text-align:center; color:#FF0000">{FB_LASTYEAR_NEG}</td>
	    	</tr>
	    	<tr valign="top">
	      		<td colspan="4" ><img src="{SITEURL}images/transparent.gif" width="1" height="5"></td>
	    	</tr>
	    	<tr>
	      		<td>{L_389}</td>
	      		<td style="text-align:center; color:#009933">{FB_SELLER_POS}</td>
	      		<td style="text-align:center">{FB_SELLER_NEUT}</td>
	      		<td style="text-align:center; color:#FF0000">{FB_SELLER_NEG}</td>
	   	 	</tr>
	    	<tr>
	      		<td>{L_390}</td>
	      		<td style="text-align:center; color:#009933">{FB_BUYER_POS}</td>
	      		<td style="text-align:center">{FB_BUYER_NEUT}</td>
	      		<td style="text-align:center; color:#FF0000">{FB_BUYER_NEG}</td>
	    	</tr>
	  	</table>
	</div>
</div>
<!-- ELSE -->
<div class="info"> {MSG}</div>
<!-- ENDIF -->

</div>
