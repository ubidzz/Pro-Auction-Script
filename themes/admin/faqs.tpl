<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="deletefaqs" action="" method="post">
	<input type="hidden" name="action" value="delete">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{PAGENAME} 
	    		<input style="float:right" type="submit" name="act" class="btn btn-xs btn-danger" value="{L_008}">
	    		<a style="float:right" class="btn btn-xs btn-success" href="newfaq.php">{L_5231}</a>
	    	</div>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
            	<tbody>
                	<tr>
                    	<td>{L_30_0102}</td>
                        <td><input type="checkbox" id="selectall" value="delete"></td>
                    </tr>
                    <!-- BEGIN cats -->
	                    <tr>
	                    	<td>{cats.CAT}</td>
	                        <td>&nbsp;</td>
	                    </tr>
	                    <!-- BEGIN faqs -->
	                    <tr>
	                    	<td><a href="editfaq.php?id={faqs.ID}">{faqs.FAQ}</a></td>
	                        <td><input type="checkbox" name="delete[]" value="{faqs.ID}" id="delete"></td>
	                    </tr>
	                    <!-- END faqs -->
                    <!-- END cats -->
               	</tbody>
        	</table>
		</div>
	</div>
</form>
