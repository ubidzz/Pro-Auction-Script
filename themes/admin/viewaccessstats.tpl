<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_5164}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
        	<thead>
              	<tr>
                 	<th>{L_5161}</th>
                   	<th>{L_5162}</th>
                 	<th>{L_5163}</th>
             	</tr>
        	</thead>
       		<tbody>
         		<tr>
             		<td>
             			<div class="progress">
             				<div class="progress-bar progress-bar-success" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><b>{TOTAL_PAGEVIEWS}</b></div>
             			</div>
             		</td>
             		<td>
             			<div class="progress">
             				<div class="progress-bar progress-bar-info" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><b>{TOTAL_UNIQUEVISITORS}</b></div>
             			</div>
             		</td>
             		<td>
             			<div class="progress">
             				<div class="progress-bar progress-bar-warning" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><b>{TOTAL_USERSESSIONS}</b></div>
             			</div>
             		</td>
             	</tr>
       		</tbody>
      	</table>
	</div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_5158}<i>{SITENAME}</i></h4>
    </div>
    <div class="panel-body">
		<table class="table">
			<tbody>
                <tr>
                    <td align="center"><b>{STATSTEXT}</b></td>
                    <td style="text-align:right;">{L_829}<a href="viewaccessstats.php?type=d">{L_109}</a>/ <a href="viewaccessstats.php?type=w">{L_828}</a>/ <a href="viewaccessstats.php?type=m">{L_830}</a></td>
                </tr>
				<!-- BEGIN sitestats -->
                <tr class="bg">
                    <td align="center" height="45"><b>{sitestats.DATE}</b></td>
                    <td>
						<!-- IF sitestats.PAGEVIEWS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
						<!-- ELSE -->
						<div class="progress">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {sitestats.PAGEVIEWS_WIDTH}%"><b>{sitestats.PAGEVIEWS}</b></div>
						</div>
						<!-- ENDIF -->
						<!-- IF sitestats.UNIQUEVISITORS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
						<!-- ELSE -->
						<div class="progress">
							<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {sitestats.UNIQUEVISITORS_WIDTH}%"><b>{sitestats.UNIQUEVISITORS}</b></div>
						</div>
						<!-- ENDIF -->
						<!-- IF sitestats.USERSESSIONS eq 0 -->
						<div style="height:15px;"><b>0</b></div>
						<!-- ELSE -->
						<div class="progress">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {sitestats.USERSESSIONS_WIDTH}%"><b>{sitestats.USERSESSIONS}</b></div>
						</div>
						<!-- ENDIF -->
                    </td>
                </tr>
				<!-- END sitestats -->
			</tbody>
		</table>
	</div>
</div>

