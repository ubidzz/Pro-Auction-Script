<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_3500_1015491}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
          	<tbody>
            	<tr>
                 	<td>{L_113}: {ID}</td>
                 	<td>{L_197}: {TITLE}</td>
                  	<td>{L_125}: {S_NICK} ({S_NAME})</td>
                 	<td>{L_127}: {MIN_BID}</td>
                 	<td>{L_111}: {STARTS}</td>
                  	<td>{L_30_0177}: {ENDS}</td>
                	<td>{L_257}: {AUCTION_TYPE}</td>
             	</tr>
        	</tbody>
       	</table>
	</div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_453}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
			<!-- IF B_WINNERS -->
          	<thead>
              	<tr>
                 	<th>{L_176}</th>
                  	<th>{L_30_0179}</th>
                 	<th>{L_284}</th>
              	</tr>
          	</thead>
         	<tbody>
           		<!-- BEGIN winners -->
             	<tr>
                	<td>{winners.W_NICK} ({winners.W_NAME})</td>
                 	<td>{winners.BID}</td>
                  	<td>{winners.QTY}</td>
              	</tr>
              	<!-- END winners -->
              	<!-- ELSE -->
              	<tr>
                 	<td colspan="3"><b>{L_30_0178}</b></td>
             	</tr>
				<!-- ENDIF -->
       		</tbody>
    	</table>
	</div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{L_30_0180}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
        	<!-- IF B_BIDS --> 
           	<thead>
             	<tr>
                 	<th>{L_176}</th>
                  	<th>{L_30_0179}</th>
                  	<th>{L_284}</th>
             	</tr>
           	</thead>
			<!-- ENDIF -->
          	<tbody>
             	<!-- IF B_BIDS --> 
             	<!-- BEGIN bids -->
             	<tr>
              		<td>{bids.W_NICK} ({bids.W_NAME})</td>
                   	<td>{bids.BID}</td>
                  	<td>{bids.QTY}</td>
               	</tr>
              	<!-- END bids -->
              	<!-- ELSE -->
              	<tr>
                	<td>{L_30_0178}</td>
              	</tr>
               	<!-- ENDIF -->
         	</tbody>
     	</table>
	</div>
</div>

