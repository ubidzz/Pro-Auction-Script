<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="check" action="" method="post">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<thead>
                	<tr>
                   		<th colspan="2">{L_3500_1015415}</th>
                    </tr>
                    <tr>
                    	<th>{L_394}</th>
                        <th><input type="text" name="new_check" size="25" value=""></th>
                    </tr>
                    <tr>
                    	<th colspan="2">
                    		{L_5117}:&nbsp;{PREV}<!-- BEGIN pages -->{pages.PAGE}&nbsp;&nbsp;<!-- END pages -->{NEXT}
    						<span style="float:right"><!-- IF ISPAGES --><a href="{SITEURL}{ADMIN_FOLDER}/email_block.php?PAGE={SETPAGE}{SETSORTA}">{L_3500_1015419}</a>&nbsp;&nbsp;<a href="{SITEURL}{ADMIN_FOLDER}/email_block.php?PAGE={SETPAGE}{SETSORTZ}">{L_3500_1015420}</a> <!-- ELSE --> <a href="{SITEURL}{ADMIN_FOLDER}/email_block.php{SETSORTA}">{L_3500_1015419}</a>&nbsp;&nbsp;<a href="{SITEURL}{ADMIN_FOLDER}/email_block.php{SETSORTZ}">{L_3500_1015420}</a> <!-- ENDIF --></span>
                        </th>
                  	</tr>
                    <tr>
                        <th>{L_3500_1015416}</th>
                    	<th>{L_008}</th>
                	</tr>
                </thead>
             	<tbody>
                   	<!-- BEGIN check -->
               		<tr>
                       	<td>
                            <input type="hidden" name="emailid[]" value="{check.ID}">
                        	<input type="text" name="checkemails[]" value="{check.EMAIL_CHECKS}" size="75">
                        </td>
                    	<td><input type="checkbox" name="delete[]" value="{check.ID}"></td>
                   	</tr>
                	<!-- END check -->
            	</tbody>
         	</table>
		</div>
	</div>
</form>
