<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="detail" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="offset" value="{OFFSET}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">
	    		{PAGENAME}
	    		<input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_030}">
	    		<input style="float:right" type="submit" name="action" class="btn btn-xs btn-danger" value="{L_029}">
	    	</h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<tbody>
                    <tr>
                    	<td>{L_3500_1015470}</td>
                	</tr>
            	</tbody>
        	</table>
		</div>
	</div>
</form>
<form name="details" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="offset" value="{OFFSET}">
	<input type="hidden" name="reportid" value="{REPORTID}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">
	    		{PAGENAME}
	    		<input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="All">
	    		<input style="float:right" type="submit" name="action" class="btn btn-xs btn-danger" value="{L_029}">
	    	</h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<tbody>
                    <tr>
                    	<td>{L_3500_1015471}</td>
                	</tr>
            	</tbody>
        	</table>
		</div>
	</div>
</form>
<div class="panel panel-primary">
	<div class="panel-heading">
	  	<h4 class="panel-title">{L_3500_1015472}</h4>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
        	<tbody>
            	<tr>
                    <td>{L_312}</td>
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
