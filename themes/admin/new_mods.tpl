<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<!-- BEGIN new_mods -->
<form name="mods" action="{FORM_2}" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{new_mods.MOD} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{BUTTON_TITLE}"></h4>
	    </div>
	    <!-- IF new_mods.B_CHECKED -->
	    <!-- ELSE -->
	    <!-- ENDIF -->
	    <div class="panel-body">
			<table class="table table-bordered">
           		<thead>
                 	<tr>
                    	<th>{L_3500_1015452}</th>
                      	<th>{L_3500_1015455}</th>
                  	</tr>
             	</thead>
               	<tbody>
                    <tr>
                        <td>
                         	{new_mods.MAKER}<br>{new_mods.VERSION}<br>
                        	<!-- IF new_mods.B_CHECKED -->
                           	<span style="color:red">{L_3500_1015457}</span>
                          	<!-- ELSE -->
                         	<input type="hidden" name="download_mod" value="yes">
                    		<input type="hidden" name="download_this_mod" value="{new_mods.DOWNLOAD}">
							{L_3500_1015454}
                        	<!-- ENDIF -->
						</td>
                   		<td>{new_mods.INFO}</td>
                	</tr>
            	</tbody>
        	</table>
		</div>
		<!-- END new_mods -->
	</div>
</form>
