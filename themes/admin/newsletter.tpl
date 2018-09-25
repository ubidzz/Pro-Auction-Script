<!-- IF ERROR ne '' -->

<div class="alert alert-info alert-dismissible">

	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>

</div>

<!-- ENDIF -->



<!-- IF B_PREVIEW -->

<div class="panel panel-primary">

    <div class="panel-heading">

    	<h4 class="panel-title">{L_25_0224}</h4>

    </div>

    <div class="panel-body">

		{PREVIEW}

	</div>

</div>

<!-- ENDIF -->

<form name="newsletter" action="" method="post">

 	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">

	<div class="panel panel-primary">

	    <div class="panel-heading">

	    	<h4 class="panel-title">{PAGENAME} <!-- IF B_PREVIEW --><input style="float:right" type="submit" name="action" class="btn btn-xs btn-success" value="submit"><!-- ENDIF --> <input style="float:right" type="submit" name="action" class="btn btn-xs btn-info" value="preview"> </h4>

	    </div>

	    <div class="panel-body">

			<table class="table table-bordered">

             	<tbody>

                 	<tr>

                    	<td>{L_5299}</td>

                     	<td>{SELECTBOX}</td>

                 	</tr>

                 	<tr>

                     	<td>{L_332}</td>

                       	<td><input type="text" name="subject" value="{SUBJECT}" size="50" maxlength="255"></td>

                  	</tr>

                 	<tr>

                     	<td>{L_605}</td>

                      	<td>

                          	{L_30_0055}

							{EDITOR}

                      	</td>

                 	</tr>

             	</tbody>

         	</table>

		</div>

	</div>

</form>

