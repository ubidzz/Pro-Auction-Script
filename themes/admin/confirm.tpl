<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="confirm" action="" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<input type="hidden" name="id" value="{ID}">
    <!-- IF TYPE eq 2 -->
   	<input type="hidden" name="user" value="{USERID}">
    <!-- ENDIF -->
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
	                	<td>{MESSAGE}</td>
	            	</tr>
	         	</tbody>
        	</table>
		</div>
	</div>
</form>
