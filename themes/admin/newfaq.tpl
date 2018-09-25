<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="newfaq" action="" method="post">
	<input type="hidden" name="action" value="update">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-success" value="{L_530}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
              	<tbody>
                 	<tr>
                      	<td>{L_5230}</td>
                       	<td colspan="2">
                         	<select name="category">
								<!-- BEGIN cats -->
                               	<option value="{cats.ID}">{cats.CATEGORY}</option>
								<!-- END cats -->
                          	</select>
                      	</td>
                  	</tr>
                	<!-- BEGIN lang -->
                  	<tr>
                      	<!-- IF lang.S_FIRST_ROW -->
                      	<td>{L_5239}</td>
                       	<!-- ELSE -->
                      	<td>&nbsp;</td>
                      	<!-- ENDIF -->
                       	<td><img src="../language/flags/{lang.LANG}.gif"></td>
                  		<td><input type="text" name="question[{lang.LANG}]" size="40" maxlength="255" value="{lang.TITLE}"></td>
                  	</tr>
                  	<!-- END lang -->
					<!-- BEGIN lang -->
                 	<tr>
                     	<!-- IF lang.S_FIRST_ROW -->
                      	<td>{L_5240}</td>
                      	<!-- ELSE -->
                       	<td>&nbsp;</td>
                       	<!-- ENDIF -->
                      	<td><img src="../language/flags/{lang.LANG}.gif"></td>
                      	<td>{lang.CONTENT}</td>
                   	</tr>
               		<!-- END lang -->
            	</tbody>
         	</table>
		</div>
	</div>
</form>
