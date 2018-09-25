<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editfeedback" action="" method="post">
	<input type="hidden" name="user" value="{RATED_USER_ID}">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="csrftoken" value="{_CSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{L_25_0010}&nbsp;&gt;&gt;&nbsp;{L_045}&nbsp;&gt;&gt;&nbsp;{RATED_USER}&nbsp;&gt;&gt;&nbsp;{L_222}
	    		<input style="float:right" type="submit" name="Submit" class="btn btn-xs btn-success" value="{L_530}">
	    		<a style="float:right" class="btn btn-xs btn-danger" href="{SITEURL}admin/userfeedback.php?id={RATED_USER_ID}">{L_234}</a>
	    	</h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
	        	<tbody>
					<tr>
						<th colspan="2">{RATER_USER} {L_506}{RATED_USER}</th>
					</tr>
					<tr>
						<td>{L_503}</td>
						<td>
							<input type="radio" name="aTPL_rate" value="1" <!-- IF SEL1 -->checked="checked"<!-- ENDIF -->>
							<img src="{SITEURL}images/positive.png" border="0">
							<input type="radio" name="aTPL_rate" value="0" <!-- IF SEL2 -->checked="checked"<!-- ENDIF -->>
							<img src="{SITEURL}images/neutral.png" border="0">
							<input type="radio" name="aTPL_rate" value="-1" <!-- IF SEL3 -->checked="checked"<!-- ENDIF -->>
							<img src="{SITEURL}images/negative.png" border="0">
						</td>
					</tr>
					<tr>
						<td>{L_504}</td>
						<td><textarea name="TPL_feedback" rows="10" cols="50">{FEEDBACK}</textarea></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</form>
