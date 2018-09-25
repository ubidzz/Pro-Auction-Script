<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="payments" action="" method="post">
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
                     	<th colspan="3">{L_3500_1015646}</th>
                  	</tr>
                  	<tr>
                     	<th>&nbsp;</th>
                      	<th>{L_087}</th>
                      	<th>{L_008}</th>
                  	</tr>
             	</thead>
            	<tbody>
                   	<!-- BEGIN payments -->
                   	<tr>
                       	<td>&nbsp;</td>
                      	<td><input type="text" name="new_payments[]" value="{payments.PAYMENT}" size="25"></td>
                     	<td><input type="checkbox" name="delete[]" value="{payments.S_ROW_COUNT}"></td>
                  	</tr>
                  	<!-- END payments -->
                  	<tr>
                     	<td>{L_394}</td>
                      	<td><input type="text" name="new_payments[]" size="25"></td>
                     	<td>&nbsp;</td>
                  	</tr>
                  	<tr>
                      	<td>&nbsp;</td>
                      	<td>{L_30_0102}</td>
                      	<td><input type="checkbox" class="selectall" value="delete"></td>
                 	</tr>
            	</tbody>
         	</table>
		</div>
	</div>
</form>
