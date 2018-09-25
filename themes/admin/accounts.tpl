<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<link rel="stylesheet" type="text/css" href="{SITEURL}includes/template/calendar.css">
<form action="" method="post">
	<div class="box box-info">
		<div class="box-header">
	    	<h4 class="box-title">{L_103}</h4>
	    <!-- tools box -->
	       	<div class="pull-right box-tools">
	        	<input type="submit" name="act" class="btn btn-sm btn-success" value="{L_103}!">
		  	</div>
		  	<div class="box-body table-responsive">
			<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
				<table class="table table-bordered table-hover">
		        	<tbody>
		            	<tr>
		                	<td>{L_855}</td>
		                    <td>{L_5281} <input type="radio" name="type" value="m"<!-- IF TYPE eq 'm' --> checked="checked"<!-- ENDIF -->>
		                    	{L_827} <input type="radio" name="type" value="w"<!-- IF TYPE eq 'w' --> checked="checked"<!-- ENDIF -->>
		                        {L_5285} <input type="radio" name="type" value="d"<!-- IF TYPE eq 'd' --> checked="checked"<!-- ENDIF -->>
		                        {L_2__0027} <input type="radio" name="type" value="a"<!-- IF TYPE eq 'a' --> checked="checked"<!-- ENDIF -->>
							</td>
		             	</tr>
		                <tr>
		                	<td>{L_856}</td>
		                    <td><input type="text" name="from_date" id="from_date" value="{FROM_DATE}" size="20" maxlength="19">
			                    <script type="text/javascript">
									new tcal ({'id': 'from_date','controlname': 'from_date'});
								</script>
			                    -
			                    <input type="text" name="to_date" id="to_date" value="{TO_DATE}" size="20" maxlength="19">
			                    <script type="text/javascript">
									new tcal ({'id': 'to_date','controlname': 'to_date'});
								</script>
		                   	</td>
		             	</tr>
		           	</tbody>
		     	</table>
		 	</div>
		</div>
	</div>
</form>
<div class="box box-info">
	<div class="box-header">
    	<h4 class="box-title">{PAGENAME}</h4>
    </div>
    <div class="box-body table-responsive">
    	<table class="table table-bordered table-hover">
          	<thead>
                <!-- IF PAGNATION -->
                <tr>
                    <th colspan="4">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                    <br>
                    <ul class="pagination">
                    	{PREV}
						<!-- BEGIN pages -->
                    	{pages.PAGE}&nbsp;&nbsp;
						<!-- END pages -->
                		{NEXT}
                	</ul>
                	</th>
                </tr>
                <!-- ENDIF -->
                <!-- IF PAGNATION -->
                <tr>
                    <th>{L_313}</th>
                    <th>{L_766}</th>
                    <th>{L_314}</th>
                	<th>{L_391}</th>
                </tr>
                <!-- ELSE -->
                <tr>
                    <th>{L_314}</th>
                	<th>{L_857}</th>
                </tr>
            	<!-- ENDIF -->
            </thead>          
          	<tbody>
                <!-- BEGIN accounts -->
				<!-- IF PAGNATION -->
               	<tr>
                    <td>{accounts.RNAME} ({accounts.NICK})</td>
                    <td>{accounts.TEXT}</td>
                    <td>{accounts.DATE}</td>
                	<td>{accounts.AMOUNT}</td>
                </tr>
				<!-- ELSE -->
                <tr>
                    <td>{accounts.DATE}</td>
                	<td>{accounts.AMOUNT}</td>
                </tr>
                <!-- ENDIF -->
				<!-- END accounts -->
        	</tbody>
    	</table>
    </div>
</div>
