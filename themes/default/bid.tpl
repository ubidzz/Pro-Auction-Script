<div class="col-sm-4">
	<!-- IF B_HASENDED eq false -->
	<div class="well well-sm">
		<!-- IF ERROR ne '' -->
		{ERROR}
		<!-- ENDIF -->
		<!-- IF B_FREE_ITEM -->
		{L_3500_1015745}: <a style="cursor:pointer" class="btn btn-success" href="{SITEURL}buy_now.php?id={ID}">{L_3500_1015747}</a><br><br>
		<!-- ELSE -->
		<!-- IF B_NOTBNONLY -->
			<form name="bid" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
				<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
				<div class="alert alert-success" id="current_bid_box" role="alert"><span class="glyphicon glyphicon-ok"></span> <b>{L_116}</b> {CURRENT_BID}</div>
				<!-- IF B_LOGGED_IN -->
				<div class="form-group">
					<label class="col-xs-4 control-label">{L_156}</label> 
					<div class="col-xs-7">
		      			<input type="text" maxlength="15" name="bid" id="bid" class="form-control" value="{BID}">
		      			<!-- IF ATYPE eq 1 -->
			    		<div id="next_bid"><small><b>{L_124}:</b> {NEXT_BID}</small></div>
		        		<!-- ENDIF -->

		      		</div>
		      	</div>
			    <!-- IF TQTY gt 1 -->
			    <div class="form-group">
			    	<label class="col-xs-4 control-label">{L_284}:</label>
			    	<div class="col-xs-7">
						<input type="text" size="3" name="qty" class="form-control" id="qty" value="{QTY}">
					</div>
				</div>
			  	<!-- ENDIF -->
			 	<!-- IF B_USERAUTH -->
				<div class="form-group">
					<label class="col-xs-4 control-label">{L_003}:</label>
					<div class="col-xs-7">
						<div class="form-control" readonly>{YOURUSERNAME}</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">{L_004}:</label>
					<div class="col-xs-7">
						<input type="password" class="form-control" name="password" size="20"  value="">
					</div>
				</div>
				<!-- ENDIF -->
				<div align="center">
					<input type="hidden" name="id" value="{ID}">
					<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> {AGREEMENT}</div>
					<input type="hidden" name="action" value="bid">
					<button type="submit" name="Input" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> {L_5199}</button>
				</div>
				<!-- ELSE -->				
				<div class="form-group">
					<label class="col-xs-4 control-label">{L_156}</label> 
					<div class="col-xs-7">
						<p id="bid" class="form-control-static form-control" disabled>{BID}<p></p>
		      			<!-- IF ATYPE eq 1 -->
			    		<div id="next_bid"><small><b>{L_124}:</b> {NEXT_BID}</small></div>
		        		<!-- ENDIF -->
		      		</div>
		      	</div>
			    <!-- IF TQTY gt 1 -->
			    <div class="form-group">
			    	<label class="col-xs-4 control-label">{L_284}:</label>
			    	<div class="col-xs-2">
			    		<p class="form-control-static form-control" disabled>{QTY}</p>
					</div>
				</div>
			  	<!-- ENDIF -->
				<div align="center">
					<input type="hidden" name="id" value="{ID}">
					<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> {AGREEMENT}</div>
				</div>
				<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> {L_3500_1015921}</div>
				<!-- ENDIF -->
			</form>
		<!-- ENDIF -->
		<!-- IF B_BUY_NOW_ONLY -->
		<div style=" text-align:center"> 
			<em><p>{L_496}: {BUYNOW} <a class="btn btn-success" href="{SITEURL}buy_now.php?id={ID}">{L_350_1015402}</a></p></em>
		</div>
		<!-- ENDIF -->
		<!-- ENDIF -->
	</div>
	<!-- ENDIF -->
</div>