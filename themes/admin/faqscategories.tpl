<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="newfaqcat" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<div class="panel-title">
	    		{PAGENAME}
	    		<!-- IF B_ADDCAT -->
                <input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="{L_5204}">
                <!-- ELSE -->
                <a style="float:right" class="btn btn-xs btn-success" href="faqscategories.php?do=add">{L_5234}</a>
                <!-- ENDIF -->
                <input style="float:right" type="submit" name="action" class="btn btn-xs btn-danger" value="{L_008}">
	    	</div>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
              	<thead>
                  	<!-- IF B_ADDCAT -->
                  	<tr>
                      	<th>{L_165}</th>
                      	<th colspan="2">
                          	<!-- BEGIN lang -->
                          	<p>{lang.LANG}:&nbsp;<input type="text" name="cat_name[{lang.LANG}]" size="25" maxlength="200"></p>
                        	<!-- END lang -->
                     	</th>
                  	</tr>
                 	<!-- ENDIF -->
                 	<tr>
                      	<th>{L_5237}</th>
                    	<th>{L_287}</th>
                   		<th>{L_008}</th>
                   	</tr>
              	</thead>
               	<tbody>
                   	<!-- BEGIN cats -->
                  	<tr>
                      	<td>{cats.ID}</td>
                      	<td><a href="editfaqscategory.php?id={cats.ID}">{cats.CATEGORY}</a> <!-- IF cats.FAQS gt 0 -->{cats.FAQSTXT}<!-- ENDIF -->	</td>
                     	<td><input type="checkbox" name="delete[]" value="{cats.ID}"></td>
                  	</tr>
                  	<!-- END cats -->
           		</tbody>
          	</table>
		</div>
	</div>
</form>
