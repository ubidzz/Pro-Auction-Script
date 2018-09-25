<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<link rel="stylesheet" type="text/css" href="{SITEURL}includes/template/calendar.css">
<form action="" method="get">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{L_103} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_275}">
	    	</div>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
             	<tbody>
                	<tr>
                      	<td>{L_313}</td>
                      	<td><input type="text" name="username" value="{USER_SEARCH}"></td>
                  	</tr>
                   	<tr>
                    	<td>{L_856}</td>
                      	<td>
                      		<input type="text" name="from_date" id="from_date" value="{FROM_DATE}" size="20" maxlength="19">
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
</form>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{PAGENAME}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
          	<thead>
              	<!-- IF PAGNATION -->
               	<tr>
	               	<th colspan="5">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
		               	<br>
		               	{PREV}
						<!-- BEGIN pages -->
		              	{pages.PAGE}&nbsp;&nbsp;
						<!-- END pages -->
		               	{NEXT}
		            </th>
              	</tr>
              	<!-- ENDIF -->
               	<tr>
                   	<th>{L_1041}</th>
                   	<!-- IF NO_USER_SEARCH -->
                   	<th>{L_313}</th>
                  	<!-- ENDIF -->
                  	<th>{L_1039}</th>
                    <th>{L_1053}</th>
                 	<th>{L_560}</th>
              	</tr>
           	</thead>   
         	<tbody>
				<!-- BEGIN invoices -->
              	<tr>
                  	<td><span class="titleText125">{L_1041}: {invoices.INVOICE}</span>
					<p class="smallspan">{invoices.DATE}</p></td>
                   	<!-- IF NO_USER_SEARCH -->
                   	<td>{invoices.USER}</td>
                  	<!-- ENDIF -->
                  	<td>{invoices.INFO}</td>
                  	<td>{invoices.TOTAL}</td>
                 	<td><!-- IF invoices.PAID --><p>{L_898}</p><!-- ENDIF --><a href="{SITEURL}order_print.php?id={invoices.INVOICE}" tagret="_blank">{L_1058}</a></td>
              	</tr>
				<!-- END invoices -->
          	</tbody>
      	</table>
	</div>
</div>

