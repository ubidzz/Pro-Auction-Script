<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<form name="boards" action="" method="post">
	<input type="hidden" name="action" value="delete">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME}<input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_008}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                	<tr>
                    	<th>{L_129}</th>
                        <th>{L_294}</th>
                        <th>{L_5046}</th>
                        <th>{L_5043}</th>
                        <th>&nbsp;</th>
                 	</tr>
              	</thead>
                <tbody>
                	<!-- BEGIN boards -->
                    <tr>
                    	<td>{boards.ID}</td>
                        <td>
                        	<a href="editboards.php?id={boards.ID}">{boards.NAME}</a>
							<!-- IF boards.ACTIVE eq 2 -->
							<b>[{L_5039}]</b>
							<!-- ENDIF -->
                       	</td>
                        <td>{boards.MSGTOSHOW}</td>
                        <td>{boards.MSGCOUNT}</td>
                        <td><input type="checkbox" name="delete[]" value="{boards.ID}"></td>
                  	</tr>
                    <!-- END boards -->
                   	<tr>
                    	<td colspan="4">{L_30_0102}</td>
                        <td><input type="checkbox" class="selectall" value="delete"></td>
                   	</tr>
             	</tbody>
          	</table>
		</div>
	</div>
</form>
