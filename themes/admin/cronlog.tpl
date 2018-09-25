<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
	<div class="panel-heading">
    	<h3 class="panel-title">{L_3500_1015624}</h3>
    </div>
	<div class="panel-body">
		<table class="table table-bordered">
		    <tbody>
		    	<tr>
		    		<th colspan="4">{L_3500_1015625}</th>
		    	<tr>
		    	<tr>
		    		<td>{L_3500_1015621}</td>
		    		<td>{L_560}: <strong>{STATUS}</strong></td>
		    		<form name="changesettngs" action="" method="post" enctype="multipart/form-data">
		    			<td><input type="checkbox" name="cronlog" value="y" {SETTINGS}></td>
		    			<td>
		    				<input type="submit" name="act" class="btn btn-info" value="{L_089}">
	    					<input type="hidden" name="action" value="changesettngs">
		    				<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
		    			</td>
		    		</form>
		    	</tr>
		    </tbody>
	    </table>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
    	<h3 class="panel-title">{L_3500_1015627}</h3>
    </div>
		<div class="panel-body">
			<div class="alert alert-success col-xs-12 col-sm-12 col-lg-12" role="alert">{L_3500_1015626} 
			<div style="float:right">
				<form name="allcronlogs" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" name="action" value="clearalllogs">
	    			<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	    			<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_3500_1015620}">
				</form>
			</div></div>
		</div>
		<div class="panel-body">
			<!-- BEGIN cron_log -->
			<div class="col-xs-4 col-sm-4 col-lg-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">
					    	{cron_log.PAGENAME}
					    	<form style="float:right" name="cronlog" action="" method="post" enctype="multipart/form-data">
								<input type="hidden" name="action" value="clearlog">
								<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
							   	<input type="hidden" name="id" value="{cron_log.ID}">
								<input type="submit" name="act" class="btn btn-xs btn-warning" value="{L_890}">
							</form>
					    </div>
					</div>
					<div class="panel-body">
						{cron_log.ERRORLOG}
					</div>
				</div>
			</div>
			<!-- END cron_log -->
	    </div>
</div>

