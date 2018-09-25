<!-- IF ERROR ne '' -->
<div class="alert alert-info alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="icon fa fa-info"></i>{ERROR}</h4>
</div>
<!-- ENDIF -->

<form name="deleteusers" action="" method="post">
	<input type="hidden" name="action" value="deleteusers">
	<input type="hidden" name="admincsrftoken" value="{_ACSRFTOKEN}">
	<div class="panel panel-primary">
	    <div class="panel-heading">
	    	<h4 class="panel-title">{PAGENAME} <input style="float:right" type="submit" name="act" class="btn btn-xs btn-danger" value="{L__0028}"></h4>
	    </div>
	    <div class="panel-body">
			<table class="table table-bordered">
             	<thead>
                	<tr>
                      	<th>{L_5180}</th>
                      	<th>{L__0022}</th>
                      	<th>{L_303}</th>
                      	<th>{L__0025}</th>
                      	<th>&nbsp;</th>
                    	<th>{L_008}</th>
               		</tr>
             	</thead>
              	<tbody>
                  	<!-- BEGIN busers -->
                   	<tr>
                     	<td><a href="editbannersuser.php?id={busers.ID}">{busers.NAME}</a></td>
                      	<td>{busers.COMPANY}</td>
                       	<td><a href="mailto:{busers.EMAIL}">{busers.EMAIL}</a></td>
                      	<td>{busers.NUM_BANNERS}</td>
                       	<td><a href="userbanners.php?id={busers.ID}">{L__0024}</a></td>
                     	<td><input type="checkbox" name="delete[]" value="{busers.ID}"></td>
                  	</tr>
                	<!-- END busers -->
               	</tbody>
         	</table>
		</div>
	</div>
</form>
