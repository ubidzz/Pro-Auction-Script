<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editmessage" action="" method="post">
	<input type="hidden" name="action" value="update">
  	<input type="hidden" name="id" value="{BOARD_ID}">
  	<input type="hidden" name="msg" value="{MSG_ID}">
    <input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
               	<tbody>
	             	<tr>
		              	<td width="24%" valign="top">{L_5059}</td>
		               	<td><textarea rows="8" cols="40" name="message">{MESSAGE}</textarea></td>
		           	</tr>
		          	<tr>
		              	<td>{L_5060}</td>
		            	<td>{USER} - {POSTED}</td>
		           	</tr>
           		</tbody>
          	</table>
		</div>
	</div>
</form>
