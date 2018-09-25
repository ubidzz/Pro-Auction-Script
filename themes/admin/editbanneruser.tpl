<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editbanneruser" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
              	<tbody>
                   	<tr>
                      	<td>{L_302}</td>
                       	<td><input type="text" name="name" value="{NAME}"></td>
                   	</tr>
                    <tr>
                         <td>{L__0022}</td>
                         <td><input type="text" name="company" value="{COMPANY}"></td>  
                    </tr>
                    <tr>
                        <td>{L_107}</td>
                     	<td><input type="text" name="email" value="{EMAIL}"></td>
                 	</tr>
             	</tbody>
           	</table>
		</div>
	</div>
</form>
