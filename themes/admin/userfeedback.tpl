<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<div class="panel panel-primary">
    <div class="panel-heading">
    	<h4 class="panel-title">{NICK} {PAGENAME}</h4>
    </div>
    <div class="panel-body">
		<table class="table table-bordered">
          	<thead>
              	<tr>
                	<th colspan="2">
                     	{L_5117}&nbsp;{PAGE}&nbsp;{L_5118}&nbsp;{PAGES}
			          	<br>
			          	{PREV}
						<!-- BEGIN pages -->
			        	{pages.PAGE}&nbsp;&nbsp;
						<!-- END pages -->
			          	{NEXT}
                     </th>
               	</tr>
          	</thead>
        	<tbody>
            	<!-- BEGIN feedback -->
             	<tr>
                 	<td>
                      	<img align="middle" src="{SITEURL}images/{feedback.FB_TYPE}.png">&nbsp;&nbsp;<b>{feedback.FB_FROM}</b>&nbsp;&nbsp;<span class="small">({L_506}{feedback.FB_TIME})</span>
                      	<p>{feedback.FB_MSG}</p>
					</td>
                   	<td><a href="edituserfeed.php?id={feedback.FB_ID}">{L_298}</a> | <a href="deleteuserfeed.php?id={feedback.FB_ID}&user={ID}">{L_008}</a></td>
                </tr>
            	<!-- END feedback -->
         	</tbody>
       	</table>
	</div>
</div>
