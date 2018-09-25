<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="countries" action="" method="post">
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
                        <th>{L_087}</th>
                    	<th>{L_008}</th>
                	</tr>
          		</thead>
              	<tbody>
                   	<tr>
                        <td>&nbsp;</td>
                        <td>{L_30_0102}</td>
                     	<td><input type="checkbox" id="deleteall" value="delete"></td>
                    </tr>
                    <tr>
                        <td>{L_394}</td>
                        <td><input type="text" name="add_new_countries[]" size="45"></td>
                    	<td>&nbsp;</td>
                   	</tr>
                    <!-- BEGIN countries -->
                  	<tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="text" name="new_countries[]" size="45" value="{countries.COUNTRY}">
                        	<input type="hidden" name="old_countries[]" value="{countries.COUNTRY}">
                        </td>
                    	<td>{countries.SELECTBOX}</td>
                    </tr>
                	<!-- END countries -->
            	</tbody>
        	</table>
		</div>
	</div>
</form>
