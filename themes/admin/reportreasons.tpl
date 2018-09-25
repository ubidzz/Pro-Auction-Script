<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="reportReason" action="" method="post">
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
                      	<th>{L_1405}</th>
                       	<th colspan="3">{L_1411}</th>
                     	<th>{L_008}</th>
                   	</tr>
               	</thead>
               	<tbody>
                	<tr>
                  		<td>{L_518} <input type="text" name="new_report_reason[]" size="55" maxlength="55"></td>
                     	<!-- <td><input type="text" name="new_report_class[]" size="2" maxlength="2"></td>-->
                      	<td><input type="radio" name="new_report_class[]" value="1" checked="checked" > {L_029}</td>
						<td><input type="radio" name="new_report_class[]"  value="2" > {L_030}</td>
						<td><input type="radio" name="new_report_class[]"  value="3" > {L_1436}</td>
                    	<td>&nbsp;</td>
                   	</tr>
                   	<tr>
                       	<td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                       	<td>{L_30_0102}</td>
                      	<td><input type="checkbox" id="deleteall" value="delete"></td>
                   	</tr>
               	</tbody>
              	<tbody>
                  	<!-- BEGIN reasons -->
                  	<tr>
                      	<td><input type="text" name="new_report_reason[{reasons.ID}]" value="{reasons.REPORT_REASON}" size="55"></td>
						<!-- <td><input type="text" name="new_report_class[{reasons.ID}]" value="{reasons.REPORT_CLASS}" size="2"></td>-->
                    	<td><input type="radio" name="new_report_class[{reasons.ID}]" value="1" {reasons.REPORT_CLASS1}> {L_029}</td>
                     	<td><input type="radio" name="new_report_class[{reasons.ID}]"  value="2" {reasons.REPORT_CLASS2}> {L_030}</td>
                       	<td><input type="radio" name="new_report_class[{reasons.ID}]"  value="3" {reasons.REPORT_CLASS3}> {L_1436}</td>
                     	<td><input type="checkbox" id="delete" name="delete[]" value="{reasons.ID}"></td>
                  	</tr>
                 	<!-- END reasons -->
             	</tbody>
           	</table>
		</div>
	</div>
</form>
