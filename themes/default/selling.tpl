<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9 table-responsive">
	<legend> {L_453}</legend>
	<table class="table table-bordered table-striped table-hover">
  		<tr>
    		<th> {L_458} </th>
    		<th> {L_455} </th>
    		<th> {L_284} </th>
    		<th> {L_893} </th>
    		<!-- IF B_DIGITAL_ITEM eq false -->
    		<th> {L_350_10018} </th>
    		<!-- ENDIF -->
  		</tr>
  		<!-- BEGIN a -->
  		<!-- IF a.B_SHIPPER -->
  		<div class="modal fade" id="AddTrackingNumber{a.ID}" tabindex="-1" role="dialog" aria-labelledby="AddTrackingNumber">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        		<h4 class="modal-title" id="myModalLabel">{L_3500_1015916}</h4>
		      		</div>
		      		<form name="trackingPackage" action="" method="post" enctype="multipart/form-data">
			      		<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
			      		<input type="hidden" name="wid" value="{a.ID}">
			      		<input type="hidden" name="update" value="addTracking">
			      		<div class="modal-body form-horizontal">
			        		<div class="form-group">
			        			<label for="shipper" class="col-sm-4 control-label">{L_3500_1015911}</label>
			        			<div class="col-sm-8">
			        				<input id="shipper" class="form-control" type="text" name="shipper" value="{a.SHIPPER}" placeholder="{L_3500_1015917}">
			        			</div>
			        		</div>
			        		<div class="form-group">
			        			<label for="shipperURL" class="col-sm-4 control-label">{L_3500_1015912}</label>
			        			<div class="col-sm-8">
			        				<input id="shipperURL" class="form-control" type="text" name="shipperURL" value="{a.SHIPPERURL}" placeholder="{L_3500_1015918}">
			        			</div>
			        		</div>
							<div class="form-group">
			        			<label for="trackingNumber" class="col-sm-4 control-label">{L_3500_1015913}</label>
			        			<div class="col-sm-8">
			        				<input id="trackingNumber" class="form-control" type="text" name="trackingNumber" value="{a.TRACKINGNUMBER}" placeholder="{L_3500_1015919}">
			        			</div>
			        		</div>
			      		</div>
			      		<div class="modal-footer">
			      			<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_3500_1015828}</button>
			        		<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> {L_678}</button>
			      		</div>
		      		</form>
		    	</div>
		  	</div>
		</div>
		<!-- ENDIF -->
  		<script type="text/javascript">
			$(document).ready(function() {
				$("#process_paid_{a.COUNTER}").submit(function() {
					if (confirm('{a.MARK_PAID_MSG}')){
						return true;
					} else {
						return false;
					}
				});
				$("#process_shipped_{a.COUNTER}").submit(function() {
					if (confirm('{a.MARK_SHIPPED_MSG}')){
						return true;
					} else {
						return false;
					}
				});
			});
  		</script>
  		<tr>
    		<td>
    			<a href="{SITEURL}products/{a.SEO_TITLE}-{a.AUCTIONID}" target="_blank">{a.TITLE}</a><br>
      			<small>(ID: <a href="{SITEURL}products/{a.SEO_TITLE}-{a.AUCTIONID}" target="_blank">{a.AUCTIONID}</a> - {L_25_0121} {a.ENDS})</small>
    			<br>
      			<div class="form-inline">
      				<div class="form-group">
				  		<!-- IF a.B_DIGITAL_ITEM -->
    					<a class="btn btn-success btn-sm" href="{SITEURL}my_downloads.php?diupload=3&fromfile={a.DIGITAL_ITEM}">{L_350_10177}</a> 
    					<!-- ENDIF -->
				  	</div>
				  	<br>
				  	<!-- IF a.B_DIGITAL_ITEM eq false -->
      				<div class="form-group">
					  	<form name="" method="post" action="{SITEURL}order_packingslip.php" id="fees" enctype="multipart/form-data" target="_blank">
							<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
							<input type="hidden" name="pfval" value="{a.AUCTIONID}">
							<input type="hidden" name="pfwon" value="{a.ID}">
							<input type="hidden" name="user_id" value="{SELLER_ID}">
							<button type="submit" name="submit" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-save-file"></span> {L_text_packingslip}</button>
						</form>
					</div>
					<!-- ENDIF -->
				</div>
      		</td>
    		<td>
    			<a href="{SITEURL}profile.php?user_id={a.WINNERID}">{a.NICK}</a><br>
    			<!-- IF a.B_FB -->
      			<div class="form-group">
      				<div class="label label-danger"><span class="glyphicon glyphicon-remove"></span> {L_072}</div><br><br>
	    			<a class="btn btn-small btn-success btn-sm" href="{SITEURL}feedback.php?auction_id={a.AUCTIONID}&wid={a.WINNERID}&sid={a.SELLERID}&ws=s"><span class="glyphicon glyphicon-star"></span> {L_207}</a>
	    		</div>
	    		<!-- ELSE -->
	    		<div class="form-group">
	    			<div class="label label-success"><span class="glyphicon glyphicon-ok"></span> {L_30_0213}</div>
	    		</div>
	    		<!-- ENDIF -->
    		</td>
    		<td> 
	 			{a.QTY}
	 		</td>
	 		<td> 
	 			{a.BIDF}<br>
	 			<!-- IF a.B_PAID -->
    			<div class="label label-success"><span class="glyphicon glyphicon-ok"></span> {L_898}</div>
    			<!-- ELSE -->
    			<div class="label label-danger"><span class="glyphicon glyphicon-remove"></span> {L_350_10024}</div>
    			<br><br>
    			<form name="paid" action="" method="post" enctype="multipart/form-data" id="process_paid_{a.COUNTER}">
					<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
					<input type="hidden" name="update" value="paid">
					<input type="hidden" name="db_id" value="{a.ID}">
					<input type="hidden" name="user_id" value="{SELLER_ID}">
					<!-- IF a.B_DIGITAL_ITEM -->
					<input type="hidden" name="item" value="{a.DIGITAL_ITEM}">
					<!-- ENDIF -->
					<button type="submit" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-info-sign"></span> {L_899}</button>
				</form>
    			<!-- ENDIF -->
 			</td>
 			<!-- IF B_DIGITAL_ITEM eq false -->
	 		<td align="center"> 
	 			<div class="form-inline">
		 			<!-- IF a.B_SHIPPED_0 -->
		 			<img src="{SITEURL}images/Box-Empty.png" border="0"><br><strong>{L_350_10020}</strong><br>
		 			<div class="form-group">
		 			<form name="shipped" action="" method="post" enctype="multipart/form-data" id="process_shipped_{a.COUNTER}">
						<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
						<input type="hidden" name="update" value="shipped">
						<input type="hidden" name="shipped" value="{a.ID}">
						<input type="hidden" name="user_id" value="{SELLER_ID}">
						<button type="submit" name="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> {L_350_10019}</button>
					</form>
					</div>
		 			<!-- ENDIF -->
					<!-- IF a.B_SHIPPED_1 -->
			    	<img src="{SITEURL}images/Shipped.png" border="0"><br><strong>{L_350_10017}</strong><br>
					<!-- ENDIF -->
					<!-- IF a.B_SHIPPED_2 -->
			    	<img src="{SITEURL}images/delivery.png" border="0"><br><strong>{L_350_10022}</strong><br>
					<!-- ENDIF -->
					<!-- IF a.B_SHIPPER -->
					<div class="form-group">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddTrackingNumber{a.ID}"><span class="glyphicon glyphicon-plus"></span> {L_3500_1015916}</button>
					</div>
					<!-- ENDIF -->
				</div>
			</td>
			<!-- ENDIF -->
  		</tr>
  		<!-- END a -->
  		<!-- IF NUM_WINNERS eq 0 -->
  		<tr>
    		<td colspan="5"> {L_198} </td>
  		</tr>
  		<!-- ENDIF -->
	</table>
    <ul class="pagination">
        <li>{PREV}</li>
        <!-- BEGIN pages -->
        <li>{pages.PAGE}</li>
        <!-- END pages -->
		<li>{NEXT}</li>
	</ul>
</div>