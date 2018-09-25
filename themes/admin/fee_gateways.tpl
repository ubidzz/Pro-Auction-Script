<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="feeGateway" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="box box-info">
	    <div class="box-header">
	    	<h4 class="box-title">{PAGENAME}</h4>
	    	<div class="pull-right box-tools">
	    		<input style="float:right" type="submit" name="act" class="btn btn-success" value="{L_530}">
	    	</div>
		    <div class="box-body table-responsive">
				<table class="table table-hover table-striped">
	            	<!-- BEGIN gateways -->
	             	<thead>
	                   	<tr>
	                     	<th colspan="2"><h4>{gateways.NAME}</h4></th>
	            		</tr>
	           		</thead>
	               	<tbody>
	                   	<tr>
	                  		<td>
		                       	<p>
		                       		<!-- IF gateways.B_BANK_NAME -->
		                       			{gateways.BANK_NAME}
		                       		<!-- ELSE -->
		                       			<a href="{gateways.WEBSITE}" target="_blank">{gateways.ADDRESS_NAME}
		                       		<!-- ENDIF --></a>:<br>
		                       		<!-- IF gateways.B_BANK_NAME -->
		                       			<textarea class="form-control" name="{gateways.PLAIN_NAME}_name" value="{gateways.BANK_NAME2}" rows="4"></textarea>
		                       		<!-- ELSE -->
		                       			<input class="form-control" type="text" name="{gateways.PLAIN_NAME}_address" value="{gateways.ADDRESS}">
		                       		<!-- ENDIF -->
		                       	</p>
		            			<!-- IF gateways.B_PASSWORD -->
		                       	<p>
		                       		{gateways.ADDRESS_PASS}:<br>
		                       		<input class="form-control" type="text" name="{gateways.PLAIN_NAME}_password" value="{gateways.PASSWORD}">
		                       	</p>
		            			<!-- ENDIF -->
		            			<!-- IF gateways.B_BANK_ACCOUNT -->
		                      	<p>{gateways.BANK_ACCOUNT}:<br><input class="form-control" type="text" name="{gateways.PLAIN_NAME}_account" value="{gateways.BANK_ACCOUNT2}"></p>
		                      	<p>{gateways.BANK_ROUTING}:<br><input class="form-control" type="text" name="{gateways.PLAIN_NAME}_routing" value="{gateways.BANK_ROUTING2}" placeholder="{L_30_0218_a}"></p>
		           	 			<!-- ENDIF -->
	                 		</td>
	                 		<td>
	                           	<p><input type="checkbox" name="{gateways.PLAIN_NAME}_required"{gateways.REQUIRED}> {L_446}</p>
	                       		<p><input type="checkbox" name="{gateways.PLAIN_NAME}_active"{gateways.ENABLED}> {L_447}</p>
	                    	</td>
	              		</tr>
	               	</tbody>
	             	<!-- END gateways -->
	          	</table>
			</div>
		</div>
	</div>
</form>
