<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<div class="panel-title">
    		{PAGENAME}
	    	<form style="float:right" name="errorlog" action="" method="post">
	    		<input type="hidden" name="action" value="clearlog">
	    		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	    		<input type="submit" name="act" class="btn btn-xs btn-success" value="{L_890}">
	    	</form>
    	</div>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
          	<thead>
              	<tr>
                   	<th colspan="4">
                    	<form name="clearmessages" action="" method="post">
                         	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	                      	{L_5065}
	                       	<input type="text" name="days">
	                       	{L_5115}&nbsp;&nbsp;&nbsp;
	                       	<input type="hidden" name="action" value="purge">
	                       	<input type="hidden" name="id" value="{ID}">
	                       	<input type="submit" name="submit" class="btn btn-success" value="{L_008}">
                       	</form>
                  	</th>
              	</tr>
              	<tr>
	              	<th>{L_5059}</th>
	              	<th>{L_5060}</th>
                 	<th>{L_314}</th>
                 	<th>&nbsp;</th>
               	</tr>
          	</thead>
           	<tbody>
              	<!-- BEGIN msgs -->
              	<tr>
                   	<td>{msgs.MESSAGE}</td>
                   	<td>{msgs.POSTED_BY}</td>
                  	<td>{msgs.POSTED_AT}</td>
                 	<td><a href="editmessage.php?id={ID}&msg={msgs.ID}">{L_298}</a>&nbsp;|&nbsp;<a href="deletemessage.php?board_id={ID}&id={msgs.ID}">{L_008}</a></td>
             	</tr>
              	<!-- END msgs -->
          	</tbody>
      	</table>
	</div>
</div>

