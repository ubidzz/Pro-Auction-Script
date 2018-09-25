<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="durations" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>{L_097}</th>
                        <th>{L_087}</th>
                    	<th>{L_008}</th>
                	</tr>
                </thead>
              	<tbody>
                    <!-- BEGIN dur -->
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="text" name="new_days[{dur.ID}]" value="{dur.DAYS}" size="5"></td>
                        <td><input type="text" name="new_durations[{dur.ID}]" value="{dur.DESC}" size="25"></td>
                    	<td><input type="checkbox" id="delete" name="delete[]" value="{dur.ID}"></td>
                    </tr>
                    <!-- END dur -->
                    <tr>
                        <td>{L_518}</td>
                        <td><input type="text" name="new_days[]" size="5" maxlength="5"></td>
                        <td><input type="text" name="new_durations[]" size="25"></td>
                    	<td>&nbsp;</td>
                    </tr>
                 	<tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>{L_30_0102}</td>
                    	<td><input type="checkbox" id="deleteall" value="delete"></td>
                	</tr>
            	</tbody>
        	</table>
		</div>
	</div>
</form>
