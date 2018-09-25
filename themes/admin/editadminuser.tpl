<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editadmin" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<tbody>
                    <tr>
                        <td>{L_003}</td>
                     	<td>{USERNAME}</td>
                    </tr>
                   	<tr>
                        <td>{L_558}</td>
                     	<td>{CREATED}</td>
                   	</tr>
                    <tr>
                        <td>{L_559}</td>
                     	<td>{LASTLOGIN}</td>
                    </tr>
                    <tr>
                     	<td colspan="2">{L_563}</td>
                    </tr>
                    <tr>
                        <td>{L_004}</td>
                    	<td><input type="password" name="password" size="25"></td>
                    </tr>
                    <tr>
                        <td>{L_564}</td>
                    	<td><input type="password" name="repeatpassword" size="25"></td>
                    </tr>
                  	<tr>
                        <td>&nbsp;</td>
                        <td>
                           	<input type="radio" name="status" value="1"<!-- IF B_ACTIVE --> checked="checked"<!-- ENDIF -->> {L_566} 
                        	<input type="radio" name="status" value="2"<!-- IF B_INACTIVE --> checked="checked"<!-- ENDIF -->> {L_567}
                    	</td>
                	</tr>
            	</tbody>
        	</table>
		</div>
	</div>
</form>
