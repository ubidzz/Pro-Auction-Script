<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="increments" action="" method="post">
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
                       	<th>{L_240}</th>
                      	<th>{L_241}</th>
                      	<th>{L_137}</th>
                      	<th>{L_008}</th>
                   	</tr>
              	</thead>
             	<tbody>
                 	<!-- BEGIN increments -->
              		<tr>
                      	<td>&nbsp;</td>
                       	<td>
                           	<input type="hidden" name="id[]" value="{increments.ID}">
                          	<input type="text" name="lows[]" value="{increments.LOW}" size="10">
						</td>
                      	<td><input type="text" name="highs[]" value="{increments.HIGH}" size="10"></td>
                       	<td><input type="text" name="increments[]" value="{increments.INCREMENT}" size="10"></td>
                     	<td><input type="checkbox" name="delete[]" id="delete" value="{increments.ID}"></td>
                  	</tr>
                  	<!-- END increments -->
                 	<tr>
                       	<td>&nbsp;</td>
                       	<td>&nbsp;</td>
                      	<td>&nbsp;</td>
                       	<td>{L_30_0102}</td>
                   		<td><input type="checkbox" id="deleteall" value="delete"></td>
                  	</tr>
                  	<tr>
                       	<td>{L_518}</td>
                      	<td><input type="text" name="new_lows" size="10"></td>
                       	<td><input type="text" name="new_highs" size="10"></td>
                      	<td><input type="text" name="new_increments" size="10"></td>
                      	<td>&nbsp;</td>
                	</tr>
             	</tbody>
         	</table>
		</div>
	</div>
</form>
