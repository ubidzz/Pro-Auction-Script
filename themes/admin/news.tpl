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
                	<th colspan="3">{NEWS_COUNT}{L_517} <a class="btn btn-xs btn-success" href="addnew.php">{L_518}</a></th>
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
                   	<th>{L_314}</th>
                    <th>{L_312}</th>
                	<th>{L_297}</th>
            	</tr>
           	</thead>
         	<tbody>
                <!-- BEGIN news -->
             	<tr>
                    <td>{news.DATE}</td>
                    <td <!-- IF news.SUSPENDED eq 1 -->style="background: #FAD0D0; color: #B01717; font-weight: bold;"<!-- ENDIF -->>{news.TITLE}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="editnew.php?id={news.ID}&PAGE={PAGE}">{L_298}</a>
                    	<a class="btn btn-sm btn-danger" href="deletenew.php?id={news.ID}&PAGE={PAGE}">{L_008}</a>
                	</td>
                </tr>
            	<!-- END news -->         
        	</tbody>
    	</table>
	</div>
</div>

