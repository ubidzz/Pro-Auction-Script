<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{PAGENAME}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
         	<thead>
            	<tr>
               		<th colspan="4">
                     	{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                       	<br>
                      	{PREV}
            			<!-- BEGIN pages -->
                      	{pages.PAGE}&nbsp;&nbsp;
            			<!-- END pages -->
                      	{NEXT}
                    </th>
              	</tr>
              	<tr>
              		<th>{L_294}</th>
                	<th>{L_293}</th>
                  	<th>{L_3500_1015468}</th>
                  	<th>{L_3500_1015469}</th>
               	</tr>
           	</thead>
           	<tbody>
         		<!-- BEGIN active_users -->
              	<tr>
                 	<td>{active_users.NAME}</td>
                  	<td>{active_users.NICK}</td>
                  	<td>{active_users.LASTLOGIN}</td>
                  	<td>{active_users.ONLINESTATUS}</td>
              	</tr>
              	<!-- END active_users -->
          	</tbody>
     	</table>
	</div>
</div>
