<div class="alert alert-info">
  <p align="center">{TOP_MESSAGE}</p>
</div>
<!-- IF SSL -->
<div class="alert alert-success"><img src="{SITEURL}images/ssl.png">{L_3500_1015493}</div>
<!-- ENDIF -->

<table class="table table-bordered">
  	<!-- IF B_ENPAYPAL -->
  	<tr>
    	<td width="160" ><img src="images/paypal.gif"></td>
	    <td >{L_767}</td>
	    <td >
	    	<form action="{PP_LINK}" method="post" id="form_paypal">
		        <input type="hidden" name="cmd" value="_xclick">
		        <input type="hidden" name="business" value="{PP_PAYTOEMAIL}">
		        <input type="hidden" name="receiver_email" value="{PP_PAYTOEMAIL}">
		        <input type="hidden" name="amount" value="{PAY_VAL}">  
		        <input type="hidden" name="quantity" value="{ITEM_QUANTITY}">
		        <input type="hidden" name="currency_code" value="{CURRENCY}">
		        <input type="hidden" name="return" value="{SITEURL}validate.php?completed">
		        <input type="hidden" name="cancel_return" value="{SITEURL}validate.php?fail">
		        <input type="hidden" name="item_name" value="{TITLE}">
		        <input type="hidden" name="undefined_quantity" value="0">
		        <input type="hidden" name="quantity" value="{ITEM_QUANTITY}">
		        <input type="hidden" name="no_shipping" value="1">
		        <input type="hidden" name="shipping" value="{SHIPPING_COST}">
		        <input type="hidden" name="no_note" value="1">
		        <input type="hidden" name="custom" value="{CUSTOM_CODE}">
		        <input type="hidden" name="notify_url" value="{SITEURL}validate.php?paypal">
		        <input class="btn btn-primary" name="submit" type="submit" value="{L_756}" border="0" class="btn btn-primary">
	      	</form>
    	</td>
  	</tr>
  	<!-- ENDIF -->
  	<!-- IF B_ENAUTHNET -->
  	<tr>
    	<td width="160" ><img src="images/authnet.gif"></td>
    	<td >Authorize.Net</td>
    	<td >
    		<form action="{AZ_LINK}" method="post" id="form_authnet">
		        <input type="hidden" name="x_description" value="{TITLE}">
		        <input type="hidden" name="x_login" value="{AN_PAYTOID}">
		        <input type="hidden" name="x_amount" value="{PAY_VAL}">
		        <input type="hidden" name="x_show_form" value="PAYMENT_FORM">
		        <input type="hidden" name="x_relay_response" value="TRUE">
		        <input type="hidden" name="x_relay_url" value="{SITEURL}validate.php?authnet">
		        <input type="hidden" name="x_fp_sequence" value="{AN_SEQUENCE}">
		        <input type="hidden" name="x_fp_timestamp" value="{AN_TIMESTAMP}">
		        <input type="hidden" name="x_fp_hash" value="{AN_KEY}">
		        <input type="hidden" name="custom" value="{CUSTOM_CODE}">
		        <input name="submit" type="submit" value="{L_756}" class="btn btn-primary">
      		</form>
      	</td>
  	</tr>
  	<!-- ENDIF -->
  	<!-- IF B_ENWORLDPAY -->
  	<tr>
    	<td width="160" ><img src="images/worldpay.gif"></td>
    	<td >WorldPay</td>
    	<td >
    		<form action="{WP_LINK}" method="post" id="form_worldpay">
        		<input type="hidden" name="instId" value="{WP_PAYTOID}">
        		<input type="hidden" name="amount" value="{PAY_VAL}">
        		<input type="hidden" name="currency" value="{CURRENCY}">
        		<input type="hidden" name="desc" value="{TITLE}">
        		<input type="hidden" name="MC_callback" value="{SITEURL}validate.php?worldpay">
        		<input type="hidden" name="cartId" value="{CUSTOM_CODE}">
        		<input name="submit" type="submit" value="{L_756}" class="btn btn-primary">
     	 	</form>
      	</td>
  	</tr>
  	<!-- ENDIF -->
  	<!-- IF B_ENSKRILL-->
  	<tr>
    	<td width="160" ><img src="images/moneybookers.gif"></td>
    	<td >Skrill</td>
    	<td >
    		<form action="{SK_LINK}" method="post" id="form_skrill">
		        <input type="hidden" name="pay_to_email" value="{MB_PAYTOEMAIL}">
		        <input type="hidden" name="amount" value="{PAY_VAL}">
		        <input type="hidden" name="language" value="EN">
		        <input type="hidden" name="merchant_fields" value="trans_id">
		        <input type="hidden" name="currency" value="{CURRENCY}">
		        <input type="hidden" name="return_url" value="{SITEURL}validate.php?completed">
		        <input type="hidden" name="cancel_url" value="{SITEURL}validate.php?fail">
		        <input type="hidden" name="status_url" value="{SITEURL}validate.php?skrill">
		        <input type="hidden" name="trans_id" value="{CUSTOM_CODE}">
		        <input name="submit" type="submit" value="{L_756}" class="btn btn-primary">
      		</form>
      	</td>
  	</tr>
  	<!-- ENDIF -->
  	<!-- IF B_ENTOOCHECK -->
  	<tr>
		<td width="160" ><img src="images/toocheckout.gif"></td>
    	<td >2Checkout</td>
    	<td >
    		<form action="{CO_LINK}" method="post" id="form_toocheckout">
        		<input type="hidden" name="sid" value="{TC_PAYTOID}">
        		<input type="hidden" name="total" value="{PAY_VAL}">
        		<input type="hidden" name="cart_order_id" value="{CUSTOM_CODE}">
        		<input name="submit" type="submit" value="{L_756}" class="btn btn-primary">
      		</form>
      	</td>
  	</tr>
  	<!-- ENDIF -->
</table>
  <!-- IF B_BANK_TRANSFER -->
<table class="table table-bordered">
	<tr>
		<th>{L_30_0219}</th>
		<th>{L_30_0228}</th>
	</tr>
	<tr>
		<td>{L_30_0215}</td>
		<td>{NAME}</td>
	</tr>
	<tr>
		<td>{L_009}:</td>
		<td>{ADRESS}</td>
	</tr>
	<tr>
		<td>{L_010}:</td>
		<td>{CITY}&nbsp; {PROV}</td>
	</tr>
	<tr>
		<td>{L_014}:</td>
		<td>{COUNTRY}</td>
	</tr>
	<tr>
		<td>{L_012}:</td>
		<td>{ZIP}</td>
	</tr>
	<tr>
		<td>{L_30_0216}:</td>
		<td>{BANK}</td>
	</tr>
	<tr>
		<td>{L_30_0217}:</td>
		<td>{BANK_ACCOUNT}</td>
	</tr>
	<tr>
		<td>{L_30_0218}:</td>
		<td>{BANK_ROUTING}</td>
	</tr>
</table>
<!-- ENDIF -->
<!-- IF B_TOUSER -->
<div style="text-align:center;"> {TOUSER_STRING} </div>
<!-- ENDIF -->
<div>
