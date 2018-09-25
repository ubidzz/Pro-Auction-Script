<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title">{L_3500_1015829}</h4>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<!-- BEGIN languages -->
                <tr>
                    <th>{L_3500_1016007}</th>
                	<th><a href="translatelanguage.php?country={languages.LANGS}"><img align="middle" src="{SITEURL}language/flags/{languages.LANG}.gif" border="0"></a></th>
               	</tr>
             	<!-- END languages -->
			</thead>
		</table>
	</div>
</div>
<form name="updateLang" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="charset" value="{CHAR}">
	<input type="hidden" name="docdir" value="{DOCDIR}">
	<input type="hidden" name="langcode" value="{COUNTRY}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{L_3500_1016008} 
	    		<input style="float:right" type="submit" name="submit" class="btn btn-sm btn-success" value="{L_071}">
	    	</div>
	    </div>
	    <div class="panel-body">
	    	{L_3500_1016013}
			<table class="table table-bordered">
	            <tbody>
	                <tr>
	                   	<th>{L_771}</th>
	                   	<th>{L_772}</th>
	                </tr>
	                <!-- BEGIN default_err -->
		          	<tr>
		             	<td><textarea class="form-control" disabled>{default_err.VALUE}</textarea></td>
		              	<td><textarea class="form-control" name="lanERR['{default_err.KEY}']">{default_err.TRANS}</textarea></td>
		          	</tr>
	             	<!-- END default_err -->

	                <!-- BEGIN default_msg -->
		          	<tr>
		             	<td><textarea class="form-control" disabled>{default_msg.VALUE}</textarea></td>
		              	<td><textarea class="form-control" name="lan['{default_msg.KEY}']">{default_msg.TRANS}</textarea></td>
		          	</tr>
	             	<!-- END default_msg -->
	          	</tbody>
	     	</table>
		</div>
	</div>
</form>
