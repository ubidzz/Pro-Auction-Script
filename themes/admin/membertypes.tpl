<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<form name="memberTypes" action="" method="post">
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
                       	<th>{L_25_0171}</th>
                       	<th>{L_25_0167}</th>
                      	<th>&nbsp;</th>
                      	<th>{L_008}</th>
                 	</tr>
              	</thead>
             	<tbody>
                  	<!-- BEGIN mtype -->
                 	<tr>
                      	<td>&nbsp;</td>
                      	<td>
                           	<input type="hidden" name="old_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}">
                         	<input type="text" name="new_membertypes[{mtype.ID}][feedbacks]" value="{mtype.FEEDBACK}" size="5">
						</td>
                       	<td>
                       		<input type="hidden" name="old_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}">
                        	<input type="text" name="new_membertypes[{mtype.ID}][icon]" value="{mtype.ICON}" size="25">
                        </td>
                       	<td><img src="../images/icons/{mtype.ICON}" align="middle"></td>
                      	<td><input type="checkbox" id="delete" name="delete[]" value="{mtype.ID}"></td>
                  	</tr>
                  	<!-- END mtype -->
                   	<tr>
                      	<td>&nbsp;</td>
                      	<td>&nbsp;</td>
                      	<td>&nbsp;</td>
                       	<td>{L_30_0102}</td>
                    	<td><input type="checkbox" id="deleteall" value="delete"></td>
                  	</tr>
                   	<tr>
                      	<td>{L_518}</td>
                      	<td><input type="text" name="new_membertype[feedbacks]" size="5"></td>
                      	<td><input type="text" name="new_membertype[icon]" size="30"></td>
                      	<td>&nbsp;</td>
                      	<td>&nbsp;</td>
                 	</tr>
              	</tbody>
         	</table>
		</div>
	</div>
</form>

