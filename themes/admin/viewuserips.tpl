<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="banips" action="" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<input type="hidden" name="offset" value="{OFFSET}">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="id" value="{ID}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{NICK} {L_2_0017}
		    	<input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_2_0015}">
		    	<a style="float:right" href="listusers.php?offset={OFFSET}" class="btn btn-xs btn-danger">{L_5279}</a>
	    	</div>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
                <thead>
                	<tr>
                      	<th colspan="4">
                          	{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                          	<br>
                           	{PREV}
            				<!-- BEGIN pages -->
                          	{pages.PAGE}&nbsp;&nbsp;
            				<!-- END pages -->
                         	{NEXT}
                      	</th>
                   	</tr>
                  	<tr>
                       	<th colspan="3">{L_667} <b>{NICK}</b></th>
                     	<th align="right">{L_559}: {LASTLOGIN}</th>
                 	</tr>
                    <tr>
                     	<th>{L_087}</th>
                     	<th>{L_2_0009}</th>
                     	<th>{L_560}</th>
                      	<th>{L_5028}</th>
                  	</tr>
             	</thead>
           		<tbody>
					<!-- BEGIN ips -->
	             	<tr>
	                   	<td>
                          	<!-- IF ips.TYPE eq 'first' -->
    						{L_2_0005}
    						<!-- ELSE -->
    						{L_221}
    						<!-- ENDIF -->
                     	</td>
	               		<td>{ips.IP}</td>
                    	<td>
                        	<!-- IF ips.ACTION eq 'accept' -->
                     		{L_2_0012}
                    		<!-- ELSE -->
                          	{L_2_0013}
                    		<!-- ENDIF -->
                    	</td>
                       	<td>
                       		<!-- IF ips.ACTION eq 'accept' -->
                        	<input type="checkbox" name="deny[]" value="{ips.ID}">&nbsp;{L_2_0006}
    						<!-- ELSE -->
                          	<input type="checkbox" name="accept[]" value="{ips.ID}">&nbsp;{L_2_0007}
    						<!-- ENDIF -->
                     	</td>
	              	</tr>
	              	<!-- END ips -->
	         	</tbody>
          	</table>
		</div>
	</div>
</form>
