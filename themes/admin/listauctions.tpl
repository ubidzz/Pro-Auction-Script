<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->
<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">
    		{PAGENAME}
    	</h4>
    </div>
	<table class="table table-hover table-striped">
   		<thead>
         	<tr>
            	<th colspan="3">{NUM_AUCTIONS} {L_311}<!-- IF B_SEARCHUSER --> {L_934}{USERNAME}<!-- ENDIF --></th>
           	</tr>
         	<tr>
             	<th colspan="3">
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
           		<th>{L_017}</th>
               	<th>{L_557}</th>
               	<th>{L_297}</th>
           	</tr>
      	</thead>
     	<tbody>
         	<!-- BEGIN auctions -->
           	<tr>
             	<td>
                 	<!-- IF auctions.SUSPENDED eq 1 -->
                   	<span style="color:#FF0000">{auctions.TITLE}</span>
                   	<!-- ELSE -->
                  	{auctions.TITLE}
                   	<!-- ENDIF -->
                   	<p><a href="{SITEURL}products/{auctions.SEO_TITLE}-{auctions.ID}" class="btn btn-sm btn-success" target="_blank">{L_5295}</a></p>
              	</td>
               	<td>
                  	<b>{L_003}:</b> {auctions.USERNAME}<br>
                  	<b>{L_625}:</b> {auctions.START_TIME}<br>
                   	<b>{L_626}:</b> {auctions.END_TIME}<br>
                  	<b>{L_041}:</b> {auctions.CATEGORY}
             	</td>
              	<td>
                 	<a class="btn btn-sm btn-info" href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a> 
                  	<!-- IF auctions.B_HASWINNERS -->
                   	<a class="btn btn-sm btn-primary" href="viewwinners.php?id={auctions.ID}&offset={PAGE}">{L__0163}</a><br /><br />
                  	<!-- ENDIF -->
                  	<a class="btn btn-sm btn-danger" href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a>
                  	<a class="btn btn-sm btn-warning" href="excludeauction.php?id={auctions.ID}&offset={PAGE}">
                    	<!-- IF auctions.SUSPENDED eq 0 -->
                       	{L_300}
                       	<!-- ELSE -->
                       	{L_310}
                      	<!-- ENDIF -->
                   	</a> 
               	</td>
           	</tr>
          	<!-- END auctions -->
      	</tbody>
	</table>
</div>
