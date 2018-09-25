<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="editfaq" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="id" value="{ID}">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
               	<tbody>
                	<tr>
                      	<td>{L_5238}</td>
                      	<td>&nbsp;</td>
                      	<td>
                          	<select name="category">
	            				<!-- BEGIN cats -->
	                          	<option value="{cats.ID}"<!-- IF cats.ID eq FAQ_CAT -->selected="selected"<!-- ENDIF -->>{cats.CAT}</option>
	            				<!-- END cats -->
                          	</select>
                     	</td>
                	</tr>
                  	<!-- BEGIN qs -->
                 	<tr>
                     	<!-- IF qs.S_FIRST_ROW -->
                     	<td>{L_5239}</td>
                       	<!-- ELSE -->
                      	<td>&nbsp;</td>
                      	<!-- ENDIF -->
                      	<td><img src="../language/flags/{qs.LANG}.gif"></td>
                      	<td><input type="text" name="question[{qs.LANG}]" maxlength="200" value="{qs.QUESTION}"></td>
                  	</tr>
                 	<!-- END qs -->
					<!-- BEGIN as -->
                  	<tr>
                      	<!-- IF as.S_FIRST_ROW -->
                       	<td>{L_5240}</td>
                      	<!-- ELSE -->
                       	<td>&nbsp;</td>
                      	<!-- ENDIF -->
                       	<td><img src="../language/flags/{as.LANG}.gif"></td>
                      	<td>{as.ANSWER}</td>
                 	</tr>
                  	<!-- END as -->
             	</tbody>
           	</table>
		</div>
	</div>
</form>

