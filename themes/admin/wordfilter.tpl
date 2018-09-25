<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="wordlist" action="" method="post">
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
                   		<td colspan="2">{L_5069}</td>
                  	</tr>
                	<tr>
                    	<td>{L_5070}</td>
                      	<td>
                        	<input type="radio" name="wordsfilter" value="y"{WFYES}> {L_030}
                          	<input type="radio" name="wordsfilter" value="n"{WFNO}> {L_029}
                    	</td>
                	</tr>
                  	<tr>
                   		<td>{L_5071}</td>
                     	<td>{L_5072}<br>
                       		<textarea name="filtervalues" cols="45" rows="15">{WORDLIST}</textarea>
						</td>
                 	</tr>
          		</tbody>
          	</table>
		</div>
	</div>
</form>
