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
                  	<th colspan="6">{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
                    	<br>
                      	{PREV}
            			<!-- BEGIN pages -->
                      	{pages.PAGE}&nbsp;&nbsp;
            			<!-- END pages -->
                      	{NEXT}
					</th>
               	</tr>
              	<tr>
                 	<th colspan="2">{L_1404}</th>
                   	<th>{L_557}</th>
                   	<th>{L_1402}</th>
                  	<th>{L_1403}</th>
                 	<th>{L_297}</th>
            	</tr>
          	</thead>
          	<tbody>
				<!-- BEGIN auctions -->
              	<tr>
                 	<td>
                     	<!-- IF auctions.SUSPENDED eq 1 --> 
                      	<b>{L_624}:<br></b>&nbsp;<span style="color:#FF0000"><b>{auctions.TITLE}</b></span><br />{L_113}:&nbsp;{auctions.ID} 
                       	<!-- ELSE --> 
                      	<b>{L_624}:<br></b>&nbsp;{auctions.TITLE}<br>
                      	<b>{L_113}:</b>&nbsp;{auctions.ID}<br>
                     	<!-- ENDIF --> 
                      	<p><b>[ <a href="{SITEURL}item.php?id={auctions.ID}" target="_blank">{L_5295}</a> ]</b></p>
                	</td>
                  	<td>{auctions.AUCTIONPIC}</td>
                  	<td>
                     	<b>{L_1415}</b> {auctions.SELLERNAME}<br> 
                     	<b>{L_1414}</b> {auctions.SELLERID}<br> 
                      	<p><span style="color:#008000"><b>[ <a class="greenlink" href="{auctions.CONTSELLER}{PAGE}">{L_1425}</a> ]</b></span></p>
                  	</td>
                   	<td>
                     	<b>{L_1416}</b> {auctions.REPORTERNAME}<br> 
                        <b>{L_1420}</b> {auctions.REPORTERID}<br>
                      	<b>{L_1423}</b> {auctions.REPORTDATE}<br>
                       	<p><b><span style="color:#008000">[ <a class="greenlink" href="{auctions.CONTREPORTER}{PAGE}">{L_1426}</a> ]</span></b></p>
                  	</td>
                   	<td>
                     	<b>Report ID: </b> {auctions.REPORTID}<br> 
                    	<b>{L_1421}</b> {auctions.REPORTREASON}<br> 
                      	<b>{L_1422}</b> {auctions.REPORTCOMMENT}
                	</td>
                   	<td>
                     	<a href="editauction.php?id={auctions.ID}&offset={PAGE}">{L_298}</a><br><br>  
                       	<a href="deleteauction.php?id={auctions.ID}&offset={PAGE}">{L_008}</a><br>
                       	<a href="excludeauction.php?id={auctions.ID}&offset={PAGE}"> <br> 
                       	<!-- IF auctions.SUSPENDED eq 0 --> 
                      	{L_300} <br> 
                       	<!-- ELSE --> 
                       	{L_310} <br> 
                       	<!-- ENDIF --> 
                       	</a><br>
                       	<a href="closereportedauctions.php?id={auctions.ID}&offset={PAGE}&reportid={auctions.REPORTID}">{L_1424}</a>
                  	</td>
             	</tr>
           		<!-- END auctions -->
         	</tbody>
       	</table>
	</div>
</div>
