<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="conditions" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary table-responsive">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME}<input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
		<table class="table table-hover table-striped">
         	<thead>
            	<tr>
                  	<th>{L_3500_1015488}</th>
                	<th>{L_087}</th>
                  	<th>{L_008}</th>
           		</tr>
         	</thead>
          	<tbody>
             	<!-- BEGIN conditions -->
            	<tr>
                   	<td><input class="form-control" type="text" name="new_item_condition[{conditions.ID}]" value="{conditions.ITEM_CONDITION}" size="40"></td>
                 	<td><textarea class="form-control" rows="4" cols="40" wrap="physical" name="new_condition_desc[{conditions.ID}]" value="{conditions.CONDITION_DESC}">{conditions.CONDITION_DESC} </textarea></td>
                	<td><input type="checkbox" id="delete" name="delete[]" value="{conditions.ID}"></td>
              	</tr>
              	<!-- END conditions -->
               	<tr>
                  	<td>&nbsp;</td>
                   	<td>{L_30_0102}</td>
                	<td><input type="checkbox" id="deleteall"></td>
              	</tr>
              	<tr>
                  	<td>{L_518} <input class="form-control" type="text" name="new_item_condition[]" size="40" maxlength="40"></td>
                  	<td colspan="2"><textarea class="form-control" rows="4" cols="40" wrap="physical" name="new_condition_desc[]"> </textarea></td>
            	</tr>
        	</tbody>
     	</table>
	</div>
</form>
