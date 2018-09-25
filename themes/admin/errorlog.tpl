<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<form name="debugging" action="" class="form-horizontal" method="post">
<div class="box box-danger">
	<div class="box-header">
    	<h3 class="box-title">{L_3500_1015946}</h3>
    		<input type="hidden" name="action" value="debugging">
	    	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	    	<div class="pull-right box-tools">
	    		<input style="float:right" type="submit" name="act" class="btn btn-sm btn-success" value="{L_530}">
	    	</div>
			<div class="box-body">
				<p class="form-control-static">{L_3500_1015947}</p>
		    	<label class="radio-inline">
		    		<input type="radio" name="debug" value="y" {DEBUG_Y}> {L_030}
				</label>
				<label class="radio-inline">
				  	<input type="radio" name="debug" value="n" {DEBUG_N}> {L_029}
				</label>
		    </div>
    </div>
</div>
</form>
<div class="box box-danger">
	<div class="box-header">
    	<h3 class="box-title">{L_891}</h3>
	   	<div class="pull-right box-tools">
	    	<form style="float:right" name="errorlog" action="" method="post">
	    		<input type="hidden" name="action" value="clearlog">
	    		<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	    		<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_890}">
	    	</form>
		</div>
		<div class="box-body">
	    	{ERRORLOG}    	
	    </div>
    </div>
</div>
