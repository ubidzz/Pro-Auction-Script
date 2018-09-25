<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editFaqsCategory" action="" method="post">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_089}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
                 <tbody>
                  	<!-- BEGIN flangs -->
                   	<tr>
                       	<!-- IF flangs.S_FIRST_ROW -->
                      	<td>{L_5284}</td>
                      	<!-- ELSE -->
                      	<td>&nbsp;</td>
                       	<!-- ENDIF -->
                      	<td><img src="{SITEURL}language/flags/{flangs.LANGUAGE}.gif"></td>
                      	<td><input type="text" name="category[{flangs.LANGUAGE}]" size="50" maxlength="150" value="{flangs.TRANSLATION}"></td>
                  	</tr>
              		<!-- END langs -->
              	</tbody>
          	</table>
		</div>
	</div>
</form>
