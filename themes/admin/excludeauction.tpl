<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="details" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="offset" value="{OFFSET}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{PAGENAME}
		    	<input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_030}">
		    	<input style="float:right" type="submit" name="action" class="btn btn-xs btn-warning" value="{L_029}">
	    	</div>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
             	<thead>
                  	<tr>
                      	<th colspan="2">
                          	<!-- IF SUSPENDED eq 0 -->
				           	{L_323}
							<!-- ELSE -->
				          	{L_324}
							<!-- ENDIF -->
						</th>
                   	</tr>
             	</thead>
              	<tbody>
                   	<tr>
				  		<td width="20%">{L_312}</td>
				       	<td>{TITLE}</td>
				  	</tr>
				 	<tr>
				      	<td>{L_313}</td>
				      	<td>{NICK}</td>
				 	</tr>
				 	<tr>
				      	<td>{L_314}</td>
				       	<td>{STARTS}</td>
				  	</tr>
				 	<tr>
				       	<td>{L_022}</td>
				      	<td>{DURATION}</td>
				   	</tr>
				  	<tr>
				       	<td>{L_287}</td>
				     	<td>{CATEGORY}</td>
				   	</tr>
				  	<tr>
				      	<td>{L_018}</td>
				      	<td>{DESCRIPTION}</td>
				  	</tr>
				   	<tr>
				    	<td>{L_116}</td>
				      	<td>{CURRENT_BID}</td>
				  	</tr>
				  	<tr>
				       	<td>{L_258}</td>
				       	<td>{QTY}</td>
				  	</tr>
				 	<tr>
				       	<td>{L_021}</td>
				      	<td>{RESERVE_PRICE}</td>
				   	</tr>
				   	<tr>
				     	<td>{L_300}</td>
				      	<td>
							<!-- IF SUSPENDED eq 0 -->
				          	{L_029}
							<!-- ELSE -->
				        	{L_030}
							<!-- ENDIF -->
				      	</td>
				  	</tr>
              	</tbody>
          	</table>
		</div>
	</div>
</form>
