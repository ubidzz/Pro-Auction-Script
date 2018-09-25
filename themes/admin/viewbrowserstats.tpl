<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_5167}<i>{SITENAME}</i> {STATSMONTH}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
			<tbody>
                <tr>
                    <th width="25%">{L_5169}</th>
                    <td>&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                </tr>
				<!-- BEGIN sitestats -->
                <tr class="bg">
                    <td height="45"><b>{sitestats.BROWSER}</b></td>
                    <td>
						<!-- IF sitestats.NUM eq 0 -->
						<div style="height:15px;"><b>0</b></div>
						<!-- ELSE -->
						<div class="progress">
							<div class="progress-bar progress-bar-success" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {sitestats.PERCENTAGE}%;"><b>{sitestats.PERCENTAGE}%</b></div>
						</div>
						<!-- ENDIF -->
                    </td>
                    <td>{sitestats.COUNT}</td>
                </tr>
				<!-- END sitestats -->
			</tbody>
		</table>
	</div>
</div>
