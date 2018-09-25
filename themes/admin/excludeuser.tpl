<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="excludeuser" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="offset" value="{OFFSET}">
	 <input type="hidden" name="mode" value="{MODE}">
	 <input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">
	    		{QUESTION}
	    		<input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_030}">
	    		<input style="float:right" type="submit" name="action" class="btn btn-xs btn-warning" value="{L_029}">
	    	</h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
              	<tbody>
                 	<tr>
                       	<td>{L_302}</td>
                     	<td>{REALNAME}</td>
                  	</tr>
                  	<tr>
                     	<td>{L_003}</td>
                      	<td>{USERNAME}</td>
                  	</tr>
                   	<tr>
                       	<td>{L_303}</td>
                     	<td>{EMAIL}</td>
                 	</tr>
                 	<tr>
                       	<td>{L_252}</td>
                     	<td>{DOB}</td>
                 	</tr>
                  	<tr>
		               	<td>{L_009}</td>
		              	<td>{ADDRESS}</td>
		           	</tr>
		           	<tr>
		               	<td>{L_011}</td>
		               	<td>{PROV}</td>
		          	</tr>
		          	<tr>
		              	<td>{L_012}</td>
		              	<td>{ZIP}</td>
		          	</tr>
		          	<tr>
		              	<td>{L_014}</td>
		             	<td>{COUNTRY}</td>
		          	</tr>
		         	<tr>
		             	<td>{L_013}</td>
		             	<td>{PHONE}</td>
		          	</tr>
		           	<tr>
		              	<td>{L_222}</td>
		              	<td><p><a href="userfeedback.php?id={ID}">{L_208}</a></p></td>
		         	</tr>
		     	</tbody>
          	</table>
		</div>
	</div>
</form>
