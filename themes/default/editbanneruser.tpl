<!-- INCLUDE user_menu_header.tpl -->
<div class="col-sm-9">
	<legend>{L_350_1012212}</legend>
	<form name="editbanneruser" action="" method="post">
		<table class="table table-bordered table-condense table-striped">
			<tbody>
				<tr>
                    	<td>{L_302}</td>
                    	<td><input type="text" name="name" class="form-control" value="{NAME}"></td>
                    </tr>
                    <tr>
                    	<td>{L__0022}</td>
                    	<td><input type="text" name="company" class="form-control" value="{COMPANY}"></td>
                    </tr>
                    <tr>
                    	<td>{L_107}</td>
                    	<td><input type="text" name="email" class="form-control" value="{EMAIL}"></td>
                    </tr>
			</tbody>
		</table>
		<input type="hidden" name="id" value="{ID}">
       	<input type="hidden" name="action" value="update">
       	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
       	<button type="submit" name="submit" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> {L_530}</button>
     	<span><a class="btn btn-sm btn-info" href="{SITEURL}managebanners.php"><span class="glyphicon glyphicon-remove"></span> {L_350_1012222}</a></span>
	</form>
</div>