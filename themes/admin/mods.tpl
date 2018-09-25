<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="mods" action="{FORM}" method="post">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{BUTTON_TITLE}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
             	<thead>
                 	<tr>
                   		<th>{L_3500_1015452}</th>
                       	<th>{L_3500_1015455}</th>
                  	</tr>
                </thead>
              	<tbody>
                   	<!-- BEGIN mods -->
                    <tr>
                        	<!-- IF mods.B_NOTDOWNLOADFOLDER -->
                           	<!-- IF mods.B_NOTBACKUPFOLDER -->
                      	<td>
                           	{mods.MOD}<br>{mods.VERSION}<br>{mods.AUTHOR}<br>{mods.NAME}<br>
                           	<!-- IF mods.B_NOTINSTALLED -->
                           	<!-- ENDIF -->
                          	<!-- IF mods.B_NOTINSTALLED -->
                          	<input type="hidden" name="do" value="install">
                          	<input type="checkbox" name="mod" value="{mods.MOD_NAME}">
                           	<b>{L_3500_1015448}</b>
                          	<!-- ELSE -->
                           	<!-- IF mods.B_CHECKED --><p style="color:red">{L_3500_1015447}</p>
                          	<form name="mod" action="{FORM_2}" method="post">
                               	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
                               	<input type="hidden" name="mod" value="{mods.MOD_NAME}">
                              	<input type="hidden" name="delete_mod" value="yes">
                             	<input type="submit" name="act" value="{L_3500_1015458}">
	                       	</form>
	                       	<!-- ENDIF -->
	                     	<!-- ENDIF -->
                       	</td>
                      	<!-- ENDIF -->
                      	<!-- ENDIF -->
                      	<!-- IF mods.B_NOTDOWNLOADFOLDER -->
                       	<!-- IF mods.B_NOTBACKUPFOLDER -->
                    	<td>{mods.DESCRIPTION}</td>
                       	<!-- ENDIF -->
                  		<!-- ENDIF -->
                   	</tr>
                 	<!-- END mods -->
             	</tbody>
         	</table>
		</div>
	</div>
</form>
